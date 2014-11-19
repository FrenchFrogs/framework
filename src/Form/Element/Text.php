<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 16/10/14
 * Time: 16:40
 */

namespace FrenchFrogs\Form\Element;


class Text extends \FrenchFrogs\Form\Element
{

    /**
     * Label du champs text
     *
     * @var string
     */
    protected $label = '';

    /**
     * Constructeur
     *
     * @param $name
     * @param string $label
     * @param array $attr
     */
    public function __construct($name, $label = '', $attr = [] )
    {
        $this->setAttribute($attr);
        $this->setName($name);
        $this->setLabel($label);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        $html =  '<div class="form-group">';
        $html .= '<label for="'.$this->getName().'">' . $this->getLabel() . '</label>';
        $html .= \Form::text($this->getName(), '', $this->getAllAttribute());
        $html .= '</div>';

        return $html;
    }
}