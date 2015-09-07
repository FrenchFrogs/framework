<?php namespace FrenchFrogs\Form\Element;


class Radio extends Element
{

    /**
     * Valeur pour le radio
     *
     *
     * @var array
     */
    protected $options = [];

    /**
     * Constructeur
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $options = [], $attr = [] )
    {
        $this->setAttribute($attr);
        $this->setName($name);
        $this->setLabel($label);
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
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('form.radio', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}