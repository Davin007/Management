@extends('layouts.app')
@section('title', 'Users')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6">
                    <h2>Position List</h2>
                </div>
                <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6 text-right">
                    <br>
                    <button type="button" class="btn btn-sm btn-primary  add-position">
                        <i id="icon" class="fa fa-lg fa-plus-circle  pointer"></i><span> Create New</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p class="text-center loading">Loading...</p>
            <table class="display hidden" cellpadding="100%" cellspacing="0" id="position-list">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Position Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
            jQuery('#position-list').removeClass('hidden');
            var info = [
                {'data': 'id'},
                {'data': 'position_title'},
                {'data': 'position_description'},
                {'data': 'action'}
            ];

            app.DataTableHelper('#position-list', '/api/position/list', info);
            app.getEdit('.edit-position', 'api/position/get-edit-position');
            app.getAdd('.add-position','api/position/get-add-position');
            app.closeModal('#cancel', '#myModal', '#myModal form');
            app.delete('.delete-position', 'api/position/delete');
        });
    </script>

@endsection