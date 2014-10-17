<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 17/10/14
 * Time: 08:47
 */

namespace FrenchFrogs\Core;

/**
 *  Gestion des tags Html
 *
 * Class Attributes
 */
Trait HtmlTag
{
    /**
     * Taq HTML to générate
     *
     * @var string
     */
    protected $tag;

    /**
     * Content of the tag
     *
     * @var string
     */
    protected $content = '';

    /**
     *
     * Attributs html du formulaire
     *
     * @var array
     */
    protected $attribute = [];

    /**
     * Set de l'attrribut class
     *
     * @param array $class
     * @return $this
     */
    public function setClass(array $class)
    {
        return $this->setAttribute('class', implode(' ', $class));
    }

    /**
     * Add class
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
            $this->setClass($attr);
        }

        return $this;
    }

    /**
     * Remove une classe de l'objet formuaire
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

        return $this->setClass($attr);
    }

    /**
     * Efface toute les classes associé à l'obet formulaire
     *
     * @return $this
     */
    public function clearClass()
    {
        return $this->removeAttribute('class');
    }

    /**
     * Renvoie true si la classe est associé au formulaire
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
     * Renvoie les classes associé au formulaire
     *
     * @return string
     */
    public function getClass()
    {
        return $this->getAttribute('class');
    }

    /**
     * Set de l'attribut style
     *
     * @param array $style
     * @return $this
     */
    public function setStyle(array $style)
    {
        $result = [];

        // formatage du css
        foreach($style as $k => $v) {
            $result[] = $k . ': ' .$v;
        }

        return $this->addAttribute('style', implode(';', $result));
    }

    /**
     * Add $name : $value à l'attribut style
     *
     * @param $name
     * @param $value
     */
    public function addStyle($name, $value)
    {

        $style = [];
        foreach(explode(';', (string) $this->getAttribute('style')) as $data) {
            list($k, $v) = explode(':', $data, 2);
            $style[$k] = $v;
        }

        // Set de la valeur
        $style[$name] = $value;
        $this->setStyle($style);
    }

    /**
     * Remove $name de l'attribut style
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

        return $this->setStyle($style);
    }

    /**
     *  Clear l'attribut style
     *
     * @return $this
     */
    public function clearStyle()
    {
        return $this->removeAttribute('style');
    }

    /**
     * Set l'intégralité des attributs du formulaire
     *
     * @param array $attribute
     * @return $this
     */
    public function setAttribute(array $attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    /**
     *
     * Ajoute un atribut
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function addAttribute($name, $value)
    {
        $this->attribute[$name] = $value;
        return $this;
    }

    /**
     * Renvoie la valeur d'un attribut par rapport a son nom
     *
     * @param $name
     * @return null
     */
    public function getAttribute($name)
    {
        return isset($this->attribute[$name]) ? $this->attribute[$name] : null;
    }

    /**
     * Supprime un attribut
     *
     * @param $name
     * @return $this
     */
    public function removeAttribute($name)
    {
        if(isset($this->attribute[$name])) {
            unset($this->attribute[$name]);
        }

        return $this;
    }

    /**
     * supprime tous les attributs
     *
     * @return $this
     */
    public function clearAttribute()
    {
        return $this->setAttribute([]);
    }
    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set content
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
     * Append coontent
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
     * Append content
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
     * Clear content
     *
     * @return $this
     */
    public function clearContent()
    {
        $this->content  = '';
        return $this;
    }

    /**
     * Get tag
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return $this
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * Call render methods
     *
     * @return string
     */
    function __toString()
    {
        return $this->render();
    }

    /**
     * Render the html attrribute
     *
     * @return string
     */
    public function render()
    {

    }

}