var front = $.extend(base, {

    file: undefined,

    globalErrMsgSelector: '.global-error-message',

    flashMsgId: '#flashMessage',

    errorMsgSelector: '.error-message',

    init: function () {

        var me = this;

        me._init();

        me.setEvents();

    },

    setEvents: function() {

        var me = this;

        $(document).bind('drop dragover', function (e) {
            // Prevent the default browser drop action:
            e.preventDefault();
        });

        $("#progress-bar").progressbar();

        $('#fileupload').fileupload({
            url: $('form').attr('action'),
            autoUpload: false,
            uploadTemplateId: false,
            downloadTemplateId: false,
            add: _.bind(me._onAdd, me),
            progressall: _.bind(me._onProgressAll, me),
            done: _.bind(me._onDone, me),
            fail: _.bind(me._onFail, me)
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');


        $('#add').bind('click', function() {
            //$('form').submit();

            $(me.globalErrMsgSelector).hide();
            $(me.errorMsgSelector).hide();

            if (me.file) {
                $("#fileupload").fileupload('send', {files: [me.file]});
            }

            return false;
        });


    },

    _onAdd: function (e, data) {

        var me = this;

        me.file = data.files[0];

        $('.filename').text(me.file.name);

        $('#title').val(me._getFileNameWithoutExt(me.file));
    },

    _onProgressAll: function(e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $("#progress-bar").progressbar("option", "value", progress);
    },

    _onDone: function(e, data) {
        var me = this,
            res = data._response,
            result = res.result,
            errors;

        if (result) {
            if (result.success) {
                location.href = '/movies/'
            } else {
                errors = result.errors;
                me._showErrorMessage(errors);
            }

        }
    },

    _onFail: function(e, data) {
        alert('アップロードに失敗しました。');
    },

    _showErrorMessage: function (errors) {

        var me = this,
            msg, selector,
            globalMsg = 'エラーがあります。';

        if (errors) {

            if (errors.hasOwnProperty('title')) {
                selector = me.errorMsgSelector + '.title';
                msg = errors['title'][0];
                $(selector).text(msg).show();
                $(me.flashMsgId).text(globalMsg);
            }

            if (errors.hasOwnProperty('file')) {
                selector = me.errorMsgSelector + '.file';
                msg = errors['file'][0];
                $(selector).text(msg).show();
                $(me.flashMsgId).text(globalMsg);
            }

            if (errors.hasOwnProperty('cast')) {
                selector = me.errorMsgSelector + '.cast';
                msg = errors['cast'][0];
                $(selector).text(msg).show();
                $(me.flashMsgId).text(globalMsg);
            }

            if (errors.hasOwnProperty('tag')) {
                selector = me.errorMsgSelector + '.tag';
                msg = errors['tag'][0];
                $(selector).text(msg).show();
                $(me.flashMsgId).text(globalMsg);
            }

            if (errors.hasOwnProperty('other')) {
                msg = errors['other'][0];
                $(me.flashMsgId).text(msg);
            }
        }

        $(me.globalErrMsgSelector).show();
    },

    _getFileNameWithoutExt: function(file) {
        var me = this,
            spritData, result = '';

        if (file) {
            spritData = file.name.split('.');
            if (spritData[0]) {
                result = spritData[0];
            }
        }
        return result;
    }

});

$(document).ready(function() {

    front.init();

});