<?php namespace FrenchFrogs\Form\Element;


class Link extends Label
{
    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('link', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}