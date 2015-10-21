<?php namespace FrenchFrogs\Polliwog\Table\Column;

use FrenchFrogs\Polliwog\Table\Table;

class Container extends Column
{
    use Table\Columns;


    /**
     * Constructror
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $attr = [] )
    {
        $this->setAttributes($attr);
        $this->setName($name);
        $this->setLabel($label);
    }


    /**
     * Add a single column to the column container
     *
     * @param Column $column
     * @return $this
     */
    public function addColumn(Column $column)
    {
        // Join column to the table
        $column->setTable($this->getTable());

        // Add renderer to column if it didn't has one
        if (!$column->hasRenderer()) {
            $column->setRenderer($this->getRenderer());
        }

        $this->columns[$column->getName()] = $column;

        return $this;
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
            $render = $this->getRenderer()->render('container', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}