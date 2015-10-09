<?php namespace FrenchFrogs\Polliwog\Form\Form;


trait Remote
{

    protected $is_remote = false;


    /**
     * Set $is_remote attribute to TRUE
     *
     * @return $this
     */
    public function enableRemote()
    {
        $this->is_remote = true;
        return $this;
    }

    /**
     * Set $is_remote attribute to FALSE
     *
     * @return $this
     */
    public function disableRemote()
    {
        $this->is_remote = false;
        return $this;
    }

    /**
     * Getter for $is_remote attribute
     *
     * @return bool
     */
    public function isRemote()
    {
        return $this->is_remote;
    }
}