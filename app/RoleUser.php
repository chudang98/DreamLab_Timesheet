<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    //
    protected $fillable = [
        'roles_id', 'users_id'
    ];
}
