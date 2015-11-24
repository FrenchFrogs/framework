<?php namespace FrenchFrogs\Form\Form;


trait Remote
{

    protected $is_remote = false;

    protected $is_callback = false;

    /**
     * Set is_callback to TRUE
     *
     * @return $this
     */
    public function enableCallback() {
        $this->disableRemote();
        $this->is_callback = true;
        return $this;
    }

    /**
     * Set is_callback nto FALSE
     *
     * @return $this
     */
    public function disableCallback()
    {
        $this->is_callback = false;
        return $this;
    }

    /**
     * Return TRUE if is_callback is true
     *
     * @return bool
     */
    public function isCallback()
    {
        return (bool) $this->is_callback;
    }


    /**
     * Set $is_remote attribute to TRUE
     *
     * @return $this
     */
    public function enableRemote()
    {
        $this->disableCallback();
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