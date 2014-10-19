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
     * @param $class
     * @return $this
     */
    public function setClass($class)
    {
        $class = implode(' ', (array)$class);
        $class = explode(' ', $class);
        $class = array_unique($class);
        $class = array_filter($class);
        return $this->addAttribute('class', implode(' ', $class));
    }

    /**
     * Add une/des classe(s) à l'objet
     *
     * @param $class
     * @return $this
     */
    public function addClass($class)
    {
        $attr = $this->getClass();
        $attr = explode(' ', $attr);
        $attr = array_merge($attr, (array)$class);
        return $this->setClass($attr);
    }

    /**
     * Remove une/des classe(s) de l'objet formuaire
     *
     * @param $class
     * @return $this
     */
    public function removeClass($class)
    {
        $class = implode(' ', (array)$class);
        $class = explode(' ', $class);

        $attr = $this->getClass();
        $attr = explode(' ', $attr);
        $attr = array_diff($attr, $class);
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
     * Renvoie true si la classe est associé à l'élément
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
     * @param $style
     * @return $this
     */
    public function setStyle($style)
    {
        if (is_array($style)) {
            array_walk($style, function(&$value, $key) {
                $value = $key . ': ' . $value;
            });
            $style = implode('; ', $style);
        }

        $result = [];
        $style = explode(';', $style);
        $style = array_filter($style);
        foreach($style as $data) {
            $data = explode(':', $data, 2);
            $data = array_map('trim', $data);
            $data[0] = strtolower($data[0]);
            $result[$data[0]] = $data[0] . ': ' . $data[1];
        }
        return $this->addAttribute('style', implode('; ', $result));
    }

    /**
     * Add $name : $value à l'attribut style
     *
     * @param string $name
     * @param $value
     * @return $this
     */
    public function addStyle($name, $value = false)
    {
        if ($value === false) {
            list($name, $value) = explode(':', $name, 2);
        }
        $style = (string)$this->getAttribute('style');
        $style .= ';' . $name . ': ' . $value;
        return $this->setStyle($style);
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
        $name = trim($name);
        $name = strtolower($name);
        foreach(explode(';', (string) $this->getAttribute('style')) as $data) {
            list($k, $v) = explode(':', $data, 2);
            if (trim($k) == $name) {
                continue;
            }
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
     * Get l'attribut style
     * @return string
     */
    public function getStyle()
    {
        return $this->getAttribute('style');
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
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = strval($content);
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
     * Render the html attribute
     *
     * @return string
     */
    public function render()
    {
        $attr = [];
        foreach ($this->attribute as $key => $value) {
            $attr[] = $key . '="' . $value . '"';
        }
        return sprintf('<%1$s %2$s>%3$s</%1$s>',
            $this->tag,
            implode(' ', $attr),
            $this->content
        );
    }

}