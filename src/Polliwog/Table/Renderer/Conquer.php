<?php namespace FrenchFrogs\Polliwog\Table\Renderer;

use FrenchFrogs\Polliwog\Table\Column;

class Conquer extends Bootstrap
{

    public function _table(\FrenchFrogs\Polliwog\Table\Table\Table $table)
    {

        /** @var $table \FrenchFrogs\Polliwog\Table\Table\Conquer */
        $html = parent::_table($table);

        return $html;
    }

}