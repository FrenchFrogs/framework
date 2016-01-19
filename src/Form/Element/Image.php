<?php namespace FrenchFrogs\Form\Element;


class Image extends Label
{



    /**
     * Constructror
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $width = null, $height = null)
    {
        $this->setName($name);
        $this->setLabel($label);
        if (!is_null($width)) {
            $this->addStyle('width', $width);
        }

        if (!is_null($height)) {
            $this->addStyle('height', $height);
        }

    }

    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('image', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}