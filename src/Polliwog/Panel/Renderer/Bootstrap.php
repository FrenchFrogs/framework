<?php namespace FrenchFrogs\Polliwog\Panel\Renderer;

use FrenchFrogs\Model\Renderer\Renderer;
use FrenchFrogs\Polliwog\Panel;
use FrenchFrogs\Model\Renderer\Style\Style;

class Bootstrap extends Renderer
{
    /**
     *
     * Available renderer
     *
     * @var array
     */
    protected $renderers = [
        'panel',
        'action',
        'button'
    ];


    /**
     * Main renderer
     *
     * @param \FrenchFrogs\Polliwog\Panel\Panel\Panel $panel
     */
    public function panel(Panel\Panel\Panel $panel)
    {

        $html = '';

        //@todo Action render
        $actions = '';
        foreach($panel->getActions() as $action) {
            $actions .= $action->render() . PHP_EOL;
        }


        $html .= html('div', ['class' => 'pull-right'], $actions);
        $title = '<h4>' . $panel->getTitle() . '</h4>';
        $html .= html('div', ['class' => Style::PANEL_HEAD_CLASS_TITLE . ' clearfix'], $title);
        $html = html('div', ['class' => Style::PANEL_HEAD_CLASS], $html);


        //@todo footer render
        $html .= html('div', ['class' => Style::PANEL_BODY_CLASS], $panel->getBody());

        $panel->addClass(Style::PANEL_CLASS);

        if ($panel->hasContext()) {
            $panel->addClass(constant( Style::class . '::' . $panel->getContext()));
        }

        return html('div', $panel->getAttributes(), $html);
    }


    /**
     *
     *
     * @param \FrenchFrogs\Polliwog\Panel\Action\Button $action
     * @return string
     */
    public function button(Panel\Action\Button $action)
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
            $action->addAttribute('data-toggle', 'tooltip');
        } else {
            $label .= $name;
        }

        if ($action->isRemote()) {
            $action->addAttribute('data-target', '#' . $action->getRemoteId())
                ->addClass('modal-remote');
        }

        $action->addAttribute('title', $name);

        return html('a', $action->getAttributes(), $label );
    }
}