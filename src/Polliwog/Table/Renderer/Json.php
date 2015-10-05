<?php namespace FrenchFrogs\Polliwog\Table\Renderer;

use FrenchFrogs\Polliwog\Table\Table;

class Json extends Bootstrap
{


    public function _table(Table\Table $table)
    {

        $data = [];
        foreach($table->getRows() as $row) {

            $line = [];
            foreach($table->getColumns() as $name => $column) {
                $line[] = $column->render((array) $row);
            }

            $data[] = $line;
        }

        return $data;
    }

}