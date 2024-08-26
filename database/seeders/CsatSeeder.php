<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CsatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisssions=[
            //table clients_csat
            'show-csat','create-csat','edit-csat','delete-csat','import-csat','export-csat','order-csat',  
        ];
        foreach ($permisssions as $permi){
            Permission::create(['name'=>$permi]);
        }

        

    }
}
