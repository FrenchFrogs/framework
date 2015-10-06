<?php namespace FrenchFrogs\Polliwog\Form\Element;

use FrenchFrogs\Core;

class Button extends Element
{

    use Core\Button;

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
        $this->setOptionAsDefault();
        $this->disableIconOnly();
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