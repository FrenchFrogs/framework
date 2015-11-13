<?php namespace FrenchFrogs\Table\Column\Strainer;

use FrenchFrogs\Form\Element\Text as FormText;
use FrenchFrogs\Table\Column\Column;

class Text extends Strainer
{

    /**
     *
     *
     * @var Select
     */
    protected $element;


    public function __construct(Column $column, $options = [], $callable = null, $attr = [])
    {
        $element = new FormText($column->getName(), '', $attr);
        $element->setPlaceholder('All');
        $this->setRenderer($column->getTable()->getRenderer());
        $this->setElement($element);
    }


    /**
     * Setter for $element attribute
     *
     * @param FormText $element
     * @return $this
     */
    public function setElement(FormText $element)
    {
        $this->element = $element;
        return $this;
    }


    /**
     * Getter for $element attribute
     *
     * @return FormText
     */
    public function getElement()
    {
        return $this->element;
    }


    /**
     * Return TRUE if $element is set
     *
     * @return bool
     */
    public function hasElement()
    {
        return isset($this->element);
    }

    /**
     * Unset $element attribute
     *
     * @return $this
     */
    public function removeElement()
    {
        unset($this->element);
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

            $table->getSource()->where($this->getField(), 'LIKE', $params[0] .  '%');
        }

        return $this;
    }

    /**
     *
     *
     * @return string
     */
    public function render()
    {
        $render = '';
        try {
            $render = $this->getRenderer()->render('strainerText', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}