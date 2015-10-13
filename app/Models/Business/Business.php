<?php namespace Models\Business;

use Models\Db;

abstract class Business
{


    /**
     * Primary key
     *
     * @var
     */
    protected $id;


    /**
     * Model user
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;


    /**
     * Class Name of the main model
     *
     * @var string
     */
    static protected $modelClass;

    /**
     * Constructor
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }


    /**
     * factory
     *
     * @param $id
     * @return \Models\Business\Business
     */
    static public function get($id)
    {
        return new static($id);
    }

    /**
     * Getter for ID
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return User as an array
     *
     * @return array
     */
    public function toArray()
    {
        return  $this->getModel()->toArray();
    }

    /**
     * return the main model
     *
     * @param bool|false $reload
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel($reload = false)
    {
        if (!isset($this->model) || $reload) {
            $class = static::$modelClass;
            $this->model = $class::findOrFail($this->getId());
        }

        return $this->model;
    }


    /**
     * Save the model
     *
     * @param array $data
     * @return $this
     */
    public function save(array $data)
    {
        $model = $this->getModel()->update($data);
        return $this;
    }

    /**
     * Factory
     *
     * @param $data
     * @return \Models\Business\Business
     */
    static public function create($data)
    {
        $class = static::$modelClass;
        /** @var  \Illuminate\Database\Eloquent\Model $model */
        $model = $class::create($data);

        return static::get($model->getKey());
    }


    /**
     * return true id user exist
     *
     * @param $id
     * @return bool
     */
    static public function exists($id)
    {
        try {
            $class = static::$modelClass;
            $class::findOrFail($id);
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

}