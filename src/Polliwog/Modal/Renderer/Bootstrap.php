<?php namespace FrenchFrogs\Polliwog\Modal\Renderer;


use FrenchFrogs\Model\Renderer\Renderer;
use FrenchFrogs\Polliwog\Modal\Modal\Modal;


class Bootstrap extends Renderer
{

    const MODAL_CLASS = 'modal fade';

    const MODAL_DIALO_CLASS = 'modal-dialog';

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
    ];


    public function _modal(Modal $modal)
    {



    }



}