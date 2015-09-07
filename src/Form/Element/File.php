<?php namespace FrenchFrogs\Form\Element;


class File extends Text
{

    /**
     * Constructeur
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $attr = [] )
    {
        $this->setAttribute($attr);
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
            $render = $this->getRenderer()->render('form.file', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}