<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    //
    protected $fillable = [ 
        'role_id', 'permission_id'
    ];


    public function role_id(){
        return $this->hasOne(Role::class, 'role_id');
    }

    public function permission_id(){
        return $this->hasOne(Permission::class, 'permission_id');
    }
}
