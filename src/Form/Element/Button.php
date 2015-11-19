<?php namespace FrenchFrogs\Form\Element;

use FrenchFrogs\Core;
use FrenchFrogs\Html;

class Button extends Element
{

    use Html\Element\Button;
    use Core\Remote;

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
            $render = $this->getRenderer()->render('button', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}