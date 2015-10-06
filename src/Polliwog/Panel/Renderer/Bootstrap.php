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
        'panel' => '_panel',
    ];


    /**
     * @param \FrenchFrogs\Polliwog\Panel\Panel\Panel $panel
     */
    public function _panel(Panel\Panel\Panel $panel)
    {

        $html = '';
        $html .= html('div', ['class' => Style::PANEL_HEAD_CLASS_TITLE], $panel->getTitle());
        $html = html('div', ['class' => Style::PANEL_HEAD_CLASS], $html);

        //@todo Action render
        //@todo footer render

        $html .= html('div', ['class' => Style::PANEL_BODY_CLASS], $panel->getBody());

        $panel->addClass(Style::PANEL_CLASS);

        if ($panel->hasContext()) {
            $panel->addClass(constant( Style::class . '::' . $panel->getContext()));
        }

        return html('div', $panel->getAttributes(), $html);
    }
}