<?php

namespace App\Repositories\Calendar;

interface CalendarRepositoryInterface{

    public function findByDate($date);

    public function insertDay($d);

    public function updateDay($d);
}
