<?php namespace FrenchFrogs\Core;

/**
 *
 * Trait for filterer polymorphisme
 *
 * Class Filterer
 * @package FrenchFrogs\Core
 */
trait Filterer
{

    /**
     * container
     *
     * @var \FrenchFrogs\Filterer\Filterer
     */
    protected $filterer;


    /**
     * Getter
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
     * Return true if a filtrerer is set
     *
     * @return bool
     */
    public function hasFilterer()
    {
        return isset($this->filterer);
    }


    /**
     * Shortcut to the main function of the model
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