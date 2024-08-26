<?php

namespace Database\Seeders;

use App\Models\Error;
use App\Models\User;
use Illuminate\Database\Seeder;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

//spatie
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TablePermisions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //seeder inicial

        //permisos
        $permisssions=[
            //table audits
            'show-audit','create-audit','edit-audit','delete-audit','importShpr-audit','exportShpr-audit',
            //table errors
            'show-error','create-error','edit-error','delete-error',
            //table roles
            'show-rol','create-rol','edit-rol','delete-rol',
            //table user
            'show-user','create-user','edit-user','delete-user',
            //table clients_csat
            'show-csat','create-csat','edit-csat','delete-csat','import-csat','export-csat','order-csat',  
        ];

        foreach ($permisssions as $permi){
            Permission::create(['name'=>$permi]);
        }

        //errores y tipos
        $errors_type=[
            'Faltante encontrado','Atraso','Error de patente','Productos sin hielo','Mal embolsado','Facturacion','Carro Olvidado','Mal gestion'
        ];
        foreach ($errors_type as $error) {
            Error::create(['type'=>$error]);
        }

        //Roles Basicos
        $roles_type=[
            'Super Administrador','Administrador', 'Auditor'
        ];
        foreach ($roles_type as $rol) {
            Role::create(['name'=>$rol]);
        }

        //Permisos
        $permission=Permission::get();
        $role=Role::where('name','Super Administrador')->firstOrFail();
        $role->syncPermissions($permisssions);

        //SuperUsuario
        $user=User::create([
            'name'=>'Dann',
            'surname'=>'Higashi',
            'email'=>'dann.higashievangelista@jumbo.cl',
            'password'=>Hash::make(123456789),
            'status'=>1,
        ]);
        $user->assignRole('Super Administrador');
        event(new Registered($user));
    }
}
