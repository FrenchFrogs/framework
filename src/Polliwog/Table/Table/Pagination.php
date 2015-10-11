<?php namespace FrenchFrogs\Polliwog\Table\Table;

/**
 * Pagination trait for table polliwog
 *
 * Class Pagination
 * @package FrenchFrogs\Polliwog\Table\Table
 */
trait Pagination
{
    /**
     * Item per table page
     *
     * @var int
     */
    protected $itemsPerPage = 25;

    /**
     * Total number of item
     *
     * @var
     */
    protected $itemsTotal;


    /**
     * Actual page
     *
     * @var int
     */
    protected $page = 1;


    /**
     * Url for navigation
     *
     * @var
     */
    protected $url;

    /**
     * Name of the $page param url
     *
     * @var string
     */
    protected $paramPage = 'page';


    /**
     * Setter for $paramPage attribute
     *
     * @param $paramPage
     * @return $this
     */
    public function setParamPage($paramPage)
    {
        $this->paramPage = strval($paramPage);
        return $this;
    }

    /**
     * Getter for $paramPage attribute
     *
     * @return string
     */
    public function getParamPage()
    {
        return $this->paramPage;
    }


    /**
     * getter for $itemsPerPage attribute
     *
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * Setter for $itemsPerPage attribute
     *
     * @param $itemsPerPage
     * @return $this
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    /**
     * Getter for $ItemsTotal attribute
     *
     * @return mixed
     */
    public function getItemsTotal()
    {
        return $this->itemsTotal;
    }

    /**
     * Getter for $page attribute
     *
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }


    /**
     * Setter for $page attribute
     *
     * @param $page
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }


    /**
     * Return the total number of page
     *
     * @return float
     */
    public function getPagesTotal()
    {
        return floor(($this->getItemsTotal() - 1) / $this->getItemsPerPage());
    }


    /**
     * Return the item offset
     *
     * @return float
     */
    public function getItemsOffset()
    {
        return  ceil(($this->getPage() - 1) * $this->getItemsPerPage());
    }

    /**
     * Set page from an offset count items
     *
     * @param $items
     * @return $this
     */
    public function setPageFromItemsOffset($items)
    {
//        dd($items, $this->getItemsPerPage());
//        dd(ceil(($items - 1) / $this->getItemsPerPage()));
        $this->setPage(ceil(--$items / $this->getItemsPerPage()));
        return $this;
    }

    /**
     * Getter for $url attribute
     *
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Setter for $url attribute
     *
     *
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Return TRUE if the url is set
     *
     * @return bool
     */
    public function hasUrl()
    {
        return isset($this->url);
    }


    /**
     *  Return the $page url
     *
     * @param $page
     * @return string
     */
    public function getPageUrl($page)
    {
        return url($this->getUrl()) . '?' . http_build_query(['page' => $page]);
    }


    /**
     * Fast pagination setup
     *
     * @param array $params
     * @return $this
     */
    public function paginate(array $params)
    {

        // page
        if (isset($params[$this->getParamPage()])) {
            $this->setPage($params[$this->getParamPage()]);
        }

        return $this;
    }

}