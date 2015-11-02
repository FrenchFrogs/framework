<?php namespace FrenchFrogs\Laravel\Database\Schema;


use Illuminate\Support\Fluent;

class MySqlGrammar extends \Illuminate\Database\Schema\Grammars\MySqlGrammar
{




    /**
     * Create the column definition for a binary type.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeBinaryUuid(Fluent $column)
    {
        return 'binary(16)';
    }
}