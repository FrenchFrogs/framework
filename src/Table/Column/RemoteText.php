<?php namespace FrenchFrogs\Table\Column;

/**
 * Boolean column with remote process
 *
 * Class BooleanSwitch
 * @package FrenchFrogs\Table\Column
 */
class RemoteText extends Text
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

        if (!is_null($function)) {
            $this->setRemoteProcess($function);
        }
    }

    /**
     * Overload for empty value management
     *
     * @param $row
     * @return mixed|string
     */
    public function getValue($row)
    {
        $value = parent::getValue($row);
        return  empty($value)  ? '---'  : $value;
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
            $render = $this->getRenderer()->render('remote_text', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}