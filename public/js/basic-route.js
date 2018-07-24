var app = function () {
    var url, type, data, callback;
};

app.prototype.changeRoute = function (tag, target, template) {

    port = window.location.port;
    port = (port != '') ? ':' + port : '';
    app.url = window.location.protocol + '//' + window.location.hostname + port + '/' + template;
    app.type = 'GET';
    app.callback = function (e) {
        jQuery('.content').html(e);
        window.history.pushState({}, "", app.url);
    };

    app.sendAjax(this);
};

app.prototype.changeStaticRouter = function (tag, target, template) {
    jQuery(target).html(template);
    app.url = app.prototype.getFullDomainName() + template;
    window.history.pushState({"html": template}, "", app.url);
};

app.prototype.sendAjax = function () {
    return jQuery.ajax({
        type: app.type,
        url: app.url,
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        success: app.callback
    });
};
