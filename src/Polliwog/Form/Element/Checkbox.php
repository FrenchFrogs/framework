<?php namespace FrenchFrogs\Polliwog\Form\Element;


class Checkbox extends Element
{

    /**
     * Valeur pour le select
     *
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
     * Renvoie si le select est multiple
     *
     * @return bool
     */
    public function isMultiple()
    {
        return count($this->options) > 0;
    }


    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $renderer = $this->isMultiple() ? 'form.checkboxmulti' : 'form.checkbox';
            $render = $this->getRenderer()->render($renderer, $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}