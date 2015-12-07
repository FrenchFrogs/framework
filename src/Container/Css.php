<?php namespace FrenchFrogs\Container;

use MatthiasMullie\Minify\CSS as MiniCss;

/**
 * Meta container
 *
 * Class Javascript
 * @package FrenchFrogs\Container
 */
class Css extends Container
{

    use Minify;

    const NAMESPACE_DEFAULT = 'minify_css';
    const TYPE_FILE = 'file';
    const TYPE_STYLE = 'style';

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
     * Add css content
     *
     * @param $content
     * @return $this
     */
    public function style($content)
    {
        return $this->append([static::TYPE_STYLE, $content]);
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
                    } elseif($t == static::TYPE_STYLE) {
                        $hash .= md5($c);
                        $contents[] = ['style', $c];
                    }
                }

                // destination file
                $target = public_path($this->getTargetPath());
                if (substr($target, -1) != '/') {
                    $target .= '/';
                }
                $target .= md5($hash) . '.css';


                // add css to minifier
                if (!file_exists($target)) {

                    $minifier = new MiniCss();

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
                $result .= html('link',
                    [
                        'href' => str_replace(public_path(), '', $target),
                        'rel' => 'stylesheet',
                        'type' => 'text/css',
                    ]
                ) . PHP_EOL;

            } else {

                foreach ($this->container as $content) {

                    list($t, $c) = $content;

                    // render file
                    if ($t == static::TYPE_FILE) {

                        $result .= html('link',
                                [
                                    'href' => $c,
                                    'rel' => 'stylesheet',
                                    'type' => 'text/css',
                                ]
                            ) . PHP_EOL;

                    // render style
                    } elseif($t == static::TYPE_STYLE) {
                        $result .= html('style', [], $c);
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