<?php namespace FrenchFrogs\Polliwog\Table\Renderer;


abstract class TableAbstract extends \FrenchFrogs\Model\Renderer\Renderer
{

    /**
     *
     * Available renderer
     *
     * @var array
     */
    protected $renderers = [
        'table' => '_table',
        'table.text' => '_text'
    ];

}