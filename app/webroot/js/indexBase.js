var base = $.extend({}, {


    _init: function () {

        var me = this;

        me.setCommonEvents();

    },

    setCommonEvents: function() {

        var me = this;

        $('#search').bind('click', function () {
            $('form').submit();
            return false;
        });

        $('.switch').bind('click', function() {
            var id = $(this).data('id');

            $('#modal-confirm a.ok').attr('data-id', id);

            return false;
        });

        $('#modal-confirm a.ok').bind('click', function() {

            var okEl = $(this),
                baseUrl = okEl.data('base-url'),
                id = okEl.data('id');

            location.href =baseUrl + '/' + id;

            return false;

        });

    }

});