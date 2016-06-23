/**
 * gestion des filtres
 *
 *
 */
jQuery.fn.dataTableExt.oApi.fnFilterColumns = function (oSettings) {

    var _that = this;// on conserve l'objet principale

    this.each(function (i) {
        jQuery.fn.dataTableExt.iApiIndex = i;

        //Ajout des evenements
        jQuery(_that.selector + ' th select').each(function() {
            jQuery(this).change(function() {

                console.log($(this).attr('name'));
                jQuery.fn.dataTableExt.iApiIndex = i;
                _that.api().columns($(this).attr('name') + ':name').search($(this).val()).draw();
            });
        });

        // daterange
        jQuery(_that.selector + ' th > div.input-daterange.date-picker').each(function() {

            jQuery(this).datepicker().on('changeDate', function(e) {
                jQuery.fn.dataTableExt.iApiIndex = i;
                search = $($(this).find('input').get(0)).val() + '#' + $($(this).find('input').get(1)).val();
                _that.api().columns( $(this).attr('name') + ':name').search(search).draw();
            });

        });

        // input:text
        jQuery(_that.selector + ' th > input').each(function() {
            jQuery(this).unbind('keyup').unbind('keypress').bind('keypress', function (e) {
                if (e.which == 13) {
                    jQuery.fn.dataTableExt.iApiIndex = i;
                    _that.api().columns($(this).attr('name') + ':name').search($(this).val()).draw();
                }
            });
        });
    });
    return this;
};