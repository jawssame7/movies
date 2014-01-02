var base = $.extend({

    casts: undefined,

    tags: undefined,

    castSelector: '#cast',

    castMenuSelector: '#cast-menu',

    tagSelector: '#tag',

    tagMenuSelector: '#tag-menu',

    _init: function () {

        var me = this,
            castsDataEl = $('#casts'),
            tagsDataEl = $('#tags');

        me.casts = $.parseJSON(castsDataEl.html());

        me.tags = $.parseJSON(tagsDataEl.html());

        me.setCommonEvents();

    },

    setCommonEvents: function() {

        var me = this;

        me.bindAutoComplete(me.castSelector, me.casts);

        me.bindAutoComplete(me.tagSelector, me.tags);

        $(me.castSelector).bind('focus', function() {
            $(me.tagSelector).autocomplete('close');
        });

        $(me.tagSelector).bind('focus', function() {
            $(me.castSelector).autocomplete('close');
        });

        $(me.castMenuSelector).bind('click', function () {

            $(me.tagSelector).autocomplete('close');

            if ($(me.castSelector).attr('menu-open') == 'true') {
                $(me.castSelector).autocomplete('close');
            } else {
                $(me.castSelector).autocomplete('search', '');
            }

            return false;
        });

        $(me.tagMenuSelector).bind('click', function () {

            $(me.castSelector).autocomplete('close');

            if ($(me.tagSelector).attr('menu-open') == 'true') {
                $(me.tagSelector).autocomplete('close');
            } else {
                $(me.tagSelector).autocomplete('search', '');
            }

            return false;
        });

    },

    bindAutoComplete: function (target, source) {

        var me = this;

        $(target).bind("keydown", function(event) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                 $(this).data("uiAutocomplete").menu.active) {
                event.preventDefault();
            }
        }).bind('blur', function () {
                $(target).autocomplete('close');
            }).autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // delegate back to autocomplete, but extract the last term
                    response($.ui.autocomplete.filter(
                        source, me.extractLast(request.term)));
                },
                focus: function(event, ui) {

                    return false;
                },
                select: function(event, ui) {

                    var terms = me.split(this.value);
                    terms.pop();
                    terms.push(ui.item.value);
                    terms.push("");
                    this.value = terms.join( ", " );
                    return false;
                },
                open: function() {
                    $(this).attr('menu-open', true);
                },
                close: function () {
                    $(this).attr('menu-open', false);

                }
            }).data( "ui-autocomplete" )._renderItem = function(ul, item ) {
            return $( "<li>" )
                .append( "<a>" + item.value + "</a>" )
                .appendTo(ul);
        };
    },

    split: function(val) {
        return val.split( /,\s*/ );
    },

    extractLast: function(term) {
        return this.split(term).pop();
    }

});