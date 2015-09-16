<?php namespace FrenchFrogs\Polliwog\Table\Renderer;

use FrenchFrogs\Polliwog\Table\Column;

class Bootstrap extends TableAbstract
{


    const TABLE_STRIPED_CLASS = 'table-striped';


    const TABLE_BORDERED_CLASS = 'table-bordered';


    const TABLE_HOVER_CLASS = 'table-hover';


    const TABLE_CONDENSED_CLASS = 'table-condensed';


    const TABLE_RESPONSIVE_CLASS = 'table-responsive';

    const TABLE_CLASS = 'table';

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


    public function _table(\FrenchFrogs\Polliwog\Table\Table $table)
    {

        // Headers
        $head = '';
        $headers = [];
        foreach($table->getColumns() as $column) {
            /** @var Column\Column $column */
            $head .= html('th', [], $column->getLabel());
            $headers[] = $column->getName();
        }


        // Data
        $body = '';
        foreach($table->getRows() as $row) {

            $line = '';
            foreach($table->getColumns() as $name => $column) {
                $line .= html('td', [], $column->render($row));

            }

            $body .= html('tr', [],$line );
        }

        // Footer

        // Gesiton des class globale
        $table->addClass(static::TABLE_CLASS);


        if ($this->isStriped()){
            $table->addClass(static::TABLE_STRIPED_CLASS);
        }

        if ($this->isBordered()) {
            $table->addClass(static::TABLE_BORDERED_CLASS);
        }

        if ($this->isCondensed()) {
            $table->addClass(static::TABLE_CONDENSED_CLASS);
        }

        if ($this->hasHover()) {
            $table->addClass(static::TABLE_HOVER_CLASS);
        }

        $table =  html('table', $table->getAttributes(), html('thead', [], $head) . html('tbody', [], $body));

        // responsive
        if ($this->isResponsive()){
            $table = html('div', ['class' => static::TABLE_RESPONSIVE_CLASS], $table);
        }

        return $table;
    }


    public function _text(Column\Text $column, array $row)
    {
        return isset($row[$column->getName()]) ? $row[$column->getName()] : '';
    }


    public function _link(Column\Link $column, array $row)
    {

    }


}


