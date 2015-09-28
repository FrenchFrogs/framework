<?php namespace FrenchFrogs\Polliwog\Modal\Modal;

use FrenchFrogs\Core;
use FrenchFrogs\Polliwog;


class Modal
{

    use Core\Renderer;


    /**
     * Configuration for the overlay
     *
     * @var string | boolean
     */
    protected $backdrop;

    /**
     * Configuration for close modal on escape button press
     *
     * @var boolean
     */
    protected $escToClose;

    /**
     * Titleof the modal
     *
     * @var string
     */
    protected $title;

    /**
     * Body of the modal
     *
     * @var string
     */
    protected $body;

    /**
     * Actions of the modal
     *
     * @var array
     */
    protected $actions = [];




    /**
     * Constructeur
     *
     * @param null $title
     * @param null $body
     * @param null $actions
     */
    public function __construct($title = null, $body = null, $actions = null)
    {
        $this->setBackdrop(configurator()->get('modal.backdrop'));
        $this->setEscToClose( configurator()->get('modal.backdrop'));

        if (!is_null($title)) {
            $this->setTitle($title);
        }

        if (!is_null($body)){
            $this->setBody($body);
        }

        if (!is_null($actions)) {
            $actions = (array) $actions;
            $this->setActions($actions);
        }
    }


    /**
     * Setter for $backdrop attribute
     *
     * @param $backdrop
     * @return $this
     *
     */
    public function setBackdrop($backdrop)
    {
        $this->backdrop = $backdrop;
        return $this;
    }

    /**
     * Set $backdrop attribute as static
     *
     * @return $this
     */
    public function setBackdropAsStatic()
    {
        $this->backdrop = 'static';
        return $this;
    }


    /**
     * Return TRUE if $backdrop attribute is set
     *
     * @return bool
     *
     */
    public function hasBackdrop()
    {
        return isset($this->backdrop);
    }


    /**
     * Getter for $backdrop attribute
     *
     * @return mixed
     */
    public function getBackdrop()
    {
        return $this->backdrop;
    }

    /**
     * Setter for $escToClose attribute
     *
     * @param $escToClose
     * @return $this
     */
    public function setEscToClose($escToClose)
    {
        $this->escToClose = (bool) $escToClose;
        return $this;
    }


    /**
     * return TRUE if $escToClose is TRUE
     *
     * @return mixed
     */
    public function isEscToClose()
    {
        return (bool) $this->escToClose;
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
     * Unset $title attribute
     *
     * @return $this
     */
    public function clearTitle()
    {
        unset($this->title);
        return $this;
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
     * Getter for $body attribute
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Unset $body attribute
     *
     * @return $this
     */
    public function clearBody()
    {
        unset($this->body);
        return $this;
    }

    /**
     * Append $body to ody attribute
     *
     * @param $body
     * @return $this
     */
    public function appendBody($body)
    {
        $this->body .= strval($body);
        return $this;
    }


    /**
     * Prepend $body to $body attribute
     *
     * @param $body
     * @return $this
     */
    public function prependBody($body)
    {
        $this->body  = strval($body) . $this->body;
        return $this;
    }

    /**
     * Setter for $actions container
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
     * Getter for $actions container
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }


    /**
     * Set $action container as an empty array
     *
     * @return $this
     */
    public function clearActions()
    {
        $this->actions = [];
        return $this;
    }

    /**
     * Shift an element off the beginning of the $actions container
     *
     * @return mixed
     */
    public function shiftAction()
    {
        return array_shift($this->actions);
    }

    /**
     * Pop an element off the end of the container
     *
     * @return mixed
     */
    public function popAction()
    {
        return array_pop($this->actions);
    }


    /**
     * Push one element to the end of the $actions container
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Button $action
     * @return $this
     */
    public function appendAction(Polliwog\Form\Element\Button $action)
    {
        $this->actions[] = $action;
        return $this;
    }

    /**
     * Prepend one elements to the beginning of the $actions container
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Button $action
     * @return $this
     */
    public function prependAction(Polliwog\Form\Element\Button $action)
    {
        array_unshift($this->actions, $action);
        return $this;
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
            $render = $this->getRenderer()->render('modal', $this);
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
}