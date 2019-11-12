<?php

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindDayByDateCriteria.
 *
 * @package namespace App\RepositoriesCriteria;
 */
class FindDayByDateCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    protected $date;
    public function __construct($date)
    {
        $this->date = $date;
    }
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where("date", $this->date);
//        dd($model);
        return $model;
    }
}
