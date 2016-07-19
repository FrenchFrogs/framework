<?php namespace FrenchFrogs\Table\Column;

use FrenchFrogs\Html\Element;

class Button extends Link
{

    use Element\Button;

    /**
     * Constructor
     *
     * @param $name
     * @param string $label
     * @param string $link
     * @param array $binds
     * @param array $attr
     */
    public function __construct($name, $label = '%s', $link = '#', $binds = [], $attr = [] )
    {
        parent::__construct($name, $label, $link, $binds, $attr );
        $this->setSizeAsExtraSmall();
    }

    /**
     * Return the binded Label
     *
     * @param array $row
     * @return string
     */
    public function getBindedLabel($row = [])
    {
        $bind = isset($row[$this->getName()]) ? $row[$this->getName()] : false;
        return sprintf($this->getLabel(), $bind);
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
            // on force l'affichage du label si pas d'icon
            if (!$this->hasIcon()) {
                $this->disableIconOnly();
            }

            if ($this->isVisible($row)) {
                $render = $this->getRenderer()->render('button', $this, $row);
            }
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}