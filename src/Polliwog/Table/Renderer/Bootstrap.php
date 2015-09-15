<?php namespace FrenchFrogs\Polliwog\Table\Renderer;

use FrenchFrogs\Polliwog\Table\Column;

class Bootstrap extends TableAbstract
{

    const TABLE_STRIPED_CLASS = 'table-striped';
    const TABLE_BORDERED_CLASS = 'table-bordered';
    const TABLE_HOVER_CLASS = 'table-hover';
    const TABLE_CONDENSED_CLASS = 'table-condensed';
    const TABLE_RESPONSIVE_CLASS = 'table-responsive';

    protected $is_striped = true;

    protected $is_bordered = false;

    protected $has_hover = true;

    protected $is_condensed = true;

    protected $is_responsive = true;


    public function setStriped($stripped = true)
    {
        $this->is_striped = $stripped;
        return $this;
    }

    public function isStriped()
    {
        return (bool) $this->is_striped;
    }

    public function setBordered($borderer = true)
    {
        $this->is_bordered = $borderer;
        return $this;
    }

    public function isBordered()
    {
        return (bool) $this->is_bordered;
    }

    public function setCondensed($condensed = true)
    {
        $this->is_condensed = $condensed;
        return $this;
    }

    public function isCondensed()
    {
        return (bool) $this->is_condensed;
    }

    public function setResponsive($responsive = true)
    {
        $this->is_responsive = $responsive;
        return $this;
    }

    public function isResponsive()
    {
        return (bool) $this->is_responsive;
    }

    public function setHover($hover = true)
    {
        $this->has_hover = $hover;
        return $this;
    }

    public function hasHover()
    {
        return (bool) $this->has_hover;
    }


    public function _table(\FrenchFrogs\Polliwog\Table\Table $table)
    {

        // Headers
        $head = '';
        $headers = [];
        foreach($table->getColumns() as $column) {
            /** @var Column\Column $column */
            $head .= html('th', [], $column->getLabel());
            $headers[] = $column->getName();
        }


        // Data
        $body = '';
        foreach($table->getRows() as $row) {

            $line = '';
            foreach($table->getColumns() as $name => $column) {
                $line .= html('td', [], $column->render($row));

            }

            $body .= html('tr', [],$line );
        }



        // Footer

        // Gesiton des class globale
        $table->addClass('table');


        if ($this->isStriped()){
            $table->addClass(static::TABLE_STRIPED_CLASS);
        }

        if ($this->isBordered()) {
            $table->addClass(static::TABLE_BORDERED_CLASS);
        }

        if ($this->isCondensed()) {
            $table->addClass(static::TABLE_CONDENSED_CLASS);
        }

        if ($this->hasHover()) {
            $table->addClass(static::TABLE_HOVER_CLASS);
        }

        $table =  html('table', $table->getAttributes(), html('thead', [], $head) . html('tbody', [], $body));

        // responsive
        if ($this->isResponsive()){
            $table = html('div', ['class' => static::TABLE_RESPONSIVE_CLASS], $table);
        }

        return $table;
    }


    public function _text(Column\Text $column, array $row)
    {
        return isset($row[$column->getName()]) ? $row[$column->getName()] : '';
    }


}


