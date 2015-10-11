<?php namespace FrenchFrogs\Polliwog\Table\Table;


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
    use Core\Panel;
    use Pagination;
    use Bootstrap;
    use Datatable;

    /**
     *
     * Data for the table
     *
     * @var \Iterator $rows
     */
    protected $rows;


    /**
     * Source data
     *
     * @var
     */
    protected $source;


    /**
     * Table columns container
     *
     * @var array
     */
    protected $columns = [];

    /**
     * If false, footer will not be render
     *
     * @var bool
     */
    protected $has_footer = true;


    /**
     * Constructor
     *
     * @param string $url
     * @param string $method
     */
    public function __construct()
    {
        /*
         * Default configuration
         */
        if (!$this->hasRenderer()) {
            $class = configurator()->get('table.renderer.class');
            $this->setRenderer(new $class);
        }

        if (!$this->hasUrl()){
            $this->setUrl(request()->url());
        }

        // if method "init" exist, we call it.
        if (method_exists($this, 'init')) {
            call_user_func_array([$this, 'init'], func_get_args());
        } elseif(func_num_args() == 1) {
            $this->setSource(func_get_arg(0));
        }

        // Force id html attribute
        if (!$this->hasAttribute('id')) {
            $this->addAttribute('id', 'table-' . rand());
        }

        if(static::class != self::class) {
            $this->enableRemote();
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
     *
     *
     * @param $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }


    /**
     * Getter for $source attribute
     *
     * @return array
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Return TRUE if $source attribute is set
     *
     * @return bool
     */
    public function hasSource()
    {
        return isset($this->source);
    }

    /**
     * Extract rows from $source attribute
     *
     * @return $this
     */
    protected function extractRows()
    {
        $source = $this->source;

        // Laravel query builder case
        if ($source instanceof \Illuminate\Database\Eloquent\Builder){
            /** @var $source \Illuminate\Database\Eloquent\Builder */
            $this->itemsTotal = $source->count();

            $source = $source->skip($this->getItemsOffset())->take($this->getItemsPerPage())->get()->toArray();
            $source = new \ArrayIterator($source);

            // Array case
        } elseif(is_array($source)) {
            $source = array_slice($source, $this->getItemsOffset(), $this->getItemsPerPage());
            $source = new \ArrayIterator($source);
        }

        /**@var $source \Iterator */
        if (!($source instanceof \Iterator)) {
            throw new \InvalidArgumentException("Source must be an array or an Iterator");
        }


        if (!is_null($source)) {
            $this->setRows($source);
        }

        return $this;
    }

    /**
     * Set $has_footer attribute to TRUE
     *
     * @return $this
     */
    public function enableFooter()
    {
        $this->has_footer = true;
        return $this;
    }

    /**
     * Set $has_footer attribute to FALSE
     *
     * @return $this
     */
    public function disableFooter()
    {
        $this->has_footer = false;
        return $this;
    }


    /**
     * return TRUE if $has_footer is set tio TRUE
     *
     * @return bool
     */
    public function hasFooter()
    {
        return $this->has_footer;
    }



    /**
     * *******************
     * RENDERER
     * *******************
     */

    /**
     * Render polliwog
     *
     * @return mixed|string
     */
    public function render()
    {

        $render = '';
        try {
            $this->extractRows();
            $render = $this->getRenderer()->render('table', $this);
        } catch(\Exception $e){
            dd($e->getMessage());//@todo find a good way to warn the developper
        }

        return $render;
    }


    /**
     * Overload parent method for form specification
     *
     * @return string
     *
     */
    public function __toString()
    {
        return $this->render();
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
     * Add Boolean column to $columns container
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Polliwog\Table\Column\Text
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
     * @return \FrenchFrogs\Polliwog\Table\Column\Link
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
     * @return \FrenchFrogs\Polliwog\Table\Column\Button
     */
    public function addButton($name, $label = '%s', $link = '#', $binds = [], $attr = [] )
    {
        $c = new Column\Button($name, $label, $link, $binds, $attr);
        $c->setOptionAsDefault();
        $this->addColumn($c);

        return $c;
    }
}