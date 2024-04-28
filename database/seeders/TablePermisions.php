<?php

namespace Database\Seeders;

use App\Models\Error;
use Illuminate\Database\Seeder;

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
    }
}
