<?php

Namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Audit extends Model
{
   use HasFactory;
   
   protected $fillable = [
        'user_id', 'order', 'shopper','type','description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function errors()
    {
        return $this->belongsToMany(Error::class,'audit_error','audit_id','error_id')->withTimestamps();
    }

}
