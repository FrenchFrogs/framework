<?php namespace FrenchFrogs\Table\Renderer;

use FrenchFrogs\Table\Column;

class Conquer extends Bootstrap
{

    public function table(\FrenchFrogs\Table\Table\Table $table)
    {

        /** @var $table \FrenchFrogs\Table\Table\Conquer */
        $html = parent::table($table);

        return $html;
    }

}