<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function all();

    public function allWithTrashed();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function deleteOrRestore($id);

    public function one($id);

    public function oneWithTrashed($id);

    public function restore($object);

    public function trashed($object);

    public function getModel();

    public function where(array $queries, array $searches, ?array $operators = null);
}
