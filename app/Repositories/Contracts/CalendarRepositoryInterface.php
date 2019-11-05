<?php

namespace App\Repositories\Contracts;

interface CalendarRepositoryInterface{

    public function findByDate($date);

    public function insertDay($d);

    public function updateDay($d);
}
