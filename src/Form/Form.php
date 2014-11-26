<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 15/10/14
 * Time: 13:28
 */

namespace FrenchFrogs\Form;

use FrenchFrogs\Core;
use InvalidArgumentException;


class Form
{
    use Core\HtmlTag;


    /**
     * Containeur des éléments du formulaire
     *
     *
     * @var array
     *
     */
    protected $element = [];

    /**
     * Conteneur des action du formulaire
     *
     *
     * @var array
     */
    protected $action = [];


    /**
     * constructeur
     *
     */
    public function __construct()
    {

    }

    /**
     * Add un élément à la pile
     *
     * @param Element $element
     * @return $this
     */
    public function addElement(Element $element)
    {
        $this->element[$element->getName()] = $element;
        return $this;
    }

    /**
     * Remove l'element $name
     *
     * @param $name
     * @return $this
     */
    public function removeElement($name)
    {

        if (isset($this->element[$name])) {
            unset($this->element[$name]);
        }

        return $this;
    }

    /**
     * Remove tous les éléments
     *
     * @return $this
     */
    public function clearElement()
    {

        $this->element = [];

        return $this;
    }

    /**
     * Renvoie l'element $name
     *
     * @param $name
     * @throws InvalidArgumentException
     * @return Element
     */
    public function getElement($name)
    {

        if (!isset($this->element[$name])) {
            throw new InvalidArgumentException("L'élément {$name} n'existe pas.");
        }

        return $this->element[$name];
    }

    /*
     * Renvoie le tableau d'élement
     *
     * @return array
     */
    public function getAllElement()
    {
        return $this->element;
    }


    /**
     * Add une action à la pile
     *
     * @param Element $element
     * @return $this
     */
    public function addAction(Element $element)
    {
        $this->action[$element->getName()] = $element;
        return $this;
    }

    /**
     * Remove l'action $name
     *
     * @param $name
     * @return $this
     */
    public function removeAction($name)
    {

        if (isset($this->action[$name])) {
            unset($this->action[$name]);
        }

        return $this;
    }

    /**
     * Remove toutes les actions
     *
     * @return $this
     */
    public function clearAction()
    {

        $this->action = [];

        return $this;
    }

    /**
     * Renvoie l'element $name
     *
     * @param $name
     * @throws InvalidArgumentException
     * @return Element
     */
    public function getAction($name)
    {

        if (!isset($this->action[$name])) {
            throw new InvalidArgumentException("L'action {$name} n'existe pas.");
        }

        return $this->action[$name];
    }

    /*
     * Renvoie le tableau d'élement
     *
     * @return array
     */
    public function getAllAction()
    {
        return $this->action;
    }

    /**
     *
     * Factory
     *
     * @param string $url attribut action
     * @param string $method $attribut method
     * @return Form
     */
    static public function create($url = '', $method = 'POST')
    {
        $form = new static();
        $form->setUrl($url);
        $form->setMethod($method);

        return $form;
    }

    /**
     * Set de l'attribut method du formulaire
     *
     * @param $method
     * @return $this
     */
    public function setMethod($method)
    {
        return $this->addAttribute('method', $method);
    }


    /**
     * Get de l'attribut method du formulaire
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->getAttribute('method');
    }

    /**
     * Set de l'action - url d'action du formulaire
     *
     * @param $action
     * @return $this
     */
    public function setUrl($action)
    {
        return $this->addAttribute('action', $action);
    }

    /**
     * Get de l'action - url d'action du formulaire
     *
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getAttribute('action');
    }


    /**
     * @param $name
     * @param $arguments
     */
    function __call($name, $arguments)
    {

        if (preg_match('#add(?<type>\w+)#', $name, $match)){

            // cas des action
            if (substr($match['type'], 0, 6) == 'Action') {
                $type = substr($match['type'], 6);
                $class = new \ReflectionClass(__NAMESPACE__ . '\Element\\' . $type);
                $e = $class->newInstanceArgs($arguments);
                $this->addAction($e);

            // cas des element
            } else {
                $class = new \ReflectionClass(__NAMESPACE__ . '\Element\\' . $match['type']);
                $e = $class->newInstanceArgs($arguments);
                $this->addElement($e);
            }
        }
    }

    /**
     * Overload parent method for form specification
     *
     */
    public function __toString()
    {
        $html = '';

        try {
            $this->addAttribute('role', 'form');
            $html .= \Form::open($this->getAllAttribute());

            // Element
            foreach ($this->element as $e) {$html .= $e->render();}

            // Action
            if (count($this->action)) {
                $html .= '<div class="text-right">';
                foreach ($this->action as $e) {
                    $html .= $e->render();
                }
                $html .= "</div>";
            }
            $html .= \Form::close();

        } catch(\Exception $e) {
            dd('Erreur sur la génération du formulaire : ' . $e->getMessage());
        }

        return $html;
    }


    /**
     * Rempli un formulaire
     *
     *
     *
     * @param array $row
     *
     */
    public function populate(array $row)
    {
        foreach($row as $name => $value) {

            if(!empty($this->element[$name])) {
                $this->element[$name]->setValue($value);
            }
        }
    }
}