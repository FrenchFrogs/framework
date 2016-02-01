<?php namespace FrenchFrogs\Form\Form;

use FrenchFrogs;
use InvalidArgumentException;


trait Element
{

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
     * Add a single element to the elements container
     *
     * @param \FrenchFrogs\Form\Element\Element $element
     * @return $this
     */
    public function addElement(\FrenchFrogs\Form\Element\Element $element, FrenchFrogs\Renderer\Renderer $renderer = null)
    {
        // Join element to the form
        $element->setForm($this);

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
     * @return \FrenchFrogs\Form\Element\Element
     */
    public function getElement($name)
    {

        if (!isset($this->elements[$name])) {
            throw new InvalidArgumentException(" Element not found : {$name}");
        }

        return $this->elements[$name];
    }

    /**
     * Return TRUE is an element $name is set in $elements container
     *
     * @param $name
     * @return bool
     */
    public function hasElement($name)
    {
        return isset($this->elements[$name]);
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
     * @param \FrenchFrogs\Form\Element\Element $element
     * @return $this
     */
    public function addAction(\FrenchFrogs\Form\Element\Element $element)
    {
        $element->setForm($this);
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
     * Return TRU is $action container has at leas one element
     *
     * @return bool
     */
    public function hasActions()
    {
        return count($this->actions) > 0;
    }

    /**
     * Return the $name element from the actions container
     *
     * @param $name
     * @throws InvalidArgumentException
     * @return \FrenchFrogs\Form\Element\Element
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
     * Add a input:text element
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Text
     */
    public function addText($name, $label = '', $is_mandatory = true)
    {
        $e = new \FrenchFrogs\Form\Element\Text($name, $label);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

        return $e;
    }


    /**
     * Add a input:text with datepicker element
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Text
     */
    public function addDate($name, $label = '', $is_mandatory = true)
    {
        $e = new \FrenchFrogs\Form\Element\Date($name, $label);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

        return $e;
    }

    /**
     *
     *  Add a input:text with timepicker element
     *
     * @param $name
     * @param string $label
     * @param bool $is_mandatory
     * @return \FrenchFrogs\Form\Element\Date
     */
    public function addTime($name, $label = '', $is_mandatory = true)
    {
        $e = new \FrenchFrogs\Form\Element\Time($name, $label);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

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
    public function addPassword($name, $label = '',  $is_mandatory = true )
    {
        $e = new \FrenchFrogs\Form\Element\Password($name, $label);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

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
    public function addTextarea($name, $label = '', $is_mandatory = true )
    {
        $e = new \FrenchFrogs\Form\Element\Textarea($name, $label);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

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
        $e = new \FrenchFrogs\Form\Element\Submit($name, $attr);
        $e->setValue($name);
        $e->setOptionAsPrimary();
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
        $e = new \FrenchFrogs\Form\Element\Checkbox($name, $label, $multi, $attr);
        $this->addElement($e);
        return $e;
    }


    public function addBoolean($name, $label = '', $attr = [] )
    {
        $e = new \FrenchFrogs\Form\Element\Boolean($name, $label, $attr);
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
    public function addTel($name, $label = '', $is_mandatory = true)
    {
        $e = new \FrenchFrogs\Form\Element\Tel($name, $label);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

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
    public function addEmail($name, $label = '',$is_mandatory = true )
    {
        $e = new \FrenchFrogs\Form\Element\Email($name, $label);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

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
        $e = new \FrenchFrogs\Form\Element\Hidden($name, $attr);
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
    public function addSelectRemote($name, $label = '', $url = '#', $length = 1, $is_mandatory = true)
    {
        $e = new \FrenchFrogs\Form\Element\SelectRemote($name, $label, $url, $length);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

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
        $e = new \FrenchFrogs\Form\Element\Label($name, $label, $attr);
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
    public function addPre($name, $label = '', $attr = [] )
    {
        $e = new \FrenchFrogs\Form\Element\Pre($name, $label, $attr);
        $this->addElement($e);
        return $e;
    }

    /**
     * Add Link element (read-only element)
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Label
     */
    public function addLink($name, $label = '', $attr = [] )
    {
        $e = new \FrenchFrogs\Form\Element\Link($name, $label, $attr);
        $this->addElement($e);
        return $e;
    }

    /**
     * Add Image element (read-only element)
     *
     * @param $name
     * @param string $label
     * @param array $attr
     * @return \FrenchFrogs\Form\Element\Label
     */
    public function addImage($name, $label = '', $width = null, $height = null )
    {
        $e = new \FrenchFrogs\Form\Element\Image($name, $label, $width, $height);
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
        $e = new \FrenchFrogs\Form\Element\Button($name, $label, $attr);
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
        $e = new \FrenchFrogs\Form\Element\Separator();
        $e->setName('separator-' . rand(1111, 9999));
        $e->enableDiscreet();
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
        $e = new \FrenchFrogs\Form\Element\Title($name, $attr);
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
    public function addContent($label, $value = '', $fullwidth = true)
    {
        $e = new \FrenchFrogs\Form\Element\Content($label, $value, $fullwidth);
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
    public function addNumber($name, $label = '', $is_mandatory = true)
    {
        $e = new \FrenchFrogs\Form\Element\Number($name, $label);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

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
    public function addRadio($name, $label = '', $multi  = [], $is_mandatory = true )
    {
        $e = new \FrenchFrogs\Form\Element\Radio($name, $label, $multi);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

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
    public function addSelect($name, $label, $multi = [],  $is_mandatory = true)
    {
        $e = new \FrenchFrogs\Form\Element\Select($name, $label, $multi);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

        return $e;
    }

    /**
     * Add list element
     *
     * @param $name
     * @param $label
     * @param array $options
     * @param bool|true $is_mandatory
     * @return FrenchFrogs\Form\Element\DataList
     */
    public function addDataList($name, $label, $options = [],  $is_mandatory = true)
    {
        $e = new \FrenchFrogs\Form\Element\DataList($name, $label, $options);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

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
    public function addFile($name, $label = '', $is_mandatory = true)
    {
        $e = new \FrenchFrogs\Form\Element\File($name, $label);
        $this->addElement($e);

        if ($is_mandatory) {
            $e->addRule('required');
        } else {
            $e->addFilter('nullable');
        }

        return $e;
    }




}