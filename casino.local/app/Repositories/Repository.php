<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function allWithTrashed()
    {
        return $this->model->withTrashed()->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $record = $this->model->find($id);

        return $record->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function deleteOrRestore($id)
    {
        if ($this->trashed($object = $this->oneWithTrashed($id))) {
            return $this->restore($object);
        }

        return $this->delete($id);
    }

    public function one($id)
    {
        return $this->model->findOrFail($id);
    }

    public function oneWithTrashed($id)
    {
        return $this->model->withTrashed()->findOrFail($id);
    }

    public function restore($object)
    {
        return $object->restore();
    }

    public function trashed($object)
    {
        return $object->trashed();
    }

    public function getModel()
    {
        return $this->model;
    }

    public function where(array $queries, array $searches, ?array $operators = null)
    {
        foreach ($queries as $key => $query) {
            $this->model = $this->model->where($query, $operators[$key] ?? '=', $searches[$key]);
        }
        return $this->model;
    }
}
