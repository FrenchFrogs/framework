<?php namespace FrenchFrogs\Polliwog\Panel\Renderer;

use FrenchFrogs\Polliwog\Panel;
use FrenchFrogs\Polliwog\Form\Element;
use FrenchFrogs\Model\Renderer\Style\Conquer as Style;

/**
 * Renderer for portlet conquer template
 *
 * @see http://www.keenthemes.com/preview/conquer/portlet_general.html
 *
 * Class Conquer
 * @package FrenchFrogs\Polliwog\Panel\Renderer
 */
class Conquer extends Bootstrap
{

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


        $html .= html('div', ['class' => Style::PANEL_HEAD_CLASS_TITLE], $panel->getTitle());
        $html .= html('div', ['class' => Style::PANEL_HEAD_CLASS_ACTIONS], $actions);
        $html = html('div', ['class' => Style::PANEL_HEAD_CLASS], $html);


        //@todo footer render
        $html .= html('div', ['class' => Style::PANEL_BODY_CLASS], $panel->getBody());

        $panel->addClass(Style::PANEL_CLASS);

        if ($panel->hasContext()) {
            $panel->addClass(constant( Style::class . '::' . $panel->getContext()));
        }

        return html('div', $panel->getAttributes(), $html);
    }

}