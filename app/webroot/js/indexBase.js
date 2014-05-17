var base = $.extend({}, {

    /**
     * 初期処理 各小クラスで呼び出し
     * @private
     */
    _init: function () {

        var me = this;

        me.setCommonEvents();

    },

    /**
     * 共通のイベント設定
     */
    setCommonEvents: function() {

        var me = this;

        $('#search').bind('click', function () {
            $('form').submit();
            return false;
        });

        // enterで検索
        $(document).bind('keydown', function (e) {
            var keyCode = e.keyCode;
            if (keyCode == 13) {
                $('#search').trigger('click');
            }
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