<?php namespace FrenchFrogs\Form\Element;


class Boolean extends Element
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
        $this->setSizeAtSmall();
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
        return parent::setValue((bool) $value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return (bool) $this->value;
    }


    /**
     * Set size to Small
     *
     * @return $this
     */
    public function setSizeAtSmall()
    {
        $this->addAttribute('data-size', 'small');
        return $this;
    }

    /**
     * Set size to normal
     *
     * @return $this
     */
    public function setSizeAtNormal()
    {
        $this->addAttribute('data-size', 'normal');
        return $this;
    }

    /**
     * Set size to large
     *
     * @return $this
     */
    public function setSizeAtLarge()
    {
        $this->addAttribute('data-size', 'large');
        return $this;
    }

    /**
     * unset size
     *
     * @return $this
     */
    public function removeSize()
    {
        $this->removeAttribute('data-size');
        return $this;
    }


    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('boolean', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}