<?php namespace FrenchFrogs\Table\Renderer;

use FrenchFrogs\Table\Column\Exportable;
use FrenchFrogs\Table\Table;
use Illuminate\Database\Query\Builder;
use League\Csv\Writer;
use PhpParser\Node\Stmt\Foreach_;

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
        // INitilisation du CSV
        $csv = Writer::createFromFileObject(new \SplTempFileObject());


        // gestion des colonne
        $header = $columns = [];
        foreach ($table->getColumns() as $index => $column) {

            // Seule les colonnes Exportable peuvent être exporté
            if ($column instanceof Exportable) {
                $columns[$index] = $column;
                $header[$index] = $column->getLabel();
            }
        }

        // insertion du header
        $csv->insertOne(array_values($header));

        //@todo mettre en place un streaming pour économiser la memoire

        // insertion des lignes
        foreach ($table->getRows() as $row) {
            $line = [];
            foreach (array_keys($header) as $index) {
                $line[] = $columns[$index]->getValue($row);
            }
            $csv->insertOne($line);
        }
        $csv->output($table->getFilename());
        exit;
    }

}