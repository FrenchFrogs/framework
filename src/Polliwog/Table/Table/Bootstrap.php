<?php namespace FrenchFrogs\Polliwog\Table\Table;


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
     * @param bool|true $stripped
     * @return $this
     */
    public function setStriped($stripped = true)
    {
        $this->is_striped = (bool) $stripped;
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
     * @param bool|true $borderer
     * @return $this
     */
    public function setBordered($borderer = true)
    {
        $this->is_bordered = (bool) $borderer;
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
     * @param bool|true $condensed
     * @return $this
     */
    public function setCondensed($condensed = true)
    {
        $this->is_condensed = (bool) $condensed;
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
     * @param bool|true $responsive
     * @return $this
     */
    public function setResponsive($responsive = true)
    {
        $this->is_responsive = (bool) $responsive;
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
     * @param bool|true $hover
     * @return $this
     */
    public function setHover($hover = true)
    {
        $this->has_hover = $hover;
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