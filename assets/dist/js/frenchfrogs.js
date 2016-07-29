$.fn.extend({

    /**
     *
     * Datatable default configuration
     *
     * @param o
     * @returns {*|{serverSide, ajax}|jQuery}
     */
    dtt : function(o) {

        options = {
            pageLength: 25, // default records per page
            lengthChange: false,
            deferRender : false,
            language: {
                processing: "Traitement en cours...",
                search: "Rechercher :",
                lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                info: "_START_ &agrave; _END_ | _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty: "0 &agrave; 0 | 0 &eacute;l&eacute;ments",
                infoFiltered: "( _MAX_ )",
                infoPostFix: "",
                loadingRecords: "Chargement en cours...",
                zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                emptyTable: "Aucune donnée disponible dans le tableau",
                paginate: {
                    first: "<<",
                    previous: "<",
                    next: ">",
                    last: ">>",
                    page: "Page",
                    pageOf: "de"
                },
                aria: {
                    sortAscending: ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                }
            },

            buttons : [],

            orderCellsTop: true,
            order : [],
            searching : false,
            ordering: true,
            retrieve : true,
            pagingType: "full_numbers", // pagination type(bootstrap, bootstrap_full_number or bootstrap_extended)
            autoWidth: false, // disable fixed width and enable fluid table
            processing: false, // enable/disable display message box on record load
            serverSide: false, // enable/disable server side ajax loading
        };

        return $(this).on('draw.dt', function(e) {$(this).initialize();}).dataTable($.extend(options, o)).fnFilterOnReturn().fnFilterColumns();
    },


    // INITAILISATION
    initialize : function() {
        console.log('initialize GO : ' + this.selector);

        // MODAL
        jQuery(this).find('.modal-remote').each(function() {

            jQuery(this).click(function (e) {
                e.preventDefault();

                var target = jQuery(this).data('target');
                var size  = jQuery(this).data('data-size');
                $url = jQuery(this).attr('href');

                $data = {};
                if ( jQuery(this).data('method')) {
                    $data = {_method: jQuery(this).data('method')}
                }

                jQuery(target)
                    .find('.modal-content')
                    .empty()
                    .load($url, $data, function(){
                        jQuery(this).initialize();
                        jQuery(this).parent().removeClass('modal-lg modal-sm').addClass(size);
                        jQuery(target).modal('show');
                    });
                e.stopImmediatePropagation();
            });
        });


        // FORM
        if (jQuery.fn.ajaxForm != undefined) {

            // FORM REMOTE
            jQuery(this).find('.form-remote').ajaxForm({

                beforeSubmit: function () {
                    jQuery(this).find("input[type='submit']")
                        .attr("disabled", "disabled")
                        .attr("value", "En cours ...");
                },

                success : function(html) {
                    jQuery('.modal-content')
                        .empty()
                        .html(html)
                        .initialize();
                }
            });

            // FORM CALLBACK
            jQuery(this).find('.form-callback').ajaxForm({

                beforeSubmit: function () {
                    jQuery(this).find("input[type='submit']")
                        .attr("disabled", "disabled")
                        .attr("value", "En cours ...");
                },

                success: function (js) {
                    eval(js);
                }
            });
        }

        // CALLBACK
        jQuery(this).find('.callback-remote').each(function () {
            jQuery(this).click(function (e) {

                if ( jQuery(this).data('method')) {

                    $data = {};
                    if ( jQuery(this).data('method')) {
                        $data = {_method: jQuery(this).data('method')}
                    }

                    jQuery.post(
                        jQuery(this).attr('href'),
                        $data,
                        function(a) {eval(a);}
                    );
                } else {
                    jQuery.getScript(jQuery(this).attr('href'));
                }

                e.preventDefault();
                e.stopImmediatePropagation();
            });
        });

        // INPUT CALLBACK
        jQuery(this).find('.input-callback').each(function () {
            jQuery(this).change(function (e) {

                if ( jQuery(this).data('method')) {
                    jQuery.post(
                        jQuery(this).data('action'),
                        {_method: jQuery(this).data('method'), value : jQuery(this).val()},
                        function(a) {eval(a);}
                    );
                } else {
                    jQuery.getScript(jQuery(this).attr('href'));
                }

                e.preventDefault();
                e.stopImmediatePropagation();
            });
        });

        // SELECT 2
        if (jQuery.fn.select2 != undefined) {
            jQuery(this).find('.select2-remote').each(function () {
                jQuery(this).select2({
                    minimumInputLength: jQuery(this).data('length'),
                    ajax: {
                        url: jQuery(this).data('remote'),
                        dataType: 'json',
                        delay: 250,
                        data: function (term) {
                            return {
                                q: term // search term
                            };
                        },
                        results: function (d) {
                            return d;
                        }
                    },

                    containerCssClass: jQuery(this).data('css'),
                    formatResult: function (i) {
                        return i.text;
                    },
                    formatSelection: function (i) {
                        return i.text;
                    },

                    escapeMarkup: function (markup) {
                        return markup;
                    },

                    initSelection: function (element, callback) {
                        $.ajax(jQuery(element).data('remote') + '?id=' + jQuery(element).val(), {dataType: "json"})
                            .done(function (data) {
                                if (data.results[0]) {
                                    callback(data.results[0]);
                                }
                            });
                    },
                });
            });
        }


        // LIAISON SELECT
        jQuery('.select-remote').each(function(){
            var $that = $(this);
            selector = jQuery(this).data('parent-selector');
            jQuery(selector).change(function (e) {
                url = $that.data('parent-url') + '?value=' + jQuery(this).val();
                jQuery.getJSON(url, function(a) {
                    populate = $that.data('populate');
                    $that.empty();
                    jQuery.each(a, function(i, v) {
                        selected = '';
                        if(populate == i){selected = 'selected'}
                        $that.append(jQuery("<option "+selected+"/>").val(i).text(v));
                    });
                });
            }).change();
        });

        // UNIFORM
        if (jQuery.fn.uniform != undefined) {
            jQuery(this).find("input[type=checkbox]:not(.toggle, .make-switch), input[type=radio]:not(.toggle, .star, .make-switch)").each(function () {
                jQuery(this).uniform();
            });
        }

        // DATEPICKER
        if (jQuery.fn.datepicker != undefined) {
            jQuery(this).find('.date-picker').datepicker({
                autoclose: true
            });
            jQuery(this).find('.date-picker').each(function() {console.log(this);});
        }

        // TIMEPICKER
        if (jQuery.fn.timepicker != undefined) {
            jQuery(this).find(".timepicker-24").timepicker({
                autoclose: true,
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false
            });
        }

        // TOOLTIP
        if (jQuery.fn.tooltip != undefined) {

            jQuery('[data-toggle="tooltip"]').tooltip({container: 'body'});

            jQuery(this).find('.ff-tooltip-left').tooltip({
                container: 'body',
                placement: 'left'
            });

            jQuery(this).find('.ff-tooltip-bottom').tooltip({
                container: 'body',
                placement: 'left'
            });
        }

        // SWITCH
        if(jQuery.fn.bootstrapSwitch !== undefined){

            /**
             * Table Remote Boolean
             */
            jQuery(this).find('input[type=checkbox].ff-remote-boolean').bootstrapSwitch({
                onSwitchChange: function(event, state) {
                    event.preventDefault();
                    jQuery.post(jQuery(this).closest('.datatable-remote').DataTable().ajax.url(), {
                        id : jQuery(this).data('id'),
                        column : jQuery(this).data('column')
                    }, function(e,f) {eval(e)});
                }
            });

            jQuery(this).find('input[type=checkbox].make-switch:not(.ff-remote-boolean)').bootstrapSwitch();
        }


        /**
         * Table remote text
         */
        jQuery(this).find('div.ff-remote-text')
            .dblclick(function(e) {

                // if element is active, we disable action
                if (jQuery(this).hasClass('ff-remote-active')){
                    return jQuery(this);
                }

                // mark element as actiove
                jQuery(this).addClass('ff-remote-active');

                // hide span
                var _that = jQuery(this).find('span').hide();

                // input setting
                jQuery(this).find('input')
                    .on('ff.remote.text', function() {
                        // disable input
                        jQuery(this)
                            .off('focusout')
                            .off('ff.remote.text')
                            .off('ff.remote.process');
                        jQuery(this).hide().prev('span').show();
                        jQuery(this).parent('.ff-remote-active').removeClass('ff-remote-active');
                    })
                    .on('ff.remote.process', function() {
                        // process modifiction
                        e.preventDefault();
                        if (_that.html() != jQuery(this).val()) {
                            _that.html(jQuery(this).val());
                            jQuery.post(jQuery(this).closest('.datatable-remote').DataTable().ajax.url(), {
                                id : jQuery(this).data('id'),
                                column : jQuery(this).data('column'),
                                value : jQuery(this).val()
                            }, function(e,f) {eval(e)});
                        }
                        jQuery(this).trigger('ff.remote.text');
                        return false;
                    })
                    .val(_that.html()) // set value
                    .show()
                    .focus()
                    .focusout(function() {
                        jQuery(this).trigger('ff.remote.text');
                    }).keypress(function(e) {
                        // enable process on enter key
                        if(e.which == 13) {
                            jQuery(this).trigger('ff.remote.process');
                        }
                    });
        });

        // TABLE REMOTE SELECT
        jQuery(this).find('select.ff-remote-select').change(
            function(e) {

                e.preventDefault();
                e.stopImmediatePropagation();

                // if element is active, we disable action
                if (jQuery(this).hasClass('ff-remote-active')){
                    return jQuery(this);
                }

                // mark element as actiove
                jQuery(this).addClass('ff-remote-active');

                jQuery.post(jQuery(this).closest('.datatable-remote').DataTable().ajax.url(), {
                    id : jQuery(this).data('id'),
                    column : jQuery(this).data('column'),
                    value : jQuery(this).val()
                }, function(e,f) {eval(e)});
            }
        );

        //DATATABLE DECORATION
       jQuery(this).find('table.table > thead > tr:last-child').children().css('border-bottom', '1px solid #ddd');
    },

    /** Populate a form in javascript */
    populate : function(data) {

        // get the form
        var $form = $(this);

        // for each index we assigen value
        $.each(data, function(i, v) {
            e = $form.find('#' + i);

            // if only one item
            if (e.length == 1) {
                // case switch (boolean)
                if (e.hasClass('make-switch')) {
                    e.bootstrapSwitch('state', v);
                } else {
                    e.val(v);
                }
            }
        });
    },

    // add disabled class to elements
    disable: function(state) {
        return this.each(function() {
            $(this).addClass('disabled');
        });
    },

    // remove class disabled to element
    enable: function(state) {
        return this.each(function() {
            $(this).removeClass('disabled');
        });
    }

});