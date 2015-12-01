<?php namespace FrenchFrogs\Form\Element;


class Content extends Element
{


    protected $is_full_width = true;


    /**
     * Set $is_full_width to true
     *
     * @return $this
     */
    public function enableFullWidth()
    {
        $this->is_full_width = true;
        return $this;
    }

    /**
     * Set $is_full_width to false
     *
     * @return $this
     */
    public function disableFullWidth()
    {
        $this->is_full_width = false;
        return $this;
    }

    /**
     * getter for $is_full_width
     *
     * @return bool
     */
    public function isFullWith()
    {
        return $this->is_full_width;
    }

    /**
     * Constructror
     *
     * @param $label
     * @param array $attr
     */
    public function __construct($label, $value = '', $fullwidth = true)
    {
        $this->setLabel($label);
        $this->setName($label);
        $this->setValue($value);

        if ($fullwidth) {
            $this->enableFullWidth();
        } else {
            $this->disableFullWidth();
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $render = '';
        try {

            $render = $this->getRenderer()->render('content', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}