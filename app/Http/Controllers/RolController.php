<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//para spatie
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RolController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show-rol|create-rol|edit-rol|delete-rol', ['only' => ['index']]);
        $this->middleware('permission:create-rol',['only'=>['create','store']]);
        $this->middleware('permission:edit-rol',['only'=>['edit','update']]);
        $this->middleware('permission:delete-rol',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Role::paginate(10);
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission=Permission::get();
        return view('roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'permission'=>'required'
        ]);
        $role=Role::create(['name'=>$request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        notify()->success('Datos creado correctamente⚡️','Creado');
        return redirect()->route('roles.index');
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
        $role=Role::findOrFail($id);
        $permission=Permission::get();
        $rolePermissions=DB::table('role_has_permissions')->where('role_has_permissions.role_id',$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();

        return view('roles.edit',compact('role','permission','rolePermissions'));
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
        $this->validate($request,[
            'name'=>'required',
            'permission'=>'required'
        ]);
        $role=Role::findOrFail($id);
        $role->name=$request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        notify()->success('Datos actualizados correctamente ⚡️','Editar');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Db::table('roles')->where('id',$id)->delete();
        notify()->success('Datos eliminado correctamente 🗑','Eliminacion');
        return redirect()->route('roles.index');
    }
}
