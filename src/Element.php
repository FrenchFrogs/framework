<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 16/10/14
 * Time: 16:33
 */

namespace FrenchFrogs\Form;

use FrenchFrogs\Core;


abstract class Element
{
    use Core\HtmlTag;

    /**
     *
     * Set le nom de l'élément
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->addAttribute('name', $name);
        return $this;
    }

    /**
     * Get le nom de l'élément
     *
     * @return string
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }
}