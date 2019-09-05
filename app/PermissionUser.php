<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    //
    protected $fillable = [ 
        'user_id', 'permission_id'
    ];

    public function users_id(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function permissions_id(){
        return $this->hasOne(Permission::class, 'permission_id');
    }
}
