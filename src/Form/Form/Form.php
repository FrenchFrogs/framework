<?php namespace FrenchFrogs\Form\Form;

use FrenchFrogs\Core;
use FrenchFrogs;
use FrenchFrogs\Form\Renderer;

/**
 * Form polliwog
 *
 * Class Form
 * @package FrenchFrogs\Form\Form
 */
class Form
{
    use \FrenchFrogs\Html\Html;
    use Core\Renderer;
    use Core\Validator;
    use Core\Filterer;
    use Core\Panel;
    use Remote;
    use Element;

    /**
     * Legend of the form (title)
     *
     * @var
     */
    protected $legend;


    /**
     * Specify if the form will render csrf token
     *
     * @var
     */
    protected $has_csrfToken;

    /**
     * Set $has_csrfToken to TRUE
     *
     * @return $this
     */
    public function enableCsrfToken()
    {
        $this->has_csrfToken = true;
        return $this;
    }

    /**
     * Set $has_csrfToken to FALSE
     *
     * @return $this
     */
    public function disableCsrfToken()
    {
        $this->has_csrfToken = false;
        return $this;
    }

    /**
     * Getter for $has_csrfToken
     *
     * @return mixed
     */
    public function hasCsrfToken()
    {
        return $this->has_csrfToken;
    }


    /**
     * Setter for $legend attribute
     *
     * @param $legend
     * @return $this
     */
    public function setLegend($legend)
    {
        $this->legend = strval($legend);
        return $this;
    }

    /**
     * Getter for $legend attribute
     *
     * @return mixed
     */
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * Return TRUE if $$legend attribute is set
     *
     * @return bool
     */
    public function hasLegend()
    {
        return isset($this->legend);
    }



    /**
     * Constructor
     *
     * @param string $url
     * @param string $method
     */
    public function __construct($url = null, $method = null)
    {
        /*
        * Configure polliwog
        */
        $c = configurator();
        $class = $c->get('form.renderer.class');
        $this->setRenderer(new $class);

        $class = $c->get('form.validator.class');
        $this->setValidator(new $class);

        $class = $c->get('form.filterer.class');
        $this->setFilterer(new $class);

        $this->has_csrfToken = $c->get('form.default.has_csrfToken', true);


        //default configuration
        $this->addAttribute('id', 'form-' . rand());

        // if method "init" exist, we call it.
        if (method_exists($this, 'init')) {
            $this->setMethod($c->get('form.default.method', 'POST'));
            call_user_func_array([$this, 'init'], func_get_args());
        } else {
            $this->setUrl($url);
            $this->setMethod(is_null($method) ? $c->get('form.default.method', 'POST') : $method);
        }

        // default url
        if (empty($this->getUrl())) {
            $this->setUrl(\Request::fullUrl());
        }
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
     * Render the polliwog
     *
     * @return mixed|string
     */
    public function render()
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
     * Overload parent method for form specification
     *
     * @return string
     *
     */
    public function __toString()
    {
        return $this->render();
    }


    /**
     *
     * Fill the form with $values
     *
     * @param array $values
     * @return $this
     */
    public function populate(array $values, $alias = false)
    {
        foreach($this->getElements() as $e) {
            /** @var $e \FrenchFrogs\Form\Element\Element */
            $name = $alias && $e->hasAlias() ? $e->getAlias() : $e->getName();
            if (array_key_exists($name, $values)) {
                $e->setValue($values[$name]);
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
            if ($e->isDiscreet()) {continue;}
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
    public function getFilteredValues()
    {
        $values = [];

        foreach($this->getElements() as $name => $e){
            /** @var \FrenchFrogs\Form\Element\Element $e */
            if ($e->isDiscreet()) {continue;}
            $values[$name] = $e->getFilteredValue();
        }
        return $values;
    }


    public function getFilteredAliasValues()
    {

        $values = [];
        foreach($this->getElements() as $name => $e){
            /** @var \FrenchFrogs\Form\Element\Element $e */
            if ($e->isDiscreet()) {continue;}
            $name = $e->hasAlias() ? $e->getAlias() : $name;

            if ($e instanceof \FrenchFrogs\Form\Element\Checkbox) {
                if(empty($values[$name])) {
                    $values[$name] = [];
                }

                foreach((array) $e->getFilteredValue() as $value) {
                    $values[$name][] = $value;
                }
            } else {
                $values[$name] = $e->getFilteredValue();
            }
        }
        return $values;
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
     * @param bool|true $populate
     * @return $this
     */
    public function valid(array $values, $populate = true)
    {
        foreach($values as $index => $value){

            // if element is not set, we pass
            if (!$this->hasElement($index)) {continue;}

            // element validation
            $element = $this->getElement($index)->valid($value);

            // populate value
            if ($populate) {
                $element->setValue($value);
            }

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
}