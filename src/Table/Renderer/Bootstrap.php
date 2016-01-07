<?php namespace FrenchFrogs\Table\Renderer;

use FrenchFrogs\Table\Column;
use FrenchFrogs\Table\Table;
use FrenchFrogs\Renderer\Style\Style;

class Bootstrap extends \FrenchFrogs\Renderer\Renderer
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
        'container',
        'strainer',
        'strainerSelect',
        'strainerText',
        'strainerBoolean'
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
        $hasStrainer = false;
        foreach($table->getColumns() as $column) {
            /** @var Column\Column $column */
            $head .= html('th', ['class' => 'text-center'], $column->getLabel());
            $headers[] = $column->getName();
            $hasStrainer = $hasStrainer || $column->hasStrainer();
        }

        $head = html('tr', ['class' => 'heading'], $head);


        // Strainer
        if ($hasStrainer) {

            // initialisation des strainer
            $strainer = '';
            foreach($table->getColumns() as $column) {
                /** @var Column\Column $column */
                $content = '';
                if ($column->hasStrainer()) {
                    $content = $column->getStrainer()->render();
                }

                $strainer .= html('th', ['class' => 'text-center'],$content);
            }

            $head .= html('tr', ['class' => 'filter'], $strainer);
        }


        // Data
        $body = '';
        foreach($table->getRows() as $row) {

            $line = '';
            foreach($table->getColumns() as $name => $column) {
                $line .= html('td', $column->getAttributes(), $column->render((array) $row)) . PHP_EOL;
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
            $html .= $c->render($row) . PHP_EOL;
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
        return $column->getValue($row);
    }


    public function link(Column\Link $column, array $row)
    {

        if ($column->isRemote()) {
            $column->addAttribute('data-target', '#' . $column->getRemoteId())
                ->addAttribute('data-toggle', 'modal');
        } elseif($column->isCallback()) {
            $column->addClass('callback-remote');
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
            $column->addClass('ff-tooltip-left');
        } else {
            $label .= $name;
        }

        if ($column->isRemote()) {
            $column->addAttribute('data-target', '#' . $column->getRemoteId())
                ->addClass('modal-remote');
        } elseif($column->isCallback()) {
            $column->addClass('callback-remote');
        }

        $column->addAttribute('title', $name);

        $html = html('a',$column->getAttributes(), $label );

        return $html;
    }

    /**
     * Render datatable js
     *
     * @param \FrenchFrogs\Table\Table\Table $table
     * @return string
     */
    public function datatable(Table\Table $table)
    {

        $options = [];

        // Is remote loading
        if ($table->isRemote()) {
            $table->addClass('datatable-remote');
            $table->save();
            $options += [
                'ajax' => ['url' => route('datatable'), 'data' => ['token' => $table->getToken()]],
                'processing' => true,
                'serverSide' => true,
                'pageLength' => $table->getItemsPerPage(),
                'deferLoading' => $table->getItemsTotal()
            ];
        }

        // is a search is set
        if ($table->hasSearch()) {
            $options += ['searching' => true];
        }


        // columns mamangement
        $columns = [];
        $order = [];
        $index = 0;
        foreach($table->getColumns() as $c) {

            $data = [];

            /**@var Column\Column $c */
                $class = $c->getClasses();
            if (!empty($class)) {
                $data['className'] = $class;
            }

            // width
            if ($c->hasWidth()) {
                $data['width'] = $c->getWidth();
            }

            // other column attribute
            $data['orderable'] = $c->hasOrder();
            $data['searchable'] = $c->hasStrainer();
            $data['name'] = $c->getName();


            // set order for main table
            if ($c->hasOrderDirection()) {
                $order[] = [$index, $c->getOrderDirection()];
            }

            // set columns to null if column parameters is empty
            $columns[] = empty($data) ? null : $data;
            $index++;
        }

        if (!empty($columns)) {
            $options += ['columns' => $columns];
        }


        // main order foir the table
        $options['order'] = $order;

        js('onload', '#' . $table->getAttribute('id'), 'dtt', $options);
        return '';
    }

    /**
     * Render strainer for a select element
     *
     * @param \FrenchFrogs\Table\Column\Strainer\Select $strainer
     * @return string
     */
    public function strainerSelect(Column\Strainer\Select $strainer)
    {

        $element = $strainer->getElement();
        $element->addStyle('width', '100%');

        $options = '';

        if ($element->hasPlaceholder()){
            $options .= html('option', ['value' => null], $element->getPlaceholder());
        }

        foreach($element->getOptions() as $value => $label){
            $attr = ['value' => $value];
            if ($element->hasValue() && in_array($value, $element->getValue())){
                $attr['selected'] = 'selected';
            }
            $options .= html('option', $attr, $label);
        }

        return html('select', $element->getAttributes(), $options);
    }


    /**
     * Render a striner for a text element
     *
     * @param Column\Strainer\Text $strainer
     * @return string
     */
    public function strainerText(Column\Strainer\Text $strainer)
    {
        $element = $strainer->getElement();
        $element->addStyle('width', '100%');
        $element->addClass('text-center');

        return html('input', $element->getAttributes());
    }

    /**
     * Render strainer for a select element
     *
     * @param \FrenchFrogs\Table\Column\Strainer\Select $strainer
     * @return string
     */
    public function strainerBoolean(Column\Strainer\Boolean $strainer)
    {

        $element = $strainer->getElement();
        $element->addStyle('width', '100%');

        $options = '';

        if ($element->hasPlaceholder()){
            $options .= html('option', ['value' => null], $element->getPlaceholder());
        }

        foreach($element->getOptions() as $value => $label){
            $attr = ['value' => $value];
            if ($element->hasValue() && in_array($value, $element->getValue())){
                $attr['selected'] = 'selected';
            }
            $options .= html('option', $attr, $label);
        }

        return html('select', $element->getAttributes(), $options);
    }
}


