<?php namespace FrenchFrogs\Core;

use FrenchFrogs\Polliwog;


class Configurator
{

    const NAMESPACE_DEFAULT = 'default';

    /**
     * Config
     *
     * @var array
     */
    protected $config = [
        'panel.class' => Polliwog\Panel\Panel\Panel::class,
        'panel.renderer.class' =>  Polliwog\Panel\Renderer\Bootstrap::class,
        'table.class' => Polliwog\Table\Table\Table::class,
        'table.renderer.class' => Polliwog\Table\Renderer\Bootstrap::class,

        'modal.class' => Polliwog\Modal\Modal\Modal::class,
        'modal.renderer.class' => Polliwog\Modal\Renderer\Bootstrap::class,
        'modal.backdrop' => true,
        'modal.escToclose' => true
    ];

    /**
     * Instances
     *
     * @var array
     */
    static protected $instances = [];

    /**
     * constructor du singleton
     *
     * @return Configurator
     */
    static function getInstance($namespace = null) {

        $namespace = is_null($namespace) ? static::NAMESPACE_DEFAULT : $namespace;

        if (!array_key_exists($namespace, self::$instances)) {
            self::$instances[$namespace] = new Configurator();
        }

        return self::$instances[$namespace];
    }


    /**
     * Constructor for a default configuration
     */
    protected function __construct()
    {

    }


    /**
     * Get a config from $index
     *
     * @param $index
     * @param null $default
     * @return null
     */
    public function get($index, $default = null)
    {

        if ($this->has($index)) {
            return $this->config[$index];
        } else {
            return $default;
        }
    }

    /**
     * Return TRUE if $index exist in config container
     *
     * @param $index
     * @return bool
     */
    public function has($index)
    {
        return array_key_exists($index, $this->config);
    }

    /**
     * Merge $config with $config attribute
     *
     * @param array $config
     * @return $this
     */
    public function merge(array $config)
    {
        $this->config = array_merge($this->config,$config);
        return $this;
    }


    /**
     * Add a single config in $config
     *
     * @param $index
     * @param $value
     */
    public function add($index, $value)
    {
        $this->config[$index] = $value;
    }


    /**
     * Remove a single config in $config container
     *
     * @param $index
     */
    public function remove($index)
    {
        if ($this->has($index)) {
            unset($this->config[$index]);
        }
    }

    /**
     * Setter for all the $config container
     *
     * @param array $allconfig
     */
    public function setAll(array $allconfig)
    {
       $this->config = $allconfig;
    }


    /**
     * Getter for all $config container
     *
     * @return array
     */
    public function getAll()
    {
        return $this->config;
    }

    /**
     * Clear $config container
     *
     */
    public function clearAll()
    {
        $this->config = [];
    }
}