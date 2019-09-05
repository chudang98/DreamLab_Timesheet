<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable =[
        'id', 'name'
    ];

    public function user(){
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }
    
}
