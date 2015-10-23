<?php namespace FrenchFrogs\Table\Table;


trait Bootstrap
{

    /**
     *
     * Add zebra-striping to any table row within the <tbody>
     *
     * @link http://getbootstrap.com/css/#tables-striped
     *
     * @var bool
     */
    protected $is_striped = true;

    /**
     * Borders on all sides of the table and cells
     *
     * @link http://getbootstrap.com/css/#tables-bordered
     *
     * @var bool
     */
    protected $is_bordered = false;


    /**
     * Enable a hover state on table rows within a <tbody>
     *
     * @link http://getbootstrap.com/css/#tables-hover-rows
     *
     * @var bool
     */
    protected $has_hover = true;

    /**
     * Make tables more compact by cutting cell padding in half.
     *
     * @link http://getbootstrap.com/css/#tables-condensed
     *
     * @var bool
     */
    protected $is_condensed = true;

    /**
     * Create responsive tables by making them scroll horizontally on small devices
     *
     * @link http://getbootstrap.com/css/#tables-responsive
     *
     * @var bool
     */
    protected $is_responsive = true;




    /**
     * Setter for $is_stripped attribute
     *
     * @return $this
     */
    public function enableStriped()
    {
        $this->is_striped = true;
        return $this;
    }

    /**
     * Setter for $is_stripped attribute
     *
     * @return $this
     */
    public function disableStriped()
    {
        $this->is_striped = false;
        return $this;
    }

    /**
     * Return TRUE if $is_stripped attribute is TRUE
     *
     * @return bool
     */
    public function isStriped()
    {
        return (bool) $this->is_striped;
    }

    /**
     * Setter for $is_bordered attribute
     *
     * @return $this
     */
    public function enableBordered()
    {
        $this->is_bordered = true;
        return $this;
    }

    /**
     * Setter for $is_bordered attribute
     *
     * @return $this
     */
    public function disableBordered()
    {
        $this->is_bordered = false;
        return $this;
    }

    /**
     * Return TRUE if $is_bordered attribute is TRUE
     *
     * @return bool
     */
    public function isBordered()
    {
        return (bool) $this->is_bordered;
    }


    /**
     * Setter for $is_condensed attribute
     *
     * @return $this
     */
    public function enableCondensed()
    {
        $this->is_condensed = true;
        return $this;
    }

    /**
     * Setter for $is_condensed attribute
     *
     * @return $this
     */
    public function disableCondensed()
    {
        $this->is_condensed = false;
        return $this;
    }

    /**
     * Return TRUE if $is_condensed attribute is TRUE
     *
     * @return bool
     */
    public function isCondensed()
    {
        return (bool) $this->is_condensed;
    }

    /**
     * Setter for $is_responsive attribute
     *
     * @return $this
     */
    public function enableResponsive()
    {
        $this->is_responsive = true;
        return $this;
    }

    /**
     * Setter for $is_responsive attribute
     *
     * @return $this
     */
    public function disableResponsive()
    {
        $this->is_responsive = false;
        return $this;
    }

    /**
     * Return TRUE if $is_responsive attribute is TRUE
     *
     * @return bool
     */
    public function isResponsive()
    {
        return (bool) $this->is_responsive;
    }

    /**
     * Setter for $has_hover attribute
     *
     * @return $this
     */
    public function enableHover()
    {
        $this->has_hover = true;
        return $this;
    }

    /**
     * Setter for $has_hover attribute
     *
     * @return $this
     */
    public function disableHover()
    {
        $this->has_hover = false;
        return $this;
    }

    /**
     * Return TRUE if $has_hover attribute is TRUE
     *
     * @return bool
     */
    public function hasHover()
    {
        return (bool) $this->has_hover;
    }

}