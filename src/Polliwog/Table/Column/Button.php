<?php namespace FrenchFrogs\Polliwog\Table\Column;


class Button extends Link
{

    /**
     * Class of the button
     *
     * @see http://getbootstrap.com/css/#buttons-options
     *
     * @var String
     */
    protected $option;


    /**
     * Class for the button's size
     *
     * @see http://getbootstrap.com/css/#buttons-sizes
     *
     * @var
     */
    protected $size;


    /**
     * Icon class
     *
     * @var string
     */
    protected $icon;

    /**
     * Is TRUE render only icon
     *
     * @var bool
     */
    protected $is_icon_only = true;

    /**
     * Is true if the link render in a model
     *
     * @var bool
     */
    protected $is_remoteModal = true;


    public function setRemoteModal($remoteModal = true)
    {
        $this->is_remoteModal = (bool) $remoteModal;
        return $this;
    }




    /**
     * Fast setting for icon
     *
     * @param $icon
     * @param bool|true $is_icon_only
     * @return $this
     */
    public function icon($icon, $is_icon_only = true)
    {
        $this->setIcon($icon);
        $this->setIconOnly($is_icon_only);
        return $this;
    }

    /**
     * Setter for $icon attribute
     *
     * @param $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Getter for $icon attribute
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * return TRUE if an $icon is set
     *
     * @return bool
     */
    public function hasIcon()
    {
        return isset($this->icon);
    }

    /**
     * Remove $icon attribute
     *
     * @return $this
     */
    public function removeIcon()
    {
        unset($this->icon);
        return $this;
    }

    /**
     * Set if label is rendered with icon only
     *
     * @param bool|true $only
     * @return $this
     */
    public function setIconOnly($only = true)
    {
        $this->is_icon_only = (bool) $only;
        return $this;
    }

    /**
     * Return TRUE  if label is rendered with icon only
     *
     * @return bool
     */
    public function isIconOnly()
    {
        return (bool) $this->is_icon_only;
    }



    /**
     * Setter for $option attribute
     *
     * @param $option
     * @return $this
     */
    public function setOption($option)
    {
        $this->option = $option;
        return $this;
    }

    /**
     * Getter for $options attribute
     *
     * @return String
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Return TRUE if $option is set
     *
     * @return bool
     */
    public function hasOption()
    {
        return isset($this->option);
    }


    /**
     * Unset $option attribute
     *
     * @return $this
     */
    public function removeOption()
    {
        unset($this->option);
        return $this;

    }


    /**
     * Set Option with OPTION_CLASS_DEFAULT
     *
     * @return $this
     */
    public function setOptionAsDefault()
    {
        $this->setOption('BUTTON_OPTION_CLASS_DEFAULT');
        return $this;
    }


    /**
     * set $option with OPTION_CLASS_PRIMARY
     *
     * @return $this
     */
    public function setOptionAsPrimary()
    {
        $this->setOption('BUTTON_OPTION_CLASS_PRIMARY');
        return $this;
    }

    /**
     * Set $option with OPTION_CLASS_SUCCESS
     *
     * @return $this
     */
    public function setOptionAsSuccess()
    {
        $this->setOption( 'BUTTON_OPTION_CLASS_SUCCESS');
        return $this;
    }

    /**
     * Set $option with OPTION_CLASS_INFO
     *
     * @return $this
     */
    public function setOptionAsInfo()
    {
        $this->setOption('BUTTON_OPTION_CLASS_INFO');
        return $this;
    }


    /**
     * Set $option with OPTION_CLASS_WARNING
     *
     * @return $this
     */
    public function setOptionAsWarning()
    {
        $this->setOption('BUTTON_OPTION_CLASS_WARNING');
        return $this;
    }

    /**
     * Set $option with OPTION_CLASS_DANGER
     *
     * @return $this
     */
    public function setOptionAsDanger()
    {
        $this->setOption('BUTTON_OPTION_CLASS_DANGER');
        return $this;
    }

    /**
     * Set $option with OPTION_CLASS_LINK
     *
     * @return $this
     */
    public function setOptionAsLink()
    {
        $this->setOption('BUTTON_OPTION_CLASS_LINK');
        return $this;
    }

    /**
     * Setter for $size attribute
     *
     * @param $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Getter for $size attribute
     *
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }


    /**
     * Return TRUE if $size is set
     *
     * @return bool
     */
    public function hasSize()
    {
        return isset($this->size);
    }

    /**
     * Unset $size attribute
     *
     * @return $this
     */
    public function removeSize()
    {
        unset($this->size);
        return $this;
    }

    /**
     * Set $size with SIZE_CLASS_LARGE
     *
     * @return $this
     */
    public function setSizeAsLarge()
    {
        $this->setSize('BUTTON_SIZE_CLASS_LARGE');
        return $this;
    }

    /**
     * Set $size with SIZE_CLASS_SMALL
     *
     * @return $this
     */
    public function setSizeAsSmall()
    {
        $this->setSize('BUTTON_SIZE_CLASS_SMALL');
        return $this;
    }


    /**
     * Set $size with SIZE_CLASS_EXTRA_SMALL
     *
     * @return $this
     */
    public function setSizeAsExtraSmall()
    {
        $this->setSize('BUTTON_SIZE_CLASS_EXTRA_SMALL');
        return $this;
    }

    /**
     *
     *
     * @return string
     */
    public function render(array $row)
    {
        $render = '';
        try {
            // on force l'affichage du label si pas d'icon
            if (!$this->hasIcon()) {
                $this->setIconOnly(false);
            }
            $this->addClass($this->getOption())->addClass($this->getSize());
            $render = $this->getRenderer()->render('table.button', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}