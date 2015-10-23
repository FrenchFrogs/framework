<?php namespace FrenchFrogs\Panel\Action;

use FrenchFrogs\Core;


abstract class Action
{
    use \FrenchFrogs\Html\Html;
    use Core\Renderer;

    /**
     * Field label
     *
     * @var string
     */
    protected $label;

    /**
     * Field value
     *
     * @var $value
     *
     */
    protected $value;



    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Retourn si l'element a un label
     *
     * @return bool
     */
    public function hasLabel()
    {
        return isset($this->label);
    }

    /**
     * Supprime le label de l'élément
     *
     * @return $this
     */
    public function removeLabel()
    {
        unset($this->label);

        return $this;
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
        return $this;
    }

    /**
     * Renvoie si une valeur est setter pour l'objet
     *
     * @return bool
     */
    public function hasValue()
    {
        return isset($this->value);
    }

    /**
     * Supprime la valeur de l'element
     *
     * @return $this
     */
    public function removevalue()
    {
        unset($this->value);

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

    /**
     * Renvoie si l'element a une attribut name
     *
     * @return bool
     */
    public function hasName()
    {
        return $this->hasAttribute('name');
    }

    /**
     * Supprime le name de l'element
     *
     * @return $this
     */
    public function removeName()
    {
        return $this->removeAttribute('name');
    }

    /**
     * Setter placeholder
     *
     * @param bool|false $value
     * @return $this
     */
    public function setPlaceholder($value = false)
    {
        // par default on met la valeur du champs
        if ($value === false) {
            $value = $this->getLabel();
        }

        return $this->addAttribute('placeholder', $value);
    }


    /**
     * getter placeholder
     *
     * @return null
     */
    public function getPlaceholder()
    {
        return $this->getAttribute('placeholder');
    }


    /**
     * Si l'element a un placeholder
     *
     * @return bool
     */
    public function hasPlaceholder()
    {
        return $this->hasAttribute('placeholder');
    }

    /**
     * Suppression du placeholder
     *
     * @return $this
     */
    public function removeplaceholder()
    {
        return $this->removeAttribute('placeholder');
    }
}