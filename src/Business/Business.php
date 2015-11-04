<?php namespace FrenchFrogs\Business;

/**
 * Overload Eloquent model for better use
 *
 * Class Business
 * @package FrenchFrogs\Business
 */
abstract class Business
{

    const UUID_VERSION = 5;

    /**
     * Set to TRUE if Business is managed with UUID as primary key
     *
     * @var bool
     */
    static protected $is_uuid = true;

    /**
     * Primary key
     *
     * @var
     */
    protected $id;


    /**
     * Model
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
        $model = $this->getModel();
        $model->update($data);
        return $this;
    }

    /**
     * Generate UUid v5 for the current business model
     *
     * @return mixed
     * @throws \Exception
     */
    static public function generateUuid()
    {
        return \Uuid::generate(4)->bytes;
    }

    /**
     * Factory
     *
     * @param $data
     * @return \Models\Business\Business
     */
    static public function create(array $data)
    {
        $class = static::$modelClass;

        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = new $class;

        // set primarye key
        if(static::isUuid() && empty($data[$model->getKeyName()])) {
            $data[$model->getKeyName()] = static::generateUuid();
        }

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

    /**
     * Return true if $is_uuid id true
     *
     * @return bool
     */
    static function isUuid()
    {
        return (bool) static::$is_uuid;
    }

}