<?php

namespace App\Repositories\Contracts\CriteriaInterface;

use App\Repositories\Criteria\Criteria;

interface CriteriaInterface{
    public function skipCriteria($status = true);


    public function getCriteria();


    public function getByCriteria(Criteria $criteria);


    public function pushCriteria(Criteria $criteria);


    public function  applyCriteria();
}
