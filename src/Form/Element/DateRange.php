<?php namespace FrenchFrogs\Form\Element;


class DateRange extends Date
{
    /**
     * name for FROM input element
     *
     * @var string
     */
    protected $from;

    /**
     * name for TO input element
     *
     * @var string
     */
    protected $to;

    /**
     * Getter for $from
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Setter for $from
     *
     * @param $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Getter for $to
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Setter for $to
     *
     * @param $to
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Constructor
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $from = null, $to = null, $formatDisplay = null, $formatStore = null, $attr = [])
    {
        parent::__construct($name, $label, $formatDisplay, $formatStore, $attr);

        $this->setTo(is_null($to) ? $name . '_to' : $to);
        $this->setFrom(is_null($from) ? $name . '_from' : $from);
    }

    /**
     * @return string
     */
    public function __toString()
    {

        $render = '';
        try {
            $render = $this->getRenderer()->render('date_range', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}