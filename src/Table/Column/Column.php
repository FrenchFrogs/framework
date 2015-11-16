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
    use Core\Filterer;
    use Strainer\Strainerable;

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
     * Width of the datatable columns
     *
     * @var
     */
    protected $width;

    /**
     *
     *
     * @var mixed string|Callable
     */
    protected $order;

    /**
     * Contain the order direction set to the columns
     *
     * @var string
     */
    protected $orderDirection;

    /**
     * Setter for $width attribute
     *
     * @param $width
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Getter for $width attribute
     *
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }


    /**
     * Return TRUE if $width attribute is set
     *
     * @return bool
     */
    public function hasWidth()
    {
        return isset($this->width);
    }


    /**
     * Unset $width attribute
     *
     * @return $this
     */
    public function removeWidth()
    {
        unset($this->width);
        return $this;
    }


    /**
     *
     *
     * @param $index
     * @param null $method
     * @param ...$params
     */
    public function addFilter($index, $method = null, ...$params)
    {
        if (!$this->hasFilterer()) {
            $this->setFilterer(configurator()->build('table.filterer.class'));
        }

        array_unshift($params, $index, $method);

        call_user_func_array([$this->getFilterer(),'addFilter'], $params);
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


    /**
     * Setter for $order attribute
     *
     * @param $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }


    /**
     * Getter for $order attribute
     *
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Return TRUE if $order is set
     *
     * @return bool
     */
    public function hasOrder()
    {
        return isset($this->order);
    }

    /**
     * Unset the order
     *
     */
    public function removeOrder()
    {
        unset($this->order);
        return $this;
    }


    /**
     * Order process for the column
     *
     * @param $direction (asc or desc)
     * @return $this
     * @throws \Exception
     */
    public function order($direction = null)
    {
        if (is_null($direction)) {
            $direction = $this->getOrderDirection();
        } else {
            $this->setOrderDirection($direction);
        }

        // if a direction is set
        if (!empty($direction)) {
            if (!is_string($this->order) && is_callable($this->order)) {
                call_user_func_array($this->order, $this);
            } else {

                $table = $this->getTable();

                // verify that source is a query
                if (!$table->isSourceQueryBuilder()) {
                    throw new \Exception('Table source is not an instance of query builder');
                }

                $table->getSource()->orderBy($this->order, $direction);
            }
        }

        return $this;
    }

    /**
     * Setter for $orderDirection attribute
     *
     * @param $direction
     * @return $this
     */
    public function setOrderDirection($direction)
    {

        $direction = strtolower($direction);

        if (!in_array($direction, ['asc', 'desc'])) {
            throw new \InvalidArgumentException('$direction must be "asc" or "desc"');
        }

        $this->orderDirection = $direction;
        return $this;
    }

    /**
     * Getter for $orderDirection attribute
     *
     * @return string
     */
    public function getOrderDirection()
    {
        return $this->orderDirection;
    }

    /**
     * Return TRUE if $orderDirection is set
     *
     * @return bool
     */
    public function hasOrderDirection()
    {
        return isset($this->orderDirection);
    }


    /**
     * Unset $orderDirection attribute
     *
     * @return $this
     */
    public function removeOrderDirection()
    {
        unset($this->orderDirection);
        return $this;
    }
}