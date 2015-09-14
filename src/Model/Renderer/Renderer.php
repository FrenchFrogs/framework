<?php namespace FrenchFrogs\Model\Renderer;


/**
 * Class model used to render the element
 *
 * Use polymorphisme with Trait \FrenchFrogs\Core\Renderer
 *
 * Class Renderer
 * @package FrenchFrogs\Model\Renderer
 */
class Renderer {

    /**
     * Container
     *
     * @var array container
     */
    protected $renderers = [];


    /**
     * Constructor
     *
     * @param ...$params
     */
    public function __construct(...$params)
    {
        // if method "init" exist, we call it.
        if (method_exists($this, 'init')) {
            call_user_func_array([$this, 'init'], $params);
        }
    }


    /**
     *  Set all renderer as an array
     *
     * @param array $renderers
     * @return $this
     */
    public function setRenderers(array $renderers)
    {
        $this->renderers = $renderers;
        return $this;
    }

    /**
     * Add a single renderer to the renderers container
     *
     * @param $index
     * @param $method
     * @return $this
     */
    public function addRenderer($index, $method)
    {
        $this->renderers[$index] = $method;
        return $this;
    }

    /**
     * Remove a single renderer from the renderers container
     *
     * @param $index
     * @return $this
     */
    public function removeRenderer($index)
    {

        if ($this->hasRenderer($index)) {
            unset($this->renderers[$index]);
        }

        return $this;
    }

    /**
     * Clear all renderers from the renderers container
     *
     * @return $this
     */
    public function clearRenderer()
    {
        $this->renderers = [];

        return $this;
    }

    /**
     * Check if the renderer $index exist in the renderer container
     *
     * @param $index
     * @return bool
     */
    public function hasRenderer($index)
    {
        return isset($this->renderers[$index]);
    }

    /**
     *  Return the renderer $index from the filters renderer container
     *
     * @return mixed Callable | string
     */
    public function getRenderer($index)
    {
        if (!$this->hasRenderer($index)) {
            throw new \Exception('Renderer not found : ' . $index);
        }

        return $this->renderers[$index];
    }


    /**
     * Return array of all renderers
     *
     * @return array
     */
    public function getRenderers()
    {
        return $this->renderers;
    }


    /**
     * Render element
     *
     * @param ...$params
     * @return mixed
     */
    public function render($index , ...$params)
    {

        $renderer = $this->getRenderer($index);

        // If it's a anonymous function
        if (is_callable($renderer)) {
            $render = call_user_func_array($renderer, $params);

            // if it's a local method
        } else {

            if (!method_exists($this, $renderer)) {
                throw new \Exception('Impossible de trouver la method pour le rendu : ' . $renderer);
            }

            $render =  call_user_func_array([$this, $renderer], $params);
        }

        return $render;
    }
}