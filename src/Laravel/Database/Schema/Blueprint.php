<?php namespace FrenchFrogs\Laravel\Database\Schema;


class Blueprint extends \Illuminate\Database\Schema\Blueprint
{


    public function binaryUuid($column)
    {
        return $this->addColumn('binaryuuid', $column, ['length' => 16]);
    }
}