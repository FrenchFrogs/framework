<?php namespace FrenchFrogs\Ruler\Ruler;

use FrenchFrogs\Ruler\Page\Page;

trait Navigation
{


    /**
     * Page container
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
     * @return Page[]
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
    public function hasPage($index, $is_recursive = true)
    {
        if (isset($this->pages[$index])) {
            return true;
        }

        if ($is_recursive) {
            foreach ($this->pages as $page) {
                /**@var $page Page */
                if ($page->hasChild($index, $is_recursive)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Return page $index from ages container
     *
     * @param $index
     * @return Page
     */
    public function getPage($index, $is_recursive = true)
    {
        if (!$this->hasPage($index, $is_recursive)) {
            throw new \InvalidArgumentException('The page "' . $index . '" doesn\'t exists');
        }

        if (isset($this->pages[$index])) {
            return $this->pages[$index];
        } else {
            foreach ($this->pages as $page) {
                /**@var $page Page */
                if ($page->getChild($index, $is_recursive)) {
                    return true;
                }
            }
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