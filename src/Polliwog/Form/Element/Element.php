<?php namespace FrenchFrogs\Polliwog\Form\Element;

use FrenchFrogs\Core;
use FrenchFrogs\Polliwog\Form\Form;


abstract class Element
{
    use Core\Html;
    use Core\Renderer;
    use Core\Validator;
    use Core\Filterer;

    /**
     * Contient le formulaire
     *
     * @var Form
     *
     */
    protected $form;

    /**
     * Label du champs
     *
     * @var string
     */
    protected $label;

    /**
     * Valeur de l'element
     *
     * @var $value
     *
     */
    protected $value;



    /**
     * Si l'element doit être traité dans les process de masse comme le retour de valeur ou autres
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

        dd($this);
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
    public function valida($value = null)
    {

        // si la valeur n'ets pas null, on la set
        if (!is_null($value)) {
            $this->setValue($value);
        }

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
     * @param $filterer
     * @param null $method
     * @return $this
     */
    public function addFilter($filter, $method = null)
    {
        $this->getFilterer()->addFilter($filter, $method);
        return $this;
    }

    /**
     * Renvoie true si lee va
     *
     * @param $rule
     * @return bool
     */
    public function hasFilter($filterer)
    {
        $this->getFilterer()->hasFilter($filter);
        return $this;
    }


    /**
     * Suppression d'un regle
     *
     * @param $rule
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
        return  $this->getFilterer()->filter($this->getValue());
    }
}