<?php namespace FrenchFrogs\Table\Column\Strainer;

use FrenchFrogs\Form\Element\DateRange as FormDateRange;
use FrenchFrogs\Form\Form\Element;
use FrenchFrogs\Table\Column\Column;

class DateRange extends Text
{

    public function __construct(Column $column, $options = [], $callable = null, $attr = [])
    {
        $element = new FormDateRange($column->getName(), '');
        $this->setRenderer($column->getTable()->getRenderer());
        $this->setElement($element);
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

            // recuperation des valeurs
            $params = explode('#', $params[0]);
            $e = $this->getElement();

            // from
            if (!empty($params[0])) {
                $from = $e->setValue($params[0])->getFilteredValue();
                $table->getSource()->where($this->getField(), '>=', $from);
            }

            // to
            if (!empty($params[1])) {
                $to = $e->setValue($params[1])->getFilteredValue();
                $to = \Carbon\Carbon::createFromFormat($e->getFormatStore(), $to)->addDay(1)->format($e->getFormatStore());
                $table->getSource()->where($this->getField(), '<', $to);
            }
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
            $render = $this->getRenderer()->render('strainerDateRange', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}