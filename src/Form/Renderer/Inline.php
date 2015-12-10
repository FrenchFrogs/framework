<?php namespace FrenchFrogs\Form\Renderer;

use FrenchFrogs\Renderer;
use FrenchFrogs\Form;
use FrenchFrogs\Renderer\Style\Style;

/**
 * Form render using bootstrap
 *
 * Class Bootstrap
 * @package FrenchFrogs\Form\Renderer
 */
class Inline extends Renderer\Renderer {

    /**
     *
     *
     * @var array
     */
    protected $renderers = [
        'form',
        'modal',
        'text',
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
        'select2',
        'time',
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
            /** @var $e \FrenchFrogs\Form\Element\Element */
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

        if ($form->isRemote()) {
            $form->addClass('form-remote');
        } elseif($form->isCallback()) {
            $form->addClass('form-callback');
        }

        $form->addCLass('form-horizontal');
        $html = html('form', $form->getAttributes(), $html);

        if ($form->hasPanel()) {
            $html = $form->getPanel()->setBody($html)->render();
        }

        return $html;
    }


    /**
     * Inpout text rendrer
     *
     * @param \FrenchFrogs\Form\Element\Text $element
     * @return string
     */
    public function text(Form\Element\Text $element)
    {
        // CLASS
        $class =  Style::FORM_GROUP_CLASS . ' row';

        // ERROR
        if($hasError = !$element->getValidator()->isValid()){

            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ';';
            }
            $element->addAttribute('data-original-title',$message);
            $element->addAttribute('data-toggle', 'tooltip');
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        // LABEL
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '" class="col-md-3 control-label">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }

        // INPUT
        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $element->addAttribute('id', $element->getName());
        $html = html('input', $element->getAttributes());

        // DESCRIPTION
        if ($element->hasDescription()) {
            $html .= html('span', ['class' => 'help-block'], $element->getDescription());
        }

        // FINAL CONTAINER
        $html = html('div', ['class' => 'col-md-9'], $html);
        return html('div', compact('class'), $label . $html);
    }


    /**
     * Textarea render
     *
     * @param \FrenchFrogs\Form\Element\Textarea $element
     * @return string
     */
    public function textarea(Form\Element\Textarea $element)
    {
        // CLASS
        $class =  Style::FORM_GROUP_CLASS . ' row';

        /// ERROR
        if($hasError = !$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        // LABEL
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '" class="col-md-3 control-label">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }


        // INPUT
        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $html = html('textarea', $element->getAttributes(), $element->getValue());

        // DESCRIPTION
        if ($element->hasDescription()) {
            $html .= html('span', ['class' => 'help-block'], $element->getDescription());
        }

        // FINAL CONTAINER
        $html = html('div', ['class' => 'col-md-9'], $html);
        return html('div', compact('class'), $label . $html);
    }


    /**
     * Submit button render
     *
     * @param \FrenchFrogs\Form\Element\Submit $element
     * @return string
     */
    public function submit(Form\Element\Submit $element)
    {

        //OPTION
        if ($element->hasOption()) {
            $element->addClass(constant(  Style::class . '::' . $element->getOption()));
        }

        //SIZE
        if ($element->hasSize()) {
            $element->addClass(constant(  Style::class . '::' . $element->getSize()));
        }

        // CLASS
        $element->addClass(Style::BUTTON_CLASS);


        // LABEL
        $label = '';
        if ($element->hasIcon()) {
            $label .= html('i', ['class' => $element->getIcon()]);
        }

        $name = $element->getLabel();
        if ($element->isIconOnly()) {
            $element->addAttribute('data-toggle', 'tooltip');
        } else {
            $label .= $name;
        }

        // INPUT
        $element->addAttribute('type', 'submit');
        $element->addAttribute('value', $label);

        return html('input',$element->getAttributes());
    }


    /**
     * Checkbox renderer
     *
     * @param \FrenchFrogs\Form\Element\Checkbox $element
     * @return string
     */
    public function checkbox(Form\Element\Checkbox $element)
    {
        // CLASS
        $class =  Style::FORM_GROUP_CLASS . ' row';

        /// ERROR
        if($hasError = !$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        // LABEL
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '[]" class="col-md-3 control-label">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }

        // OPTIONS
        $options = '';
        foreach($element->getOptions() as $value => $label){

            $options .= '<label class="'.Style::FORM_ELEMENT_CHECKBOX_INLINE.'">';
            $attr = ['type' => 'checkbox', 'name' => $element->getName() . '[]', 'value' => $value];

            // value
            if (!is_null( $element->getValue()) && in_array($value, $element->getValue())) {
                $attr['checked'] = 'checked';
            }

            $options .= html('input', $attr);
            $options .= $label;
            $options .= '</label>';
        }

        // DESCRIPTION
        if ($element->hasDescription()) {
            $options .= html('span', ['class' => 'help-block'], $element->getDescription());
        }

        // INPUT
        $html =  html('div', $element->getAttributes(), $options);

        // FINAL CONTAINER
        $html = html('div', ['class' => 'col-md-9'], $html);
        return html('div', compact('class'), $label . $html);
    }

    /**
     * Render input tel
     *
     * @param \FrenchFrogs\Form\Element\Tel $element
     * @return string
     */
    public function tel(Form\Element\Tel $element)
    {
        return $this->text($element);
    }


    /**
     * Render email input
     *
     * @param \FrenchFrogs\Form\Element\Email $element
     * @return string
     */
    public function email(Form\Element\Email $element)
    {
        return $this->text($element);
    }

    /**
     * render hidden input
     *
     * @param \FrenchFrogs\Form\Element\Hidden $element
     * @return string
     */
    public function hidden(Form\Element\Hidden $element)
    {
        $html = html('input', $element->getAttributes());
        return $html;
    }


    /**
     * Render Label iunput
     *
     * @param \FrenchFrogs\Form\Element\Label $element
     * @return string
     */
    public function label(Form\Element\Label $element)
    {
        $html = '<label class="col-md-3 control-label">' . $element->getLabel() . '</label>';
        $html .= '<div class="col-md-9"><p class="form-control-static">' . $element->getValue() . '</p></div>';

        $class =  Style::FORM_GROUP_CLASS . ' row';
        return html('div', compact('class'), $html);
    }

    /**
     * rende a button element
     *
     * @param \FrenchFrogs\Form\Element\Button $element
     * @return string
     */
    public function button(Form\Element\Button $element)
    {

        //@todo prendre en compte les option et les size
        $element->addClass('btn btn-default');
        $html  = '<div class="form-group">';
        $html .= '<label class="col-md-3 control-label">&nbsp;</label>';
        $html .= '<div class="col-md-9">' . html('button', $element->getAttributes(), $element->getLabel()) . '</div>';
        $html .= '</div>';
        return $html;
    }

    public function separator(Form\Element\Separator $element)
    {
        return '<hr class="col-mld-9">';
    }

    /**
     * Render title
     *
     * @param \FrenchFrogs\Form\Element\Title $element
     * @return string
     */
    public function title(Form\Element\Title $element)
    {
        return '<h3>' . $element->getName() . '</h3>';
    }


    /**
     * Render content
     *
     * @param \FrenchFrogs\Form\Element\Content $element
     * @return string
     */
    public function content(Form\Element\Content $element)
    {

        if ($element->isFullWith()) {
            $html = '<div class="col-md-12">' . $element->getValue() . '</div>';
        } else {
            $html = '<label class="col-md-3 control-label">' . $element->getLabel() . '</label>';
            $html .= '<div class="col-md-9">' . $element->getValue() . '</div>';
        }

        $class = Style::FORM_GROUP_CLASS;
        return html('div', compact('class'), $html);
    }

    /**
     * Render number
     *
     * @param Form\Element\Number $element
     * @return string
     */
    public function number(Form\Element\Number $element)
    {

        // CLASS
        $class =  Style::FORM_GROUP_CLASS;

        // ERROR
        if($hasError = !$element->getValidator()->isValid()){

            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ';';
            }
            $element->addAttribute('data-original-title',$message);
            $element->addAttribute('data-toggle', 'tooltip');
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        // LABEL
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '" class="col-md-3 control-label">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }

        // INPUT
        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $html = html('input', $element->addAttribute('type', 'number')->getAttributes());

        // DESCRIPTION
        if ($element->hasDescription()) {
            $html .= html('span', ['class' => 'help-block'], $element->getDescription());
        }

        // FINAL CONTAINER
        $html = html('div', ['class' => 'col-md-9'], $html);
        return html('div', compact('class'), $label . $html);
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

    /**
     * Render select
     *
     * @param \FrenchFrogs\Form\Element\Select $element
     * @return string
     */
    public function select(Form\Element\Select $element)
    {
        // CLASS
        $class =  Style::FORM_GROUP_CLASS;

        // ERROR
        if($hasError = !$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        // LABEL
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '" class="col-md-3 control-label">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }


        // OPTIONS
        $options = '';
        if ($element->hasPlaceholder()){
            $options .= html('option', ['value' => null], $element->getPlaceholder());
        }

        $elementValue = (array) $element->getValue();
        foreach($element->getOptions() as $value => $key){
            $attr = ['value' => $value];
            if ($element->hasValue() && in_array($value, $elementValue)){
                $attr['selected'] = 'selected';
            }
            $options .= html('option', $attr, $key);
        }


        // INPUT
        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $element->addAttribute('id', $element->getName());
        if ($element->isMultiple()) {
            $element->setName($element->getName() .  '[]');
        }
        $html = html('select', $element->getAttributes(), $options);

        // DESCRIPTION
        if ($element->hasDescription()) {
            $html .= html('span', ['class' => 'help-block'], $element->getDescription());
        }

        $html = html('div', ['class' => 'col-md-9'], $html);

        // FINAL CONTAINER
        return html('div', compact('class'), $label . $html ) . PHP_EOL;
    }

    /**
     * Render password element
     *
     * @param \FrenchFrogs\Form\Element\Password $element
     * @return string
     */
    public function password(Form\Element\Password $element)
    {
        return $this->text($element);
    }



    public function file(Form\Element\File $element)
    {
        // CLASS
        $class =  Style::FORM_GROUP_CLASS;

        // ERROR
        if($hasError = !$element->getValidator()->isValid()){

            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ';';
            }
            $element->addAttribute('data-original-title',$message);
            $element->addAttribute('data-toggle', 'tooltip');
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        // LABEL
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '" class="col-md-3 control-label">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }

        // INPUT
        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $element->addAttribute('type', 'file');
        $html = html('input', $element->getAttributes());

        // DESCRIPTION
        if ($element->hasDescription()) {
            $html .= html('span', ['class' => 'help-block'], $element->getDescription());
        }

        // FINAL CONTAINER
        $html = html('div', ['class' => 'col-md-9'], $html);
        return html('div', compact('class'), $label . $html);
    }


    /**
     * Render a date element
     *
     * @param \FrenchFrogs\Form\Element\Date $element
     * @return string
     */
    public function date(Form\Element\Date $element)
    {

        // CLASS
        $class =  Style::FORM_GROUP_CLASS;

        // ERROR
        if($hasError = !$element->getValidator()->isValid()){

            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ';';
            }
            $element->addAttribute('data-original-title',$message);
            $element->addAttribute('data-toggle', 'tooltip');
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        // LABEL
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '" class="col-md-3 control-label">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }

        // INPUT
        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $element->addClass('date-picker');
        $element->addAttribute('value', $element->getDisplayValue());
        $html = html('input', $element->getAttributes());

        // DESCRIPTION
        if ($element->hasDescription()) {
            $html .= html('span', ['class' => 'help-block'], $element->getDescription());
        }

        // FINAL CONTAINER
        $html = html('div', ['class' => 'col-md-9'], $html);
        return html('div', compact('class'), $label . $html);
    }


    /**
     * Render a time element
     *
     * @param \FrenchFrogs\Form\Element\Time $element
     * @return string
     */
    public function time(Form\Element\Time $element)
    {

        // CLASS
        $class =  Style::FORM_GROUP_CLASS;

        // ERROR
        if($hasError = !$element->getValidator()->isValid()){

            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ';';
            }
            $element->addAttribute('data-original-title',$message);
            $element->addAttribute('data-toggle', 'tooltip');
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        // LABEL
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '" class="col-md-3 control-label">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }

        // INPUT
        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $element->addClass('timepicker-24');
        $html = html('input', $element->getAttributes());

        // DESCRIPTION
        if ($element->hasDescription()) {
            $html .= html('span', ['class' => 'help-block'], $element->getDescription());
        }

        // FINAL CONTAINER
        $html = html('div', ['class' => 'col-md-9'], $html);
        return html('div', compact('class'), $label . $html);

    }



    public function select2(Form\Element\SelectRemote $element)
    {
        // CLASS
        $class =  Style::FORM_GROUP_CLASS;

        // ERROR
        if($hasError = !$element->getValidator()->isValid()){

            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ';';
            }
            $element->addAttribute('data-original-title',$message);
            $element->addAttribute('data-toggle', 'tooltip');
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        // LABEL
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '" class="col-md-3 control-label">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }

        // INPUT
        $element->addClass('select2-remote');
        $element->addAttribute('data-css', 'form-control input-large input-sm');
        $element->addAttribute('data-remote', $element->getUrl());
        $element->addAttribute('data-length', $element->getLength());
        $element->addAttribute('placeholder', $element->getLabel());
        $html = html('input', $element->getAttributes());

        // DESCRIPTION
        if ($element->hasDescription()) {
            $html .= html('span', ['class' => 'help-block'], $element->getDescription());
        }

        // FINAL CONTAINER
        $html = html('div', ['class' => 'col-md-9'], $html);
        return html('div', compact('class'), $label . $html);
    }
}