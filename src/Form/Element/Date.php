<?php namespace FrenchFrogs\Form\Element;


class Date extends Text
{

    protected $formatDisplay;

    protected $formatStore;


    public function setFormatDisplay($format)
    {
        $this->formatDisplay = $format;
        return $this;
    }

    public function getFormatDisplay()
    {
        return  $this->formatDisplay;
    }

    public function setFormatStore($format)
    {
        $this->formatStore = $format;
        return $this;
    }

    public function getFormatStore()
    {
        return $this->formatStore;
    }


    /**
     * Constructor
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $formatDisplay = null, $formatStore = null, $attr = [])
    {
        $this->setAttributes($attr);
        $this->setName($name);
        $this->setLabel($label);

        $this->addAttribute('data-date-format', configurator()->get('form.element.date.formatjs'));

        $this->setFormatDisplay(is_null($formatDisplay) ? configurator()->get('form.element.date.formatDisplay') : $formatDisplay);
        $this->setFormatStore(is_null($formatStore) ? configurator()->get('form.element.date.formatStore') : $formatStore);

        $this->addFilter('dateFormat', 'dateFormat', $this->getFormatDisplay());
    }

    /**
     * Overload set value
     *
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        if (!empty($value)) {
            try {
                $date = substr($value, 0, strlen(date($this->getFormatDisplay())));
                $value = \Carbon\Carbon::createFromFormat($this->getFormatDisplay(), $date);
            } catch (\InvalidArgumentException $e) {

                try {
                    $date = substr($value, 0, strlen(date($this->getFormatStore())));
                    $value = \Carbon\Carbon::createFromFormat($this->getFormatStore(), $date);
                } catch (\InvalidArgumentException $e) {
                    throw $e;
                }

            } finally {
                $value = $value instanceof \Carbon\Carbon ? $value->format($this->getFormatStore()) : '';
            }
        }

        return parent::setValue($value);
    }


    /**
     * Overload getvalue
     *
     * @return mixed|string|static
     */
    public function getDisplayValue()
    {

        $value = parent::getValue();

        if (!empty($value)) {
            try {
                $date = substr($value, 0, strlen(date($this->getFormatStore())));
                $value = \Carbon\Carbon::createFromFormat($this->getFormatStore(), $date);
            } catch (\InvalidArgumentException $e) {
                throw $e;
            } finally {
                $value = $value instanceof \Carbon\Carbon ? $value->format($this->getFormatDisplay()) : '';
            }
        }

        return $value;
    }


    /**
     * overload
     *
     * @return mixed|string|static
     */
    public function getFilteredValue()
    {

        $value = parent::getFilteredValue();
        if (!empty($value)) {
            try {
                $date = substr($value, 0, strlen(date($this->getFormatDisplay())));
                $value = \Carbon\Carbon::createFromFormat($this->getFormatDisplay(), $date);
            } catch (\InvalidArgumentException $e) {

                try {
                    $date = substr($value, 0, strlen(date($this->getFormatStore())));
                    $value = \Carbon\Carbon::createFromFormat($this->getFormatStore(), $date);
                } catch (\InvalidArgumentException $e) {
                    throw $e;
                }

            } finally {
                $value = $value instanceof \Carbon\Carbon ? $value->format($this->getFormatStore()) : '';
            }
        }

       return $value;
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