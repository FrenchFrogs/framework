<?php namespace FrenchFrogs\Table\Column;


class Text extends Column
{



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
            $render = $this->getRenderer()->render('text', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}