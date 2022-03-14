<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model
     */
    protected $AppVersionModel;

    /**
     *
     */
    public function boot()
    {
        //
    }

    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Sync relations
     *
     * @param $id
     * @param $relation
     * @param $attributes
     * @param bool $detaching
     * @return mixed
     */
    public function sync($id, $relation, $attributes, $detaching = true)
    {
        return $this->find($id)->{$relation}()->sync($attributes, $detaching);
    }

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        return $this->AppVersionModel->get($columns);
    }

    /**
     * Retrieve first data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function first($columns = ['*'])
    {
        return $this->AppVersionModel->first($columns);
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->AppVersionModel->findOrFail($id, $columns);
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        $model = $this->AppVersionModel->newInstance($attributes);
        $model->save();

        return $model;
    }

    /**
     * Update a entity in repository by id
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update($id, array $attributes)
    {
        $model = $this->AppVersionModel->findOrFail($id);

        $model->fill($attributes);
        $model->save();

        return $model;
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        $model = $this->find($id);

        $deleted = $model->delete();

        return $deleted;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model();

    /**
     * @return Model
     * @throws Exception
     */
    public function makeModel()
    {
        $model = app()->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->AppVersionModel = $model;
    }
}
