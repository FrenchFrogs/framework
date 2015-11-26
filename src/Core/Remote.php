<?php namespace FrenchFrogs\Core;


trait Remote
{

    /**
     * Define if a link will load in a modal
     *
     * @var bool
     */
    protected $is_remote = false;


    /**
     * Define if a link will load a js script
     *
     * @var bool
     */
    protected $is_callback = false;

    /**
     * id html attribute for remote modal
     *
     * @var
     */
    protected $remoteId;


    /**
     * Set $is_callback attribute to TRUE
     *
     * @return $this
     */
    public function enableCallback($method = null)
    {
        $this->is_callback = true;
        $this->disableRemote();// disable remte, we can have both

        if (!is_null($method) && method_exists($this, 'addAttribute')) {
            $this->addAttribute('data-method', $method);
        }

        return $this;
    }

    /**
     * Set $is_callback attribute to FALSE
     *
     * @return $this
     */
    public function disableCallback()
    {
        $this->is_callback = false;
        return $this;
    }

    /**
     * Return TRUE id $is_callback attribute is true
     *
     * @return bool
     */
    public function isCallback()
    {
        return $this->is_callback;
    }


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
     * Setter for $is_remoter attribute
     *
     * @return $this
     */
    public function enableRemote($method = null)
    {
        $this->is_remote = true;
        $this->disableCallback();// disable callback, we cannot have both

        if (!is_null($method) && method_exists($this, 'addAttribute')) {
            $this->addAttribute('data-method', $method);
        }

        return $this;
    }

    /**
     * Setter for $is_remoter attribute
     *
     * @return $this
     */
    public function disableRemote()
    {
        $this->is_remote = false;
        return $this;
    }

    /**
     * Return TRUE if $is_remote attribute is true
     *
     * @return bool
     */
    public function isRemote()
    {
        return $this->is_remote;
    }

    /**
     * Set $is_remote attribute as TRUE
     *
     * @return $this
     */
    public function remote()
    {
        $this->enableRemote();
        return $this;
    }

}