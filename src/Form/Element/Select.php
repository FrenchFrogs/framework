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

        if ($this->isMultiple()) {
            $value = (array) $value;
        }

        $this->value = $value;
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
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('select', $this);
        } catch(\Exception $e){
            dd($e->getTraceAsString());
        }

        return $render;
    }


    /**
     * Set Options from parent selection
     *
     * @param $selector
     * @param $url
     * @return $this
     */
    public function setDependOn($selector, $url)
    {
        return $this->addAttribute('data-parent-url', $url)
                    ->addAttribute('data-parent-selector',  $selector)
                    ->addClass('select-remote');
    }


    /**
     * Unlink parent selection for options completion
     *
     * @return $this
     */
    public function removeDependOn()
    {
        return $this->removeAttribute('data-parent-url')
            ->removeAttribute('data-parent-selector')
            ->removeClass('select-remote');
    }
}