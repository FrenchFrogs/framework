<?php namespace FrenchFrogs\Form\Element;


class Pre extends Label
{

    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('pre', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}