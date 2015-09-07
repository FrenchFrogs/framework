<?php namespace FrenchFrogs\Filterer;


class Filterer
{

    /**
     * Regle de filtre
     *
     * @var array
     */
    protected $filterer = [];


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
     * Set des filtres
     *
     * @param array $filterer
     * @return $this
     */
    public function setFilterer(array $filterer)
    {
        $this->filterer = $filterer;
        return $this;
    }

    /**
     * Ajoute un filtres
     *
     * @param $index
     * @param $filterer
     * @return $this
     */
    public function addFilterer($index, $method = null, ...$params)
    {
        $this->filterer[$index] = [$method, $params];
        return $this;
    }

    /**
     * Suppression d'une filtres
     *
     * @param $index
     * @return $this
     */
    public function removeFilterer($index)
    {
        if ($this->hasFilterer($index)) {
            unset($this->filterer[$index]);
        }

        return $this;
    }

    /**
     * Efface toutes les reègles
     *notempty
     * @return $this
     */
    public function clearFilterer()
    {
        $this->filterer = [];

        return $this;
    }

    /**
     * Renvoie true si la règle existe
     *
     * @param $index
     * @return bool
     */
    public function hasFilterer($index)
    {
        return isset($this->filterer[$index]);
    }

    /**
     * Renvoie la valeur de la regle
     *
     * @return mixed Callable | string
     */
    public function getFilterer($index)
    {
        if (!$this->hasFilterer($index)) {
            throw new \Exception('Impossible de trouver le filtre : ' . $index);
        }

        return $this->filterer[$index];
    }


    /**
     * Renvoie la liste des Rendu
     *
     * @return array
     */
    public function getAllFilterer()
    {
        return $this->filterer;
    }


    /**
     * Renvoie la valeur filtré et formater
     *
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public function filter($value)
    {

        foreach($this->getAllFilterer() as $index => $filterer) {

            // recuperation de la methodd et des paramètre
            list($method, $params) = $filterer;

            // on ajoute la valeur aux paramètres
            array_unshift($params, $value);

            // si le rendu est une function anonyme
            if (is_callable($method)) {

                return call_user_func_array($method, $params);

                // si c'est une methode local
            } else {

                if (!method_exists($this, $method)) {
                    throw new \Exception('Impossible de trouver la method '. $method .' pour la validation : ' . $index);
                }

                return call_user_func_array([$this, $method], $params);
            }
        }
    }
}