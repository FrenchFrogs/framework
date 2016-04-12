<?php namespace FrenchFrogs\Table\Column;

/**
 * Boolean column with remote process
 *
 * Class BooleanSwitch
 * @package FrenchFrogs\Table\Column
 */
class RemoteBoolean extends Boolean
{

    use RemoteProcess;

    /**
     * Overload the constdcteur
     *
     * BooleanSwitch constructor.
     * @param $name
     * @param string $label
     * @param null $function
     */
    public function __construct($name, $label = '', $function = null )
    {
        parent::__construct($name, $label);
        $this->center();

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
            $render = $this->getRenderer()->render('remote_boolean', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}