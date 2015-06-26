<?php namespace FrenchFrogs\Form\Element;

use FrenchFrogs\Core;


abstract class Element
{
    use Core\HtmlTag;

    /**
     * Valeur de l'element
     *
     * @var $value
     *
     */
    protected $value;

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
        return $this;
    }

    /**
     *
     * Set le nom de l'élément
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->addAttribute('name', $name);
    }

    /**
     * Get le nom de l'élément
     *
     * @return string
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }


    public function placeholder($value = false)
    {

        // par default on met la valeur du champs
        if ($value === false) {
            $value = $this->getName();
        }

        return $this->addAttribute('placeholder', $value);
    }
}