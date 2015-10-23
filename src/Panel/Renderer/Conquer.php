<?php namespace FrenchFrogs\Panel\Renderer;

use FrenchFrogs\Panel;
use FrenchFrogs\Form\Element;
use FrenchFrogs\Renderer\Style\Conquer as Style;

/**
 * Renderer for portlet conquer template
 *
 * @see http://www.keenthemes.com/preview/conquer/portlet_general.html
 *
 * Class Conquer
 * @package FrenchFrogs\Panel\Renderer
 */
class Conquer extends Bootstrap
{

    /**
     * Main renderer
     *
     * @param \FrenchFrogs\Panel\Panel\Panel $panel
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