<?php

namespace App\Repositories\User;

interface UserRepositoryInterface{

    public function updateName($id, $name);

    public function updatePW($id , $pw);
}
