<?php namespace FrenchFrogs\Polliwog\Table\Renderer;

abstract class TableAbstract
{

    /**
     *
     * Available renderer
     *
     * @var array
     */
    protected $renderers = [
        'head' => '_head',
        'body' => '_body',
        'foot' => '_foot'
    ];

}