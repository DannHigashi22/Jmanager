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

        return redirect()->route('errors.index');
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
        return redirect()->route('errors.index');
    }
}
