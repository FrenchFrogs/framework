<?php namespace FrenchFrogs\Form\Element;


class Hidden extends Text
{
    /**
     * Constructror
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $attr = [] )
    {
        $this->setAttributes($attr);
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
            $render = $this->getRenderer()->render('hidden', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}