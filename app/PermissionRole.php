<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    //
    protected $fillable = [ 
        'roles_id', 'permissions_id'
    ];


    public function roles_id(){
        return $this->hasOne(Role::class, 'roles_id');
    }

    public function permissions_id(){
        return $this->hasOne(Permission::class, 'permissions_id');
    }
}
