<?php namespace FrenchFrogs\Form\Element;


class Checkbox extends Element
{
    /**
     * Options values
     *
     * @var array
     */
    protected $options = [];

    /**
     * Constructror
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $options = [], $attr = [] )
    {
        $this->setAttributes($attr);
        $this->setName($name);
        $this->setLabel($label);
        $this->setOptions($options);

        $this->addAttribute('type', 'checkbox');
    }



    /**
     * Set the options
     *
     * @param $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Get the options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('checkbox', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}