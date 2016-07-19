<?php namespace FrenchFrogs\Table\Column;

use FrenchFrogs\Core;

class Media extends Link
{


    /**
     * Media width
     *
     * @var int
     */
    protected $media_width = 320;


    /**
     * Media height
     *
     * @var int
     */
    protected  $media_height = 180;


    /**
     * SETTER for $media_with
     *
     * @param $width
     */
    public function setMediaWidth($width)
    {
        $this->media_width = $width;
        return $this;
    }

    /**
     * GETTER for $media_with
     *
     * @return int
     */
    public function getMediaWidth()
    {
        return $this->media_width;
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
     * SETTER for $media_height
     *
     * @param $width
     */
    public function setMediaHeight($height)
    {
        $this->media_height = $height;
        return $this;
    }

    /**
     * GETTER for $media_height
     *
     * @return int
     */
    public function getMediaHeight()
    {
        return $this->media_height;
    }


    /**
     * Constructor
     *
     * @param $name
     * @param string $label
     * @param string $link
     * @param array $binds
     * @param array $attr
     */
    public function __construct($name, $label, $link = '#', $binds = [], $width = 320, $height = 180 )
    {
        $this->setLabel($label);
        $this->setMediaHeight($height);
        $this->setMediaWidth($width);
        $this->setName($name);
        $this->setLink($link);
        $this ->setWidth($width);
        $this->setBinds((array) $binds);
        $this->center();
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
            $render = $this->getRenderer()->render('media', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}