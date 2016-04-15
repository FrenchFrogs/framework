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
        if (empty($keys[$index]) || empty($column = $this->columns[$keys[$index]])) {
            throw new \InvalidArgumentException('Table don\'t have a column index : ' . $index);
        }

        return $column;
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
     * Add Code column to $columns container
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Code
     */
    public function addCode($name, $label = '', $attr = [])
    {
        $c = new Column\Code($name, $label, $attr);
        $this->addColumn($c);
        return $c;
    }

    /**
     * Add Pre column to $columns container
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Code
     */
    public function addPre($name, $label = '', $attr = [])
    {
        $c = new Column\Pre($name, $label, $attr);
        $this->addColumn($c);
        return $c;
    }

    /**
     *
     *
     * @param $name
     * @param $label
     * @param $function
     * @return mixed
     */
    public function addCustom($name, $label, $function)
    {
        $c = new Column\Custom($name, $label, $function);
        $this->addColumn($c);
        return $c;
    }


    /**
     * Add Date column to $columns container
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Date
     */
    public function addDate($name, $label = '', $format = null, $attr = [])
    {
        $c = new Column\Date($name, $label, $format, $attr);
        $this->addColumn($c);
        return $c;
    }

    /**
     * Add Datetime column to $columns container
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Datetime
     */
    public function addDatetime($name, $label = '', $format = null, $attr = [])
    {
        $c = new Column\Datetime($name, $label, $format, $attr);
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
     * Add boolean switch
     *
     * @param $name
     * @param string $label
     * @return \FrenchFrogs\Table\Column\RemoteBoolean
     */
    public function addRemoteBoolean($name, $label = '', $function = null)
    {
        $c = new Column\RemoteBoolean($name, $label, $function);
        $this->addColumn($c);

        return $c;
    }


    /**
     * Add remote text
     *
     * @param $name
     * @param string $label
     * @return \FrenchFrogs\Table\Column\RemoteText
     */
    public function addRemoteText($name, $label = '', $function = null)
    {
        $c = new Column\RemoteText($name, $label, $function);
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
    public function addIcon($name, $label = '', $mapping = [])
    {

        $c = new Column\Icon($name, $label, $mapping);
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
     * Add Link columns to $columns container
     *
     * @param $name
     * @param string $label
     * @param string $link
     * @param array $binds
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Link
     */
    public function addMedia($name, $label, $link = '#', $binds = [],  $width = 320, $height = 180)
    {
        $c = new Column\Media($name, $label, $link, $binds, $width, $height);
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
     * @return \FrenchFrogs\Table\Column\Button
     */
    public function addButtonRemote($name, $label = '%s', $link = '#', $binds = [], $method = 'post' )
    {
        return $this->addButton($name, $label, $link, $binds)->enableRemote($method);
    }

    /**
     * Add remote button as column
     *
     * @param $name
     * @param string $label
     * @param string $link
     * @param array $binds
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Button
     */
    public function addButtonCallback($name, $label = '%s', $link = '#', $binds = [], $method = 'post' )
    {
        return $this->addButton($name, $label, $link, $binds)->enableCallback($method);
    }


    /**
     * Add default edit button
     *
     * @param string $link
     * @param array $binds
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Button
     */
    public function addButtonEdit($link = '#', $binds = [], $is_remote = true, $method = 'post')
    {


        $c = new Column\Button(configurator()->get('button.edit.name'), configurator()->get('button.edit.label'), $link, $binds);
        $c->setOptionAsPrimary();
        $c->icon(configurator()->get('button.edit.icon'));
        if ($is_remote) {
            $c->enableRemote($method);
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
    public function addButtonDelete($link = '#', $binds = [], $is_remote = true, $method = 'delete')
    {
        $c = new Column\Button(configurator()->get('button.delete.name'), configurator()->get('button.delete.label'), $link, $binds);
        $c->setOptionAsDanger();
        $c->icon(configurator()->get('button.delete.icon'));
        if ($is_remote) {
            $c->enableRemote($method);
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