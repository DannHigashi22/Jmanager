<?php

namespace App\Http\Controllers;

use App\Exports\AuditExport;
use App\Imports\AuditImport;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Models\Audit;
use App\Models\Error;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show-audit|create-audit|edit-audit|delete-audit|importShpr-audit|exportShpr-audit',['only'=>['index']]);
        $this->middleware('permission:create-audit',['only'=>['create','store']]);
        $this->middleware('permission:edit-audit',['only'=>['edit','update']]);
        $this->middleware('permission:edelete-audit',['only'=>['destroy']]);
        $this->middleware('permission:importShpr-audit',['only'=>['importShoppers']]);
        $this->middleware('permission:exportShpr-audit',['only'=>['exportAudits']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //date filter.
        $start= null;
        $end= null;
        $user=null;
        if (!empty($request->input('dateRange'))) {
            $date= explode(" - ",$request->input('dateRange'));
            $start=Carbon::createFromFormat('Y/m/d',$date[0])->startOfDay();
            $end=Carbon::createFromFormat('Y/m/d',empty($date[1])?$date[0]:$date[1])->endOfDay();   
        }
        
        if(Auth::user()->getRoleNames()[0] == 'Auditor'){
            $user=Auth::user()->id;
        }elseif($request->input('user') !== null){
            $user=User::select('id')->where('email',$request->input('user'))->first();
            $user=$user ? $user->id:'';
        }

        $audits=Audit::when($user !== null , function ($q) use ($user){
            return $q->where('user_id',$user);
        })
        ->when($request->input('dateRange') != null , function ($q) use ($start,$end){
            return $q->whereBetween('created_at',[$start,$end]);
        })->when($request->input('type') == 'Despacho' | $request->input('type') == 'Click auto', function($q) use ($request){
            return $q->where('type','=',$request->input('type'));
        },function($q){
            return $q->orderBy('created_at','desc');
        })->paginate(20)->withQueryString();

        $users=User::orderBy('name')->get();//Usuarios totales
        
        //confirm alert
        $title = 'Borrar Auditoria!';
        $text = "estas seguro de borrar?";
        confirmDelete($title, $text);

        return view('audit.index',compact('audits','users')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $error_type=Error::pluck('type','id')->all();
        return view('audit.create',compact('error_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate=$this->validate($request,[
            'order'=>['required','unique:audits,order','int'],
            'type'=>['required',"regex:(Despacho|Click auto)"],
            'error_type'=>['required','min:1'],
            'description'=>['required']
        ]);
        $user_id=Auth::user()->id;
        $input=$request->all();
        $input=Arr::add($input,'user_id',$user_id);

        $audit=Audit::create($input);
        //crear relaciones en tabla pivote
        $audit->errors()->attach($input['error_type']);
        notify()->success('Auditoria ingresada correctamente, gracias por su tiempo ⚡️','Creado');
        return redirect()->route('audits.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Audit $audit)
    {
        $error_type=Error::pluck('type','id');
        $errorAudit=DB::table('audit_error')->where('audit_error.audit_id',$audit->id)
        ->pluck('audit_error.error_id','audit_error.error_id')->all();
        return view('audit.edit',compact('audit','error_type','errorAudit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Audit $audit)
    {
        $validate=$this->validate($request,[
            'order'=>['required',"unique:audits,order,$audit->id"],
            'type'=>['required',"regex:(Despacho|Click auto)"],
            'error_type'=>['required','min:1'],
            'description'=>['required']
        ]);
        $audit->update($request->all());
        //actualizar relaciones de tabla pivote
        $audit->errors()->sync($request->input('error_type'));
        notify()->success('Auditoria actualiza correctamente ⚡️','Editar');
        return redirect()->route('audits.index'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Audit $audit)
    {   
        //borrado de errores en tabla pivote
        $audit->errors()->detach();
        
        $audit->delete();
        notify()->success('Auditoria eliminada correctamente 🗑','Eliminado');
        return redirect()->route('audits.index');
    }

    public function importShoppers(Request $request){
        $validate=$this->validate($request,[
            'excel'=>['required','mimes:csv,xlsx,txt','max:2048']
        ]);
        $excel=$request->file('excel');
        try {
            Excel::Import(New AuditImport,$excel);
            notify()->success('Datos importados correctamente, datos que no fueron cambiados verificar orden ✔','Importar');
            return redirect()->route('audits.index');     
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            notify()->error('Accion no realizada, verifica tamaño de archivo, extension y contenido; consulta con operador ','Importar');
            return redirect()->route('audits.index')->with([
                'failures'=> $failures
            ]);
        }
    }

    public function exportAudits(Request $request){
          $start= null;
          $end= null;
          $user=null;
          if (!empty($request->input('dateRange'))) {
              $date= explode(" - ",$request->input('dateRange'));
              $start=Carbon::createFromFormat('Y/m/d',$date[0])->startOfDay();
              $end=Carbon::createFromFormat('Y/m/d',empty($date[1])?$date[0]:$date[1])->endOfDay();   
          }
          if(Auth::user()->getRoleNames()[0] == 'Auditor'){
              $user=Auth::user()->id;
          }elseif($request->input('user') !== null){
              $user=User::select('id')->where('email',$request->input('user'))->first();
              $user=$user ? $user->id:'';
          }
          $audits=Audit::when($user !== null , function ($q) use ($user){
              return $q->where('user_id',$user);
          })
          ->when($request->input('dateRange') != null , function ($q) use ($start,$end){
              return $q->whereBetween('created_at',[$start,$end]);
          })->when($request->input('type') == 'Despacho' | $request->input('type') == 'Click auto', function($q) use ($request){
              return $q->where('type','=',$request->input('type'));
          },function($q){
              return $q->orderBy('created_at','desc');
          })->get();//->paginate(10);
        return Excel::download(new AuditExport($audits), 'audits.xlsx');
    }
}
