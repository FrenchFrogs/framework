<?php namespace FrenchFrogs\Table\Column;


class Custom extends Column
{

    protected $custom;


    /**
     * Return TRUE if $custom is set
     *
     * @return bool
     */
    public function hasCustom()
    {
        return isset($this->custom);
    }

    /**
     * Unset $custom
     *
     * @return $this
     */
    public function removeCustom()
    {
        unset($this->custom);
        return $this;
    }

    /**
     * SETTER for $custom
     *
     * @param $custom
     * @return $this
     */
    public function setCustom($custom)
    {
        if (!is_callable($custom)) {
            throw new \InvalidArgumentException('"' . $custom . '" is not callable');
        }

        $this->custom = $custom;
        return $this;
    }

    /**
     * GETTER for $custom
     *
     * @return mixed
     */
    public function getCustom()
    {
        return $this->custom;
    }

    /**
     *
     * Custom constructor.
     * @param $name
     * @param $label
     * @param $function callable
     */
    public function __construct($name, $label, $function )
    {
        $this->setName($name);
        $this->setLabel($label);
        $this->setCustom($function);
    }

    /**
     *
     *
     * @param $row
     * @return mixed|string
     * @throws \Exception
     */
    public function getValue($row) {

        $value = isset($row[$this->getName()]) ? $row[$this->getName()] : '';
        if ($this->hasFilterer()) {
            $value = $this->getFilterer()->filter($value);
        }
        return $value;
    }

    /**
     *
     *
     * @return string
     */
    public function render(array $row)
    {
        $render = '';
        try {
            $render = $this->getRenderer()->render('custom', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}