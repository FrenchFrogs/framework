<?php namespace FrenchFrogs\Form\Element;


class Hidden extends Text
{
    /**
     * Constructeur
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $attr = [] )
    {
        $this->setAttribute($attr);
        $this->setName($name);
        $this->addAttribute('type', 'hidden');
    }


    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('form.hidden', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}