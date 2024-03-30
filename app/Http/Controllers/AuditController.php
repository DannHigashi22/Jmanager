<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Models\Audit;
use App\Models\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show-audit|create-audit|edit-audit|delete-audit',['only'=>['index']]);
        $this->middleware('permission:create-audit',['only'=>['create','store']]);
        $this->middleware('permission:edit-audit',['only'=>['edit','update']]);
        $this->middleware('permission:edelete-audit',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $audits=Audit::paginate(10);
        return view('audit.index',compact('audits'));
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
            'order'=>['required','unique:audits,order'],
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
        //
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
            'type'=>['required'],
            'error_type'=>['required','min:1'],
            'description'=>['required']
        ]);
        $audit->update($request->all());
        //actualizar relaciones de tabla pivote
        $audit->errors()->sync($request->input('error_type'));
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
        return redirect()->route('audits.index');
    }
}
