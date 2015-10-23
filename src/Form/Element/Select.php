<?php namespace FrenchFrogs\Form\Element;


class Select extends Element
{

    /**
     * Valeur pour le select
     *
     *
     * @var array
     */
    protected $options = [];

    /**
     *
     *
     * @param $name
     * @param string $label
     * @param array $options
     * @param array $attr
     */
    public function __construct($name, $label = '', $options = [], $attr = [] )
    {
        $this->setAttributes($attr);
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
     * Setting de la value
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = (array) $value;
    }


    /**
     * getter placeholder
     *
     * @return null
     */
    public function getPlaceholder()
    {
        return '-- ' . $this->getAttribute('placeholder') . ' --';
    }

    /**
     * Enabler pour le multiple
     *
     * @return $this
     */
    public function enableMultiple()
    {
        $this->addAttribute('multiple', 'multiple');
        return $this;
    }

    /**
     * Disabler pour le multiple
     *
     * @return $this
     */
    public function disableMultiple()
    {
        $this->removeAttribute('multiple');
        return $this;
    }

    /**
     * Renvoie si le select est multiple
     *
     * @return bool
     */
    public function isMultiple()
    {
        return $this->getAttribute('multiple') == 'multiple';
    }

    /**
     * Get filtered value of select
     *
     * @return mixed
     */
    public function getFilteredValue()
    {
        $data = $this->getValue();
        if($this->isMultiple()) {
            $value = $data;
        }
        else {
            $value = $data[0];
        }

        return $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('select', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}