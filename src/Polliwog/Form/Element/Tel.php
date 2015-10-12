<?php namespace FrenchFrogs\Polliwog\Form\Element;


class Tel extends Text
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
        $this->addAttribute('type', 'tel');
    }


    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('tel', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}