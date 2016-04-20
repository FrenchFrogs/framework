<?php namespace FrenchFrogs\Table\Column;


class Text extends Column
{

    protected $tooltip = false;
    protected $tooltip_position = "bottom";

    /**
     * Constructror
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $attr = [] )
    {
        $this->setAttributes($attr);
        $this->setName($name);
        $this->setLabel($label);
    }

    /**
     *
     *
     * @param $row
     * @return mixed|string
     * @throws \Exception
     */
    public function getValue($row) {

        $value = isset($row[$this->getName()]) ? $row[$this->getName()] : '';
        if ($this->hasFilterer()) {
            $value = $this->getFilterer()->filter($value);
        }
        return $value;
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
                $render = $this->getRenderer()->render('text', $this, $row);
            }
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }

    /**
     * Add tooltip on the column
     *
     * @param $position
     */
    public function tooltip($position = "bottom")
    {
        $this->tooltip = true;
        $this->tooltip_position = $position;
    }

    /**
     * Check if column has tooltip
     *
     * @return bool
     */
    public function hasTooltip()
    {
        return $this->tooltip;
    }

    /**
     * Get the tooltip position
     *
     * @return string
     */
    public function getTooltipPosition()
    {
        return $this->tooltip_position;
    }
}