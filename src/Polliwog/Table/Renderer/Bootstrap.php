<?php namespace FrenchFrogs\Polliwog\Table\Renderer;

use FrenchFrogs\Polliwog\Table\Column;
use FrenchFrogs\Polliwog\Table\Table;
use FrenchFrogs\Model\Renderer\Style\Style;

class Bootstrap extends \FrenchFrogs\Model\Renderer\Renderer
{
    /**
     *
     * Available renderer
     *
     * @var array
     */
    protected $renderers = [
        'table' ,
        'text',
        'link',
        'button',
        'datatable',
        'boolean',
        'container'
    ];



    /*
     * ************************
     * COLUMNS
     * ***********************
     *
     */

    public function table(Table\Table $table)
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

        if ($table->isDatatable()) {
            $table->disableFooter();
            $this->render('datatable', $table);
        }

        // Footer
        $footer = '';

        if ($table->hasFooter()) {
            $current = $table->getPage();
            $footer .= sprintf('<li class="disabled"><span>&laquo;</span></li>');
            for ($i = 1; $i <= min(10, $table->getPagesTotal()); $i++) {
                $footer .= html('li', ['class' => $current == $i ? 'active' : null], sprintf('<a href="%s">%s</a>', $table->getPageUrl($i), $i));
            }

            $footer .= sprintf('<li><a href="%s" rel="next">&raquo;</a></li>', '#');
            $footer = html('ul', ['class' => 'pagination'], $footer);
            $footer = html('td', ['colspan' => count($headers)], $footer);
            $footer = html('tr', [], $footer);
            $footer = html('tfoot', ['class' => 'text-center'], $footer);
        }


        // Bootstrap class management
        $table->addClass(Style::TABLE_CLASS);

        if ($table->isStriped()){
            $table->addClass(Style::TABLE_CLASS_STRIPED);
        }

        if ($table->isBordered()) {
            $table->addClass(Style::TABLE_CLASS_BORDERED);
        }

        if ($table->isCondensed()) {
            $table->addClass(Style::TABLE_CLASS_CONDENSED);
        }

        if ($table->hasHover()) {
            $table->addClass(Style::TABLE_CLASS_HOVER);
        }

        $html =  html('table', $table->getAttributes(), html('thead', [], $head) . html('tbody', [], $body) . $footer);

        // responsive
        if ($table->isResponsive()){
            $html = html('div', ['class' => Style::TABLE_CLASS_RESPONSIVE], $html);
        }

        if ($table->hasPanel()) {
            $html = $table->getPanel()->setBody($html)->render();
        }

        return $html;
    }


    public function container(Column\Container $column, array $row) {

        $html = '';
        foreach($column->getColumns() as $c) {
            /** @var Column\Column $c */
            $html .= '<span class="ff-padding">' . $c->render($row) . '</span>';
        }

        return $html;
    }

    public function boolean(Column\Boolean $column, array $row)
    {

        $html = '';
        if(isset($row[$column->getName()]) && !empty($row[$column->getName()])) {
            $html .= '<i class="fa fa-check"></i>';
        }

        return $html;
    }


    public function text(Column\Text $column, array $row)
    {
        return isset($row[$column->getName()]) ? $row[$column->getName()] : '';
    }


    public function link(Column\Link $column, array $row)
    {

        if ($column->isRemote()) {
            $column->addAttribute('data-target', '#' . $column->getRemoteId())
                ->addAttribute('data-toggle', 'modal');
        }

        $html = html('a', ['href' => $column->getBindedLink($row)], $column->getBindedLabel($row));
        return $html;
    }


    public function button(Column\Button $column, array $row)
    {

        if ($column->hasOption()) {
            $column->addClass(constant(  Style::class . '::' . $column->getOption()));
        }

        if ($column->hasSize()) {
            $column->addClass(constant(  Style::class . '::' . $column->getSize()));
        }


        $column->addClass(Style::BUTTON_CLASS);
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
                    ->addClass('modal-remote');
        }

        $column->addAttribute('title', $name);

        $html = html('a',$column->getAttributes(), $label );

        return $html;
    }

    /**
     * Render datatable js
     *
     * @param \FrenchFrogs\Polliwog\Table\Table\Table $table
     * @return string
     */
    public function datatable(Table\Table $table)
    {

        $options = [];

        // Is remote loading
        if ($table->isRemote()) {
            $table->save();

            js()->log($table->getToken());
            $options += [
                'ajax' => ['url' => route('datatable'), 'data' => ['token' => $table->getToken()]],
                'processing' => true,
                'serverSide' => true,
                'deferLoading' => $table->getItemsTotal()
            ];
        }

        js('onload', '#' . $table->getAttribute('id'), 'dtt', $options);
        return '';
    }
}


