<?php namespace FrenchFrogs\Form\Element;


class Time extends Text
{

    /**
     * Constructor
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '')
    {
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
            $render = $this->getRenderer()->render('time', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}