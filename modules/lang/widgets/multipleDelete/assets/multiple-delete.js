var MultipleDelete = function () {

    return {
        //main function to initiate the module
        init: function () {
            $('button.multiple-delete').click(function (e) {
                $el = $(this);
                var gridId = $el.data('gridid');
                if (gridId) {
                    var ids = $('#' + gridId).yiiGridView('getSelectedRows');
                    if (ids.length > 0) {
                        var deleteconfirm = $el.data('deleteconfirm');
                        var url = $el.data('url');
                        swal({
                            title: deleteconfirm,
                            text: '',
                            type: 'error',
                            allowOutsideClick: true,
                            showConfirmButton: true,
                            showCancelButton: true,
                            confirmButtonClass: 'btn m-btn--pill m-btn--air btn-danger',
                            cancelButtonClass: 'btn m-btn--pill m-btn--air btn-success',
                            confirmButtonText: 'Да',
                            cancelButtonText: 'Нет',
                            dangerMode: true
                        }).then(function (result) {
                            if (result.value) {
                                var form = $('<form action=' + url + ' method=\"POST\"></form>'),
                                    csrfParam = $('meta[name=csrf-param]').prop('content'),
                                    csrfToken = $('meta[name=csrf-token]').prop('content');

                                if (csrfParam) {
                                    form.append('<input type=\"hidden\" name=' + csrfParam + ' value=' + csrfToken + ' />');
                                }
                                $.each(ids, function (index, id) {
                                    form.append('<input type=\"hidden\" name=\"ids[]\" value=' + id + ' />');
                                });
                                form.hide().appendTo('body');
                                form.submit();
                            }
                        });

                    }
                }
            });
        }
    }
}();

jQuery(document).ready(function () {
    MultipleDelete.init();
});