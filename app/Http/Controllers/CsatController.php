<?php

namespace App\Http\Controllers;

use App\Imports\CsatImport;
use App\Models\ClientsCsat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class CsatController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show-csat|create-csat|edit-csat|delete-csat|import-csat|export-csat|order-csat',['only'=>['index']]);
        $this->middleware('permission:create-csat',['only'=>['create','store']]);
        $this->middleware('permission:edit-csat',['only'=>['edit','update']]);
        $this->middleware('permission:delete-csat',['only'=>['destroy']]);
        $this->middleware('permission:import-csat',['only'=>['importCsat']]);
        $this->middleware('permission:order-csat',['only'=>['importOrderCsat']]);
        $this->middleware('permission:export-csat',['only'=>['exportCsat']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients=ClientsCsat::all();
        //confirm alert
        $title = 'Borrar Cliente!';
        $text = "estas seguro de borrar?";
        confirmDelete($title, $text);
        return view('csat.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'rut'=>['required','regex:/(\d{1,2}(?:\.\d{1,3}){2}-[\dkK])$/','string','min:11','max:12','unique:clients_csat,rut'],
            'names'=>['required','string'],
            'vip_sala'=>['sometimes','in:1'],
            'description'=>['nullable']
        ]);
        $input=$request->all();
        $request->input('vip_sala') ?'': $input=Arr::add($input,'vip_sala',0);
        $input=Arr::add($input,'created_by',Auth::user()->name);
        $clients=ClientsCsat::create($input);
        notify()->success('Cliente Csat ingresado correctamente ⚡️','Añadido');
        return redirect()->route('csat.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientsCsat  $clientsCsat
     * @return \Illuminate\Http\Response
     */
    public function show(ClientsCsat $clientsCsat)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientsCsat  $clientsCsat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client=ClientsCsat::FindOrFail($id);
        return view('csat.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientsCsat  $clientsCsat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate=$this->validate($request,[
            'rut'=>['required','regex:/(\d{1,2}(?:\.\d{1,3}){2}-[\dkK])$/','string','min:11','max:12',"unique:clients_csat,rut,$id"],
            'names'=>['required','string'],
            'vip_sala'=>['sometimes','in:1'],
            'description'=>['nullable']
        ]);
        $client=ClientsCsat::FindOrFail($id);
        $input=$request->all();
        $request->input('vip_sala') ?'': $input=Arr::add($input,'vip_sala',0);
        $client->update($input);
        notify()->success('Cliente Csat actualizo correctamente ⚡️','Editar');
        return redirect()->route('csat.index'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientsCsat  $clientsCsat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $client=ClientsCsat::FindOrFail($id);
        $client->delete();
        notify()->success('Cliente Csat eliminado correctamente 🗑','Eliminado');
        return redirect()->route('csat.index');
    }

    public function importCsat(Request $request){
        $validate=$this->validate($request,[
            'excel'=>['required','mimes:csv,xlsx,txt','max:2048']
        ]);
        $file = $request->file('excel');

        $rows = Excel::toArray(new CsatImport, $file);
        $matchedData = [];

        $databaseRuts = ClientsCsat::pluck('rut')->toArray();

        $rows=$rows[0];
        $excelRut=[];
        
        for ($i=0;$i<count($rows);$i++) {
            $excelRut=$rows[$i]['rut_cliente'];
            if (in_array($excelRut, $databaseRuts)) {
                $matchedData[] = $rows[$i];
            }
        }

        $message='Datos importados, Sin pedidos realizados por clientes csat ✖';
        if (count($matchedData)>=1) {
            $message='Datos importados correctamente, verificar pedidos reaalizados ✔';
        }

        notify()->success($message,'Csat Import pedidos');
        return redirect()->route('csat.index')->with(['orderCsat'=>$matchedData]);
    }
    
    public function exportCsat(){

    }

    public function importOrderCsat(){

    }
}
