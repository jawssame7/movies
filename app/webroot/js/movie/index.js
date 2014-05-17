var front = $.extend(base, {

    /**
     *
     */
    init: function () {

        var me = this;

        me._init();

        me.setEvents();

    },

    setEvents: function() {

        var me = this;

    }

});

$(document).ready(function() {

    front.init();

});