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
        'modal.class' => Polliwog\Modal\Modal\Bootstrap::class,
        'modal.renderer.class' => Polliwog\Modal\Renderer\Bootstrap::class,
        'modal.closeButtonLabel' => 'Fermer',
        'modal.backdrop' => true,
        'modal.escToclose' => true,
        'modal.is_remote' => false,
        'modal.remote.id' => 'modal-remote',
    ];

    /**
     * Instances
     *
     * @var array
     */
    protected static $instances = [];

    /**
     * constructor du singleton
     *
     * @param $namespace
     * @return static
     */
    public static function getInstance($namespace = null) {

        $namespace = is_null($namespace) ? static::NAMESPACE_DEFAULT : $namespace;

        if (!array_key_exists($namespace, self::$instances)) {
            static::$instances[$namespace] = new static();
        }

        return static::$instances[$namespace];
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
     * @return mixed
     */
    public function get($index, $default = null)
    {

        if ($this->has($index)) {
            return $this->config[$index];
        }
        return $default;
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
     * @param array $config
     */
    public function setAll(array $config)
    {
       $this->config = $config;
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