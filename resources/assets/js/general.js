var App = function() {}

App.prototype.DataTableHelper = function (tag, url, data) {
    jQuery(tag).DataTable({
        'processing': true,
        'serverSide': true,
        'ajax': {
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            error: function () {
                alert('Not ready to load');
            }
        },
        'columns': data
    });
}


App.prototype.getEdit = function(tag, url) {
    jQuery('document, body').on('click', tag, function () {
        var id = jQuery(this).attr('id');
        var param = [];
        param['url'] = url;
        param['type'] = 'POST';
        param['data'] = {id: id};
        param['headers'] = {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }

        param['success'] = function (template) {
            jQuery('.modal-template').html(template);
        }

        App.prototype.sendRequest(param);
    });
}

App.prototype.sendRequest = function (param) {
    jQuery.ajax({
        url: param['url'],
        type: param['type'],
        data: param['data'],
        headers: param['headers'],
        success: param['success'],
        error: param['error'],
        complete: param['complete']
    });
}

App.prototype.delete = function (tag, url) {
    jQuery('document, body').on('click', tag, function () {
        var id = jQuery(this).attr('id');
        swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true
            },
            function() {
                var param = {
                    url: url,
                    type: 'POST',
                    data: {id: id},
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        jQuery('#' + id).closest('tr').remove();
                    }
                };

                App.prototype.sendRequest(param);
            });
    });
}

App.prototype.closeModal = function (tag, target, formName) {
    jQuery('document, body').on('click', tag, function () {
        jQuery(target).modal('hide');
    });
}
App.prototype.getUserInfo = function (tag,url,data) {
    jQuery(tag).DataTable({
        'processing': true,
        'serverSide': true,
        'ajax': {
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            error: function () {
                alert('Not ready to load');
            }
        },
        'columns': data
    });
}


