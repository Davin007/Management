@extends('layouts.app')
@section('title', 'Leave Status')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading" style="">
            <div class="row">
                <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6">
                    <h2>Leave Status</h2>
                </div>
                <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6 text-right">
                    <br>
                    <button type="button" class="btn btn-sm btn-primary  add-status">
                        <i id="icon" class="fa fa-lg fa-plus-circle pointer"></i><span> Create New</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p class="text-center loading">Loading...</p>
            <div class="row">
                <div class="col-sm-12">
                    <table class="display hidden" cellpadding="100%" cellspacing="0" id="status-list">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
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
            jQuery('#status-list').removeClass('hidden');
            var info = [
                {'data': 'id'},
                {'data': 'status_title'},
                {'data': 'status_description'},
                {'data': 'action'}
            ];

            app.DataTableHelper('#status-list','api/status/list', info);
            app.getAdd('.add-status','api/status/get-status');
            app.closeModal('#cancel','#myModal', '#myModal form');
            app.getEdit('.edit-status','api/status/get-edit-status');
            app.delete('.delete-status','api/status/get-delete');
        });
    </script>

@endsection