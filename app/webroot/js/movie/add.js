var front = $.extend(base, {


    init: function () {

        var me = this;

        me._init();

        me.setEvents();

    },

    setEvents: function() {

        var me = this;

        $('#add').bind('click', function() {
            $('form').submit();
            return false;
        });


    }

});

$(document).ready(function() {

    front.init();

});