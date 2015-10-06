<?php namespace FrenchFrogs\Polliwog\Table\Table;

use Session;

trait Datatable
{

    /**
     *
     *
     * @var
     */
    protected $is_datatable;

    /**
     *
     *
     * @var
     */
    protected $is_remote;


    /**
     * Session token for remote
     *
     * @var
     */
    protected $token;


    /**
     * If a single token if set, it mean that this class can only have a single instance
     *
     * @var
     */
    static protected $singleToken;


    /**
     * @return bool
     */
    static public function hasSingleToken()
    {
        return !empty(static::$singleToken);
    }

    /**
     *
     * @return mixed
     */
    static public function getSingleToken()
    {
        return static::$singleToken;
    }


    /**
     * Set TRUE to $is_remote
     *
     * @return $this
     */
    public function enableRemote()
    {
        $this->is_remote = true;
        return $this;
    }

    /**
     * Set FALSE to $is_remote attribute
     *
     * @return $this
     */
    public function disableRemote()
    {
        $this->is_remote = false;
        return $this;
    }

    /**
     * Return TRUE is datatable ajax is enable
     *
     * @return mixed
     */
    public function isRemote()
    {
        return $this->is_remote;
    }


    /**
     * Set $is_datatable attribute
     *
     * @param $datatable
     * @return $this
     */
    public function enableDatatable()
    {
        $this->is_datatable = true;
        return $this;
    }

    /**
     * Set to FALSE $is_datatable
     *
     * @return $this
     */
    public function disableDatatable()
    {
        $this->is_datatable = false;
        return $this;
    }

    /**
     * Return TRUE if datatable is enabled
     *
     * @return mixed
     */
    public function isDatatable()
    {
        return $this->is_datatable;
    }

    /**
     * Return true if $is_datatable is set
     *
     * @return bool
     */
    public function hasDatatable()
    {
        return isset($this->is_datatable);
    }

    /**
     * Getter for $token attribute
     *
     * @return mixed
     */
    public function getToken()
    {
     return $this->token;
    }

    /**
     * Setter for $token attribute
     *
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = strval($token);
        return $this;
    }


    /**
     * Return TRUE if the datatble have a token
     *
     * @return bool
     */
    public function hasToken()
    {
        return isset($this->token);
    }

    /**
     * Generate a token and fill it
     *
     * @return $this
     */
    public function generateToken()
    {
        $this->token = 'table.' . md5(static::class . microtime());
        return $this;
    }

    /**
     * Save the Table configuration in Session
     *
     */
    public function save() {

        if(!$this->hasToken()) {
            if (static::hasSingleToken()) {
                $this->setToken(static::getSingleToken());
            } else {
                $this->generateToken();
            }
        }

        Session::push($this->getToken(), json_encode(['class' => static::class]));
        return $this;
    }


    /**
     * Load a datable from a token
     *
     * @param $token
     * @return object
     */
    static public function load($token = null)
    {

        if (is_null($token) && static::hasSingleToken()) {
            $token = static::getSingleToken();
        }

        if (!Session::has($token)){
            if (static::hasSingleToken()) {
                Session::push($token, json_encode(['class' => static::class]));
            } else {
                throw new \InvalidArgumentException('Token "' . $token . '" is not valid');
            }
        }

        $config = Session::get($token);
        $config = json_decode($config[0]);

        $instance = new \ReflectionClass($config->class);
        return $instance->newInstance();
    }
}