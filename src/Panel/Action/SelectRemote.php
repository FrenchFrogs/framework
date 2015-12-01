<?php namespace FrenchFrogs\Panel\Action;

use FrenchFrogs\Core;
use FrenchFrogs\Html\Element;
use FrenchFrogs\Form\Element\SelectRemote as FormSelectRemote;

class SelectRemote extends Action
{
    use Core\Remote;
    use Element\Button;

    /**
     * @var FormSelectRemote
     */
    protected $element;

    /**
     * Url action
     *
     * @var
     */
    protected $url;


    /**
     * Setter for $element
     *
     * @param \FrenchFrogs\Form\Element\SelectRemote $element
     * @return $this
     */
    public function setElement(FormSelectRemote $element)
    {
        $this->element = $element;
        return $this;
    }

    /**
     * Getter for $element
     *
     * @return \FrenchFrogs\Form\Element\SelectRemote
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Setter for $url
     *
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * getter for $url
     *
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Constructror
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $placeholder,  $data_url, $action_url,  $length = 3 )
    {
        $element = new FormSelectRemote($name, $placeholder, $data_url, $length);
        $this->setElement($element);
        $this->setUrl($action_url);
    }


    /**
     * @return string
     */
    public function render()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('selectremote', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }


}