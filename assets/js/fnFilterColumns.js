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
                jQuery.fn.dataTableExt.iApiIndex = i;
                _that.api().columns($(this).attr('name') + ':name').search($(this).val()).draw();
            });
        });
        jQuery(_that.selector + ' th input').each(function() {
            jQuery(this).unbind('keyup').bind('keypress', function (e) {
                if (e.which == 13) {
                    jQuery.fn.dataTableExt.iApiIndex = i;
                    _that.api().columns($(this).attr('name') + ':name').search($(this).val()).draw();
                }
            });
        });
    });
    return this;
};