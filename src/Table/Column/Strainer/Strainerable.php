<?php namespace FrenchFrogs\Table\Column\Strainer;


trait Strainerable
{

    /**
     * Contain strainer for a column
     *
     * @var Strainer
     */
    protected $strainer;


    /**
     *  Return the strainer for the column
     *
     * @return Strainer
     */
    public function getStrainer()
    {
        return $this->strainer;
    }

    /**
     * Setter for $strainer attribute
     *
     * @param Strainer $strainer
     * @return $this
     */
    public function setStrainer(Strainer $strainer)
    {
        $this->strainer = $strainer;
        return $this;
    }

    /**
     * Return TRUE if a sgtrainer is set
     *
     * @return bool
     */
    public function hasStrainer()
    {
        return isset($this->strainer);
    }


    /**
     * Unset $strainer attribute
     *
     * @return $this
     */
    public function removeStrainer()
    {
        unset($this->strainer);
        return $this;
    }


    /**
     * Set Strainer as a select form element
     *
     * @param array $options
     * @param array $attr
     * @return \FrenchFrogs\Table\Column\Strainer\Strainerable
     */
    public function setStrainerSelect($options = [], $callable = null, $attr = [])
    {

        // if callable is a string , it's a field
        if (is_string($callable)) {
            $field = $callable;
            $callable = null;
        }

        // create the strainer
        $strainer = new Select($this, $options, $callable, $attr);


        //if a fields is set, we configure the strainer
        if (isset($field)) {
            $strainer->setField($field);
        }

        return $this->setStrainer($strainer);
    }


    public function setStrainerText($callable = null, $attr = [])
    {
        // if callable is a string , it's a field
        if (is_string($callable)) {
            $field = $callable;
            $callable = null;
        }

        // create the strainer
        $strainer = new Text($this, $callable, $attr);
        
        //if a fields is set, we configure the strainer
        if (isset($field)) {
            $strainer->setField($field);
        }

        return $this->setStrainer($strainer);
    }


    /**
     * Set strainer as a Boolean
     *
     * @param null $callable
     * @param array $attr
     * @return Strainerable
     */
    public function setStrainerBoolean($callable = null, $attr = [])
    {
        // if callable is a string , it's a field
        if (is_string($callable)) {
            $field = $callable;
            $callable = null;
        }

        // create the strainer
        $strainer = new Boolean($this, $callable, $attr);

        //if a fields is set, we configure the strainer
        if (isset($field)) {
            $strainer->setField($field);
        }

        return $this->setStrainer($strainer);
    }


    /**
     * Set a strainer as date from to
     *
     * @param null $callable
     * @param array $attr
     * @return $this
     */
    public function setStrainerDateRange($callable = null, $attr = [])
    {

        // if callable is a string , it's a field
        if (is_string($callable)) {
            $field = $callable;
            $callable = null;
        }

        // create the strainer
        $strainer = new DateRange($this, $callable, $attr);

        //if a fields is set, we configure the strainer
        if (isset($field)) {
            $strainer->setField($field);
        }

        return $this->setStrainer($strainer);
    }

}