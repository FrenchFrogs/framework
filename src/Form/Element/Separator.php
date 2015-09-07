<?php namespace FrenchFrogs\Form\Element;


class Separator extends Element
{

    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('form.separator', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}