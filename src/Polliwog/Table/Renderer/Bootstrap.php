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
        'table.button' => '_button',
        'datatable' => '_datatable'
    ];


    /*
     * ************************
     * COLUMNS
     * ***********************
     *
     */

    public function _table(\FrenchFrogs\Polliwog\Table\Table\Table $table)
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
        $footer = '';

        $current = $table->getPage();
        $footer .= sprintf('<li class="disabled"><span>&laquo;</span></li>');
        for($i = 1; $i <= min(10, $table->getPagesTotal()); $i++){
            $footer .= html('li', ['class' => $current == $i ? 'active' : null], sprintf('<a href="%s">%s</a>', $table->getPageUrl($i), $i));
        }

        $footer .= sprintf('<li><a href="%s" rel="next">&raquo;</a></li>', '#');
        $footer = html('ul', ['class' => 'pagination'], $footer);
        $footer = html('td', ['colspan' => count($headers)], $footer);
        $footer = html('tr', [], $footer);
        $footer = html('tfoot', ['class' => 'text-center'], $footer);


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

        $html =  html('table', $table->getAttributes(), html('thead', [], $head) . html('tbody', [], $body) . $footer);

        // responsive
        if ($table->isResponsive()){
            $html = html('div', ['class' => static::TABLE_CLASS_RESPONSIVE], $html);
        }

        if ($table->hasPanel()) {
            $html = $table->getPanel()->setBody($html)->render();
        }

        return $html;
    }


    public function _text(Column\Text $column, array $row)
    {
        return isset($row[$column->getName()]) ? $row[$column->getName()] : '';
    }


    public function _link(Column\Link $column, array $row)
    {

        if ($column->isRemote()) {
            $column->addAttribute('data-target', '#' . $column->getRemoteId())
                ->addAttribute('data-toggle', 'modal');
        }

        $html = html('a', ['href' => $column->getBindedLink($row)], $column->getBindedLabel($row));
        return $html;
    }


    public function _button(Column\Button $column, array $row)
    {

        if ($column->hasOption()) {
            $column->addClass(constant( 'static::' . $column->getOption()));
        }

        if ($column->hasSize()) {
            $column->addClass(constant( 'static::' . $column->getSize()));
        }


        $column->addClass(static::BUTTON_CLASS);
        $column->addAttribute('href',$column->getBindedLink($row));


        $label = '';
        if ($column->hasIcon()) {
            $label .= html('i', ['class' => $column->getIcon()]);
        }

        $name = $column->getBindedLabel($row);
        if ($column->isIconOnly()) {
            $column->addAttribute('data-toggle', 'tooltip');
        } else {
            $label .= $name;
        }

        if ($column->isRemote()) {
            $column->addAttribute('data-target', '#' . $column->getRemoteId())
                    ->addAttribute('data-toggle', 'modal');
        }

        $column->addAttribute('title', $name);

        $html = html('a',$column->getAttributes(), $label );

        return $html;
    }
}


