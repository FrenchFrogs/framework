<?php namespace FrenchFrogs\Table\Table;


use FrenchFrogs\Table\Renderer\Csv;

trait Export
{

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
     * Export dans un fichier CSV
     *
     * @param $filename
     * @param bool $download
     * @return $this
     */
    public function toCsv($filename)
    {

        // on set le nom du fichier
        $this->setFilename($filename);

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