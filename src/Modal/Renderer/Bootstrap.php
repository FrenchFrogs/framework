<?php namespace FrenchFrogs\Modal\Renderer;


use FrenchFrogs\Core\FrenchFrogsServiceProvider;
use FrenchFrogs\Renderer\Renderer;
use FrenchFrogs\Modal\Modal;
use FrenchFrogs\Form\Element;
use FrenchFrogs\Renderer\Style\Style;


class Bootstrap extends Renderer
{

    /**
     *
     * Available renderer
     *
     * @var array
     */
    protected $renderers = [
        'modal',
        'action',
        'modal_remote'
    ];


    /**
     * Render a modal
     *
     * @param \FrenchFrogs\Modal\Modal\Modal $modal
     * @return string
     */
    public function modal(Modal\Modal $modal)
    {

        $html = '';

        // header
        if ($modal->hasCloseButton()) {
            $html .= html('button', ['type' => 'button', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => $modal->getCloseButtonLabel()], '<span aria-hidden="true">&times;</span>');
        }

        if ($modal->hasTitle()) {
            $html .= html('h4', ['class' => Style::MODAL_HEADER_TITLE_CLASS], $modal->getTitle());
            $html = html('div', ['class' => Style::MODAL_HEADER_CLASS], $html);
        }

        // body
        $html .= html('div', ['class' => Style::MODAL_BODY_CLASS], $modal->getBody());

        // footer
        if ($modal->hasActions()) {

            $actions = '';

            if ($modal->hasCloseButton()) {
                $actions .= html('button', ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal'], $modal->getCloseButtonLabel());
            }

            foreach ($modal->getActions() as $action) {
                /** @var Element\Button $action */
                $actions .= $this->render('action', $action);
            }

            $html .= html('div', ['class' => Style::MODAL_FOOTER_CLASS], $actions);
        }

        // container
        if (!$modal->isRemote()) {
            $html = html('div', ['class' => Style::MODAL_CONTENT_CLASS, ], $html);
            $html = html('div', ['class' => Style::MODAL_DIALOG_CLASS, 'role' => 'document'], $html);
            $html = html('div', ['class' => Style::MODAL_CLASS,'role' => 'dialog'], $html);
        }

        return $html;
    }


    public function action(Element\Button $action)
    {

        if ($action->hasOption()) {
            $action->addClass(constant(  Style::class . '::' . $action->getOption()));
        }

        if ($action->hasSize()) {
            $action->addClass(constant(  Style::class . '::' . $action->getSize()));
        }

        $action->addClass(Style::BUTTON_CLASS);

        $label = '';
        if ($action->hasIcon()) {
            $label .= html('i', ['class' => $action->getIcon()]);
        }

        $name = $action->getLabel();
        if ($action->isIconOnly()) {
            $action->addClass('ff-tooltip-left');
        } else {
            $label .= $name;
        }

        if ($action->isRemote()) {
            $action->addAttribute('data-target', '#' . $action->getRemoteId())
                ->addClass('modal-remote');
        } elseif($action->isCallback()) {
            $action->addClass('callback-remote');
        }

        $action->addAttribute('title', $name);

        $html = html('a',$action->getAttributes(), $label );

        return $html;

    }


    public function modal_remote(Modal\Modal $modal)
    {

        $html = html('div', ['class' => Style::MODAL_CONTENT_CLASS, ], '');
        $html = html('div', ['class' => Style::MODAL_DIALOG_CLASS, 'role' => 'document'], $html);
        $html = html('div', ['class' => Style::MODAL_CLASS,'role' => 'dialog', 'id' => $modal->getRemoteId()], $html);

        return $html;
    }
}