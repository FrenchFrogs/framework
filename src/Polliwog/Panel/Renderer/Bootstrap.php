<?php namespace FrenchFrogs\Polliwog\Panel\Renderer;

use FrenchFrogs\Model\Renderer\Renderer;
use FrenchFrogs\Polliwog\Panel;

class Bootstrap extends Renderer
{


    const PANEL_CLASS = 'panel';
    const PANEL_CLASS_DEFAULT = 'panel-default';
    const PANEL_CLASS_PRIMARY = 'panel-primary';
    const PANEL_CLASS_SUCCESS = 'panel-success';
    const PANEL_CLASS_INFO = 'panel-info';
    const PANEL_CLASS_WARNING = 'panel-warning';
    const PANEL_CLASS_DANGER = 'panel-danger';
    const PANEL_HEAD_CLASS = 'panel-heading';
    const PANEL_HEAD_CLASS_TITLE = 'panel-title';
    const PANEL_HEAD_CLASS_ACTIONS = '';
    const PANEL_BODY_CLASS = 'panel-body';


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
        $html .= html('div', ['class' => static::PANEL_HEAD_CLASS_TITLE], $panel->getTitle());
        $html = html('div', ['class' => static::PANEL_HEAD_CLASS], $html);

        //@todo Action render
        //@todo footer render

        $html .= html('div', ['class' => static::PANEL_BODY_CLASS], $panel->getBody());

        $panel->addClass(static::PANEL_CLASS);

        if ($panel->hasContext()) {
            $panel->addClass(constant( 'static::' . $panel->getContext()));
        }

        return html('div', $panel->getAttributes(), $html);
    }
}