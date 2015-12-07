<?php namespace FrenchFrogs\Container;

use MatthiasMullie\Minify;

/**
 * Meta container
 *
 * Class Javascript
 * @package FrenchFrogs\Container
 */
class Css extends Container
{

    const NAMESPACE_DEFAULT = 'css';


    /**
     * Target directory for css file
     *
     * @var
     */
    protected $targetPath;

    /**
     *
     *
     * Css constructor.
     */
    protected function __construct()
    {
        parent::__construct();
        $this->setTargetPath(public_path());
    }


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
     * Add link
     *
     * @param $href
     * @param string $rel
     * @param string $type
     * @return $this
     */
    public function file($href)
    {
        return $this->append($href);
    }


    public function __toString()
    {

        $result = '';

        if (app()->environment() != 'production') {

            $hash  = '';
            $minifier = new Minify\CSS();qs
            foreach($this->container as $file) {
                $hash .= md5_file($file = public_path($file));
                $minifier->add($file);
            }

            dd($hash);

        } else {
            foreach($this->container as $file) {

                $result .= html('link',
                        [
                            'href' => $file,
                            'rel' => 'stylesheet',
                            'type' => 'text/css',
                        ]
                    ) . PHP_EOL;
            }
        }

        return $result;

    }


}