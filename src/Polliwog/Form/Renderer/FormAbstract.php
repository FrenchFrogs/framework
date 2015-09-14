<?php namespace FrenchFrogs\Polliwog\Form\Renderer;

use FrenchFrogs\Model\Renderer;
use FrenchFrogs\Polliwog\Form;


/**
 * skeleton for Form renderer
 *
 * Class FormAbstract
 * @package FrenchFrogs\Polliwog\Form\Renderer
 */
abstract class FormAbstract extends Renderer\Renderer
{

    /**
     *
     *
     * @var array
     */
    protected $renderer = [
        'form' => '_form',
        'form.text' => '_text',
        'form.textarea' => '_textarea',
        'form.submit' => '_submit',
        'form.checkbox' => '_checkbox',
        'form.checkboxmulti' => '_checkboxmulti',
        'form.tel' => '_tel',
        'form.email' => '_email',
        'form.hidden' => '_hidden',
        'form.label' => '_label',
        'form.button' => '_button',
        'form.separator' => '_separator',
        'form.title' => '_title',
        'form.content' => '_content',
        'form.number' => '_number',
        'form.radio' => '_radio',
        'form.select' => '_select',
        'form.password' => '_password',
        'form.file' => '_file'
    ];

    /**
     * Render object form
     *
     * @param \FrenchFrogs\Polliwog\Form\Form $form
     * @return string
     */
    abstract public function  _form(Form\Form $form);


    /**
     * Render object input.text
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Text $element
     * @return string
     */
    abstract public function  _text(Form\Element\Text $element);


    /**
     * Render object textarea
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Textarea $element
     * @return string
     */
    abstract public function _textarea(Form\Element\Textarea $element);

    /**
     * Render object submit
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Submit $element
     * @return string
     */
    abstract public function _submit(Form\Element\Submit $element);


    /**
     * Render object checkbox
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Checkbox $element
     * @return string
     */
    abstract public function _checkbox(Form\Element\Checkbox $element);

    /**
     * Render object multiple checkbox
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Checkbox $element
     * @return string
     */
    abstract public function _checkboxmulti(Form\Element\Checkbox $element);

    /**
     * Render object input:tel
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Tel $element
     * @return string
     */
    abstract public function _tel(Form\Element\Tel $element);

    /**
     * Render object input:mail
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Email $element
     * @return string
     */
    abstract public function _email(Form\Element\Email $element);


    /**
     * Render object input:hidden
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Hidden $element
     * @return string
     */
    abstract public function _hidden(Form\Element\Hidden $element);

    /**
     * Render object label
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Label $element
     * @return string
     */
    abstract public function _label(Form\Element\Label $element);

    /**
     * Render object button
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Button $element
     * @return string
     */
    abstract public function _button(Form\Element\Button $element);

    /**
     * Render separation object
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Separator $element
     * @return string
     */
    abstract public function _separator(Form\Element\Separator $element);

    /**
     * Render object title
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Title $element
     * @return string
     */
    abstract public function _title(Form\Element\Title $element);

    /**
     * Render object content
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Content $element
     * @return string
     */
    abstract public function _content(Form\Element\Content $element);

    /**
     * Render object input:number
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Number $element
     * @return string
     */
    abstract public function _number(Form\Element\Number $element);

    /**
     * Render object input:radio
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Radio $element
     * @return string
     */
    abstract public function _radio(Form\Element\Radio $element);

    /**
     * Render object
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Select $element
     * @return string
     */
    abstract public function _select(Form\Element\Select $element);

    /**
     * Render object input:password
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\Password $element
     * @return string
     */
    abstract public function _password(Form\Element\Password $element);


    /**
     * Render object input:file
     *
     * @param \FrenchFrogs\Polliwog\Form\Element\File $element
     * @return string
     */
    abstract public function _file(Form\Element\File $element);
}