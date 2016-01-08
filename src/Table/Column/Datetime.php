<?php namespace FrenchFrogs\Table\Column;


class Datetime extends Text
{
    /**
     * Constructror
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $format = null, $attr = [] )
    {
        parent::__construct($name, $label, $attr);
        $this->center();

        if (is_null($format)) {
            $format = configurator()->get('table.column.datetime.format');
        }

        $this->addFilter('dateFormat', 'dateFormat', $format);
    }
}