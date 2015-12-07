<?php namespace FrenchFrogs\Container;


use MatthiasMullie\Minify\JS as MiniJs;

/**
 * Javascript container
 *
 * Class Javascript
 * @package FrenchFrogs\Container
 */
class Javascript extends Container
{

    const NAMESPACE_DEFAULT = 'onload';

    use Minify;

    const TYPE_FILE = 'file';
    const TYPE_INLINE = 'inline';

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
        return $this->append([static::TYPE_FILE, $href]);
    }

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
                $attributes[] = json_encode($p, JSON_PRETTY_PRINT );
            } elseif (substr($p,0,8) == 'function') {
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
        array_unshift($params, $selector, $function);
        $this->append([static::TYPE_INLINE, call_user_func_array([$this, 'build'], $params)]);
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
        array_unshift($params, $selector, $function);
        $this->append([static::TYPE_INLINE, call_user_func_array([$this, 'build'], $params)]);
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
        $this->append([static::TYPE_INLINE, sprintf('alert("%s")', $message)]);
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
        $this->append([static::TYPE_INLINE, sprintf('console.log("%s")', $message)]);
        return $this;
    }


    /**
     * Add toastr warning message
     *
     * @param $body
     * @param string $title
     * @return $this
     */
    public function warning($body = '', $title = '')
    {
        $body = empty($body) ?  configurator()->get('toastr.warning.default') : $body;
        $this->append([static::TYPE_INLINE, sprintf('toastr.warning("%s", "%s")', $body, $title)]);
        return $this;
    }

    /**
     * Add toastr success message
     *
     * @param $body
     * @param string $title
     * @return $this
     */
    public function success($body = '', $title = '')
    {
        $body = empty($body) ?  configurator()->get('toastr.success.default') : $body;
        $this->append([static::TYPE_INLINE, sprintf('toastr.success("%s", "%s")', $body, $title)]);
        return $this;
    }


    /**
     * Add toastr success message
     *
     * @param $body
     * @param string $title
     * @return $this
     */
    public function error($body = '', $title = '')
    {
        $body = empty($body) ?  configurator()->get('toastr.error.default') : $body;
        $this->append([static::TYPE_INLINE , sprintf('toastr.error("%s", "%s")', $body, $title)]);
        return $this;
    }

    /**
     * Close the remote modal
     *
     * @return $this
     */
    public function closeRemoteModal()
    {
        $this->appendJs('#modal-remote', 'modal', 'hide');
        return $this;
    }

    /**
     * ReloadAjaxDatatable
     *
     * @param bool|false $resetPaging
     * @return $this
     */
    public function reloadDataTable($resetPaging = false)
    {
        $this->append([static::TYPE_INLINE, 'jQuery(".datatable-remote").DataTable().ajax.reload(null, '. ($resetPaging ?  'true' : 'false') .')']);
        return $this;
    }



    /**
     *
     *
     * @return string
     */
    public function __toString()
    {
        $result = '';
        try {

            // If we want to minify
            if ($this->isMinify()) {

                $hash = '';
                $contents = [];

                // manage remote or local file
                foreach ($this->container as $content) {

                    list($t, $c) = $content;

                    if ($t == static::TYPE_FILE) {

                        // scheme case
                        if (preg_match('#^//.+$#', $c)) {
                            $c = 'http:' . $c;
                            $contents[] = ['remote', $c];
                            $hash .= md5($c);

                            // url case
                        } elseif (preg_match('#^https?//.+$#', $c)) {
                            $contents[] = ['remote', $c];
                            $hash .= md5($c);

                            // local file
                        } else {
                            $c = public_path($c);
                            $hash .= md5_file($c);
                            $contents[] = ['local', $c];
                        }
                    } elseif($t == static::TYPE_INLINE) {
                        $hash .= md5($c);
                        $contents[] = ['inline', $c];
                    }
                }

                // destination file
                $target = public_path($this->getTargetPath());
                if (substr($target, -1) != '/') {
                    $target .= '/';
                }
                $target .= md5($hash) . '.js';


                // add css to minifier
                if (!file_exists($target)) {

                    $minifier = new MiniJs();

                    // Remote file management
                    foreach($contents as $content) {

                        list($t, $c) = $content;

                        // we get remote file content
                        if ($t == 'remote') {
                            $c = file_get_contents($c);
                        }

                        $minifier->add($c);
                    }

                    // minify
                    $minifier->minify($target);
                }

                // set $file
                $result .= html('script',
                        [
                            'src' => str_replace(public_path(), '', $target),
                            'type' => 'text/javascript',
                        ]
                    ) . PHP_EOL;

            } else {

                foreach ($this->container as $content) {

                    list($t, $c) = $content;

                    // render file
                    if ($t == static::TYPE_FILE) {

                        $result .= html('script',
                                [
                                    'src' => $c,
                                    'type' => 'text/javascript',
                                ]
                            ) . PHP_EOL;

                        // render style
                    } elseif($t == static::TYPE_INLINE) {
                        $result .= $c;
                    }
                }
            }

        } catch(\Exception $e) {

            $result = '<!--' . PHP_EOL . 'Error on css generation' . PHP_EOL;

            // stack trace if in debug mode
            if (debug()) {
                $result .= $e->getMessage() . ' : ' . PHP_EOL . $e->getTraceAsString() . PHP_EOL;
            }

            $result .= '-->';
        }

        return $result;
    }
}