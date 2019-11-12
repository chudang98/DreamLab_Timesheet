<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DayRepository.
 *
 * @package namespace App\Contracts;
 */
interface DayRepository extends RepositoryInterface
{
    //
//    public function findByDate($date);

    public function insertDay($d);

    public function updateDay($d);
}
