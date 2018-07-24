@extends('layouts.app')
@section('title', 'Users')
@section('content')
        <div class="panel panel-default">
            <div class="panel-heading" style="">
                <div class="row">
                    <div class=" col col-sm-6 col-xs-6 col-md-6 col-lg-6">
                        <h2>User List</h2>
                    </div>
                    <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6 text-right">
                        <br>
                        <button type="button" class="btn btn-sm btn-primary  add-user">
                            <i id="icon" class="fa fa-lg fa-plus-circle pointer"></i><span> Create New</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <p class="text-center loading">Loading...</p>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="display hidden" cellpadding="100%" cellspacing="0" id="user-list">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <div class="modal-template"></div>
@endsection

@section('style')
    <link rel="stylesheet" href="css/sweetalert.css">
@endsection

@section('script')
    <script type="text/javascript" src="js/general.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var app = new App();
            jQuery('.loading').hide();
            jQuery('#user-list').removeClass('hidden');
            var info = [
                {'data': 'id'},
                {'data': 'user_name'},
                {'data': 'user_full_name'},
                {'data': 'email'},
                {'data': 'action'}
            ];

            app.DataTableHelper('#user-list','api/users/list', info);
            app.getEdit('.edit-user','api/users/get-edit-user');
            app.getAdd('.add-user','/api/users/get-add-user');
            app.closeModal('#cancel','#myModal', '#myModal form');
            app.delete('.delete-user','api/users/delete');
            app.resetPassword('.reset-password','api/users/reset-password');
            app.getEdit('.get-routes','api/users-route/get-route');
            app.getView('.get-view','api/users-view/get-view');
        });
    </script>

@endsection