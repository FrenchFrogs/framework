<?php namespace FrenchFrogs\Core;


trait Filterer
{

    /**
     * container
     *
     * @var \FrenchFrogs\Filterer\Filterer
     */
    protected $filterer;


    /**
     * getter
     *
     * @return \FrenchFrogs\Filterer\Filterer
     */
    public function getFilterer()
    {
        return $this->filterer;
    }


    /**
     * Setter
     *
     * @param \FrenchFrogs\Filterer\Filterer $filterer
     * @return $this
     */
    public function setFilterer(\FrenchFrogs\Filterer\Filterer $filterer)
    {

        $this->filterer = $filterer;
        return $this;
    }

    /**
     * Renvoie tru si un validator est setté
     *
     * @return bool
     */
    public function hasFilterer()
    {
        return isset($this->filterer);
    }


    /**
     * Validation de l'element
     *
     * @param $value
     * @return $this
     * @throws \Exception
     */
    public function filter($value)
    {
        $this->getFilterer()->filter($value);
        return $this;
    }
}