<?php namespace FrenchFrogs\Core;


class Configurator
{


    /**
     * Configurator container
     *
     *
     * @var array
     */
    static protected $config = [];


    /**
     * Get a config from $index
     *
     * @param $index
     * @return null
     */
    static public function get($index)
    {

        if (self::has($index)) {
            return self::$config[$index];
        }
    }

    /**
     * Return TRUE if $index exist in config container
     *
     * @param $index
     * @return bool
     */
    static public function has($index)
    {
        return isset(self::$config[$index]);
    }


    /**
     * Add a single config in $config
     *
     * @param $index
     * @param $value
     */
    static public function add($index, $value)
    {
        self::$config[$index] = $value;
    }

    static public function remove($index)
    {
        if (self::has($index)) {
            unset(self::$config[$index]);
        }
    }

    static public function setAll(array $allconfig)
    {
       self::$config = $allconfig;
    }

    static public function getAll()
    {
        return self::$config;
    }

    static public function clearAll()
    {
        self::$config = [];
    }
}