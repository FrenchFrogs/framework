<?php namespace FrenchFrogs\Table\Table;


use Doctrine\DBAL\Driver\Mysqli\MysqliConnection;
use FrenchFrogs\Core;
use FrenchFrogs\Table\Column;
use FrenchFrogs\Table\Renderer;
use InvalidArgumentException;

/**
 * Table polliwog
 *
 * Default table is build with a bootstrap support
 *
 * Class Table
 * @package FrenchFrogs\Table
 */
class Table
{

    use Core\Renderer;
    use Core\Filterer;
    use \FrenchFrogs\Html\Html;
    use Core\Panel;
    use Pagination;
    use Bootstrap;
    use Datatable;
    use Columns;

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
     * If false, footer will not be render
     *
     * @var bool
     */
    protected $has_footer = true;

    /**
     * Enable Json decode on value
     *
     * @var array
     */
    protected $jsonField = [];


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

        if (!$this->hasFilterer()) {
            $class = configurator()->get('table.filterer.class');
            $this->setFilterer(new $class);
        }

        if (!$this->hasUrl()){
            $this->setUrl(request()->url());
        }

        $this->enableBordered();

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
        if(  $this->isSourceQueryBuilder())  {
            /** @var $source \Illuminate\Database\Query\Builder */

            $count = query(raw("({$source->toSql()}) as a"), [raw('COUNT(*) as _num_rows')], $source->getConnection()->getName())->mergeBindings($source)->first();
            $this->itemsTotal = isset($count['_num_rows']) ?  $count['_num_rows'] : null;

            $source = $source->skip($this->getItemsOffset())->take($this->getItemsPerPage())->get();
            $source = new \ArrayIterator($source);

            // Array case
        } elseif(is_array($source)) {
            $this->itemsTotal = count($source);
            $source = array_slice($source, $this->getItemsOffset(), $this->getItemsPerPage());
            $source = new \ArrayIterator($source);
        }

        /**@var $source \Iterator */
        if (!($source instanceof \Iterator)) {
            throw new \InvalidArgumentException("Source must be an array or an Iterator");
        }


        if (!is_null($source)) {
            $this->setRows($source);

            if ($this->hasJsonField()) {
                $this->extractJson();
            }
        }

        return $this;
    }

    /**
     * Return true if the source is an instance of \Illuminate\Database\Query\Builder
     *
     * @return bool
     */
    public function isSourceQueryBuilder()
    {
        return is_object($this->getSource()) && get_class($this->getSource()) == \Illuminate\Database\Query\Builder::class;
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
     * Add json field to decode
     *
     * @param $field
     */
    public function addJsonField($field)
    {
        $this->jsonField[] = $field;
        return $this;
    }

    /**
     * Remove $field from $jsonField
     *
     * @param $field
     * @return $this
     */
    public  function removeJsonField($field)
    {

        $i = array_search($field, $this->jsonField);

        if ($i !== false) {
            unset($this->jsonField[$i]);
        }

        return $this;
    }


    /**
     * Setter for $jsonField
     *
     * @param array $fields
     * @return $this
     */
    public function setJsonFields(array $fields)
    {
        $this->jsonField = $fields;
        return $this;
    }


    /**
     * Getter for jsonField
     *
     * @return array
     */
    public function getJsonFields()
    {
        return $this->jsonField;
    }

    /**
     * Return TRUE if a json field is set at least
     *
     * @return bool
     */
    public function hasJsonField()
    {
        return count($this->jsonField) > 0;
    }

    /**
     * Extract json data
     *
     * @return $this
     */
    public function extractJson()
    {
        foreach($this->getRows() as &$row) {

            foreach($this->getJsonFields() as $field) {
                if (isset($row[$field])) {

                    $data = json_decode($row[$field], JSON_OBJECT_AS_ARRAY);

                    foreach((array) $data as $k => $v) {
                        $row[sprintf('_%s__%s', $field, $k)] = $v;
                    }
                }
            }
        }

        return $this;
    }
}