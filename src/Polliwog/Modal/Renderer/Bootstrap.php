<?php namespace FrenchFrogs\Polliwog\Modal\Renderer;


use FrenchFrogs\Model\Renderer\Renderer;
use FrenchFrogs\Polliwog\Modal\Modal;
use FrenchFrogs\Polliwog\Form\Element;


class Bootstrap extends Renderer
{

    const MODAL_CLASS = 'modal fade';
    const MODAL_DIALOG_CLASS = 'modal-dialog';
    const MODAL_CONTENT_CLASS = 'modal-content';
    const MODAL_HEADER_CLASS = 'modal-header';
    const MODAL_HEADER_TITLE_CLASS = 'modal-title';
    const MODAL_BODY_CLASS = 'modal-body';
    const MODAL_FOOTER_CLASS = 'modal-footer';

    /**
     *
     * Available renderer
     *
     * @var array
     */
    protected $renderers = [
        'modal' => '_modal',
        'modal_remote' => '_modal_remote'
    ];


    /**
     * Render a modal
     *
     * @param \FrenchFrogs\Polliwog\Modal\Modal\Bootstrap $modal
     * @return string
     */
    public function _modal(Modal\Bootstrap $modal)
    {

        $html = '';

        // header
        if ($modal->hasCloseButton()) {
            $html .= html('button', ['type' => 'button', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => $modal->getCloseButtonLabel()], '<span aria-hidden="true">&times;</span>');
        }

        if ($modal->hasTitle()) {
            $html .= html('h4', ['class' => static::MODAL_HEADER_TITLE_CLASS], $modal->getTitle());
        }

        $html = html('div', ['class' => static::MODAL_HEADER_CLASS], $html);


        // body
        $html .= html('div', ['class' => static::MODAL_BODY_CLASS], $modal->getBody());


        // footer
        if ($modal->hasActions()) {

            $actions = '';

            if ($modal->hasCloseButton()) {
                $actions .= html('button', ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal'], $modal->getCloseButtonLabel());
            }

            foreach ($modal->getActions() as $action) {
                /** @var Element\Button $action */
                $actions .= html('button', $action->getAttributes(), $action->getLabel());
            }

            $html .= html('div', ['class' => static::MODAL_FOOTER_CLASS], $actions);
        }

        // container
        if (!$modal->isRemote()) {
            $html = html('div', ['class' => static::MODAL_CONTENT_CLASS, ], $html);
            $html = html('div', ['class' => static::MODAL_DIALOG_CLASS, 'role' => 'document'], $html);
            $html = html('div', ['class' => static::MODAL_CLASS,'role' => 'dialog'], $html);
        }

        return $html;
    }


    public function _modal_remote(Modal\Bootstrap $modal)
    {

        $html = html('div', ['class' => static::MODAL_CONTENT_CLASS, ], '');
        $html = html('div', ['class' => static::MODAL_DIALOG_CLASS, 'role' => 'document'], $html);
        $html = html('div', ['class' => static::MODAL_CLASS,'role' => 'dialog', 'id' => $modal->getRemoteId()], $html);

        return $html;
    }
}