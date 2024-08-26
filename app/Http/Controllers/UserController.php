<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use Illuminate\Auth\Events\Registered;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show-user|create-user|edit-user|delete-user',['only'=>['index']]);
        $this->middleware('permission:create-user',['only'=>['create','store']]);
        $this->middleware('permission:edit-user',['only'=>['edit','update']]);
        $this->middleware('permission:delete-user',['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::paginate(10);

        $title = 'Borrar Usuario!';
        $text = "estas seguro de borrar?";
        confirmDelete($title, $text);
        
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::pluck('name','name')->all();
        return view('user.create',compact('roles'));
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
            'name' => ['required', 'string', 'max:255'],
            'surname'=>['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles'=>['required','exists:roles,name',
                Rule::when(Auth::user()->getRoleNames()[0] !== 'Super Administrador',  'not_regex:(Super Administrador)')],
            'status'=>['required','boolean']
        ]);

        $input=$request->all();
        $input=Arr::add($input,'status',0);
        $input['password']=Hash::make($input['password']);
        
        $user=User::create($input);
        $user->assignRole($request->input('roles'));
        event(new Registered($user));
        notify()->success('Usuario creado correctamente⚡️','Creado');
        return redirect()->route('users.index');
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
        $user=User::findOrFail($id);
        $roles=Role::pluck('name','name');
        $userRole=$user->roles->pluck('name','name')->all();
        return view('user.edit',compact('user','roles','userRole'));
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
            'name' => ['required', 'string', 'max:255'],
            'surname'=>['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,$id"],
            'password' => ['nullable','string', 'min:8', 'same:password_confirmation'],
            'roles'=>['required','exists:roles,name',
            Rule::when(Auth::user()->getRoleNames()[0] !== 'Super Administrador',  'not_regex:(Super Administrador)')],
            'status'=>['required','boolean']
        ]);
        
        $input=$request->all();
        if (!empty($input['password'])) {
            $input['password']=Hash::make($input['password']);
        }else{
            $input=Arr::except($input,array('password'));
        }
        $user=User::FindOrFail($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));
        notify()->success('Usuario actualizado correctamente ⚡️','Editar');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        notify()->success('Usuario eliminado correctamente 🗑','Eliminacion');
        return redirect()->route('users.index');
    }
}
