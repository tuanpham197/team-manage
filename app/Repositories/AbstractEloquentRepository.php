<?php

declare(strict_types=1);

namespace App\Repositories;

abstract class AbstractEloquentRepository implements RepositoryInterface
{
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    protected function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return $this->_model->all();
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->_model->find($id);
    }

    public function create(array $attributes)
    {
        // TODO: Implement create() method.
        return $this->_model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        // TODO: Implement update() method.
        return $this->_model->where('id', $id)->update($attributes);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->_model->where('id', $id)->delete();
    }

    /**
     * @return mixed
     */
    abstract public function getModel();
}
