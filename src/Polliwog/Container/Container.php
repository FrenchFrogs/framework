<?php namespace FrenchFrogs\Polliwog\Container;


class Container
{

    const NAMESPACE_DEFAULT = 'default';

    /**
     * @var string
     */
    protected $container = '';

    /**
     * Instances
     *
     * @var array
     */
    static protected $instances = [];

    /**
     * constructor du singleton
     *
     * @return Container
     */
    static function getInstance($namespace = null) {

        $namespace = is_null($namespace) ? static::NAMESPACE_DEFAULT : $namespace;

        if (!array_key_exists($namespace, static::$instances)) {
            self::$instances[$namespace] = new static();
        }

        return self::$instances[$namespace];
    }


    /**
     * Setter for $container attribute
     *
     * @param $container
     * @return $this
     */
    public function set($container)
    {
        $this->container = strval($container);
        return $this;
    }


    /**
     * Getter for $ container attribute
     *
     * @return string
     */
    public function get()
    {
        return $this->container;
    }


    /**
     * Clear the $container attribute
     *
     * @return $this
     */
    public function clear()
    {
        $this->container = '';
        return $this;
    }

    /**
     * Append raw string
     *
     * @param $container
     * @return $this
     */
    public function append($container)
    {
        $this->container .= PHP_EOL . $container;
        return $this;
    }



    /**
     * Prepend $container into container attribute
     *
     * @param $container
     * @return $this
     */
    public function prepend($container)
    {
        $this->container = $container . PHP_EOL . $this->container;
        return $this;
    }


    public function __toString()
    {
        return $this->get();
    }
}