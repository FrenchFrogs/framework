<?php namespace FrenchFrogs\Form\Element;

use FrenchFrogs\Core;
use FrenchFrogs\Form\Form\Form;


abstract class Element
{
    use \FrenchFrogs\Html\Html;
    use Core\Renderer;
    use Core\Validator;
    use Core\Filterer;

    /**
     * Parent form
     *
     * @var Bootstrap
     *
     */
    protected $form;

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
     * Description for element
     *
     * @var string
     */
    protected $description;


    /**
     * Name of belong element
     *
     * @var string
     */
    protected $alias;


    /**
     * Setter for $belongTo attribute
     *
     * @param $name
     * @return $this
     */
    public function setAlias($name)
    {
        $this->alias = $name;
        return $this;
    }


    /**
     * Getter $belongTo attribute
     *
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Return TRUE if $belongTo attribute is set
     *
     * @return bool
     */
    public function hasAlias()
    {
        return isset($this->alias);
    }


    /**
     * unset $belongTo attribute
     *
     * @return $this
     */
    public function removeBelongTo()
    {
        unset($this->alias);
        return $this;
    }

    /**
     * If the element has to be treat during global action
     *
     */
    protected $is_discreet = false;

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param Form $form
     * @return $this
     */
    public function setForm(Form $form)
    {
        $this->form = $form;
        return $this;
    }

    /**
     * Retourn si l'element a un label
     *
     * @return bool
     */
    public function hasForm()
    {
        return isset($this->form);
    }

    /**
     * Supprime la liaison avec le formulaire
     *
     * @return $this
     */
    public function removeForm()
    {
        unset($this->form);
        return $this;

    }



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



    /**
     * Setter for $description attribute
     *
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Getter for $description attribute
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Return TRUE if $description attribute is set
     *
     * @return bool
     */
    public function hasDescription()
    {
        return isset($this->description);
    }

    /**
     * Unset $description attribute
     *
     * @return $this
     */
    public function removeDescription()
    {
        unset($this->description);
        return $this;
    }


    /**
     * Getter for form renderer
     *
     * @return \FrenchFrogs\Renderer\Renderer|null
     */
    public function getRenderer()
    {
        if ($this->hasForm()) {
            return $this->getForm()->getRenderer();
        } elseif($this->hasRenderer()) {
            return $this->renderer;
        } else {
            return null;
        }
    }

    /**
     * getter for form validator
     *
     * @return \FrenchFrogs\Validator\Validator|null
     */
    public function getValidator()
    {
        if(!$this->hasValidator() && $this->hasForm()) {
            $this->setValidator(clone $this->getForm()->getValidator());
        }
        return $this->validator;
    }

    /**
     * **************
     *
     * VALIDATOR
     *
     * **************
     */


    /**
     * Ajoute un validator
     *
     * @param $rule
     * @param null $method
     * @param array $params
     * @param null $message
     * @return $this
     */
    public function addRule($rule, $method = null, $params = [], $message = null)
    {

        // construction des paramètres
        array_unshift($params, $rule, $method);

        //ajout de la regle
        call_user_func_array([$this->getValidator(), 'addRule'], $params);

        if (!is_null($message)) {
            $this->getValidator()->addMessage($rule, $message);
        }

        return $this;
    }

    /**
     * Renvoie true si lee va
     *
     * @param $rule
     * @return bool
     */
    public function hasRule($rule)
    {
        $this->getValidator()->hasRule($rule);
        return $this;
    }


    /**
     * Suppression d'un regle
     *
     * @param $rule
     * @return $this
     */
    public function removeRule($rule)
    {
        $this->getValidator()->removeRule($rule);

        return $this;
    }


    /**
     * Validation de la valeur courant de l'element
     *
     * @param mixed $value
     * @return $this
     * @throws \Exception
     */
    public function valid($value = null)
    {

        // si la valeur n'ets pas null, on la set
        if (!is_null($value)) {
            $this->setValue($value);
        }
//        ddo($this->getValidator());
        $this->getValidator()->valid($this->getValue());

        return $this;
    }

    /**
     * ******************
     *
     * FILTERER
     *
     * ******************
     */

    /**
     * Ajoute un filtre
     *
     * @param $filter
     * @param null $method
     * @return $this
     */
    public function addFilter($filter, $method = null, ...$params)
    {
        if (!$this->hasFilterer()) {
            $this->setFilterer(configurator()->build('form.filterer.class'));
        }

        call_user_func_array([$this->getFilterer(), 'addFilter'], func_get_args());
        return $this;
    }

    /**
     * Renvoie true si lee va
     *
     * @param $filter
     * @return bool
     */
    public function hasFilter($filter)
    {
        $this->getFilterer()->hasFilter($filter);
        return $this;
    }


    /**
     * Suppression d'un regle
     *
     * @param $filter
     * @return $this
     */
    public function removeFilter($filter)
    {
        $this->getFilterer()->removeFilter($filter);
        return $this;
    }


    /**
     * Renvoie la valeur filtré
     *
     * @return mixed
     * @throws \Exception
     */
    public function getFilteredValue()
    {
        if ($this->hasFilterer()) {
            $value = $this->getFilterer()->filter($this->getValue());
        } else {
            $value = $this->getValue();
        }

        return $value;
    }

    /**
     * Enable if the element has to be treated during global process
     *
     * @return \FrenchFrogs\Form\Element\Element
     */
    public function enableDiscreet()
    {
        $this->is_discreet = true;
        return $this;
    }

    /**
     * Disable if the element has to be treated during global process
     *
     * @return \FrenchFrogs\Form\Element\Element
     */
    public function disableDiscreet()
    {
        $this->is_discreet = false;
        return $this;
    }

    /**
     *
     * Return TRUE if the element has to be treat during global process
     *
     * @return bool
     */
    public function isDiscreet()
    {
        return $this->is_discreet;
    }
}