<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface{

    public function updateName($id, $name);

    public function updatePW($id , $pw);
}
