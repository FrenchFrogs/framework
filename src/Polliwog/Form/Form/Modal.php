<?php namespace FrenchFrogs\Polliwog\Form\Form;


trait Modal
{
    /**
     * True id render is a modal
     *
     * @var
     */
    protected $is_modal;

    /**
     * Set $is_modal to TRUE
     *
     * @return $this
     */
    public function enableModal()
    {
        $this->is_modal = true;
        return $this;
    }

    /**
     * Set $is_modal to FALSE
     *
     * @return $this
     */
    public function disableModal()
    {
        $this->is_modal = false;
        return $this;
    }

    /**
     * Return TRUE if $is_modal is TRUE
     *
     * @return mixed
     */
    public function isModal()
    {
        return $this->is_modal;
    }

}