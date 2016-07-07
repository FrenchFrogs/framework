<?php namespace FrenchFrogs\Table\Column;

use FrenchFrogs\Core;

class Link extends Text
{

    use Core\Remote;


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
    public function __construct($name, $label = '%s', $link = '#', $binds = [], $attr = [] )
    {
        $this->setRemoteId(configurator()->get('modal.remote.id', $this->remoteId));

        $this->setAttributes($attr);
        $this->setName($name);
        $this->setLabel($label);
        $this->setLink($link);
        $this->setBinds((array) $binds);
    }

    /**
     * Return the binded link
     *
     * @param array $row
     * @return string
     */
    public function getBindedLink($row = [])
    {
        $bind = array_intersect_key($row, array_fill_keys($this->getBinds(), ''));

        // patch pour les paramètre bindé en query
        $link = str_replace('%25', '%', $this->getLink());

        return vsprintf($link, $bind);
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
     *
     *
     * @return string
     */
    public function render(array $row)
    {
        $render = '';
        try {
            $render = $this->getRenderer()->render('link', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}