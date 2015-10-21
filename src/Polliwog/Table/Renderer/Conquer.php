<?php namespace FrenchFrogs\Polliwog\Table\Renderer;

use FrenchFrogs\Polliwog\Table\Column;

class Conquer extends Bootstrap
{

    public function table(\FrenchFrogs\Polliwog\Table\Table\Table $table)
    {

        /** @var $table \FrenchFrogs\Polliwog\Table\Table\Conquer */
        $html = parent::table($table);

        return $html;
    }

}