<?php namespace FrenchFrogs\Form\Element;


class Title extends Element
{

    /**
     * Constructeur
     *
     * @param $label
     * @param array $attr
     */
    public function __construct($label, $attr = [] )
    {
        $this->setAttribute($attr);
        $this->setName($label);
    }


    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('form.title', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}