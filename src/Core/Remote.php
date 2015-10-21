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
     * id html attribute for remote modal
     *
     * @var
     */
    protected $remoteId;


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
    public function enableRemote()
    {
        $this->is_remote = true;
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