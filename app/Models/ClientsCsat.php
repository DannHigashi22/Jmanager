<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsCsat extends Model
{
    use HasFactory;

    protected $table='clients_csat';

   protected $fillable = [
        'rut','names','vip_sala','description','created_by'
    ];


}
