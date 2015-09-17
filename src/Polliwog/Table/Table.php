<?php namespace FrenchFrogs\Polliwog\Table;


use FrenchFrogs\Core;
use FrenchFrogs\Polliwog\Table\Column;
use FrenchFrogs\Polliwog\Table\Renderer;
use InvalidArgumentException;

/**
 * Table polliwog
 *
 * Default table is build with a bootstrap support
 *
 * Class Table
 * @package FrenchFrogs\Polliwog\Table
 */
class Table
{

    use Core\Renderer;
    use Core\Html;


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
     *
     * Data for the table
     *
     * @var \Iterator $rows
     */
    protected $rows;


    /**
     * Table columns container
     *
     * @var array
     */
    protected $columns = [];


    /**
     * Constructor
     *
     * @param string $url
     * @param string $method
     */
    public function __construct($rows = [])
    {
        if (is_array($rows)) {
            $rows = new \ArrayIterator($rows);
        }

        if (!($rows instanceof \Iterator)){
            throw new InvalidArgumentException("{$rows} must be an array or an Iterator");
        }

        if (!is_null($rows)) {
            $this->setRows($rows);
        }
    }


    /**
     * Set all the rows container
     *
     * @param \Iterator  $rows
     * @return $this
     */
    public function setRows(\Iterator $rows)
    {
        $this->rows = $rows;
        return $this;
    }


    /**
     * return all the rows container
     *
     * @return \Iterator
     */
    public function getRows()
    {
        return $this->rows;
    }


    /**l
     * Clear all the rows container
     *l
     * @return $this
     */
    public function clearRows()
    {
        $this->rows = new \ArrayIterator();
        return $this;
    }


    /**
     * Setter for $columns container
     *
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }


    /**
     * Getter for $columns container
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Clear the $columns container
     *
     * @return $this
     */
    public function clearColumns()
    {
        $this->columns = [];
        return $this;
    }


    /**
     * Add a single column to the column container
     *
     * @param Column\Column $column
     * @return $this
     */
    public function addColumn(Column\Column $column)
    {
        // Join column to the table
        $column->setTable($this);

        // Add renderer to column if it didn't has one
        if (!$column->hasRenderer()) {
            $column->setRenderer($this->getRenderer());
        }

        $this->columns[$column->getName()] = $column;

        return $this;
    }

    /**
     * Remove $name columns from the $columns container
     *
     * @param $name
     * @return $this
     */
    public function removeColumn($name)
    {

        if (isset($this->columns[$name])){
            unset($this->columns[$name]);
        }

        return $this;
    }

    /**
     * Return TRUE if the column ame exist in the ĉolumns container
     *
     * @param $name
     * @return bool
     */
    public function hasColumn($name)
    {
        return isset($this->columns[$name]);
    }


    /**
     * Return the $name column from $column container
     *
     * @param $name
     * @return mixed
     */
    public function getColumn($name)
    {
        return $this->columns[$name];
    }


    /**
     * Overload parent method for form specification
     *
     * @return string
     *
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('table', $this);
        } catch(\Exception $e){
            dd($e->getMessage());//@todo find a good way to warn the developper
        }

        return $render;
    }



    /**
     *
     ********************
     * COLUMNS
     *
     ********************
     */


    /**
     * Add Text column to $columns container
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Polliwog\Table\Column\Text
     */
    public function addText($name, $label = '', $attr = [])
    {

        $c = new Column\Text($name, $label, $attr);
        $this->addColumn($c);

        return $c;
    }


    /**
     * Add Link columns to $columns container
     *
     * @param $name
     * @param string $label
     * @param string $link
     * @param array $binds
     * @param array $attr
     * @return \FrenchFrogs\Polliwog\Table\Column\Link
     */
    public function addLink($name, $label = '', $link = '', $binds = [], $attr = [])
    {
        $c = new Column\Link($name, $label, $link, $binds, $attr);
        $this->addColumn($c);

        return $c;
    }

    public function addButton($name, $label = '', $link = '', $binds = [], $attr = [])
    {
        $c = new Column\Button($name, $label, $link, $binds, $attr);
        $c->setOptionAsDefault();
        $this->addColumn($c);

        return $c;
    }



    /**
     * **********************
     * Bootstrap
     *
     * **********************
     *
     */


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