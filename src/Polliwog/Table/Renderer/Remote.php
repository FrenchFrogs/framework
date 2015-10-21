<?php namespace FrenchFrogs\Polliwog\Table\Renderer;

use FrenchFrogs\Polliwog\Table\Table;

class Remote extends Bootstrap
{

    /**
     * Overload render for array data output
     *
     * @param \FrenchFrogs\Polliwog\Table\Table\Table $table
     * @return array
     */
    public function table(Table\Table $table)
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