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
    protected $backdrop = true;

    /**
     * Configuration for close modal on escape button press
     *
     * @var boolean
     */
    protected $is_escToClose = true;

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
     * true if render the header close button
     *
     * @var Boolean
     */
    protected $has_closeButton = true;


    /**
     * Label for the close button
     *
     * @var string
     */
    protected $closeButtonLabel = 'Close';


    /**
     * id html attribute for remote modal
     *
     * @var
     */
    protected $remoteId;


    /**
     * TRUE if render only the main content container
     *
     * @var bool
     */
    protected $is_remote = false;


    /**
     * Setter for $id attribute
     *
     * @param $id
     * @return $this
     */
    public function setRemoteId($id)
    {
        $this->remoteId = $id;
        return $this;
    }

    /**
     * Getter for $remoteId Attribute
     *
     * @return mixed
     */
    public function getRemoteId()
    {
        return $this->remoteId;
    }

    /**
     * Setter for $closeButtonLabel Attribute
     *
     * @param $label
     * @return $this
     */
    public function setCloseButtonLabel($label)
    {
        $this->closeButtonLabel = $label;
        return $this;
    }

    /**
     * Getter for $closeButtonLabel attribute
     *
     * @return string
     */
    public function getCloseButtonLabel()
    {
        return $this->closeButtonLabel;
    }

    /**
     * Enabler for $is_closeButton attribute
     *
     * @return $this
     */
    public function enableCloseButton()
    {
        $this->has_closeButton = true;
        return $this;
    }

    /**
     * Disabler for $is_closeButton attribute
     *
     * @return $this
     */
    public function disableCloseButton()
    {
        $this->has_closeButton = false;
        return $this;
    }

    /**
     * Return TRUE if the close button will be render
     *
     * @return bool
     */
    public function hasCloseButton()
    {
        return $this->has_closeButton;
    }

    /**
     * Enabler for $is_onlyContent attribute
     *
     * @return $this
     */
    public function enableRemote()
    {
        $this->is_remote = true;
        return $this;
    }

    /**
     * Disabler for $is_onlyContent attribute
     *
     * @return $this
     */
    public function disableRemote()
    {
        $this->is_remote = false;
        return $this;
    }

    /**
     * Return TRUE if $is_onlyContent attribute is TRUE
     *
     * @return bool
     */
    public function isRemote()
    {
        return $this->is_remote;
    }

    /**
     * Constructeur
     *
     * @param null $title
     * @param null $body
     * @param null $actions
     */
    public function __construct($title = null, $body = null, $actions = null)
    {
        (configurator()->get('modal.backdrop')) ? $this->enableBackdrop()   : $this->disableBackdrop();
        (configurator()->get('modal.backdrop')) ? $this->enableEscToClose() : $this->disableEscToClose();
        $this->setCloseButtonLabel(configurator()->get('modal.closeButtonLabel', $this->closeButtonLabel));

        (configurator()->get('modal.is_remote')) ? $this->enableRemote()    : $this->disableRemote();
        $this->setRemoteId(configurator()->get('modal.remote.id', $this->remoteId));

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

        // Renderer
        $renderer = configurator()->get('modal.renderer.class');
        $this->setRenderer(new $renderer);
    }

    /**
     * Enabler for $backdrop attribute
     *
     * @return $this
     *
     */
    public function enableBackdrop()
    {
        $this->backdrop = true;
        return $this;
    }

    /**
     * Disabler for $backdrop attribute
     *
     * @return $this
     *
     */
    public function disableBackdrop()
    {
        $this->backdrop = false;
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
     * Enabler for $is_escToClose attribute
     *
     * @return $this
     */
    public function enableEscToClose()
    {
        $this->is_escToClose = true;
        return $this;
    }

    /**
     * Disabler for $is_escToClose attribute
     *
     * @return $this
     */
    public function disableEscToClose()
    {
        $this->is_escToClose = false;
        return $this;
    }

    /**
     * return TRUE if $is_escToClose is TRUE
     *
     * @return mixed
     */
    public function isEscToClose()
    {
        return (bool) $this->is_escToClose;
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
     * Return TRUE if $action container have at least 1 element
     *
     * @return bool
     */
    public function hasActions()
    {
        return (bool) count($this->actions);
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


    /**
     * Render an emptyl
     *
     * @param null $remoteId
     * @return mixed
     * @throws \Exception
     */
    static function renderRemoteEmptyModal($remoteId = null)
    {
        $modal = modal();

        if (!is_null($remoteId)) {
            $modal->setRemoteId($remoteId);
        }
        return $modal->getRenderer()->render('modal_remote', $modal);
    }
}