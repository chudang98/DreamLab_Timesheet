<?php

namespace App\Repositories;

use App\User;
use DB;

class UserEloquentRepository extends EloquentRepository{

    public function getModel()
    {
        return User::class;
    }

    public function updateName($id, $name){
        DB::table('users')->where('id', $id)
            ->update([
                'name' =>$name
            ]);
    }

    public function updatePW($id , $pw){
        DB::table('users')->where('id', $id)
            ->update([
                'password' =>$pw
            ]);
    }
}
