<?php namespace FrenchFrogs\Core;


trait Renderer
{

    /**
     * container
     *
     * @var \FrenchFrogs\Renderer\Renderer
     */
    protected $renderer;


    /**
     * getter
     *
     * @return \FrenchFrogs\Renderer\Renderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }


    /**
     * Setter
     *
     * @param \FrenchFrogs\Renderer\Renderer $renderer
     * @return $this
     */
    public function setRenderer(\FrenchFrogs\Renderer\Renderer $renderer)
    {

        $this->renderer = $renderer;
        return $this;
    }

    /**
     * Renvoie true si un renderer est setté
     *
     * @return bool
     *
     */
    public function hasRenderer()
    {
        return isset($this->renderer);
    }

    /**
     * Rendu
     *
     * @return string
     */
    public function render()
    {
        return strval($this);
    }
}