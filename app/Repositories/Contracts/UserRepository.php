<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Contracts;
 */
interface UserRepository extends RepositoryInterface
{
    //
    public function updateName($id, $name);

    public function updatePW($id , $pw);
}
