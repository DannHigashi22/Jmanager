<?php

namespace App\Http\Controllers;

use App\Models\Error;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show-error|create-error|edit-error|delete-error',['only'=>['index']]);
        $this->middleware('permission:create-error',['only'=>['create','store']]);
        $this->middleware('permission:edit-error',['only'=>['edit','update']]);
        $this->middleware('permission:edelete-error',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $errors=Error::paginate(10);

        $title ='Borrar Tipo error!';
        $text = "estas seguro de borrar?";
        confirmDelete($title, $text);

        return view('error.index',compact('errors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('error.create');
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
            'type'=>['required','string']
        ]);
        $error=New Error();
        $error->type=$request->input('type');
        $error->save();
        notify()->success('Auditoria ingresada correctamente, gracias por su tiempo ⚡️','Creado');
        return redirect()->route('errors.index')->with(['type'=>'success','message'=>'Datos creado correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $error=Error::findOrFail($id);
        return view('error.edit',compact('error'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate=$this->validate($request,[
            'type'=>['required','string',"unique:errors,type,$id"]
        ]);
        $error=Error::findOrFail($id);
        $error->type=$request->input('type');
        $error->update();
        notify()->success('Datos actualizados correctamente ⚡️','Editar');
        return redirect()->route('errors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $error=Error::findOrFail($id);
        $error->delete();
        notify()->success('Datos eliminado correctamente 🗑','Eliminacion');
        return redirect()->route('errors.index');
    }
}
