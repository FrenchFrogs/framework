<?php namespace FrenchFrogs\Polliwog\Form\Renderer;


use FrenchFrogs\Model\Renderer;
use FrenchFrogs\Polliwog\Form;
use FrenchFrogs\Model\Renderer\Style\Style;

class ConquerModal extends ConquerInline
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

        if ($form->hasLegend()) {
            $html .= html('h4', ['class' => Style::MODAL_HEADER_TITLE_CLASS], $form->getLegend());
        }

        $html = html('div', ['class' => Style::MODAL_HEADER_CLASS], $html);

        $body = '';
        foreach ($form->getElements() as $e) {
            /** @var $e \FrenchFrogs\Polliwog\Form\Element\Element */
            $body .= $e->render();
        }

        // body
        $body = html('div', ['class' => 'form-body'], $body);
        $html .= html('div', ['class' => Style::MODAL_BODY_CLASS . ' form'], $body);

        // Actions
        if ($form->hasActions()) {
            $actions = '';
            foreach ($form->getActions() as $e) {
                $actions .= $e->render();
            }
            $html .= html('div', ['class' => Style::MODAL_FOOTER_CLASS], $actions);
        }

        if ($form->isRemote()) {
            $form->addClass('form-remote');
        }

        $html = html('form', $form->getAttributes(), $html);

        return $html;
    }

}