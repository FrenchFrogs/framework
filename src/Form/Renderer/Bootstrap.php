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
class Bootstrap extends Renderer\Renderer {

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
        'link',
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
        'datalist'
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
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
            $element->addAttribute('data-toggle', 'tooltip');
        }

        // rendu principal
        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }
        $html = $label . html('input', $element->getAttributes());

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
            $element->addAttribute('data-toggle', 'tooltip');
        }

        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }
        $html = $label . html('textarea', $element->getAttributes(), $element->getValue());

        $class =  Style::FORM_GROUP_CLASS;
        if ($hasError) {
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        $html = html('div', compact('class'), $html);

        return $html;
    }


    public function submit(Form\Element\Submit $element)
    {

        if ($element->hasOption()) {
            $element->addClass(constant(  Style::class . '::' . $element->getOption()));
        }

        if ($element->hasSize()) {
            $element->addClass(constant(  Style::class . '::' . $element->getSize()));
        }


        $element->addClass(Style::BUTTON_CLASS);

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

        $element->addAttribute('type', 'submit');
        $element->addAttribute('value', $label);

        $html = html('input',$element->getAttributes());

        return $html;
    }


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
            $element->addAttribute('data-toggle', 'tooltip');
        }

        $html = '<label for="'.$element->getName().'[]">' . $element->getLabel() . '</label>';

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


        $html .= html('div', $element->getAttributes(), $options);

        $class =  Style::FORM_GROUP_CLASS;
        if ($hasError) {
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        $html = html('div', compact('class'), $html);

        return $html;
    }

    public function tel(Form\Element\Tel $element)
    {
        return $this->text($element);
    }

    public function email(Form\Element\Email $element)
    {
        return $this->text($element);
    }

    public function hidden(Form\Element\Hidden $element)
    {
        $html = html('input', $element->getAttributes());
        return $html;
    }

    public function label(Form\Element\Label $element)
    {

        $html = '<label>' . $element->getLabel() . '</label>';
        $html .= '<p>' . $element->getValue() . '</p>';

        $class = Style::FORM_GROUP_CLASS;
        $html = html('div', compact('class'), $html);

        return $html;
    }


    /**
     * Render a link element
     *
     * @param \FrenchFrogs\Form\Element\Link $element
     * @return string
     */
    public function link(Form\Element\Link $element)
    {

        $html = '<label>' . $element->getLabel() . '</label>';
        $html .= '<p>' . html('a', ['href' => $element->getValue(), 'target' => '_blank'], $element->getValue()) . '</p>';

        $class = Style::FORM_GROUP_CLASS;
        $html = html('div', compact('class'), $html);

        return $html;
    }

    public function button(Form\Element\Button $element)
    {

        //@todo prendre en compte les option et les size
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

    public function content(Form\Element\Content $element)
    {

        $html = '<label>' . $element->getLabel() . '</label>';
        $html .= '<p class="well">' . $element->getValue() . '</p>';

        $class = Style::FORM_GROUP_CLASS;
        $html = html('div', compact('class'), $html);

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
            $element->addAttribute('data-toggle', 'tooltip');
        }

        $element->addClass(Style::FORM_ELEMENT_CONTROL);
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
            $element->addAttribute('data-toggle', 'tooltip');
        }

        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }
        $html =  '<div class="form-group">';
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

        if($element->isMultiple()) {
            $element->setName($element->getName() . '[]');
        }

        $html .= $label . html('select', $element->getAttributes(), $options);
        $html .= '</div>';

        if($element->isMultiple()){
            $element->setName(chop($element->getName(), '[]'));
        }

        return $html;
    }

    public function password(Form\Element\Password $element)
    {
        return $this->text($element);
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
            $element->addAttribute('data-toggle', 'tooltip');
        }

        $html =  '<div class="form-group">';
        $html .= '<label for="'.$element->getName().'">' . $element->getLabel() . '</label>';
        $element->addAttribute('type', 'file');
        $html .= html('input', $element->getAttributes());
        $html .= '</div>';

        return $html;
    }


    /**
     * Render a date element
     *
     * @param \FrenchFrogs\Form\Element\Date $element
     * @return string
     */
    public function date(Form\Element\Date $element)
    {
        // Error
        if($hasError = !$element->getValidator()->isValid()){

            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
            $element->addAttribute('data-toggle', 'tooltip');
        }

        $element->addClass('date-picker');

        // rendu principal
        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $label = '';

        $element->addAttribute('value', $element->getDisplayValue());
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }
        $html = $label . html('input', $element->getAttributes());

        $class =  Style::FORM_GROUP_CLASS;
        if ($hasError) {
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        $html = html('div', compact('class'), $html);

        return $html;
    }


    public function select2(Form\Element\SelectRemote $element)
    {

        // Error
        if($hasError = !$element->getValidator()->isValid()){

            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
            $element->addAttribute('data-toggle', 'tooltip');
        }


        // rendu principal
        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }

        $element->addClass('select2-remote');
        $element->addAttribute('data-remote', $element->getUrl());
        $element->addAttribute('data-length', $element->getLength());

        $element->removeClass('form-control');
        $html = $label . html('input', $element->getAttributes());

        $class =  Style::FORM_GROUP_CLASS;
        if ($hasError) {
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        $html = html('div', compact('class'), $html);

        return $html;
    }

    public function datalist(Form\Element\DataList $element)
    {
        // Error
        if($hasError = !$element->getValidator()->isValid()){
            $element->addClass('form-error');
            if(empty($element->getAttribute('data-placement'))){$element->addAttribute('data-placement','bottom');}
            $message = '';
            foreach($element->getValidator()->getErrors() as $error){
                $message .= $error . ' ';
            }
            $element->addAttribute('data-original-title',$message);
            $element->addAttribute('data-toggle', 'tooltip');
        }

        // rendu principal
        $element->addClass(Style::FORM_ELEMENT_CONTROL);
        $label = '';
        if ($element->getForm()->hasLabel()) {
            $label = '<label for="' . $element->getName() . '">' . $element->getLabel() . ($element->hasRule('required') ? ' *' : '') . '</label>';
        }
        $html = $label . html('input', $element->getAttributes());

        $class =  Style::FORM_GROUP_CLASS;
        if ($hasError) {
            $class .= ' ' .Style::FORM_GROUP_ERROR;
        }

        //datalist
        $options = '';

        $elementValue = (array) $element->getValue();
        foreach($element->getOptions() as $value){
            $attr = ['value' => $value];
            if ($element->hasValue() && in_array($value, $elementValue)){
                $attr['selected'] = 'selected';
            }
            $options .= html('option', $attr);
        }

        $html = html('div', compact('class'), $html).html('datalist', ['id' => $element->getName()], $options);

        return $html;
    }
}
