@extends('layouts.app')
@section('title','Permission')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6">
                    <h2>Permission Control</h2>
                </div>
                <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6 text-right">
                    <br>
                    <button type="button" class="btn btn-sm btn-primary add-permission">
                        <i id="icon" class="fa fa-lg fa-plus-circle  pointer"></i><span> Create New</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p class="text-center loading">Loading...</p>
            <table class="display hidden" cellpadding="100%" cellspacing="0" id="permission">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Controller</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-template"></div>
@endsection()
@section('style')
    <link rel="stylesheet" href="css/sweetalert.css">
@endsection

@section('script')
    <script type="text/javascript" src="js/general.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var app = new App();
            jQuery('.loading').hide();
            jQuery('#permission').removeClass('hidden');
            var info = [
                {'data': 'id'},
                {'data': 'controller_id'},
                {'data': 'action'},
            ];
            app.DataTableHelper('#permission', '/api/permission/get-permission', info);
            app.getAdd('.add-permission','/api/permission/get-add-permission');
            app.getEdit('.edit-permission','/api/edit-permission/get-edit-permission');
            app.closeModal('#cancel', '#myModal', '#myModal form');
            app.delete('.delete-permission','/api/delete-permission/get-delete-permission');
        });
    </script>
@endsection