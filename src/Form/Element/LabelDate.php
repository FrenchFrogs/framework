<?php namespace FrenchFrogs\Form\Element;


class LabelDate extends Date
{

    protected $is_discreet = true;

    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('label_date', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}