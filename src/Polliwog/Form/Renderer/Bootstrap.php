<?php namespace FrenchFrogs\Polliwog\Form\Renderer;

use FrenchFrogs\Model\Renderer;
use FrenchFrogs\Polliwog\Form;

/**
 * Form render using bootstrap
 *
 * Class Bootstrap
 * @package FrenchFrogs\Polliwog\Form\Renderer
 */
class Bootstrap extends Renderer\Renderer {

    //@TODO manage horizontal inline form


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
        'file'
    ];



    function form(Form\Form\Form $form)
    {

        $html = '';
        $form->addAttribute('role', 'form');

        // Elements
        if ($form->hasCsrfToken()) {
            $html .= csrf_field();
        }

        foreach ($form->getElements() as $e) {
            /** @var $e \FrenchFrogs\Polliwog\Form\Element\Element */
            $html .= $e->render();
        }

        // Actions
        if ($form->hasActions()) {
            $html .= '<div class="text-right">';
            foreach ($form->getActions() as $e) {
                $html .= $e->render();
            }
            $html .= "</div>";
        }

        $html = html('form', $form->getAttributes(), $html);

        if ($form->hasPanel()) {
            $html = $form->getPanel()->setBody($html)->render();
        }

        return $html;
    }



    public function text(Form\Element\Text $element)
    {
        // Error
        if($hasError = !$element->getValidator()->isValid()){

            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ';';
            }
            $element->addAttribute('data-original-title',$message);
            $element->addAttribute('data-toggle', 'tooltip');
        }

        // rendu principal
        $element->addClass('form-control');
        $html =  '<div class="form-group '. ($hasError ? 'has-error' : '' ).'">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        $html .= html('input', $element->getAttributes());
        $html .= '</div>';

        return $html;
    }

    public function textarea(Form\Element\Textarea $element)
    {

        //error
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $element->addClass('form-control');
        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';
        $html .= html('textarea', $element->getAttributes(), $element->getValue());
        $html .= '</div>';

        return $html;
    }


    public function submit(Form\Element\Submit $element)
    {
        $html = html('input', $element->getAttributes());
        return $html;
    }


    public function checkbox(Form\Element\Checkbox $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $html =  '<div class="checkbox">';
        $html .= '<label for="'.$element->getName().'">';
        if ($element->getValue() == true){
            $element->addAttribute('checked', 'checked');
        }

        $html .= html('input', $element->getAttributes());
        $html .= $element->getLabel();
        $html .= '</label>';
        $html .= '</div>';

        return $html;
    }

    public function checkboxmulti(Form\Element\Checkbox $element)
    {

        // error
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'[]">' . $element->getLabel() . '</label>';

        $options = '';
        foreach($element->getOptions() as $value => $label){

            $options .= '<label class="checkbox-inline">';

            $attr = ['type' => 'checkbox', 'name' => $element->getName() . '[]', 'value' => $value];


            // value
            if (!is_null( $element->getValue()) && in_array($value, $element->getValue())) {
                $attr['checked'] = 'checked';
            }

            $options .= html('input', $attr);
            $options .= $label;
            $options .= '</label>';
        }


        $html .= html('div', $element->getAttributes(), $options);
        $html .= '</div>';

        return $html;
    }

    public function tel(Form\Element\Tel $element)
    {
        return $this->_text($element);
    }

    public function email(Form\Element\Email $element)
    {
        return $this->_text($element);
    }

    public function hidden(Form\Element\Hidden $element)
    {
        $html = html('input', $element->getAttributes());
        return $html;
    }

    public function label(Form\Element\Label $element)
    {

        $html = '<div class="form-group">';
        $html .= '<label>' . $element->getLabel() . '</label>';
        $html .= '<p>' . $element->getValue() . '</p>';
        $html .= '</div>';


        return $html;
    }

    public function button(Form\Element\Button $element)
    {

        $element->addClass('btn btn-default');
        $html = '<div class="form-group">';
        $html .= html('button', $element->getAttributes(), $element->getLabel());
        $html .= '</div>';
        return $html;
    }

    public function separator(Form\Element\Separator $element)
    {
        return '<hr>';
    }

    public function title(Form\Element\Title $element)
    {
        return '<h2>' . $element->getName() . '</h2>';
    }

    public function content(Form\Element\Content $element)
    {

        $html = '<div class="form-group">';
        $html .= '<label>' . $element->getLabel() . '</label>';
        $html .= '<p class="well">' . $element->getValue() . '</p>';
        $html .= '</div>';


        return $html;

    }

    public function number(Form\Element\Number $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $element->addClass('form-control');
        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';
        $html .= html('input', $element->addAttribute('type', 'number')->getAttributes());
        $html .= '</div>';
        return $html;
    }

    public function radio(Form\Element\Radio $element)
    {
        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';

        $options = '';
        foreach($element->getOptions() as $value => $label){

            $options .= '<label class="radio-inline">';

            $attr = ['type' => 'radio', 'name' => $element->getName(), 'value' => $value];
            // value
            if ($value == $element->getValue()) {
                $attr['checked'] = 'checked';
            }

            $options .= html('input', $attr);
            $options .= $label;
            $options .= '</label>';
        }


        $html .= html('div', $element->getAttributes(), $options);
        $html .= '</div>';

        return $html;
    }

    public function select(Form\Element\Select $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $element->addClass('form-control');
        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';

        $options = '';

        if ($element->hasPlaceholder()){
            $options .= html('option', ['value' => null], $element->getPlaceholder());
        }


        foreach($element->getOptions() as $value => $label){
            $attr = ['value' => $value];
            if ($element->hasValue() && in_array($value, $element->getValue())){
                $attr['selected'] = 'selected';
            }
            $options .= html('option', $attr, $label);
        }

        $html .= html('select', $element->getAttributes(), $options);
        $html .= '</div>';

        return $html;
    }

    public function password(Form\Element\Password $element)
    {
        return $this->_text($element);
    }

    public function file(Form\Element\File $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';
        $element->addAttribute('type', 'file');
        $html .= html('input', $element->getAttributes());
        $html .= '</div>';

        return $html;
    }

}