<?php namespace FrenchFrogs\Form\Renderer;

use FrenchFrogs\Renderer;
use FrenchFrogs\Form;
use FrenchFrogs\Renderer\Style\Style;


class ConquerModal extends Conquer
{


    function form(Form\Form\Form $form)
    {

        $html = '';
        $form->addAttribute('role', 'form');
        $form->addClass('form-horizontal');

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
            /** @var $e \FrenchFrogs\Form\Element\Element */
            $body .= $e->render();
        }

        // body
        $html .= html('div', ['class' => Style::MODAL_BODY_CLASS . ' form-body'], $body);

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