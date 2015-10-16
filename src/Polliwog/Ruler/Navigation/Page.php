<?php namespace FrenchFrogs\Polliwog\Ruler\Navigation;

use InvalidArgumentException;

use FrenchFrogs\Core;

class Page
{

    use Core\Renderer;
    use Core\Html;

    /**
     * Label of the page
     *
     * @var string
     */
    protected $label;

    /**
     * Link to the page
     *
     * @var string
     */
    protected $link;

    /**
     * Permission needed to have access to the page
     *
     * @var string
     */
    protected $permission;

    /**
     * Children page container
     *
     * @var array
     */
    protected $children = [];

    /**
     * Constructeur
     *
     * @param $link
     * @param null $label
     * @param null $permission
     * @param array $children
     */
    public function __construct($link, $label = null, $permission = null, array $children = [])
    {

        $this->setLink($link);

        if(!is_null($label)) {
            $this->setLabel($label);
        }

        if(!is_null($permission)) {
            $this->setPermission($permission);
        }

        $this->setChildren($children);
    }


    /**
     * Getter for $label attribute
     *
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Setter for $label attribute
     *
     * @param $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = strval($label);
        return $this;
    }

    /**
     * Unset $label attribute
     *
     * @return $this
     */
    public function removeLabel()
    {
        unset($this->label);
        return $this;
    }

    /**
     * Return TRUE is $label is set
     *
     * @return bool
     */
    public function hasLabel()
    {
        return isset($this->label);
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
     * Setter for $link attribute
     *
     * @param $link
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = strval(url($link));
        return $this;
    }

    /**
     * Unset $link attribute
     *
     * @return $this
     */
    public function removeLink()
    {
        unset($this->link);
        return $this;
    }

    /**
     * Return TRUE is $link is set
     *
     * @return bool
     */
    public function hasLink()
    {
        return isset($this->link);
    }

    /**
     * Getter for $permission attribute
     *
     * @return mixed
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Setter for $permission attribute
     *
     * @param $permission
     * @return $this
     */
    public function setPermission($permission)
    {
        $this->permission = strval($permission);
        return $this;
    }

    /**
     * Unset $permission attribute
     *
     * @return $this
     */
    public function removePermission()
    {
        unset($this->permission);
        return $this;
    }

    /**
     * Return TRUE is $permission is set
     *
     * @return bool
     */
    public function hasPermission()
    {
        return isset($this->permission);
    }


    /**
     * Setter for $children container
     *
     * @param $children
     * @return $this
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }


    /**
     * Getter for $children attribute
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Clear $children container
     *
     * @return $this
     */
    public function clearChildren()
    {
        $this->children = [];
        return $this;
    }

    /**
     * Return true if $children container contain a least 1 element
     *
     * @return bool
     */
    public function hasChildren()
    {
        return count($this->children) > 0;
    }

    /**
     * Add $pag to $children container
     *
     * @param $index
     * @param \FrenchFrogs\Polliwog\Ruler\Navigation\Page $page
     * @return $this
     */
    public function addChild($index, Page $page)
    {
        $this->children[$index] = $page;
        return $this;
    }

    /**
     * Return TRUE id $index page exist in $children container
     *
     * @param $index
     * @return bool
     */
    public function hasChild($index, $is_recursive = true)
    {

        $recursive = function(Page $page) use ($index, &$recursive) {
            foreach ($page->getChildren() as $k => $p ) {

                /**@var Page $p*/
                if ($index == $k) {
                    return true;
                }

                if ($p->hasChildren()) {
                    if ($recursive($p)) {
                        return true;
                    }
                }
            }
        };

        return $recursive($this);
    }

    /**
     * Return $index page from $children container
     *
     * @param $index
     * @return mixed
     */
    public function getChild($index, $is_recursive = true)
    {


        if (!$this->hasChild($index, $is_recursive)) {
            throw new InvalidArgumentException('Child doesn\'t exist : ' . $index);
        }

        $recursive = function(Page $page) use ($index, &$recursive) {
            foreach ($page->getChildren() as $k => $p ) {

                /**@var Page $p*/
                if ($index == $k) {
                    return $p;
                }

                if ($p->hasChildren()) {
                    if ($pp = $recursive($p)) {
                        return $pp;
                    }
                }
            }
        };

        return $recursive($this);
    }


    /**
     * Remove $index child from $children container
     *
     * @param $index
     * @return $this
     */
    public function removeChild($index)
    {
        if (!$this->hasChild($index)) {
            throw new InvalidArgumentException('Child doesn\'t exist : ' . $index);
        }

        unset($this->children[$index]);

        return $this;
    }

    /**
     * Return TRUE if the current page is this page
     *
     * @return bool
     */
    public function isCurrent()
    {
        return \URL::current() == $this->getLink();
    }

}