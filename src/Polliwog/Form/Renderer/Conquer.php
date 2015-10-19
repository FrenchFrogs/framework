<?php namespace FrenchFrogs\Polliwog\Form\Renderer;

use FrenchFrogs\Model\Renderer;
use FrenchFrogs\Polliwog\Form;
use FrenchFrogs\Model\Renderer\Style\Style;


class Conquer extends Bootstrap
{


    public function label(Form\Element\Label $element)
    {

        $html = '<label>' . $element->getLabel() . '</label>';
        $html .= '<p>' . $element->getValue() . '</p>';

        $class = Style::FORM_GROUP_CLASS;
        $html = html('div', compact('class'), $html);

        return $html;
    }


    public function checkboxmulti(Form\Element\Checkbox $element)
    {

        // error
        if($hasError = !$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $html = '<label for="'.$element->getName().'[]">' . $element->getLabel() . '</label>';

        $options = '';
        foreach($element->getOptions() as $value => $label){

            $opt = '';

            // input
            $attr = ['type' => 'checkbox', 'name' => $element->getName() . '[]', 'value' => $value];
            if (!is_null( $element->getValue()) && in_array($value, $element->getValue())) {
                $attr['checked'] = 'checked';
            }
            $opt .= html('input', $attr);
            $opt .= $label;
            $options .= '<label>'.$opt.'</label>';
        }


        $element->addClass('checkbox-list');
        $html .= html('div', $element->getAttributes(), $options);

        $class =  Style::FORM_GROUP_CLASS;
        if ($hasError) {
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        $html = html('div', compact('class'), $html);

        return $html;
    }







}