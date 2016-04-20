<?php namespace FrenchFrogs\Table\Column;
use FrenchFrogs\Form\Element\Element;

/**
 * Boolean column with remote process
 *
 * Class BooleanSwitch
 * @package FrenchFrogs\Table\Column
 */
class RemoteSelect extends Column
{

    use RemoteProcess;

    /**
     * Valeur pour le select
     *
     *
     * @var array
     */
    protected $options = [];


    protected $index;

    /**
     * GEtter for $index
     *
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Setter $index
     *
     * @param $index
     * @return mixed
     *
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $index;
    }

    /**
     * Overload the constcteur
     *
     * BooleanSwitch constructor.
     * @param $name
     * @param string $label
     * @param null $function
     */
    public function __construct($name, $label = '', $index = null,  $options = [], $function = null )
    {
        $this->setName($name);
        $this->setLabel($label);
        $this->setOptions($options);

        if (!is_null($index)) {
            $this->setIndex($index);
        }

        if (!is_null($function)) {
            $this->setRemoteProcess($function);
        }
    }

    /**
     *
     *
     * @return string
     */
    public function render(array $row)
    {
        $render = '';
        try {
            if ($this->isVisible($row)) {
                $render = $this->getRenderer()->render('remote_select', $this, $row);
            }
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }


    /**
     * Setter pour les options
     *
     * @param $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Getter pour les options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

}