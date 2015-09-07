<?php namespace FrenchFrogs\Form\Element;


class Tel extends Text
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
        $this->addAttribute('type', 'tel');
    }


    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('form.tel', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}