<?php namespace FrenchFrogs\Form;

use FrenchFrogs\Core;
use InvalidArgumentException;
use FrenchFrogs;

/**
 * Class de gesiton de formulaire de FrenchFrogs
 *
 * Class Form
 * @package FrenchFrogs\Form
 */
class Form
{
    use Core\Html;
    use Core\Renderer;
    use Core\Validator;
    use Core\Filterer;

    /**
     * Containeur des éléments du formulaire
     *
     *
     * @var array
     *
     */
    protected $element = [];

    /**
     * Conteneur des actions du formulaire
     *
     *
     * @var array
     */
    protected $action = [];


    /**
     * constructeur
     *
     */
    public function __construct($url = '', $method = 'POST')
    {
        $this->setUrl($url);
        $this->setMethod($method);
    }

    /**
     * Add un élément à la pile
     *
     * @param Element\Element $element
     * @return $this
     */
    public function addElement(Element\Element $element, Renderer\FormAbstract $renderer = null)
    {
        // attribution du form a l'element pour ne pas qu'il soit orphelin
        $element->setForm($this);

        // si l'element n'a pas de rendu on lui applique celui du formulaire)
        if (!$element->hasRenderer() || !is_null($renderer)) {
            $element->setRenderer($this->getRenderer());
        }

        // si l'element n'a pas de validator on lui applique le model de celui du formulaire
        if (!$element->hasValidator()){
            $element->setValidator(clone $this->getValidator());
        }

        // si l'element n'a pas de validator on lui applique le model de celui du formulaire
        if (!$element->hasFilterer()){
            $element->setFilterer(clone $this->getFilterer());
        }

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
     * @return Element\Element
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
     * @param Element\Element $element
     * @return $this
     */
    public function addAction(Element\Element $element)
    {
        $element->setRenderer($this->getRenderer());
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
     * @return Element\Element
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
        $form = new static($url, $method);
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
        $this->addAttribute('action', $action);
        return $this->addAttribute('url', $action);
    }

    /**
     * Get de l'action - url d'action du formulaire
     *
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getAttribute('url');
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
     * @return string
     *
     */
    public function __toString()
    {
        $render = '';
        try {
            $render = $this->getRenderer()->render('form', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }


    public function render()
    {
        return strval($this);
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


    /**
     * Renvoie la valeur d'un element
     *
     * @param $name
     * @return mixed
     */
    public function getValue($name)
    {
        return $this->getElement($name)->getValue();
    }


    /**
     * Renvoie toute les valeur d'un formulaire
     *
     * @return array
     */
    public function getAllValue()
    {

        $values = [];
        foreach($this->getAllElement() as $name => $e) {
            $values[$name] = $e->getValue();
        }

        return $values;
    }


    /**
     * Renvoie lma valeur filtré d'un element
     *
     * @param $name
     * @return mixed
     */
    public function getFilteredValue($name)
    {
        return $this->getElement($name)->getFilteredValue();
    }


    /**
     * Renvoie toutes les valeurs filtré
     *
     * @return array
     */
    public function getAllFilteredValue()
    {

        $values = [];
        foreach($this->getAllElement() as $name => $e){
            /** @var \FrenchFrogs\Form\Element\Element $e */
            $values[$name] = $e->getFilteredValue();
        }
        return $values;
    }



    /*
     * ***********************************
     *
     * ELEMENTS
     *
     * ***********************************
     */


    /**
     * Ajout d'un champs text
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Text
     */
    public function addText($name, $label = '', $attr = [] )
    {
        $e = new Element\Text($name, $label, $attr);
        $this->addElement($e);
        return $e;
    }

    /**
     * Ajout d'un champs password
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Password
     */
    public function addPassword($name, $label = '', $attr = [] )
    {
        $e = new Element\Password($name, $label, $attr);
        $this->addElement($e);
        return $e;
    }

    /**
     * Ajout d'un champs textarea
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Textarea
     */
    public function addTextarea($name, $label = '', $attr = [] )
    {
        $e = new Element\Textarea($name, $label, $attr);
        $this->addElement($e);
        return $e;
    }
    
    /**
     * Ajout d'un bouton en fin de formulaire
     *
     * @param $name
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Submit
     */
    public function addSubmit($name, $attr = [])
    {
        $e = new Element\Submit($name, $attr);
        $this->addAction($e);
        return $e;
    }


    /**
     * Ajout d'un champs checkbox
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Checkbox
     */
    public function addCheckbox($name, $label = '', $multi  = [], $attr = [] )
    {
        $e = new Element\Checkbox($name, $label, $multi, $attr);
        $this->addElement($e);
        return $e;
    }


    /**
     * Ajout d'un champs tel
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Tel
     */
    public function addTel($name, $label = '', $attr = [] )
    {
        $e = new Element\Tel($name, $label, $attr);
        $this->addElement($e);
        return $e;
    }

    /**
     * Ajout d'un champs Email
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Email
     */
    public function addEmail($name, $label = '', $attr = [] )
    {
        $e = new Element\Email($name, $label, $attr);
        $this->addElement($e);
        return $e;
    }


    /**
     * Ajout d'un champs hidden
     *
     *
     * @param $name
     * @param array $attr
     * @return  \FrenchFrogs\Form\Element\Hidden
     */
    public function addHidden($name, $attr = [])
    {
        $e = new Element\Hidden($name, $attr);
        $this->addElement($e);
        return $e;
    }

    /**
     * Ajout d'un champs label
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Label
     */
    public function addLabel($name, $label = '', $attr = [] )
    {
        $e = new Element\Label($name, $label, $attr);
        $this->addElement($e);
        return $e;
    }


    /**
     * Ajout d'un bouton
     *
     * @param $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Button
     */
    public function addButton($name, $label, $attr = [] )
    {
        $e = new Element\Button($name, $label, $attr);
        $this->addElement($e);
        return $e;
    }


    /**
     * Ajout d'un ligne de sépration
     *
     * @return \FrenchFrogs\Form\Element\Separator
     */
    public function addSeparator()
    {
        $e = new Element\Separator();
        $this->addElement($e);
        return $e;
    }



    public function addTitle($name, $attr = [])
    {
        $e = new Element\Title($name, $attr);
        $this->addElement($e);
        return $e;
    }


    /**
     * Ajout d'un bloc de contenu
     *
     * @param $label
     * @param string $content
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Content
     */
    public function addContent($label, $value = '', $attr = [])
    {
        $e = new Element\Content($label, $value, $attr);
        $this->addElement($e);
        return $e;
    }


    /**
     * Ajout d'un element nombre
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Number
     */
    public function addNumber($name, $label = '', $attr = [] )
    {
        $e = new Element\Number($name, $label, $attr);
        $this->addElement($e);
        return $e;
    }


    /**
     * Ajout d'un element Radio
     *
     * @param $name
     * @param string $label
     * @param array $multi
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Radio
     */
    public function addRadio($name, $label = '', $multi  = [], $attr = [] )
    {
        $e = new Element\Radio($name, $label, $multi, $attr);
        $this->addElement($e);
        return $e;
    }


    /**
     * Ajout d'un champ select
     *
     *
     * @param $name
     * @param $label
     * @param array $multi
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Select
     */
    public function addSelect($name, $label, $multi = [], $attr = [])
    {
        $e = new Element\Select($name, $label, $multi, $attr);
        $this->addElement($e);
        return $e;
    }


    /**
     * Ajout d'un champ fichier
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\File
     */
    public function addFile($name, $label = '', $attr = [])
    {
        $e = new Element\File($name, $label, $attr);
        $this->addElement($e);
        return $e;
    }


    /**
     * *********************
     *
     * VALIDATOR
     *
     * ********************
     */

    /**
     * Validation du formualaire
     *
     * @param array $values
     * @return $this
     */
    public function valid(array $values)
    {
        // validation des elements
        foreach($values as $index => $value){

            $element = $this->getElement($index)->valid($value);

            if (!$element->isValid()) {
                $this->getValidator()->addError($index, $element->getErrorAsString());
            }
        }

        return $this;
    }

    /**
     * Renvoie les erreur formater en chaine de charactère
     *
     *
     * @return string
     */
    public function getErrorAsString()
    {
        $errors  = [];
        foreach($this->getValidator()->getAllError() as $index => $message){
            $errors[] = sprintf('%s:%s %s', $index, PHP_EOL, $message);
        }
        return implode(PHP_EOL, $errors);
    }


    /**
     *
     * *************************
     *
     * FILTERER
     *
     * *************************
     */



    public function filter(array $values)
    {
        // validation des elements
        foreach($values as $index => $value){
            $this->getElement($index)->filter($value);
        }

        return $this;
    }
}