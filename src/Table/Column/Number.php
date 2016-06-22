<?php namespace FrenchFrogs\Table\Column;


class Number extends Text
{
    /**
     * Constructror
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $decimal = 2)
    {
        $this->setName($name);
        $this->setLabel($label);
        $this->addFilter('nullable');
        $this->addFilter('numfr', null, $decimal);
        $this->right();
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
                $render = $this->getRenderer()->render('number', $this, $row);
            }
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}