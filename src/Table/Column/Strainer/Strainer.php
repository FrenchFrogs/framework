<?php namespace FrenchFrogs\Table\Column\Strainer;


use FrenchFrogs\Core\Renderer;

class Strainer
{

    use Renderer;


    /**
     * Fields name for Eloquent search
     *
     * @var string
     */
    protected $field;

    /**
     * Function executed foir strainer
     *
     * @var
     */
    protected $callable;


    /**
     * Getter for $field attribute
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Return TRUE if $field attribute
     *
     * @return bool
     */
    public function hasField()
    {
        return isset($this->field);
    }

    /**
     * Unset $field attribute
     *
     * @return $this
     */
    public function removeField()
    {
        unset($this->field);
        return $this;
    }

    /**
     * Setter for $field attribute
     *
     * @param $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }


    /**
     * Setter for $callbale attribute
     *
     * @param $callable
     */
    public function setCallable($callable)
    {
        $this->callable = $callable;
    }

    /**
     * Getter for ĉallable attribute
     *
     * @return mixed
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * Return TRUE if is $callable is set
     *
     * @return bool
     */
    public function hasCallable()
    {
        return isset($this->callable);
    }

    /**
     * Unset $callable attribute
     *
     * @return $this
     */
    public function removeCallable()
    {
        unset($this->callable);
        return $this;
    }

    /**
     * Execute strainer
     *
     * @param \FrenchFrogs\Table\Table\Table $table
     * @param array ...$params
     * @return $this
     * @throws \Exception
     */
    public function call(\FrenchFrogs\Table\Table\Table $table, ...$params)
    {

        if ($this->hasCallable()) {
            call_user_func_array($this->callable, $params);
        } else {

            // verify that source is a query
            if (!$table->isSourceQueryBuilder()) {
                throw new \Exception('Table source is not an instance of query builder');
            }

            $this->setValue($params[0]);
            $table->getSource()->where($this->getField(), '=', $params[0]);
        }

        return $this;
    }


    /**
     * Set value to strainer element
     *
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {

        if (isset($this->element)) {
            $this->element->setValue($value);
        }

        return $this;
    }
}