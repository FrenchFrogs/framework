<?php namespace FrenchFrogs\Polliwog\Ruler\Ruler;

use FrenchFrogs\Polliwog\Ruler\Navigation\Page;

trait Navigation
{


    /**
     * Navigation container
     *
     * @var array
     */
    protected $pages = [];



    /**
     * Setter for $pages container
     *
     * @param array $pages
     * @return $this
     */
    public function setPages(array $pages)
    {
        $this->pages = $pages;
        return $this;
    }


    /**
     * Getter for $pages container
     *
     * @return array
     */
    public function getPages()
    {
        return $this->pages;
    }


    /**
     * Clear $pages container
     *
     * @return $this
     */
    public function clearPages()
    {
        $this->pages = [];
        return $this;
    }

    /**
     * Add page to the container
     *
     * @param $index
     * @param Page $page
     * @return $this
     */
    public function addPage($index, Page $page)
    {
        $this->pages[$index] = $page;
        return $this;
    }


    /**
     * Return TRUE if a page $index exist in $pages container
     *
     * @param $index
     * @return bool
     */
    public function hasPage($index)
    {
        return isset($this->pages[$index]);
    }

    /**
     * Return page $index from ages container
     *
     * @param $index
     * @return Page
     */
    public function getPage($index)
    {
        if (!$this->hasPage($index)){
            throw new \InvalidArgumentException('The page "'.$index.'" doesn\'t exists');
        }

        return $this->pages[$index];
    }

    /**
     * Remove a page from $pages container
     *
     * @param $index
     * @return $this
     */
    public function removePage($index)
    {

        if ($this->hasPage($index)){
            unset($this->pages[$index]);
        }

        return $this;
    }





}