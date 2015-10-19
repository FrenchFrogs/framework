<?php namespace FrenchFrogs\Polliwog\Form\Element;


class Checkbox extends Element
{
    /**
     * Options values
     *
     * @var array
     */
    protected $options = [];

    /**
     * Value when checked
     *
     * @var string
     */
    protected $checkedValue = '1';

    /**
     * Value when not checked
     *
     * @var string
     */
    protected $uncheckedValue = '0';

    /**
     * Current value
     *
     * @var string 0 or 1
     */
    protected $value = '0';

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
     * Override of parent class
     *
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        if ($value == $this->getCheckedValue()) {
            parent::setValue($value);
            $this->checked = true;
        } else {
            parent::setValue($this->getUncheckedValue());
            $this->checked = false;
        }
        return $this;
    }

    /**
     * Set the options
     *
     * @param $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        if (array_key_exists('checkedValue', $options)) {
            $this->setCheckedValue($options['checkedValue']);
            unset($options['checkedValue']);
        }
        if (array_key_exists('uncheckedValue', $options)) {
            $this->setUncheckedValue($options['uncheckedValue']);
            unset($options['uncheckedValue']);
        }
        $this->options = $options;

        $curValue = $this->getValue();

        $test = array($this->getCheckedValue(), $this->getUncheckedValue());

        if (!in_array($curValue, $test)) {
            $this->setValue($curValue);
        }

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
     * Set the checked value
     *
     * @param $value
     * @return $this
     */
    public function setCheckedValue($value)
    {
        $this->checkedValue = (string) $value;
        $this->options['checkedValue'] = $value;
        return $this;
    }

    /**
     * Get value when checked
     *
     * @return string
     */
    public function getCheckedValue()
    {
        return $this->checkedValue;
    }

    /**
     * Set the unchecked value
     *
     * @param $value
     * @return $this
     */
    public function setUncheckedValue($value)
    {
        $this->uncheckedValue = (string) $value;
        $this->options['uncheckedValue'] = $value;
        return $this;
    }

    /**
     * Get value when not checked
     *
     * @return string
     */
    public function getUncheckedValue()
    {
        return $this->uncheckedValue;
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
            $renderer = $this->isMultiple() ? 'checkboxmulti' : 'checkbox';
            $render = $this->getRenderer()->render($renderer, $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}