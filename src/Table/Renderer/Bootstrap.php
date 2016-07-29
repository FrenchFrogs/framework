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
        'code',
        'pre',
        'button',
        'datatable',
        'boolean',
        'remote_boolean',
        'remote_text',
        'remote_select',
        'container',
        'strainer',
        'strainerSelect',
        'strainerText',
        'strainerBoolean',
        'strainerDateRange',
        'icon',
        'media',
        'custom',
        'number'
    ];



    /*
     * ************************
     * COLUMNS
     * ***********************
     *
     */

    /**
     * Render the table structure
     * Main method
     *
     * @param \FrenchFrogs\Table\Table\Table $table
     * @return mixed|string
     * @throws \Exception
     */
    public function table(Table\Table $table)
    {

        // Headers
        $head = '';
        $headers = [];
        $hasStrainer = false;
        foreach($table->getColumns() as $column) {
            /** @var Column\Column $column */
			$label = $column->getLabel();
			if ($column->hasDescription()) {
				//$label .= '<i class="fa fa-question-circle" data-toggle="tooltip" title="'.$column->getDescription().'"></i>';
			}
            $head .= html('th', ['class' => 'text-center'], $label);
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

                $attributes = $column->getAttributes();
                if ($table->hasIdField()) {

                    if (!isset($row[$table->getIdField()])) {
                        throw new \LogicException($table->getIdField() . ' column is not found');
                    }

                    //too soon for you
//                  $attributes['data-id'] = sprintf('%s#%s', $row[$table->getIdField()], $name);
                }

                // remove class in colum because it set in column for datatable
                if ($table->isDatatable()) {
                    unset($attributes['class']);
                }

                $line .= html('td', $attributes, $column->render((array) $row)) . PHP_EOL;
            }

            $body .= html('tr', [],$line );
        }

		// Footer
		$footer = '';

        if ($table->isDatatable()) {
            $this->render('datatable', $table);
        } elseif ($table->hasFooter()) {
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


    /**
     * Render a container
     *
     * @param \FrenchFrogs\Table\Column\Container $column
     * @param array $row
     * @return string
     */
    public function container(Column\Container $column, array $row) {

        $html = '';
        foreach($column->getColumns() as $c) {
            /** @var Column\Column $c */
            $html .= $c->render($row) . PHP_EOL;
        }

        return $this->post($html, $column, $row);
    }

    /**
     * render boolean icon
     *
     * @param \FrenchFrogs\Table\Column\Boolean $column
     * @param array $row
     * @return string
     */
    public function boolean(Column\Boolean $column, array $row)
    {

        $html = '';
        if($column->getValue($row)) {
            $html .= '<i class="fa fa-check"></i>';
        }

        return $this->post($html, $column, $row);
    }

    /**
     * render boolean switch
     *
     * @param \FrenchFrogs\Table\Column\BooleanSwitch $column
     * @param array $row
     * @return string
     */
    public function remote_boolean(Column\RemoteBoolean $column, array $row)
    {

        $table = $column->getTable();

        // Attributes
        $attributes = [
            'class' => 'ff-remote-boolean make-switch',
            'type' => 'checkbox',
            'data-size' => 'small',
            'value' => true,
            'data-id' => $row[$column->getTable()->getIdField()],
            'data-column' =>  $column->getName(),
        ];

        if(isset($row[$column->getName()]) && !empty($row[$column->getName()])) {
            $attributes['checked'] = 'checked';
        }


        $html = html('input', $attributes);

        return $this->post($html, $column, $row);
    }


    /**
     * Render Icon column
     *
     * @param \FrenchFrogs\Table\Column\Icon $column
     * @param array $row
     * @return string
     */
    public function icon(Column\Icon $column, array $row)
    {

        $html = '';
        $html .= '<i class="fa '. $column->getValue($row).'"></i>';

        return $this->post($html, $column, $row);
    }

    /**
     * Render custom callable column
     *
     * @param \FrenchFrogs\Table\Column\Custom $column
     * @param array $row
     * @return mixed
     */
    public function custom(Column\Custom $column, array $row)
    {
        $html = call_user_func($column->getCustom(), $row);
        return $this->post($html, $column, $row);
    }


    /**
     * Render text column
     *
     * @param \FrenchFrogs\Table\Column\Text $column
     * @param array $row
     * @return mixed|string
     */
    public function text(Column\Text $column, array $row)
    {

        $attributes = $column->getAttributes();

        if($column->hasTooltip()){
            $attributes += [
                'data-placement' => $column->getTooltipPosition(),
                'data-original-title' => $column->getValue($row),
                'data-toggle' => 'tooltip'
            ];

            $html = html('div', $attributes, str_limit($column->getValue($row), 70));
        } else {
            $html = html('span',$attributes, $column->getValue($row));
        }

        return $this->post($html, $column, $row);
    }

    /**
     *
     *
     * @param $row
     * @return mixed|string
     * @throws \Exception
     */
    public function getValue($row) {

        $value = isset($row[$this->getName()]) ? $row[$this->getName()] : '';
        if ($this->hasFilterer()) {
            $value = $this->getFilterer()->filter($value);
        }
        return $value;
    }


    /**
     * Render a number column
     *
     * @param Column\Number $column
     * @param array $row
     * @return mixed|string
     */
    public function number(Column\Number $column, array $row)
    {
       return $this->text($column, $row);
    }


    /**
     * Render a text remote
     *
     * @param \FrenchFrogs\Table\Column\RemoteText $column
     * @param array $row
     * @return mixed|string
     */
    public function remote_text(Column\RemoteText $column, array $row)
    {

        $html = $this->text($column, $row);
        $html .= html('input', [
            'type' => 'text',
            'data-id' => $row[$column->getTable()->getIdField()],
            'data-column' =>  $column->getName()
        ]);
        $html = html('div', ['class' => 'ff-remote-text'], $html);
        return $html;
    }

    /**
     * Render remote Select
     *
     * @param \FrenchFrogs\Table\Column\RemoteSelect $column
     * @param array $row
     * @return string
     */
    public function remote_select(Column\RemoteSelect $column, array $row)
    {

        // OPTIONS
        $options = html('option', [], '--');
        $elementValue = $row[$column->getIndex()];
        foreach($column->getOptions() as $value => $key){
            $attr = ['value' => $value];
            if ($value == $elementValue){
                $attr['selected'] = 'selected';
            }
            $options .= html('option', $attr, $key);
        }

        $html = html('select', [
            'class' => 'ff-remote-select',
            'data-id' => $row[$column->getTable()->getIdField()],
            'data-column' =>  $column->getName()
        ], $options);
        return $html;
    }


    /**
     * Render link column
     *
     * @param \FrenchFrogs\Table\Column\Link $column
     * @param array $row
     * @return string
     */
    public function link(Column\Link $column, array $row)
    {

        if ($column->isRemote()) {
            $column->addAttribute('data-target', '#' . $column->getRemoteId())
                ->addAttribute('data-toggle', 'modal');
        } elseif($column->isCallback()) {
            $column->addClass('callback-remote');
        }

        $html = html('a', ['href' => $column->getBindedLink($row)], $column->getValue($row));
        return $this->post($html, $column, $row);
    }

    /**
     * Render a media content
     *
     * @param \FrenchFrogs\Table\Column\Link $column
     * @param array $row
     * @return string
     */
    public function media(Column\Media $column, array $row)
    {

        $media =  $column->getBindedLink($row);
        $extension = pathinfo($media, PATHINFO_EXTENSION);

        if (empty($extension)) {
            return '';
        }

        if (($pos = strpos($extension, '?')) !== false) {
            $extension = substr($extension, 0, $pos);
        }

        // Fancybox compatible Image
        if (in_array($extension, ['jpg', 'png', 'jpeg', 'gif'])) {
            $html = html('img', ['style' => 'object-fit: cover;', 'width' => $column->getMediaWidth(), 'height' => $column->getMediaHeight(), 'src' => $media]);
            return html('a', ['href' => $media, 'class' => 'fancybox'], $html);
        }elseif(in_array($extension, ['mp4'])) {
            $source  = html('source', ['src' => $media, 'type' => 'video/' . $extension]);
            return html('video', ['style' => sprintf('width:%spx;height:%spx', $column->getMediaWidth(), $column->getMediaHeight()), 'controls' => 'controls'], $source);
        } else {
            dd($extension);
            throw new \Exception('Extension pas trouvé : ' . $media);
        }

        $html = html('a', ['href' => $column->getBindedLink($row)], $column->getBindedLabel($row));

        return $this->post($html, $column, $row);
    }


    /**
     * Render a button
     *
     * @param \FrenchFrogs\Table\Column\Button $column
     * @param array $row
     * @return mixed
     */
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
            $label .= PHP_EOL;
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

        $html = html('a', $column->getAttributes(), $label );

        $column->clearClasses()->center();

        return $html;
    }


    /**
     * Rendor a code element
     *
     * @param \FrenchFrogs\Table\Column\Code $column
     * @param array $row
     * @return string
     */
    public function code(Column\Code $column, array $row)
    {
        $html = html('code', [],$column->getValue($row));
        return $this->post($html, $column, $row);
    }

    /**
     * Render a pre element
     *
     * @param \FrenchFrogs\Table\Column\Code $column
     * @param array $row
     * @return string
     */
    public function pre(Column\Pre $column, array $row)
    {
        $html = html('pre', [],$column->getValue($row));
        return $this->post($html, $column, $row);
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
                'ajax' => ['url' => route('datatable', ['token' => $table->getToken()])],
                'processing' => true,
                'serverSide' => true,
                'pageLength' => $table->getItemsPerPage(),
                'deferLoading' => $table->getItemsTotal()
            ];
        }

        //param par default
        $options += ['searching' => true];

        //Param dom datatable
        $dom = '';

        //header dom
        $dom .= '<"dataTables_wrapper no-footer"<"row"<"col-md-6 col-sm-12"lB>';
        // is a search is set
        if ($table->hasSearch()) {
            $dom .= '<"col-md-6 col-sm-12"f>';
        }
        $dom .= '>';

        //dom table
        $dom .= '<"table-scrollable"t>';

        //footer dom
        if ($table->hasFooter()) {

            $dom .= '<"row"<"col-md-5 col-sm-12"i><"col-md-7 col-sm-12"p>>';
        }
        
        //Set dom
        $options += ['dom' => $dom];


        // columns mamangement
        $columns = [];
        $order = [];
        $index = 0;
        $search = '';
        foreach($table->getColumns() as $c) {

            $data = [];

            /**@var Column\Column $c */
            $class = $c->getClasses();
            if (!empty($class)) {
                $data['className'] = trim($class);
            }

            // width
            if ($c->hasWidth()) {
                $data['width'] = $c->getWidth();
            }

            // other column attribute
            $data['orderable'] = $c->hasOrder();
            $data['searchable'] = $c->hasStrainer();
            $data['name'] = $c->getName();

            if ($data['searchable'] && !is_null($value = $c->getStrainer()->getValue())) {
				$value = is_bool($value) ? intval($value) : $value;
                $search[] = $value;
            } else {
                $search[] = null;
            }

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

        // buttons
        if ($table->hasDatatableButtons())
        {
            $options += ['buttons' => $table->getDatatableButtons()];
        }

        // main order foir the table
        $options['order'] = $order;

        js('onload', '#' . $table->getAttribute('id'), 'dtt', $options);

        // init search configuration - seartchcols doesn't work
        foreach($search as $i => $s) {
            if (is_null($s)) {continue;}
            js('onload',  '#' . $table->getAttribute('id'), 'DataTable().columns('.$i.').search', $s);
        }

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
        $element->addClass(Style::FORM_ELEMENT_CONTROL);

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
        $element->addClass(Style::FORM_ELEMENT_CONTROL);

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
        $element->addClass(Style::FORM_ELEMENT_CONTROL);

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
    public function strainerDateRange(Column\Strainer\DateRange $strainer)
    {
        $element = $strainer->getElement();

        $html = html('input', ['type' => 'text', 'class' => Style::FORM_ELEMENT_CONTROL, 'name' => $element->getFrom()]);
        $html .= '<span class="input-group-addon">-</span>';
        $html .= html('input', ['type' => 'text', 'class' => Style::FORM_ELEMENT_CONTROL, 'name' => $element->getTo()]);
        return html('div', [
            'name' => $element->getName(),
            'class' => 'input-group date-picker daterange input-daterange text-center',
            'data-date-format' =>  configurator()->get('form.element.date.formatjs')
        ], $html);
    }

    /**
     * Render id data if specified
     *
     * @param $render
     * @param \FrenchFrogs\Table\Column\Column $column
     * @param array $row
     * @return mixed
     */
    protected function post($render, Column\Column $column, array $row)
    {
//        $table = $column->getTable();
//
//        if ($table->hasIdField()) {
//            if (!isset($row[$table->getIdField()])) {
//                throw new \LogicException('"'.$table->getIdField().'" does not exists');
//            }
//
//            $render = html('div', ['data_id' => sprintf('%s#%s', $row[$table->getIdField()], $column->getName())], $render);
//        }

        return $render;
    }
}


