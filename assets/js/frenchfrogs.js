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
                search: "Rechercher&nbsp;:",
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

            orderCellsTop: true,
            order : [],
            searching : false,
            ordering: true,
            pagingType: "bootstrap_extended", // pagination type(bootstrap, bootstrap_full_number or bootstrap_extended)
            autoWidth: false, // disable fixed width and enable fluid table
            processing: false, // enable/disable display message box on record load
            serverSide: false, // enable/disable server side ajax loading
        };

        return $(this).on('draw.dt', function(e) {$(this).initialize();}).dataTable($.extend(options, o)).fnFilterOnReturn().fnFilterColumns();
    },


    initialize : function() {
        console.log('initialize : ' + this.selector);

        // Activate Remote modal button
        jQuery(this).find('.modal-remote').each(function() {

            jQuery(this).click(function (e) {
                e.preventDefault();

                var target = jQuery(this).data('target');
                $url = jQuery(this).attr('href');

                if ( jQuery(this).data('method')) {
                    $data = {_method: jQuery(this).data('method')}
                }

                jQuery(target)
                    .find('.modal-content')
                    .empty()
                    .load($url, $data, function(){
                        jQuery(this).initialize();
                        jQuery(target).modal('show');
                    });
                e.stopImmediatePropagation();
            });
        });

        // Activate ajax form
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

        // Activate ajax form
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

        jQuery(this).find('.callback-remote').each(function () {
            jQuery(this).click(function (e) {

                if ( jQuery(this).data('method')) {
                    jQuery.post(
                        jQuery(this).attr('href'),
                        {_method: jQuery(this).data('method')},
                        function(a) {eval(a);}
                    );
                } else {
                    jQuery.getScript(jQuery(this).attr('href'));
                }

                e.preventDefault();
                e.stopImmediatePropagation();
            });
        });

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

        jQuery(this).find('.select2-remote').each(function () {
            jQuery(this).select2({
                ajax: {
                    url: jQuery(this).data('remote'),
                    dataType: 'json',
                    delay: 250,
                    data: function (term) {
                        return {
                            q: term // search term
                        };
                    },
                    results: function (d) {return d;}
                },

                minimumInputLength: jQuery(this).data('length'),
                containerCssClass : jQuery(this).data('css'),
                formatResult: function(i) {return i.text;},
                formatSelection: function(i) {return i.text;},

                escapeMarkup: function (markup) { return markup; },

                initSelection: function (element, callback) {
                    $.ajax(jQuery(element).data('remote') + '?id=' + jQuery(element).val() , {dataType: "json"})
                        .done(function(data) {
                            if (data.results[0]) {
                                callback(data.results[0]);
                            }
                        });
                },
            });
        });


        // Activate uniform checkbox
        jQuery(this).find("input[type=checkbox]:not(.toggle, .make-switch), input[type=radio]:not(.toggle, .star, .make-switch)").each(function() {
            jQuery(this).uniform();
        });

        jQuery(this).find('.date-picker').datepicker({
            autoclose: true
        });

        if(jQuery.fn.bootstrapSwitch !== undefined){jQuery(this).find('input[type=checkbox].make-switch').bootstrapSwitch();}

        // decoration datatable
        jQuery(this).find('table.table > thead > tr:last-child').children().css('border-bottom', '1px solid #ddd');
    }
});

