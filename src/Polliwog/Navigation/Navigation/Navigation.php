<?php namespace FrenchFrogs\Polliwog\Navigation\Navigation;


class Navigation
{
    const NAMESPACE_DEFAULT = 'default';

    /**
     * Navigation container
     *
     * @var array
     */
    protected $pages = [];

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
     * Setter for $pages container
     *
     * @param array $pages
     * @return $this
     */
    public function setPages(array $pages)
    {
        $this->pages = $pages;
        return $this;
    }


    /**
     * Getter for $pages container
     *
     * @return array
     */
    public function getPages()
    {
        return $this->pages;
    }


    /**
     * Clear $pages container
     *
     * @return $this
     */
    public function clearPages()
    {
        $this->pages = [];
        return $this;
    }


    public function addPage($index, $label = '', $link = '#', $permission = null, $parent = null)
    {
        $this->pages[$index] = compact('label', 'link', 'permission', 'parent');

    }










}