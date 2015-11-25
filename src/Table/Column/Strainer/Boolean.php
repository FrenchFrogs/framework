<?php namespace FrenchFrogs\Table\Column\Strainer;

use FrenchFrogs\Form\Element\Select as FormSelect;
use FrenchFrogs\Table\Column\Column;

class Boolean extends Strainer
{

    /**
     *
     *
     * @var Select
     */
    protected $element;


    public function __construct(Column $column, $callable = null, $attr = [])
    {
        $element = new FormSelect($column->getName(), '', ["No", "Yes"], $attr);
        $element->setPlaceholder('All');
        $this->setRenderer($column->getTable()->getRenderer());
        $this->setElement($element);
    }


    /**
     * Setter for $element attribute
     *
     * @param FormSelect $element
     * @return $this
     */
    public function setElement(FormSelect $element)
    {
        $this->element = $element;
        return $this;
    }


    /**
     * Getter for $element attribute
     *
     * @return FormSelect
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
     * Overloading
     *
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->getElement()->setValue([$value]);
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
            $render = $this->getRenderer()->render('strainerBoolean', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}