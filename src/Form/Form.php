<?php namespace FrenchFrogs\Form;

use FrenchFrogs\Core;
use InvalidArgumentException;
use FrenchFrogs;

/**
 * Form pollywog
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
     * Elements container
     *
     * @var array
     */
    protected $elements = [];

    /**
     * Action (form submission) containers
     *
     * @var array
     */
    protected $actions = [];


    /**
     * Constructor
     *
     * @param string $url
     * @param string $method
     */
    public function __construct($url = '', $method = 'POST')
    {
        $this->setUrl($url);
        $this->setMethod($method);
    }

    /**
     * Add a single element to the elements container
     *
     * @param Element\Element $element
     * @return $this
     */
    public function addElement(Element\Element $element, Renderer\FormAbstract $renderer = null)
    {
        // Join element to the form
        $element->setForm($this);

        // Add renderer to element if it didn't has one
        if (!$element->hasRenderer() || !is_null($renderer)) {
            $element->setRenderer($this->getRenderer());
        }

        // Add validator to element if it didn't has one
        if (!$element->hasValidator()){
            $element->setValidator(clone $this->getValidator());
        }

        // Add validator to element if it didn't has one
        if (!$element->hasFilterer()){
            $element->setFilterer($this->getFilterer());
        }

        $this->elements[$element->getName()] = $element;

        return $this;
    }

    /**
     * Remove element $name from elements container
     *
     * @param $name
     * @return $this
     */
    public function removeElement($name)
    {

        if (isset($this->elements[$name])) {
            unset($this->elements[$name]);
        }

        return $this;
    }

    /**
     * Clear the elements container
     *
     * @return $this
     */
    public function clearElements()
    {

        $this->elements = [];

        return $this;
    }

    /**
     * Return the element $name from the elements container
     *
     * @param $name
     * @throws InvalidArgumentException
     * @return Element\Element
     */
    public function getElement($name)
    {

        if (!isset($this->elements[$name])) {
            throw new InvalidArgumentException(" Element not found : {$name}");
        }

        return $this->elements[$name];
    }

    /*
     * Return the elemen container as an array
     *
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }


    /**
     * Set the action container
     *
     * @param array $actions
     * @return $this
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;
        return $this;
    }


    /**
     * Add an action to the action container
     *
     * @param Element\Element $element
     * @return $this
     */
    public function addAction(Element\Element $element)
    {
        $element->setRenderer($this->getRenderer());
        $this->actions[$element->getName()] = $element;
        return $this;
    }

    /**
     * Remove the action $name from the actions container
     *
     * @param $name
     * @return $this
     */
    public function removeAction($name)
    {

        if (isset($this->actions[$name])) {
            unset($this->actions[$name]);
        }

        return $this;
    }

    /**
     * Clear all the actions from the action container
     *
     * @return $this
     */
    public function clearActions()
    {
        $this->actions = [];
        return $this;
    }

    /**
     * Return the $name element from the actions container
     *
     * @param $name
     * @throws InvalidArgumentException
     * @return Element\Element
     */
    public function getAction($name)
    {

        if (!isset($this->actions[$name])) {
            throw new InvalidArgumentException("Action not found : {$name}");
        }

        return $this->actions[$name];
    }

    /**
     * Return actions container as an array
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     *
     * Factory
     *
     * @param string $url action attributes
     * @param string $method method Attributes
     * @return Form
     */
    static public function create($url = '', $method = 'POST')
    {
        $form = new static($url, $method);
        return $form;
    }

    /**
     * Set method
     *
     * @param $method
     * @return $this
     */
    public function setMethod($method)
    {
        return $this->addAttribute('method', $method);
    }


    /**
     * Get method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->getAttribute('method');
    }

    /**
     * Set action URL
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
     * get action URL
     *
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getAttribute('url');
    }


    /**
     * Magic method for exceptional use
     *
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
            dd($e->getMessage());//@todo find a good way to warn the developper
        }

        return $render;
    }


    /**
     *
     * Fill the form with $values
     *
     * @param array $values
     * @return $this
     */
    public function populate(array $values)
    {
        foreach($values as $name => $value) {
            if(!empty($this->elements[$name])) {
                $this->elements[$name]->setValue($value);
            }
        }

        return $this;
    }


    /**
     * Return the value single value of the $name element
     *
     * @param $name
     * @return mixed
     */
    public function getValue($name)
    {
        return $this->getElement($name)->getValue();
    }


    /**
     * Return all values from all elements
     *
     * @return array
     */
    public function getValues()
    {

        $values = [];
        foreach($this->getElements() as $name => $e) {
            /** @var $e \FrenchFrogs\Form\Element\Element */
            $values[$name] = $e->getValue();
        }

        return $values;
    }


    /**
     * Return single filtered value from the $name element
     *
     * @param $name
     * @return mixed
     */
    public function getFilteredValue($name)
    {
        return $this->getElement($name)->getFilteredValue();
    }


    /**
     * Return all filtered values from all elements
     *
     * @return array
     */
    public function getAllFilteredValue()
    {

        $values = [];
        foreach($this->getElements() as $name => $e){
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
     * Add a input:text element
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
     * Add input:password element
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
     * Add textarea element
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
     * Add action button
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
     * Add input checkbox element
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
     * Add phone element
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
     * Add input:mail element
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
     * Add input:hidden element
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
     * Add label element (read-only element)
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
     * Add button element
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
     * Add separation
     *
     * @return \FrenchFrogs\Form\Element\Separator
     */
    public function addSeparator()
    {
        $e = new Element\Separator();
        $this->addElement($e);
        return $e;
    }


    /**
     * Add a Title element
     *
     * @param $name
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Title
     */
    public function addTitle($name, $attr = [])
    {
        $e = new Element\Title($name, $attr);
        $this->addElement($e);
        return $e;
    }


    /**
     * Add format content
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
     * Add input:number element
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
     * Add input:radio element
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
     * Add select element
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
     * Add file element
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
     * Valid all the form elements
     *
     * @param array $values
     * @return $this
     */
    public function valid(array $values)
    {
        foreach($values as $index => $value){

            $element = $this->getElement($index)->valid($value);

            if (!$element->isValid()) {
                $this->getValidator()->addError($index, $element->getErrorAsString());
            }
        }

        return $this;
    }

    /**
     * Return string formated error from the form validation
     *
     *
     * @return string
     */
    public function getErrorAsString()
    {
        $errors  = [];
        foreach($this->getValidator()->getErrors() as $index => $message){
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

        foreach($values as $index => $value){
            $this->getElement($index)->filter($value);
        }

        // @todo return fitered values

        return $this;
    }
}