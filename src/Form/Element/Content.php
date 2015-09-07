<?php namespace FrenchFrogs\Form\Element;


class Content extends Element
{

    /**
     * Constructeur
     *
     * @param $label
     * @param array $attr
     */
    public function __construct($label, $value = '', $attr = [])
    {
        $this->setAttribute($attr);
        $this->setLabel($label);
        $this->setName($label);
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $render = '';
        try {

            $render = $this->getRenderer()->render('form.content', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}