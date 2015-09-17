<?php namespace FrenchFrogs\Polliwog\Table\Renderer;

use FrenchFrogs\Polliwog\Table\Column;

class Bootstrap extends \FrenchFrogs\Model\Renderer\Renderer
{

    /**
     * Classes for table element
     *
     */
    const TABLE_CLASS_STRIPED = 'table-striped';
    const TABLE_CLASS_BORDERED = 'table-bordered';
    const TABLE_CLASS_HOVER = 'table-hover';
    const TABLE_CLASS_CONDENSED = 'table-condensed';
    const TABLE_CLASS_RESPONSIVE = 'table-responsive';
    const TABLE_CLASS = 'table';


    /**
     * Classes for button element
     *
     */
    const BUTTON_CLASS = 'btn';
    const BUTTON_OPTION_CLASS_DEFAULT = 'btn-default';
    const BUTTON_OPTION_CLASS_PRIMARY = 'btn-primary';
    const BUTTON_OPTION_CLASS_SUCCESS = 'btn-success';
    const BUTTON_OPTION_CLASS_INFO = 'btn-info';
    const BUTTON_OPTION_CLASS_WARNING = 'btn-warning';
    const BUTTON_OPTION_CLASS_DANGER = 'btn-danger';
    const BUTTON_OPTION_CLASS_LINK = 'btn-link';
    const BUTTON_SIZE_CLASS_LARGE = 'btn-lg';
    const BUTTON_SIZE_CLASS_SMALL = 'btn-sm';
    const BUTTON_SIZE_CLASS_EXTRA_SMALL = 'btn-xs';

    /**
     *
     * Available renderer
     *
     * @var array
     */
    protected $renderers = [
        'table' => '_table',
        'table.text' => '_text',
        'table.link' => '_link',
        'table.button' => '_button'
    ];


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
                $line .= html('td', [], $column->render((array) $row));
            }

            $body .= html('tr', [],$line );
        }

        // Footer

        // Bootstrap class management
        $table->addClass(static::TABLE_CLASS);

        if ($table->isStriped()){
            $table->addClass(static::TABLE_CLASS_STRIPED);
        }

        if ($table->isBordered()) {
            $table->addClass(static::TABLE_CLASS_BORDERED);
        }

        if ($table->isCondensed()) {
            $table->addClass(static::TABLE_CLASS_CONDENSED);
        }

        if ($table->hasHover()) {
            $table->addClass(static::TABLE_CLASS_HOVER);
        }


        $html =  html('table', $table->getAttributes(), html('thead', [], $head) . html('tbody', [], $body));

        // responsive
        if ($table->isResponsive()){
            $html = html('div', ['class' => static::TABLE_CLASS_RESPONSIVE], $html);
        }

        return $html;
    }


    public function _text(Column\Text $column, array $row)
    {
        return isset($row[$column->getName()]) ? $row[$column->getName()] : '';
    }


    public function _link(Column\Link $column, array $row)
    {

        $html = html('a', ['href' => $column->getBindedLink($row)], isset($row[$column->getName()]) ? $row[$column->getName()] : '' );
        return $html;
    }


    public function _button(Column\Button $column, array $row)
    {

        if ($column->hasOption()) {
            $column->addClass($column->getOption());
        }

        if ($column->hasSize()) {
            $column->addClass($column->getSize());
        }


        $column->addClass(static::BUTTON_CLASS);
        $column->addAttribute('href',$column->getBindedLink($row));


        $label = '';
        if ($column->hasIcon()) {
            $label .= html('i', ['class' => $column->getIcon()]);
        }

        $name = $column->getLabel();
        if ($column->isIconOnly()) {
            $column->addAttribute('data-toggle', 'tooltip');
        } else {
            $label .= $name;
        }

        $column->addAttribute('title', $name);

        $html = html('a',$column->getAttributes(), $label );
        return $html;
    }
}


