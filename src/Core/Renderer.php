<?php namespace FrenchFrogs\Core;


/**
 * Trait for render polymorphisme
 *
 * Class Renderer
 * @package FrenchFrogs\Core
 */
trait Renderer
{

    /**
     * Renderer container
     *
     * @var \FrenchFrogs\Model\Renderer\Renderer
     */
    protected $renderer;


    /**
     * Getter
     *
     * @return \FrenchFrogs\Model\Renderer\Renderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }


    /**
     * Setter
     *
     * @param \FrenchFrogs\Model\Renderer\Renderer $renderer
     * @return $this
     */
    public function setRenderer(\FrenchFrogs\Model\Renderer\Renderer $renderer)
    {

        $this->renderer = $renderer;
        return $this;
    }

    /**
     * Return TRUE if a renderer is set
     *
     * @return bool
     *
     */
    public function hasRenderer()
    {
        return isset($this->renderer);
    }

    /**
     *
     * Shortcut to the main function of the model
     *
     * @return string
     */
    public function render()
    {
        return strval($this);
    }
}