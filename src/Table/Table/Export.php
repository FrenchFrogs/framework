<?php namespace FrenchFrogs\Table\Table;


use FrenchFrogs\Table\Renderer\Csv;

/**
 * Trait pour la gestion des export CSV d'un table
 *
 * Class Export
 * @package FrenchFrogs\Table\Table
 */
trait Export
{

    /**
     * Nom du fichier d'export par default
     *
     */
    protected $filenameDefault = 'export.csv';

    /**
     *
     * Nom du fichier d'export CSV
     *
     * @var
     */
    protected $filename;


    /**
     * Setter pour $exportFileName
     *
     * @param $name
     * @return $this
     */
    public function setFilename($name)
    {
        $this->filename = $name;
        return $this;
    }

    /**
     * Getter pour $exportFileName
     *
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }


    /**
     * Return TRUE if filename is not empty
     *
     * @return bool
     */
    public function hasFilename()
    {
        return !empty($this->filename);
    }

    /**
     * Export dans un fichier CSV
     *
     * @param $filename
     * @param bool $download
     * @return $this
     */
    public function toCsv($filename = null)
    {

        // on set le nom du fichier
        if (!is_null($filename)) {
            $this->setFilename($filename);
        }

        // si pas de nom de fichier setté, on met celui par default
        if (!$this->hasFilename()) {
            $this->setFilename($this->filenameDefault);
        }

        // backup du renderer
        $renderer = $this->getRenderer();

        // render export
        $this->setRenderer(new Csv());
        $this->render();

        // restore renderer
        $this->setRenderer($renderer);

        return $this;
    }


}