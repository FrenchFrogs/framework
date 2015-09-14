<?php namespace FrenchFrogs\Core;

/**
 * Trait for Html element management polymorphisme
 *
 * Class Attributes
 */
Trait Html
{
    /**
     * HTML tag
     *
     * @var string
     */
    protected $tag;

    /**
     * Content of the HTML tag
     *
     * @var string
     */
    protected $content = '';

    /**
     *
     * Attributes of the HTML tag
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Set all the "class" attribute as an array
     *
     * @param array $class
     * @return $this
     */
    public function setClasses(array $classes)
    {
        return $this->addAttribute('class', implode(' ', $classes));
    }

    /**
     * Add a single "class" to the "class" attribute
     *
     * @param $class
     * @return $this
     */
    public function addClass($class)
    {

        if(!$this->hasClass($class)) {
            $attr = $this->getAttribute('class');
            $attr = explode(' ', $attr);
            $attr[] = $class;
            $this->setClasses($attr);
        }

        return $this;
    }

    /**
     * Remove a single "class" from the "class" attribute
     *
     * @param $class
     * @return $this
     */
    public function removeClass($class)
    {

        $attr = $this->getAttribute('class');
        $attr = explode(' ', $attr);
        if (($i = array_search($class, $attr)) !== false) {
            unset($attr[$i]);
        }

        return $this->setClasses($attr);
    }

    /**
     * Clear the "class" attribute
     *
     * @return $this
     */
    public function clearClasses()
    {
        return $this->removeAttribute('class');
    }

    /**
     * Check if the "class" exist in the "class" attribute
     *
     * @param $class
     * @return bool
     */
    public function hasClass($class)
    {
        $attr = $this->getAttribute('class');
        $attr = explode(' ', $attr);
        return array_search($class, $attr) !== false;
    }

    /**
     * Return an array of all "class"
     *
     * @return string
     */
    public function getClasses()
    {
        return $this->getAttribute('class');
    }

    /**
     * Set all the "style" attribute as an array
     *
     * @param array $style
     * @return $this
     */
    public function setStyles(array $styles)
    {
        $result = [];

        // formatage du css
        foreach($styles as $k => $v) {
            $result[] = $k . ': ' .$v;
        }

        return $this->addAttribute('style', implode(';', $result));
    }

    /**
     * Add a single "style" to the "style" attribute
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function addStyle($name, $value)
    {
        $style = [];

        foreach(explode(';', (string) $this->getAttribute('style')) as $data) {
            if (empty($data)) {continue;}
            list($k, $v) = explode(':', $data, 2);
            $style[$k] = $v;
        }

        // Set de la valeur
        $style[$name] = $value;
        return $this->setStyles($style);
    }

    /**
     * Remove a single "style" from the "style" attribute
     *
     * @param $name
     * @return $this
     */
    public function removeStyle($name)
    {

        $style = [];
        foreach(explode(';', (string) $this->getAttribute('style')) as $data) {
            list($k, $v) = explode(':', $data, 2);
            if ($k == $name) {continue;}
            $style[$k] = $v;
        }

        return $this->setStyles($style);
    }

    /**
     *  Clear the "style" attribute
     *
     * @return $this
     */
    public function clearStyles()
    {
        return $this->removeAttribute('style');
    }

    /**
     * Check if $style exist in the "style" attribute
     *
     * @param $class
     * @return bool
     */
    public function hasStyle($name)
    {

        foreach(explode(';', (string) $this->getAttribute('style')) as $data) {
            list($k, $v) = explode(':', $data, 2);
            if ($k == $name) {return true;}
        }

        return false;
    }


    /**
     * Return the value of a single "style" from the "style" attribute
     *
     * @param $name
     * @return bool
     */
    public function getStyle($name)
    {
        foreach(explode(';', (string) $this->getAttribute('style')) as $data) {
            list($k, $v) = explode(':', $data, 2);
            if ($k == $name) {return $v;}
        }

        return false;
    }

    /**
     * Return an array of all "style"
     *
     * @return string
     */
    public function getStyles()
    {
        return $this->getAttribute('style');
    }


    /**
     * Set all attributes as an array
     *
     * @param array $attribute
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     *
     * Add a single attribute to the attributes container
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * Return the attribute $name from the attributes container
     *
     * @param $name
     * @return null
     */
    public function getAttribute($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * Return an array of all attributes
     *
     * @return array
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * Remove a single attribute from de attributes container
     *
     * @param $name
     * @return $this
     */
    public function removeAttribute($name)
    {
        if(isset($this->attributes[$name])) {
            unset($this->attributes[$name]);
        }

        return $this;
    }


    /**
     * Return TRUE if the attribute $name is found in the attributes container
     *
     * @param $name
     * @return bool
     */
    public function hasAttribute($name)
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Clear all attributes from the attributes container
     *
     * @return $this
     */
    public function clearAttributes()
    {
        return $this->setAttributes([]);
    }



    /**
     * Return the content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Append $content to the current content
     *
     * @param $content
     * @return $this
     */
    public function appendContent($content)
    {
        $this->content .= strval($content);
        return $this;
    }

    /**
     * Prepend $content to the current content
     *
     * @param $content
     * @return $this
     */
    public function prependContent($content)
    {
        $this->content = strval($content) . $this->content;
        return $this;
    }

    /**
     * Clear the current content
     *
     * @return $this
     */
    public function clearContent()
    {
        $this->content  = '';
        return $this;
    }

    /**
     * Set the tag
     *
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Return the tag
     *
     * @param string $tag
     * @return $this
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }


    /**
     * return the html version of the model
     *
     * @return string
     */
    public function toHtml()
    {
        return html($this->tag, $this->attributes, $this->content);
    }
}