<?php namespace FrenchFrogs\Polliwog\Form\Renderer;


use FrenchFrogs\Model\Renderer;
use FrenchFrogs\Polliwog\Form;
use FrenchFrogs\Model\Renderer\Style\Style;

class ConquerInline extends Bootstrap
{




    function form(Form\Form\Form $form)
    {

        $html = '';
        $form->addAttribute('role', 'form');
        $form->addClass(Style::FORM_HORIZONTAL_CLASS);

        // Elements
        if ($form->hasCsrfToken()) {
            $html .= csrf_field();
        }

        foreach ($form->getElements() as $e) {
            /** @var $e \FrenchFrogs\Polliwog\Form\Element\Element */
            $html .= $e->render();
        }

        $html = html('div', ['class' => 'form-body'], $html);

        // Actions
        if ($form->hasActions()) {
            $html .= '<div class="text-right">';
            foreach ($form->getActions() as $e) {
                $html .= $e->render();
            }
            $html .= "</div>";
        }

        if ($form->isRemote()) {
            $form->addClass('form-remote');
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
        $element->addClass(Style::FORM_ELEMENT_CONTROL);

        // input
        $html = html('input', $element->getAttributes());

        // description
        if ($element->hasDescription()) {
            $html .= '<span class="help-block">'.$element->getDescription().'</span>';
        }

        $html = html('div', ['class' => 'col-md-9'], $html);
        $html = '<label for="'.$element->getName().'" class="control-label col-md-3">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>' . $html;

        $class =  Style::FORM_GROUP_CLASS;
        if ($hasError) {
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        $html = html('div', compact('class'), $html);

        return $html;
    }


    public function textarea(Form\Element\Textarea $element)
    {
        //error
        if($hasError = !$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        $element->addClass(Style::FORM_ELEMENT_CONTROL);

        // input
        $html = html('textarea', $element->getAttributes(), $element->getValue());

        // description
        if ($element->hasDescription()) {
            $html .= '<span class="help-block">'.$element->getDescription().'</span>';
        }

        $html = html('div', ['class' => 'col-md-9'], $html);
        $html = '<label for="'.$element->getName().'" class="control-label col-md-3">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>' . $html;

        $class = Style::FORM_GROUP_CLASS;
        if ($hasError) {
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        $html = html('div', compact('class'), $html);

        return $html;
    }


    public function label(Form\Element\Label $element)
    {

        $html = '<label class="col-md-3 control-label">' . $element->getLabel() . '</label>';
        $html .= '<div class="col-md-9"><p class="form-control-static">' . $element->getValue() . '</p></div>';

        $class = Style::FORM_GROUP_CLASS;
        $html = html('div', compact('class'), $html);

        return $html;
    }



    public function checkbox(Form\Element\Checkbox $element)
    {

        if($hasError = !$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
        }

        if ($element->getValue() == true){
            $element->addAttribute('checked', 'checked');
        }

        // input
        $html = html('input', $element->getAttributes());
        $html = html('div', ['class' => 'checkbox-list'], $html);

        // description
        if ($element->hasDescription()) {
            $html .= '<span class="help-block">'.$element->getDescription().'</span>';
        }

        $html = html('div', ['class' => 'col-md-9'], $html);
        $html = '<label for="'.$element->getName().'" class="control-label col-md-3">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>' . $html;


        $class =  Style::FORM_GROUP_CLASS;
        if ($hasError) {
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        $html = html('div', compact('class'), $html);

        return $html;
    }






}