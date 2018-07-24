var App = function() {
    this.city = 'CITY';
    this.district = 'DISTRICT';
    this.commune = 'COMMUNE';
    this.village = 'VILLAGE';
};

/**
 *
 * @param tag
 * @param url
 * @param data
 * @constructor
 */
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
                swal({
                    title: '',
                    text: 'Not ready to load!',
                    timer: 2000
                }).then(
                    function () {},
                    // handling the promise rejection
                    function (dismiss) {
                        if (dismiss === 'timer') {
                            console.log('Not ready to load!')
                        }
                    }
                )
            }
        },
        'columns': data
    });
};

/**
 * edit popup
 *
 * @param tag
 * @param url
 */
App.prototype.getEdit = function(tag, url) {
    jQuery('document, body').on('click', tag, function () {
        var id = jQuery(this).attr('id');
        var param = [];
        param['url'] = url;
        param['type'] = 'POST';
        param['data'] = {id: id};
        param['headers'] = {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        };

        param['success'] = function (template) {
            jQuery('.modal-template').html(template);
        };

        App.prototype.sendRequest(param);
    });
};

/**
 * view detail
 * 
 * @param tag
 * @param url
 */
App.prototype.getView = function (tag, url) {
    jQuery('document, body').on('click', tag, function () {
        var id = jQuery(this).attr('id');
        var param = [];
        param['url'] = url;
        param['type'] = 'POST';
        param['data'] = {id:id};
        param['headers'] = {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        };

        param['success'] = function (template) {
            jQuery('.modal-template').html(template);
        };

        App.prototype.sendRequest(param);
    });
};

/**
 * app call to update profile info
 * @param tag
 * @param url
 */
App.prototype.editProfile = function (tag, url) {
    jQuery('document, body').on('click', tag, function () {
       var id = jQuery(this).find('a').attr('id');
       var param = [];
       param['url'] = url;
       param['type'] = 'POST';
       param['data'] = {id: id};
       param['headers'] = {
           'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
       };

       param['success'] = function (template) {
           jQuery('.modal-template').html(template);
       };

       App.prototype.sendRequest(param);
    });
};

/**
 * change password in profile form
 *
 * @param tag
 * @param url
 */
App.prototype.passworeProfile = function (tag, url) {
        jQuery('document, body').on('click', tag, function () {
            var id = jQuery(this).find('a').attr('id');
            var param = [];
            param['url'] = url;
            param['type'] = 'POST';
            param['data'] = {id: id};
            param['headers'] = {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            };

            param['success'] = function (template) {
                jQuery('.modal-template').html(template);
            };

            App.prototype.sendRequest(param);
        });
};

/**
 * Add popup modal
 *
 * @param tag
 * @param url
 */
App.prototype.getAdd = function(tag, url) {
    jQuery('document, body').on('click', tag, function () {
        var param = [];
        param['url'] = url;
        param['type'] = 'POST';
        param['headers'] = {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        };

        param['success'] = function (template) {
            jQuery('.modal-template').html(template);
        };

        App.prototype.sendRequest(param);
    });
};

/**
 * for show popup helper of delete
 *
 * @param tag
 * @param url
 */
App.prototype.resetPassword = function (tag,url) {
    jQuery('document, body').on('click',tag, function () {
       var id = jQuery(this).attr('id');
       var param = [];
       param['url'] = url;
       param['type'] = 'POST';
       param['data'] = {id: id};
       param['headers'] = {
           'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
       };

       param['success'] = function (template) {
           jQuery('.modal-template').html(template);
       };
       App.prototype.sendRequest(param);
    });
};

/**
 *
 * @param param
 */
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
};

/**
 *
 * for delete popup
 * @param tag
 * @param url
 */
App.prototype.delete = function (tag, url) {
    jQuery('document, body').on('click', tag, function () {
        var id = jQuery(this).attr('id');
        swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dd6b55",
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
};

/**
 * @param tag
 * @param target
 * @param formName
 */
App.prototype.closeModal = function (tag, target, formName) {
    jQuery('document, body').on('click', tag, function () {
        jQuery(target).modal('hide');
    });
};

/**
 *
 * @param tag
 * @param url
 * @param data
 */
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
                swal({
                    title: '',
                    text: 'Not yet to load data!',
                    timer: 2000
                }).then(
                    function () {},
                    // handling the promise rejection
                    function (dismiss) {
                        if (dismiss === 'timer') {
                            console.log('Not yet to load data!')
                        }
                    }
                )
            }
        },
        'columns': data
    });
};

/**
 *
 * @param tag
 * @param url
 * @param template
 * @param target
 */
App.prototype.getLocation = function (tag, url, template, target) {

    jQuery('body, document').on('change', tag, function () {
        var val = jQuery(this).val();
        var param = [];
        param['url'] = url;
        param['data'] = {id: val, template: template};
        param['type'] = 'POST';
        param['headers'] = {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        };

        param['success'] = function (e) {
            jQuery(target).html(e);
        };

        App.prototype.sendRequest(param);
    });
};

/**
 *
 * @param url
 * @param data
 * @param target
 */
App.prototype.insert = function (url, data, target) {
    var param = [];
    param['url'] = url;
    param['data'] = data;
    param['type'] = 'POST';
    param['headers'] = {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    };
    param['success'] = function (e) {
        if (typeof e.redirect != 'undefined' && e.redirect != '') {
            window.location.href = e.redirect;
        } else {
            jQuery(target).html(e);
        }
    };
    App.prototype.sendRequest(param)
};

/**
 * app for upload profile image
 *
 * @param tag
 * @param url
 */
App.prototype.uploadImage = function (tag, url) {
    jQuery(tag).on('click', function () {
        jQuery(this).change(function() {
            var file = this.files[0];
            if (file.size > 1048576) {
                swal({
                    title: '',
                    text: 'Your file greater than 1M!',
                    timer: 2000
                }).then(
                    function () {},
                    // handling the promise rejection
                    function (dismiss) {
                        if (dismiss === 'timer') {
                            console.log('Your file greater than 1M!')
                        }
                    }
                )
            }
            var form = new FormData(jQuery('#profile-form'));
            console.log(form)
            if (file.type == 'image/jpeg' || file.type === 'image/jpg' || file.type == 'image/png') {
                var param = [];
                param['type'] = 'POST';
                param['url'] = url;
                param['data'] = form;
                param['headers'] = {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                };
                param['success'] = function (e) {
                    var image = JSON.parse(e);
                    if (image.error == 1) {
                        swal({
                            title: '',
                            text: 'We look something wrong!',
                            timer: 2000
                        }).then(
                            function () {},
                            // handling the promise rejection
                            function (dismiss) {
                                if (dismiss === 'timer') {
                                    console.log('We look somethin wrong!')
                                }
                            }
                        )
                    } else {
                        jQuery('#thumbnail').removeAttr('src').attr('src', 'upload/' + image.file_name)
                    }
                };
                App.prototype.sendRequest(param);
            } else {
                swal({
                    title: '',
                    text: 'This file not an image allowed!',
                    timer: 2000
                }).then(
                    function () {},
                    // handling the promise rejection
                    function (dismiss) {
                        if (dismiss === 'timer') {
                            console.log('This file not an image allowed!')
                        }
                    }
                )
            }
        });
    });
};

App.prototype.checkAll = function (tag, target) {
    jQuery(tag).click(function () {
        if (jQuery(this).is(':checked')) {
            jQuery(target).prop('checked', true);
        } else {
            jQuery(target).prop('checked', false);
        }
    });
};




