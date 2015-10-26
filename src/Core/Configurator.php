<?php namespace FrenchFrogs\Core;

use FrenchFrogs;


class Configurator
{

    const NAMESPACE_DEFAULT = 'default';

    /**
     * Config
     *
     * @var array
     */
    protected $config = [
        'panel.class' => FrenchFrogs\Panel\Panel\Panel::class,
        'panel.renderer.class' =>  FrenchFrogs\Panel\Renderer\Bootstrap::class,


        'table.class' => FrenchFrogs\Table\Table\Table::class,
        'table.renderer.class' => FrenchFrogs\Table\Renderer\Bootstrap::class,
        'table.filterer.class' => FrenchFrogs\Filterer\Filterer::class,

        'table.column.date.format' => 'd/m/Y',

        'form.renderer.class' => FrenchFrogs\Form\Renderer\Bootstrap::class,
        'form.renderer.modal.class' => FrenchFrogs\Form\Renderer\Modal::class,
        'form.validator.class' => FrenchFrogs\Validator\Validator::class,
        'form.filterer.class' => FrenchFrogs\Filterer\Filterer::class,

        'form.default.method' => 'POST',
        'form.default.has_csrfToken' => true,

        'modal.class' => FrenchFrogs\Modal\Modal\Modal::class,
        'modal.renderer.class' => FrenchFrogs\Modal\Renderer\Bootstrap::class,
        'modal.closeButtonLabel' => 'Fermer',
        'modal.backdrop' => true,
        'modal.escToclose' => true,
        'modal.is_remote' => false,
        'modal.remote.id' => 'modal-remote',


        'ruler.class' => FrenchFrogs\Ruler\Ruler\Ruler::class,
        'ruler.renderer.class' => FrenchFrogs\Ruler\Renderer\Conquer::class,

        'toastr.success.default' => 'Action realised with success',
        'toastr.error.default' => 'Oups, something bad happened',
        'toastr.warning.default' => 'Something happened....',


        'button.edit.icon' => 'fa fa-pencil',
        'button.edit.name' => 'ff_edit',
        'button.edit.label' => 'Edit',

        'button.delete.icon' => 'fa fa-trash-o',
        'button.delete.name' => 'ff_delete',
        'button.delete.label' => 'Delete',


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
     * Return an instantiated object
     *
     * @param $index
     * @param null $default
     * @return mixed
     * @throws \Exception
     */
    public function build($index, $default = null)
    {
        $class = $this->get($index, $default);
        if (!class_exists($class)) {
            throw new \Exception('Class doesn\'t exist for the index : ' .$index);
        }

        return new $class;
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