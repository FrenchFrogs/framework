<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 16/10/14
 * Time: 16:40
 */

namespace FrenchFrogs\Form\Element;


class Submit extends \FrenchFrogs\Form\Element
{

    /**
     * Constructeur
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $attr = [] )
    {
        $this->setAttribute($attr);
        $this->setName($name);
    }

    /**
     * @return string
     */
    public function __toString()
    {

        $this->addClass('btn btn-default');
        $html = '';
        $html .= \Form::submit($this->getName(), $this->getAllAttribute());

        return $html;
    }
}