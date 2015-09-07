<?php namespace FrenchFrogs\Renderer;


/**
 * Trait de gestion pour les decorators
 *
 * Class Renderer
 * @package FrenchFrogs\Renderer
 */
class Renderer {

    /**
     * @var array container
     */
    protected $renderer = [];


    /**
     * Constructeur
     *
     * @param ...$params
     */
    public function __construct(...$params)
    {
        // s'il y a  une methode pour enregistrer des
        if (method_exists($this, 'init')) {
            call_user_func_array([$this, 'init'], $params);
        }
    }



    /**
     * Set des rendu
     *
     * @param array $renderer
     * @return $this
     */
    public function setRenderer(array $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * Ajoute un Rendu
     *
     * @param $index
     * @param $method
     * @return $this
     */
    public function addRenderer($index, $method)
    {
        $this->renderer[$index] = $method;
        return $this;
    }

    /**
     * Suppression d'un Rendu
     *
     * @param $index
     * @return $this
     */
    public function removeRenderer($index)
    {

        if ($this->hasRenderer($index)) {
            unset($this->renderer[$index]);
        }

        return $this;
    }

    /**
     * Efface toute les Rendu
     *
     * @return $this
     */
    public function clearRenderer()
    {
        $this->renderer = [];

        return $this;
    }

    /**
     * Renvoie true si le Rendu existe
     *
     * @param $index
     * @return bool
     */
    public function hasRenderer($index)
    {
        return isset($this->renderer[$index]);
    }

    /**
     * Renvoie la valeur du Rendu
     *
     * @return mixed Callable | string
     */
    public function getRenderer($index)
    {
        if (!$this->hasRenderer($index)) {
            throw new \Exception('Impossible de trouver le rendu : ' . $index);
        }

        return $this->renderer[$index];
    }


    /**
     * Renvoie la liste des Rendu
     *
     * @return array
     */
    public function getAllRenderer()
    {
        return $this->renderer;
    }


    /**
     * Effectue le rendu
     *
     * @param ...$params
     * @return mixed
     */
    public function render($index , ...$params)
    {
        $renderer = $this->getRenderer($index);

        // si le rendu est une function anonyme
        if (is_callable($renderer)) {
            $render = call_user_func_array($renderer, $params);

        // si c'est une methode local
        } else {

            if (!method_exists($this, $renderer)) {
                throw new \Exception('Impossible de trouver la method pour le rendu : ' . $renderer);
            }

            $render =  call_user_func_array([$this, $renderer], $params);
        }

        return $render;
    }
}