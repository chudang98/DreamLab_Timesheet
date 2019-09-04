<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    //
    protected $fillable = [ 
        'users_id', 'permissions_id'
    ];

    public function users_id(){
        return $this->belongsTo(User::class,'users_id');
    }

    public function permissions_id(){
        return $this->hasOne(Permission::class, 'permissions_id');
    }
}
