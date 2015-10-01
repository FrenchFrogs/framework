<?php namespace FrenchFrogs\Polliwog\Container;

/**
 * Javascript container
 *
 * Class Javascript
 * @package FrenchFrogs\Polliwog\Container
 */
class Javascript extends Container
{
    /**
     * Build a jquery call javascript code
     *
     * @param $selector
     * @param $function
     * @param ...$params
     * @return string
     */
    public function build($selector, $function, ...$params)
    {
        $attributes = [];
        foreach($params as $p) {

            if (is_array($p)) {
                $attributes[] = json_encode($p);
            } elseif (substr($p,0,7) == 'function') {
                $attributes[] = str_replace('"', '\"', $p);
            } else {
                $attributes[] = '"'.str_replace('"', '\"', $p).'"';
            }
        }

        return sprintf('$("%s").%s(%s);', $selector, $function, implode(',', $attributes));
    }

    /**
     * Append build javascript to $container attribute
     *
     * @param $selector
     * @param $function
     * @param ...$params
     * @return $this
     */
    public function appendJs($selector, $function, ...$params)
    {
        $this->append($this->build($selector, $function, $params));
        return $this;
    }

    /**
     * Prepend build javascript to $container attribute
     *
     * @param $selector
     * @param $function
     * @param ...$params
     * @return $this
     */
    public function prependJs($selector, $function, ...$params)
    {
        $this->prepend($this->build($selector, $function, $params));
        return $this;
    }

    /**
     * Add alert() javascript function to the container
     *
     * @param $message
     * @return $this
     */
    public function alert($message)
    {
        $this->append(sprintf('alert("%s")', $message));
        return $this;
    }

    /**
     * Add console.log() javascript function to the container
     *
     * @param $message
     * @return $this
     */
    public function log($message)
    {
        $this->append(sprintf('console.log("%s")', $message));
        return $this;
    }

}