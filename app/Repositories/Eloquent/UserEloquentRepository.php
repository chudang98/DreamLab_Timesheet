<?php

namespace App\Repositories\Eloquent;

use App\User;
use DB;
use App\Repositories\Eloquent\EloquentRepository;

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
