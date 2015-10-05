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

    public function hasToken()
    {
        return isset($this->token);
    }

    public function generateToken()
    {
        $this->token = 'table.' . md5(static::class . microtime());
        return $this;
    }

    /**
     *
     */
    public function save() {

        if(!$this->hasToken()) {
            $this->generateToken();
        }

        Session::push($this->getToken(), json_encode(['class' => static::class]));
        return $this;
    }


    static public function load($token)
    {
        if (!Session::has($token)){
            throw new \InvalidArgumentException('Token "' . $token .'" is not valid');
        }

        $config = Session::get($token);
        $config = json_decode($config[0]);

        $instance = new \ReflectionClass($config->class);
        return $instance->newInstance();
    }
}