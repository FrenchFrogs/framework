<?php namespace FrenchFrogs\Container;


class Container
{

    const NAMESPACE_DEFAULT = 'default';

    /**
     * @var string
     */
    protected $container = [];


    /**
     * Glue for g"nération
     *
     * @var string
     */
    protected $glue = PHP_EOL;

    /**
     * Instances
     *
     * @var array
     */
    static protected $instances = [];


    /**
     * Protected constructor for singleton
     *
     * Container constructor.
     */
    protected function __construct() {

    }

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
     * Setter for $glue
     *
     * @param $glue
     * @return $this
     */
    public function setGlue($glue)
    {
        $this->glue = $glue;
        return $this;
    }


    /**
     * Getter for $glue
     *
     * @return string
     */
    public function getGlue()
    {
        return $this->glue;
    }


    /**
     * Setter for $container attribute
     *
     * @param $container
     * @return $this
     */
    public function set(array $container)
    {
        $this->container = $container;
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
        $this->container = [];
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
        $this->container[] = $container;
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
        array_unshift($this->container, $container);
        return $this;
    }


    /**
     *
     *
     * @return string
     */
    public function __toString()
    {
        return implode($this->glue, $this->container);
    }
}