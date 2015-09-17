<?php namespace FrenchFrogs\Polliwog\Table\Column;


class Link extends Text
{

    /**
     * sprintf format url to inject $binds attribute
     *
     *
     * @var string lien
     */
    protected $link = '%s';

    /**
     * Variable contianer to inject in $link attribute
     *
     * @var array
     */
    protected $binds = [];


    /**
     *
     *
     * @param $link
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * Getter for $link attribute
     *
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }


    /**
     * Setter for $binds
     *
     * @param array $binds
     * @return $this
     */
    public function setBinds(array $binds)
    {
        $this->binds = $binds;
        return $this;
    }

    /**
     * Getter for $binds
     *
     * @return array
     */
    public function getBinds()
    {
        return $this->binds;
    }


    /**
     * Clear $binds container
     *
     * @return $this
     */
    public function clearBinds()
    {
        $this->binds = [];
        return $this;
    }

    /**
     * Add a single value to the end of $binds container
     *
     * @param $bind
     * @return $this
     */
    public function appendBind($bind)
    {
        $this->binds[] = $bind;
        return $this;
    }

    /**
     * Add a single value to the begin of $binds container
     *
     * @param $bind
     * @return $this
     */
    public function prependBind($bind)
    {
        array_unshift($this->binds, $bind);
        return $this;
    }

    /**
     * Shift first element of $binds container
     *
     * @return mixed
     */
    public function shiftBind()
    {
        return array_shift($this->binds);
    }

    /**
     * Pop last element of $binds container
     *
     * @return mixed
     */
    public function popBind()
    {
        return array_pop($this->binds);
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
    public function __construct($name, $label = '', $link = '', $binds = [], $attr = [] )
    {
        $this->setAttributes($attr);
        $this->setName($name);
        $this->setLabel($label);
        $this->setLink($link);
        $this->setBinds((array) $binds);
    }

    public function getBindedLink($row = [])
    {

        $bind = array_intersect_key($row, array_fill_keys($this->getBinds(), ''));

        return vsprintf($this->getLink(),$bind);

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
            $render = $this->getRenderer()->render('table.link', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}