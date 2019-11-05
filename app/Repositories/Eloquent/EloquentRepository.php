<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Contracts\CriteriaInterface;
use App\Repositories\Criteria\Criteria;
use mysql_xdevapi\Collection;


abstract class EloquentRepository implements RepositoryInterface, CriteriaInterface{
    protected $_model;
    protected $criteria;
    protected $skipCriteria = false;

    public function __construct()
    {
        $this->setModel();
//        $this->criteria= $collection;
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->_model = $this->getModel();
    }

    public function getAll()
    {
        return $this->_model::all();
    }


    public function all($columns = array('*')) {
        $this->applyCriteria();
        return $this->model->get($columns);
    }

    public function paginate($perPage = 1, $columns = array('*')) {
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    public function find1($id, $columns = array('*')) {
        $this->applyCriteria();
        return $this->model->find($id, $columns);
    }

    public function find($id)
    {
        $result = $this->_model::where("id", $id)->first();
        return $result;
    }

    public function findBy($attribute, $value, $columns = array('*')) {
        $this->applyCriteria();
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    public function create(array $attributes)
    {

        return $this->_model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();
        }
    }
    public function resetScope() {
        $this->skipCriteria(false);
        return $this;
    }


    public function skipCriteria($status = true){
        $this->skipCriteria = $status;
        return $this;
    }


    public function getCriteria() {
        return $this->criteria;
    }


    public function getByCriteria(Criteria $criteria) {
        $this->model = $criteria->apply($this->model, $this);
        return $this;
    }


    public function pushCriteria(Criteria $criteria) {
        $this->criteria->push($criteria);
        return $this;
    }


    public function  applyCriteria() {
        if($this->skipCriteria === true)
            return $this;

        foreach($this->getCriteria() as $criteria) {
            if($criteria instanceof Criteria)
                $this->model = $criteria->apply($this->model, $this);
        }

        return $this;
    }
}
