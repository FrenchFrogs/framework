<?php namespace FrenchFrogs\Polliwog\Form\Element;


class Email extends Text
{

    /**
     * Constructor
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
        $this->addAttribute('type', 'email');

        //$this->addRule('email'); @todo need to have a validator before adding rules
    }

    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('email', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}