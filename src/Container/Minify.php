<?php namespace FrenchFrogs\Container;


trait Minify
{

    /**
     *
     *
     * @var bool
     */
    protected $is_minify = false;


    /**
     * Target directory for css file
     *
     * @var
     */
    protected $targetPath;

    /**
     * Setter for argetPath
     *
     * @param $path
     * @return $this
     */
    public function setTargetPath($path)
    {
        $this->targetPath = $path;
        return $this;
    }

    /**
     * getter for $targetPath
     *
     * @return mixed
     */
    public function getTargetPath()
    {
        return $this->targetPath;
    }

    /**
     * Set $is_minity to TRUE
     *
     * @return $this
     */
    public function enableMinify()
    {
        $this->is_minify = true;
        return $this;
    }

    /**
     * Set $is_minity to FALSE
     *
     * @return $this
     */
    public function disableMinify()
    {
        $this->is_minify = false;
        return $this;
    }

    /**
     * Return $is_minify
     *
     * @return bool
     */
    public function isMinify()
    {
        return $this->is_minify;
    }


    /**
     * Force minify
     *
     * @return string
     */
    public function minify() {
        return strval($this);
    }
}