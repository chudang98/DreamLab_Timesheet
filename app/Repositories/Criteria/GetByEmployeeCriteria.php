<?php

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\User;

/**
 * Class GetByEmployeeCriteria.
 *
 * @package namespace App\RepositoriesCriteria;
 */
class GetByEmployeeCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    protected $employee;
    public function __construct($employee)
    {
        $this->employee = $employee;
    }
    public function apply($model, RepositoryInterface $repository)
    {
        $user = User::select('id')
            ->where('employee_id', 'LIKE', "%{$this->employee}%")
            ->orWhere('name', 'LIKE', "%{$this->employee}%");
        $model= $model->whereIn('user_id', $user);
        return $model;
    }
}
