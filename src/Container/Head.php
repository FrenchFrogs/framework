<?php namespace FrenchFrogs\Container;

/**
 * Meta container
 *
 * Class Javascript
 * @package FrenchFrogs\Container
 */
class Head extends Container
{

    const NAMESPACE_DEFAULT = 'meta';


    /**
     * Meta
     *
     * @param $name
     * @param $content
     * @param null $conditional
     * @return $this
     */
    public function meta($name, $content, $conditional = null)
    {
        $meta = html('meta', ['name' => $name, 'content' => $content]);

        // if conditionnal
        if (!is_null($conditional)) {
            $meta = '<!--[if '.$conditional.']>'.PHP_EOL . $meta . PHP_EOL . '<![endif]-->';
        }

        return $this->append($meta);
    }


    /**
     * Fast identity set
     *
     * @param $title
     * @param $description
     * @return $this
     */
    public function identity($title, $description)
    {
        $this->title($title);
        $this->meta('description', $description);
        return $this;
    }


    /**
     * Title
     *
     * @param $title
     * @return $this
     */
    public function title($title)
    {
        return $this->append(html('title', [], $title));
    }

    /**
     * Charset
     *
     * @param string $charset
     * @return $this
     */
    public function charset($charset = 'utf-8')
    {
        return $this->append(html('meta', ['charset' => $charset]));
    }

    /**
     * Append a property
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function property($name, $value)
    {
        return $this->append(html('meta', ['property' => $name, 'content' => $value]));
    }

    /**
     * Usefool facebook open graph
     *
     * @param null $title
     * @param null $site
     * @param null $url
     * @param null $description
     * @param null $type
     * @param null $app
     */
    public function fb($title = null, $site = null, $url = null, $description = null, $type = null, $app = null)
    {
        if (!is_null($title)) {
            $this->property('og:title', $title);
        }

        if (!is_null($site)) {
            $this->property('og:site_name', $site);
        }

        if (!is_null($url)) {
            $this->property('og:url', $url);
        }

        if (!is_null($description)) {
            $this->property('og:description', $description);
        }

        if (!is_null($url)) {
            $this->property('og:type', $type);
        }

        if (!is_null($app)) {
            $this->property('fb:app_id', $app);
        }
    }

    /**
     * Set twitter meta
     *
     * @param string $card
     * @param $site
     * @param $title
     * @param $description
     * @param null $image
     */
    public function twitter($title, $site, $description, $image = null, $card = 'summary')
    {
        $this->meta('twitter:card', $card);
        $this->meta('twitter:site', $site);
        $this->meta('twitter:title', $title);
        $this->meta('twitter:description', $description);
        $this->meta('twitter:card', $title);

        if (!is_null($image)) {
            $this->meta('twitter:image', $image);
        }
    }

    /**
     * Add link
     *
     * @param $href
     * @param string $rel
     * @param string $type
     * @return $this
     */
    public function link($href, $rel = 'stylesheet', $type = 'text/css')
    {
        return $this->append(html('link', compact('href', 'type', 'rel')));
    }


    /**
     * Favicon management
     *
     * @param $favicon
     * @return $this
     */
    public function favicon($favicon)
    {
        return $this->append(html('link', ['rel'=>'shortcut icon', 'href'=> $favicon]));
    }


}