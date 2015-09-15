<?php namespace FrenchFrogs\Polliwog\Table;


use FrenchFrogs\Core;
use FrenchFrogs\Polliwog\Table\Column;
use FrenchFrogs\Polliwog\Table\Renderer;
use InvalidArgumentException;

/**
 * Table polliwog
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
     *
     * Column
     *
     *
     *
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




}