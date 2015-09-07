<?php namespace FrenchFrogs\Form\Renderer;

use FrenchFrogs\Renderer;
use FrenchFrogs\Form;

/**
 * Rendu d'un formulaire en mode bootstrap
 *
 * Class Bootstrap
 * @package FrenchFrogs\Form\Renderer
 */
class Bootstrap extends FormAbstract {


    function _form(Form\Form $form)
    {

        $html = '';
        $form->addAttribute('role', 'form');

        // Element
        foreach ($form->getAllElement() as $e) {
            $html .= $e->render();
        }

        // Action
        $action = $form->getAllAction();
        if (count($action)) {
            $html .= '<div class="text-right">';
            foreach ($action as $e) {
                $html .= $e->render();
            }
            $html .= "</div>";
        }

        $html = html('form', $form->getAllAttribute(), $html);

        return $html;
    }

    public function _text(Form\Element\Text $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getAllError() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $element->addClass('form-control');
        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';
        $html .= html('input', $element->getAllAttribute());
        $html .= '</div>';

        return $html;
    }

    public function _textarea(Form\Element\Textarea $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getAllError() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $element->addClass('form-control');
        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';
        $html .= html('textarea', $element->getAllAttribute(), $element->getValue());
        $html .= '</div>';

        return $html;
    }

    public function _submit(Form\Element\Submit $element)
    {
        $element->addClass('btn btn-default');
        $html = html('input', $element->getAllAttribute());

        return $html;
    }

    public function _checkbox(Form\Element\Checkbox $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getAllError() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $html =  '<div class="checkbox">';
        $html .= '<label for="'.$element->getName().'">';
        if ($element->getValue() == true){
            $element->addAttribute('checked', 'checked');
        }

        $html .= html('input', $element->getAllAttribute());
        $html .= $element->getLabel();
        $html .= '</label>';
        $html .= '</div>';

        return $html;
    }

    public function _checkboxmulti(Form\Element\Checkbox $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getAllError() as $error){
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
            if (in_array($value, $element->getValue())) {
                $attr['checked'] = 'checked';
            }

            $options .= html('input', $attr);
            $options .= $label;
            $options .= '</label>';
        }


        $html .= html('div', $element->getAllAttribute(), $options);
        $html .= '</div>';

        return $html;
    }

    public function _tel(Form\Element\Tel $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getAllError() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $element->addClass('form-control');
        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';
        $html .= html('input', $element->getAllAttribute());
        $html .= '</div>';
        return $html;
    }

    public function _email(Form\Element\Email $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getAllError() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $element->addClass('form-control');
        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';
        $html .= html('input', $element->getAllAttribute());
        $html .= '</div>';

        return $html;
    }

    public function _hidden(Form\Element\Hidden $element)
    {
        $html = html('input', $element->getAllAttribute());
        return $html;
    }

    public function _label(Form\Element\Label $element)
    {

        $html = '<div class="form-group">';
        $html .= '<label>' . $element->getLabel() . '</label>';
        $html .= '<p>' . $element->getValue() . '</p>';
        $html .= '</div>';


        return $html;
    }

    public function _button(Form\Element\Button $element)
    {

        $element->addClass('btn btn-default');
        $html = '<div class="form-group">';
        $html .= html('button', $element->getAllAttribute(), $element->getLabel());
        $html .= '</div>';
        return $html;
    }

    public function _separator(Form\Element\Separator $element)
    {
        return '<hr>';
    }

    public function _title(Form\Element\Title $element)
    {
        return '<h2>' . $element->getName() . '</h2>';
    }

    public function _content(Form\Element\Content $element)
    {

        $html = '<div class="form-group">';
        $html .= '<label>' . $element->getLabel() . '</label>';
        $html .= '<p class="well">' . $element->getValue() . '</p>';
        $html .= '</div>';


        return $html;

    }

    public function _number(Form\Element\Number $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getAllError() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $element->addClass('form-control');
        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';
        $html .= html('input', $element->addAttribute('type', 'number')->getAllAttribute());
        $html .= '</div>';
        return $html;
    }

    public function _radio(Form\Element\Radio $element)
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


        $html .= html('div', $element->getAllAttribute(), $options);
        $html .= '</div>';

        return $html;
    }

    public function _select(Form\Element\Select $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getAllError() as $error){
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

        $html .= html('select', $element->getAllAttribute(), $options);
        $html .= '</div>';

        return $html;
    }

    public function _password(Form\Element\Password $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getAllError() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $element->addClass('form-control');
        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';
        $html .= html('input', $element->getAllAttribute());
        $html .= '</div>';

        return $html;
    }

    public function _file(Form\Element\File $element)
    {
        if(!$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getAllError() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';
        $element->addAttribute('type', 'file');
        $html .= html('input', $element->getAllAttribute());
        $html .= '</div>';

        return $html;
    }

}