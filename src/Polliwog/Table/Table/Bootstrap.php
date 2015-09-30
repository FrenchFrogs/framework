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
class Bootstrap
{

    use Core\Renderer;
    use Core\Html;
    use Core\Panel;

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
     * Item per table page
     *
     * @var int
     */
    protected $itemsPerPage = 25;

    /**
     * Total number of item
     *
     * @var
     */
    protected $itemTotal;


    /**
     * Actual page
     *
     * @var int
     */
    protected $currentPage = 1;

    /**
     * Constructor
     *
     * @param string $url
     * @param string $method
     */
    public function __construct()
    {
        // if method "init" exist, we call it.
        if (method_exists($this, 'init')) {
            call_user_func_array([$this, 'init'], func_get_args());
        } elseif(func_num_args() == 1) {
            $this->setSource(func_get_arg(0));
        }

        if (!$this->hasRenderer()) {
            $class = configurator()->get('table.renderer.class');
            $this->setRenderer(new $class);
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
     * getter for $itemsPerPage attribute
     *
     * @return int
     */
    public function getItemPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * Setter for $itemsPerPage attribute
     *
     * @param $itemsPerPage
     * @return $this
     */
    public function setItemPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    /**
     * Getter for $itemTotal attribute
     *
     * @return mixed
     */
    public function getItemTotal()
    {
        return $this->itemTotal;
    }

    /**
     * Getter for $currentPage attribute
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }


    /**
     * Setter for $currentPage attribute
     *
     * @param $currentPage
     * @return $this
     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
        return $this;
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
            /** @var $source  \Illuminate\Database\Eloquent\Builder */

            $this->itemTotal = $source->count();
            $source = $source->skip(($this->getCurrentPage() - 1) * $this->getItemPerPage())->take($this->getItemPerPage())->get()->toArray();
            $source = new \ArrayIterator($source);

            // Array case
        } elseif(is_array($source)) {
            $source = array_slice($source, ceil($this->getCurrentPage() * $this->getItemPerPage()), $this->getItemPerPage());
            $source = new \ArrayIterator($source);
        }

        if (!($source instanceof \Iterator)) {
            throw new \InvalidArgumentException("Source must be an array or an Iterator");
        }

        if (!is_null($source)) {
            $this->setRows($source);
        }

        return $this;
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