<?php namespace FrenchFrogs\Form\Renderer;

use FrenchFrogs\Renderer;
use FrenchFrogs\Form;
use FrenchFrogs\Renderer\Style\Style;


class Conquer extends Bootstrap
{

    /**
     *
     *
     * @var array
     */
    protected $renderers = [
        'form',
        'modal',
        'text' => 'text',
        'textarea',
        'submit',
        'checkbox',
        'checkboxmulti',
        'tel',
        'email',
        'hidden',
        'label',
        'button',
        'separator',
        'title',
        'content',
        'number',
        'radio',
        'select',
        'password',
        'file',
        'date',
        'boolean'
    ];

    /**
     * Render Label
     *
     * @param \FrenchFrogs\Form\Element\Label $element
     * @return string
     */
    public function label(Form\Element\Label $element)
    {

        $html = '<label>' . $element->getLabel() . '</label>';
        $html .= '<p>' . $element->getValue() . '</p>';

        $class = Style::FORM_GROUP_CLASS;
        $html = html('div', compact('class'), $html);

        return $html;
    }


    /**
     * Render checkbox multi
     *
     * @param \FrenchFrogs\Form\Element\Checkbox $element
     * @return string
     */
    public function checkbox(Form\Element\Checkbox $element)
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

            $values = (array) $element->getValue();

            if (!is_null( $element->getValue()) && in_array($value, $values)) {
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

    /**
     * Render boolean element
     *
     * @param \FrenchFrogs\Form\Element\Boolean $element
     * @return string$
     */
    public function boolean(Form\Element\Boolean $element)
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

        $element->addClass('make-switch');
        $element->addAttribute('type', 'checkbox');
        $element->addAttribute('value', 1);

        // rendu principal
        $html = '<label for="'.$element->getName().'">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>' . PHP_EOL;
        $html .= html('input', $element->getAttributes());

        $class =  Style::FORM_GROUP_CLASS;
        if ($hasError) {
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        $html = html('div', compact('class'), $html);

        return $html;

    }



}