var front = $.extend({


    init: function () {

        var me = this;

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