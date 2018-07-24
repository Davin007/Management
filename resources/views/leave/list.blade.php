@extends('layouts.app')
@section('title', 'Leave Request')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading" style="">
            <div class="row">
                <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6">
                    <h2>Leave Request</h2>
                </div>
                <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6 text-right">
                    <br>
                    <button type="button" class="btn btn-sm btn-primary  add-leave">
                        <i id="icon" class="fa fa-lg fa-plus-circle pointer"></i><span> Create New</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p class="text-center loading">Loading...</p>
            <div class="row">
                <div class="col-sm-12">
                    <table class="display hidden" cellpadding="100%" cellspacing="0" id="leave-list">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Reason</th>
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
            jQuery('#leave-list').removeClass('hidden');
            var info = [
                {'data': 'id'},
                {'data': 'leave_type'},
                {'data': 'leave_duration'},
                {'data': 'leave_description'},
                {'data': 'action'}
            ];

            app.DataTableHelper('#leave-list','api/leave/list', info);
            app.getAdd('.add-leave','/api/leave/get-add-leave');
            app.getEdit('.edit-leave','/api/leave/get-edit-leave');
            app.delete('.delete-leave','/api/leave/get-delete');
            app.closeModal('#cancel','#myModal', '#myModal form');
        });
    </script>

@endsection