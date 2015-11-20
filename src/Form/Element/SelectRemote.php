<?php namespace FrenchFrogs\Form\Element;


class SelectRemote extends Text
{

    /**
     * Length tptrigger search
     *
     * @var int
     */
    protected $length = 1;


    /**
     * Loading json url for select 2 data
     *
     * @var
     */
    protected $url;

    /**
     * Getter for $url
     *
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Setter for $url
     *
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = strval($url);
        return $this;
    }

    /**
     * Return TRUE if $url is set
     *
     * @return bool
     */
    public function hasUrl()
    {
        return isset($this->url);
    }

    /**
     * Unset $url
     *
     * @return $this
     */
    public function removeUrl()
    {
        unset($this->url);
        return $this;
    }


    /**
     *
     * Getter for $length
     *
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Setter for $length
     *
     *
     * @param $length cannot be under 1
     * @return $this
     */
    public function setLength($length)
    {
        $length = intval($length);
        $this->length = empty($length) ? 1 : $length;

        return $this;
    }

    /**
     * Constructror
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $url = '#', $length = 1, $attr = [] )
    {
        $this->setAttributes($attr);
        $this->setName($name);
        $this->setLabel($label);
        $this->setUrl($url);
        $this->setLength($length);
        $this->addAttribute('type', 'hidden');
    }




    /**
     * @return string
     */
    public function __toString()
    {
        $render = '';
        try {

            $render = $this->getRenderer()->render('select2', $this);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}