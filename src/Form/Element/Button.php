<?php namespace FrenchFrogs\Form\Element;


class Button extends Element
{
    /**
     * Constructror
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $attr = [] )
    {
        $this->setAttributes($attr);
        $this->setName($name);
        $this->setLabel($label);
    }

    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('form.button', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}