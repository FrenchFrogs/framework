<?php namespace FrenchFrogs\Polliwog\Form\Element;


class Title extends Element
{

    /**
     * Constructror
     *
     * @param $label
     * @param array $attr
     */
    public function __construct($label, $attr = [] )
    {
        $this->setAttributes($attr);
        $this->setName($label);
    }


    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('title', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}