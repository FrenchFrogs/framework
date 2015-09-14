<?php namespace FrenchFrogs\Polliwog\Form\Element;


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
     * Setter pour le multiple
     *
     * @param bool $bool
     * @return $this
     */
    public function setMultiple($bool = true)
    {
        if ($bool) {
            $this->addAttribute('multiple', 'multiple');
        } else {
            $this->removeAttribute('multiple');
        }
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
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('form.select', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}