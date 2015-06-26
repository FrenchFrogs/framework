<?php namespace FrenchFrogs\Core;


trait Decorator {

    protected $decorator = [];

    /**
     * Set des decorator
     *
     * @param array $decorator
     * @return $this
     */
    public function setDecorator(array $decorator)
    {
        $this->decorator = $decorator;
        return $this;
    }

    /**
     * Ajoute un decorator
     *
     * @param $index
     * @param $method
     * @return $this
     */
    public function addDecorator($index, $method)
    {
        $this->decorator[$index] = $method;
        return $this;
    }

    /**
     * Suppression d'un decorator
     *
     * @param $index
     * @return $this
     */
    public function removeDecorator($index)
    {

        if ($this->hasDecorator($index)) {
            unset($this->decorator[$index]);
        }

        return $this;
    }

    /**
     * Efface toute les decorators
     *
     * @return $this
     */
    public function clearDecorator()
    {
        $this->decorator = [];

        return $this;
    }

    /**
     * Renvoie true si le decorator existe
     *
     * @param $index
     * @return bool
     */
    public function hasDecorator($index)
    {
        return isset($this->decorator[$index]);
    }

    /**
     * Renvoie la valeur du decorator
     *
     * @return mixed Callable | string
     */
    public function getDecorator($index)
    {
        if (!$this->hasDecorator($index)) {
            throw new \Exception('Impossible de trouver le decorator : ' . $index);
        }

        return $this->decorator[$index];
    }


    /**
     * Effectue le rendu
     *
     * @param ...$params
     * @return mixed
     */
    public function decorate($index , ...$params)
    {

        $decorator = $this->getDecorator($index);

        // si le decorator est une function anonyme
        if (is_callable($decorator)) {
            $render = call_user_func_array($decorator, $params);

        // si c'est une methode local
        } else {

            if (!method_exists($this, $decorator)) {
                throw new \Exception('Impossible de trouver la method pour le decorator : ' . $decorator);
            }

            $render =  call_user_func_array([$this, $decorator], $params);
        }

        return $render;
    }
}