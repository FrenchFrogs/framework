<?php namespace FrenchFrogs\Polliwog\Panel\Renderer;

use FrenchFrogs\Polliwog\Panel;
use FrenchFrogs\Polliwog\Form\Element;

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
    const PANEL_CLASS = 'portlet';
    const PANEL_CLASS_DEFAULT = '';
    const PANEL_CLASS_PRIMARY = '';
    const PANEL_CLASS_SUCCESS = '';
    const PANEL_CLASS_INFO = '';
    const PANEL_CLASS_WARNING = '';
    const PANEL_CLASS_DANGER = '';
    const PANEL_HEAD_CLASS = 'portlet-title';
    const PANEL_HEAD_CLASS_TITLE = 'caption';
    const PANEL_HEAD_CLASS_ACTIONS = 'actions';
    const PANEL_BODY_CLASS = 'portlet-body';
}