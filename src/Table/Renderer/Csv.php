<?php namespace FrenchFrogs\Table\Renderer;

use FrenchFrogs\Table\Table;

class Csv extends \FrenchFrogs\Renderer\Renderer
{

    protected $renderers = [
        'table'
    ];


    /**
     * Overload render for array data output
     *
     * @param \FrenchFrogs\Table\Table\Table $table
     * @return array
     */
    public function table(Table\Table $table)
    {

        dd($table);
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