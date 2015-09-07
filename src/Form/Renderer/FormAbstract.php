<?php namespace FrenchFrogs\Form\Renderer;

use FrenchFrogs\Renderer;
use FrenchFrogs\Form;

abstract class FormAbstract extends Renderer\Renderer
{

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
     * Rendu du formumaire
     *
     * @param \FrenchFrogs\Form\Form $form
     * @return string
     */
    abstract public function  _form(Form\Form $form);


    /**
     * Rendu d'un champ test input.text
     *
     * @param \FrenchFrogs\Form\Element\Text $element
     * @return string
     */
    abstract public function  _text(Form\Element\Text $element);


    /**
     * Rendu d'un champ textarea
     *
     * @param \FrenchFrogs\Form\Element\Textarea $element
     * @return string
     */
    abstract public function _textarea(Form\Element\Textarea $element);

    /**
     * Rendu d'un bouton de soumission
     *
     * @param \FrenchFrogs\Form\Element\Submit $element
     * @return string
     */
    abstract public function _submit(Form\Element\Submit $element);


    /**
     * Rendu d'une checkbox
     *
     * @param \FrenchFrogs\Form\Element\Checkbox $element
     * @return string
     */
    abstract public function _checkbox(Form\Element\Checkbox $element);

    /**
     * Rendu d'une checkbox multiple
     *
     * @param \FrenchFrogs\Form\Element\Checkbox $element
     * @return string
     */
    abstract public function _checkboxmulti(Form\Element\Checkbox $element);

    /**
     * Rendu d'un champ input tel
     *
     * @param \FrenchFrogs\Form\Element\Tel $element
     * @return string
     */
    abstract public function _tel(Form\Element\Tel $element);

    /**
     * Rendu d'un champ input email
     *
     * @param \FrenchFrogs\Form\Element\Email $element
     * @return string
     */
    abstract public function _email(Form\Element\Email $element);


    /**
     * Rendu d'un champ input hidden
     *
     * @param \FrenchFrogs\Form\Element\Hidden $element
     * @return string
     */
    abstract public function _hidden(Form\Element\Hidden $element);

    /**
     * Rendu d'un champ input text
     *
     * @param \FrenchFrogs\Form\Element\Label $element
     * @return string
     */
    abstract public function _label(Form\Element\Label $element);

    /**
     * Rendu d'un bouton a l'interieur du formulaire
     *
     * @param \FrenchFrogs\Form\Element\Button $element
     * @return string
     */
    abstract public function _button(Form\Element\Button $element);

    /**
     * Ajout d'un ligen de séparation
     *
     * @param \FrenchFrogs\Form\Element\Separator $element
     * @return string
     */
    abstract public function _separator(Form\Element\Separator $element);

    /**
     * Rendu d'un titre
     *
     * @param \FrenchFrogs\Form\Element\Title $element
     * @return string
     */
    abstract public function _title(Form\Element\Title $element);

    /**
     * Rendu d'un contenu
     *
     * @param \FrenchFrogs\Form\Element\Content $element
     * @return string
     */
    abstract public function _content(Form\Element\Content $element);

    /**
     * Rendu d'un champ input number
     *
     * @param \FrenchFrogs\Form\Element\Number $element
     * @return string
     */
    abstract public function _number(Form\Element\Number $element);

    /**
     * Rendu d'un champs de type radio
     *
     * @param \FrenchFrogs\Form\Element\Radio $element
     * @return string
     */
    abstract public function _radio(Form\Element\Radio $element);

    /**
     * Rendu d'un champs de type select
     *
     * @param \FrenchFrogs\Form\Element\Select $element
     * @return string
     */
    abstract public function _select(Form\Element\Select $element);

    /**
     * Rendu d'un champ input Password
     *
     * @param \FrenchFrogs\Form\Element\Password $element
     * @return string
     */
    abstract public function _password(Form\Element\Password $element);


    /**
     * Rendu d'un champ input.file
     *
     * @param \FrenchFrogs\Form\Element\File $element
     * @return string
     */
    abstract public function _file(Form\Element\File $element);
}