<?php namespace FrenchFrogs\Table\Column;


class Icon extends Text
{

    protected $mapping = [];


    /**
     * Setter for $mapping
     *
     * @param array $mapping
     * @return $this
     */
    public function setMapping(array $mapping)
    {
        $this->mapping = $mapping;
        return $this;
    }

    /**
     * Getter for $mapping
     *
     * @return array
     */
    public function getMapping()
    {
        return $this->mapping;
    }


    /**
     * Constructror
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $mapping = [] )
    {
        parent::__construct($name, $label);
        $this->setMapping($mapping);
        $this->center();
    }


    /**
     * @param $row
     * @return string
     */
    public function getValue($row)
    {
        $value = parent::getValue($row);
        return empty($this->mapping[$value]) ? '' : $this->mapping[$value];
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
            $render = $this->getRenderer()->render('icon', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }

}