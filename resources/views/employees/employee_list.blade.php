@extends('layouts.app')
@section('title', 'Employee')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading" style="">
            <div class="row">
                <div class=" col col-sm-6 col-xs-6 col-md-6 col-lg-6">
                    <h2>Employee List</h2>
                </div>
                <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6 text-right">
                    <br>
                    <button type="button" class="btn btn-sm btn-primary add-employee">
                        <i id="icon" class="fa fa-lg fa-plus-circle pointer"></i><span> Create New</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p class="text-center loading">Loading...</p>
            <div class="row">
                <div class="col-sm-12">
                    <table class="display hidden" cellpadding="100%" cellspacing="0" id="employees-list">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Sex</th>
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
            jQuery('#employees-list').removeClass('hidden');
            var info = [
                {'data': 'id'},
                {'data': 'user_full_name'},
                {'data': 'sex'},
                {'data': 'email'},
                {'data': 'action'}
            ];

            app.DataTableHelper('#employees-list', 'api/employees/employee_list', info);
            app.getAdd('.add-employee','/api/employee/get-add-employee');
            app.getEdit('.edit-employee', 'api/employee/get-edit-employee');
            app.closeModal('#cancel', '#myModal', '#myModal form');
            app.delete('.delete-employee', 'api/employee/delete');
            app.getLocation('#city', '/api/location/get', 'city', '#district-block');
            app.getLocation('#district', '/api/location/get', 'district', '#commune-block');
            app.getLocation('#commune', '/api/location/get', 'commune', '#village-block');
            app.getView('.detail-employee','api/employee/detail');
        });
    </script>

@endsection