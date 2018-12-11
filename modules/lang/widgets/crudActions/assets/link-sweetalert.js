var LinkSweetAlert = function () {

    return {
        //main function to initiate the module
        init: function () {
            $('a.link-sweetalert').each(function(){
                var sa_title = $(this).data('title');
                var sa_message = $(this).data('message');
                var sa_type = $(this).data('type');
                var sa_allowOutsideClick = $(this).data('allow-outside-click');
                var sa_showConfirmButton = $(this).data('show-confirm-button');
                var sa_showCancelButton = $(this).data('show-cancel-button');
                var sa_closeOnConfirm = $(this).data('close-on-confirm');
                var sa_closeOnCancel = $(this).data('close-on-cancel');
                var sa_confirmButtonText = $(this).data('confirm-button-text');
                var sa_cancelButtonText = $(this).data('cancel-button-text');
                var sa_confirmButtonClass = $(this).data('confirm-button-class');
                var sa_cancelButtonClass = $(this).data('cancel-button-class');

                $(this).click(function(e){
                    $el = $(this);
                    e.preventDefault(); // Prevent the href from redirecting directly
                    swal({
                        title: sa_title,
                        text: sa_message,
                        type: sa_type,
                        allowOutsideClick: sa_allowOutsideClick,
                        showConfirmButton: sa_showConfirmButton,
                        showCancelButton: sa_showCancelButton,
                        confirmButtonClass: sa_confirmButtonClass,
                        cancelButtonClass: sa_cancelButtonClass,
                        closeOnConfirm: sa_closeOnConfirm,
                        closeOnCancel: sa_closeOnCancel,
                        confirmButtonText: sa_confirmButtonText,
                        cancelButtonText: sa_cancelButtonText,
                        dangerMode: true
                    }).then(function (result) {
                        if(result.value) {
                            LinkSweetAlert.handleAction($el);
                        }
                    });
                    return false;
                });
            });

        },
        handleAction: function($e) {
            var method = $e.data('method'),
                action = $e.attr('href'),
                params = $e.data('params');

            if (method === undefined && action) {
                window.location = action;
            }
            if (method.search(/post/i) !== -1){
                $form = $('<form/>', {method: method, action: action});
                var target = $e.attr('target');
                if (target) {
                    $form.attr('target', target);
                }
                var csrfParam = yii.getCsrfParam();
                if (csrfParam) {
                    $form.append($('<input/>', {name: csrfParam, value: yii.getCsrfToken(), type: 'hidden'}));
                }
                $form.hide().appendTo('body');

                var gridId = $e.data('gridid');
                if (gridId) {
                    var selRows = $('#'+gridId).yiiGridView('getSelectedRows');
                    if(params === undefined)
                        params = {gridIds:selRows};
                    else
                        params['gridIds'] = selRows;
                }

                if (params && $.isPlainObject(params)) {
                    $.each(params, function (idx, obj) {
                        $form.append($('<input/>').attr({name: idx, value: obj, type: 'hidden'}));
                    });
                }
                $form.trigger('submit');
            }
        }
    }

}();

jQuery(document).ready(function() {
    LinkSweetAlert.init();
});