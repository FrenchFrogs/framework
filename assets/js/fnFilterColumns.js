/**
 * Tri le tableau en focntion des valeur dans les strainer
 *
 * @param oSettings
 * @returns {jQuery.fn.dataTableExt.oApi}
 */
jQuery.fn.dataTableExt.oApi.fnStrainer = function (oSettings) {

    var _that = this;// on conserve l'objet principale

    this.each(function (i) {
        jQuery.fn.dataTableExt.iApiIndex = i;

        //Ajout des evenements
        jQuery(_that.selector + ' th select').each(function() {
            _that.api().columns($(this).attr('name') + ':name').search($(this).val());
        });

        // daterange
        jQuery(_that.selector + ' th > div.input-daterange.date-picker').each(function() {
            search = $($(this).find('input').get(0)).val() + '#' + $($(this).find('input').get(1)).val();
            _that.api().columns( $(this).attr('name') + ':name').search(search);
        });

        // input:text
        jQuery(_that.selector + ' th > input').each(function() {
            _that.api().columns($(this).attr('name') + ':name').search($(this).val());
        });

        // jQuery.fn.dataTableExt.iApiIndex = i;
        _that.api().draw();
    });
    return this;
};


/**
 * Assignation des evenement de filtre sur les strainer
 *
 * @param oSettings
 * @returns {jQuery.fn.dataTableExt.oApi}
 */
jQuery.fn.dataTableExt.oApi.fnFilterColumns = function (oSettings) {

    var _that = this;// on conserve l'objet principale

    this.each(function (i) {
        jQuery.fn.dataTableExt.iApiIndex = i;

        //Ajout des evenements
        jQuery(_that.selector + ' th select').each(function() {
            jQuery(this).change(function() {
                _that.fnStrainer();
            });
        });

        // daterange
        jQuery(_that.selector + ' th > div.input-daterange.date-picker').each(function() {

            jQuery(this).datepicker().on('changeDate', function(e) {
                _that.fnStrainer();
            });

        });

        // input:text
        jQuery(_that.selector + ' th > input').each(function() {
            jQuery(this).unbind('keyup').unbind('keypress').bind('keypress', function (e) {
                if (e.which == 13) {
                    _that.fnStrainer();
                }
            });
        });
    });
    return this;
};

/**
 * Clear des strainers
 *
 * @param oSettings
 * @returns {jQuery.fn.dataTableExt.oApi}
 */
jQuery.fn.dataTableExt.oApi.fnClearFilters = function (oSettings) {

    var _that = this;// on conserve l'objet principale

    this.each(function (i) {
        jQuery.fn.dataTableExt.iApiIndex = i;

        //Ajout des evenements
        jQuery(_that.selector + ' th select').each(function() {
            $(this).val('');
        });

        // daterange
        jQuery(_that.selector + ' th > div.input-daterange.date-picker').each(function() {
            $(this).find('input').val('');
        });

        // input:text
        jQuery(_that.selector + ' th > input').each(function() {
            $(this).val('');
        });

        _that.fnStrainer();
    });
    return this;
};