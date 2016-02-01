<?php namespace FrenchFrogs\Form\Element;

/**
 * Input list html5
 *
 * Class AutoComplete
 * @package FrenchFrogs\Form\Element
 */
class DataList extends Element
{

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
        $this->addAttribute('list', $name);
        $this->setOptions($options);
    }

    /**
     * Setter pour les options
     *
     * @param $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Getter pour les options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
    * @return mixed
    */
    public function getValue()
    {
        return $this->value;
    }

    /**
    *
    * @param mixed $value
    */
    public function setValue($value)
    {
        $this->value = $value;
        $this->addAttribute('value', $value);

        return $this;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        $render = '';
        try {
            $render = $this->getRenderer()->render('datalist', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}