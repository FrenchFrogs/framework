<?php namespace FrenchFrogs\Table\Column;

use FrenchFrogs\Core;
use FrenchFrogs;


/**
 *
 *
 * Class Column
 */
abstract class Column
{

    use \FrenchFrogs\Html\Html;
    use Core\Renderer;
    //use Core\Filterer;


    /**
     *
     *
     * @var FrenchFrogs\Table\Table\Table
     */
    protected $table;


    /**
     * Column label
     *
     * @var string
     */
    protected $label;


    /**
     * Column name
     *
     * @var string
     */
    protected $name;


    /**
     * Filter for the column
     *
     * @var
     */
    protected $filter;


    /**
     * Return TRUE if the column has a filter
     *
     * @return bool
     */
    public function hasFilter()
    {
        return isset($this->filter);
    }

    /**
     *
     * Getter for $filter attribute
     *
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Setter for filter attribute
     *
     * @param $filter
     * @return $this
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
        return $this;
    }


    /**
     * Setter for $table property
     *
     * @param \FrenchFrogs\Table\Table\Table $table
     * @return $this
     */
    public function setTable(\FrenchFrogs\Table\Table\Table $table)
    {
        $this->table = $table;
        return $this;
    }


    /**
     * Getter for $table property
     *
     * @return \FrenchFrogs\Table\Table\Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Return TRUE if the $table property id set
     *
     * @return bool
     */
    public function hasTable()
    {
        return isset($this->table);
    }

    /**
     * Unset the $table property
     *
     * @return $this
     */
    public function removeTable()
    {
        unset($this->table);
        return $this;
    }


    /**
     * Getter for $label property
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }


    /**
     * Setter for $label property
     *
     * @param $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Return TRUE if label is set
     *
     * @return bool
     */
    public function hasLabel()
    {
        return isset($this->label);
    }


    /**
     * Unset label
     *
     * @return $this
     */
    public function removeLabel()
    {
        unset($this->label);
        return $this;
    }

    /**
     * Setter for $name property
     *
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Getter for name property
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return TRUE if $name property is set
     *
     * @return bool
     */
    public function hasName()
    {
        return isset($this->name);
    }


    /**
     * unset $name property
     *
     * @return $this
     */
    public function removeName()
    {
        unset($this->name);
        return $this;
    }


    /**
     * Default render
     *
     * @param array $row
     * @return mixed
     */
    public function render(array $row)
    {
        return $row[$this->name];
    }
}