<?php namespace FrenchFrogs\Panel\Panel;


use FrenchFrogs\Core;
use FrenchFrogs\Panel\Action;
use InvalidArgumentException;

/**
 *  Helper to generate a panel
 *
 * @see http://getbootstrap.com/components/#panels
 *
 * Class Panel
 * @package FrenchFrogs\Panel\Panel
 */
class Panel
{

    use \FrenchFrogs\Html\Html;
    use Core\Renderer;

    /**
     * Title of the panel
     *
     * @var
     */
    protected $title;

    /**
     * Header Action container
     *
     * @var array
     */
    protected $actions = [];

    /**
     * Body of the panel
     *
     * @var string
     */
    protected $body;


    /**
     * Context renderer
     *
     * @see http://getbootstrap.com/components/#panels-alternatives
     *
     * @var
     */
    protected $context;


    public function __construct()
    {
        $renderer = configurator()->get('panel.renderer.class');
        $this->setRenderer(new $renderer);


        $this->setContextAsDefault();
    }

    /**
     * Setter for $body attribute
     *
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = strval($body);
        return $this;
    }

    /**
     * getter for $body attribute
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Append $bodyparts to $body attribute
     *
     * @param $bodypart
     * @return $this
     */
    public function appendBody($bodypart)
    {
        $this->body .= strval($bodypart);
        return $this;
    }

    /**
     * Prepend $bodyparts to $body attribute
     *
     * @param $bodypart
     * @return $this
     */
    public function prependBody($bodypart)
    {
        $this->body = strval($bodypart) . $this->body;
        return $this;
    }

    /**
     * unset $body attribute
     *
     * @return $this
     */
    public function clearBody()
    {
        unset($this->body);
        return $this;
    }


    /**
     * Return TRUE $body is set
     *
     * @return bool
     */
    public function hasBody()
    {
        return isset($this->body);
    }


    /**
     * Setter for $title attribute
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }


    /**
     * Getter for $title attribute
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Return TRUE if $title attribute is set
     *
     * @return bool
     */
    public function hasTitle()
    {
        return isset($this->title);
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
     * @param Action\Action $element
     * @return $this
     */
    public function addAction(Action\Action $element)
    {
        if (!$element->hasRenderer()) {
            $element->setRenderer($this->getRenderer());
        }

        $this->actions[$element->getName()] = $element;
        return $this;
    }

    /**
     * Add select remote
     *
     * @param $name
     * @param $placeholder
     * @param $data_url
     * @param $action_url
     * @param int $length
     * @return \FrenchFrogs\Panel\Action\SelectRemote
     */
    public function addSelectRemote($name, $placeholder,  $data_url, $action_url,  $length = 3 )
    {
        $e = new Action\SelectRemote($name, $placeholder,  $data_url, $action_url,  $length);
        $this->addAction($e);
        return $e;
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
     * @return Action\Action
     */
    public function getAction($name)
    {

        if (!$this->hasAction($name)) {
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
     * Return TRUE if $name actions exist in $actions attribute
     *
     * @param $name
     * @return bool
     */
    public function hasAction($name)
    {
        return isset($this->actions[$name]);
    }


    /**
     *
     * Add Button to $actions container
     *
     * @param $name
     * @param $label
     * @param string $href
     * @param array $attr
     * @return \FrenchFrogs\Panel\Action\Button
     */
    public function addButton($name, $label, $href = '#', $attr = [] )
    {
        $e = new Action\Button($name, $label, $attr);
        $e->addAttribute('href', $href);
        $this->addAction($e);
        return $e;
    }


    /**
     * Render polliwog
     *
     * @return mixed|string
     */
    public function render()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('panel', $this);
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
     * *********************
     * CONTEXT
     * *********************
     *
     */


    /**
     * Setter for $context attribute
     *
     * @param $context
     * @return $this
     */
    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }

    /**
     * Getter for $contexts attribute
     *
     * @return String
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Return TRUE if $context is set
     *
     * @return bool
     */
    public function hasContext()
    {
        return isset($this->context);
    }


    /**
     * Unset $context attribute
     *
     * @return $this
     */
    public function removeContext()
    {
        unset($this->context);
        return $this;

    }


    /**
     * Set $context with OPTION_CLASS_DEFAULT
     *
     * @return $this
     */
    public function setContextAsDefault()
    {
        $this->setContext('PANEL_CLASS_DEFAULT');
        return $this;
    }


    /**
     * set $context with OPTION_CLASS_PRIMARY
     *
     * @return $this
     */
    public function setContextAsPrimary()
    {
        $this->setContext('PANEL_CLASS_PRIMARY');
        return $this;
    }

    /**
     * Set $context with OPTION_CLASS_SUCCESS
     *
     * @return $this
     */
    public function setContextAsSuccess()
    {
        $this->setContext('PANEL_CLASS_SUCCESS');
        return $this;
    }

    /**
     * Set $context with OPTION_CLASS_INFO
     *
     * @return $this
     */
    public function setContextAsInfo()
    {
        $this->setContext('PANEL_CLASS_INFO');
        return $this;
    }


    /**
     * Set $context with OPTION_CLASS_WARNING
     *
     * @return $this
     */
    public function setContextAsWarning()
    {
        $this->setContext('PANEL_CLASS_WARNING');
        return $this;
    }

    /**
     * Set $context with OPTION_CLASS_DANGER
     *
     * @return $this
     */
    public function setContextAsDanger()
    {
        $this->setContext('PANEL_CLASS_DANGER');
        return $this;
    }

}