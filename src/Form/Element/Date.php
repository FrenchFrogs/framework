<?php namespace FrenchFrogs\Form\Element;


class Date extends Text
{

    /**
     * Constructor
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $format = null, $attr = [])
    {
        $this->setAttributes($attr);
        $this->setName($name);
        $this->setLabel($label);

        $this->addAttribute('data-date-format', configurator()->get('form.element.date.formatjs'));

        if (is_null($format)) {
            $format = configurator()->get('form.element.date.format');
        }

        $this->addFilter('dateFormat', 'dateFormat', $format);
    }

    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('date', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}