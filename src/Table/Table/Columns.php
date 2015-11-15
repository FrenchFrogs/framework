<?php namespace FrenchFrogs\Table\Table;


use FrenchFrogs\Table\Column;

trait Columns
{

    protected $columns = [];

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
     * @return Column\Column $column
     */
    public function getColumn($name)
    {
        return $this->columns[$name];
    }

    /**
     * Return the column from his index
     *
     * @return Column\Column $column
     */
    public function getColumnByIndex($index)
    {
        $keys = array_keys($this->columns);

        if (empty($keys[$index]) || $this->columns[$keys[$index]]) {
            throw new \InvalidArgumentException('Table don\'t have a column index : ' . $index);
        }

        return $this->getColumn($keys[$index]);
    }




    /**
     * Add Text column to $columns container
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Text
     */
    public function addText($name, $label = '', $attr = [])
    {
        $c = new Column\Text($name, $label, $attr);
        $this->addColumn($c);
        return $c;
    }


    /**
     * Add Date column to $columns container
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Text
     */
    public function addDate($name, $label = '', $format = null, $attr = [])
    {
        $c = new Column\Date($name, $label, $format, $attr);
        $this->addColumn($c);
        return $c;
    }


    /**
     * Add Boolean column to $columns container
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Text
     */
    public function addBoolean($name, $label = '', $attr = [])
    {

        $c = new Column\Boolean($name, $label, $attr);
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
     * @return \FrenchFrogs\Table\Column\Link
     */
    public function addLink($name, $label = '%s', $link = '#', $binds = [], $attr = [] )
    {
        $c = new Column\Link($name, $label, $link, $binds, $attr);
        $this->addColumn($c);

        return $c;
    }

    /**
     * Add as Button Column
     *
     * @param $name
     * @param string $label
     * @param string $link
     * @param array $binds
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Button
     */
    public function addButton($name, $label = '%s', $link = '#', $binds = [], $attr = [] )
    {
        $c = new Column\Button($name, $label, $link, $binds, $attr);
        $c->setOptionAsDefault();
        $this->addColumn($c);

        return $c;
    }

    /**
     * Add remote button as column
     *
     * @param $name
     * @param string $label
     * @param string $link
     * @param array $binds
     * @param array $attr
     * @return $this
     */
    public function addButtonRemote($name, $label = '%s', $link = '#', $binds = [], $attr = [] )
    {
        return $this->addButton($name, $label, $link, $binds, $attr)->enableRemote();
    }

    /**
     * Add remote button as column
     *
     * @param $name
     * @param string $label
     * @param string $link
     * @param array $binds
     * @param array $attr
     * @return $this
     */
    public function addButtonCallback($name, $label = '%s', $link = '#', $binds = [], $attr = [] )
    {
        return $this->addButton($name, $label, $link, $binds, $attr)->enableCallback();
    }


    /**
     * Add default edit button
     *
     * @param string $link
     * @param array $binds
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Button
     */
    public function addButtonEdit($link = '#', $binds = [], $is_remote = true)
    {
        $c = new Column\Button(configurator()->get('button.edit.name'), configurator()->get('button.edit.label'), $link, $binds);
        $c->setOptionAsPrimary();
        $c->icon(configurator()->get('button.edit.icon'));
        if ($is_remote) {
            $c->enableRemote();
        }

        $this->addColumn($c);
        return $c;
    }

    /**
     * Add default delete button
     *
     * @param string $link
     * @param array $binds
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Button
     */
    public function addButtonDelete($link = '#', $binds = [], $is_remote = true)
    {
        $c = new Column\Button(configurator()->get('button.delete.name'), configurator()->get('button.delete.label'), $link, $binds);
        $c->setOptionAsDanger();
        $c->icon(configurator()->get('button.delete.icon'));
        if ($is_remote) {
            $c->enableRemote();
        }
        $this->addColumn($c);
        return $c;
    }



    /**
     * Add a container columns
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Container
     */
    public function addContainer($name, $label = '', $attr = [])
    {
        $c = new Column\Container($name, $label, $attr);
        $this->addColumn($c);
        return $c;
    }



}