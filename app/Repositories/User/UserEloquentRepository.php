<?php

namespace App\Repositories\User;

use App\User;
use DB;
use App\Repositories\EloquentRepository;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface {

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
