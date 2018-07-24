@extends('layouts.app')
@section('title', 'Village')
@section('content')
   <div class="panel panel-default">
      <div class="panel-heading">
         <div class="row">
            <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6">
               <h2>Villages List</h2>
            </div>
            <div class="col col-sm-6 col-xs-6 col-md-6 col-lg-6 text-right">
                <br>
               <button type="button" class="btn btn-sm btn-primary  add-village">
                   <i id="icon" class="fa fa-lg fa-plus-circle  pointer"></i><span> Create New</span>
                </button>
            </div>
         </div>
      </div>
      <div class="panel-body">
         <p class="text-center loading">Loading...</p>
         <table class="display hidden" cellpadding="100%" cellspacing="0" id="village-list">
            <thead>
            <tr>
               <th>ID</th>
               <th>Name</th>
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
           jQuery('#village-list').removeClass('hidden');
           var info = [
               {'data': 'id'},
               {'data': 'name'},
               {'data': 'action'}
           ];

           app.DataTableHelper('#village-list', '/api/village/list', info);
            app.getEdit('.edit-village', 'api/village/get-edit-village');
            app.getAdd('.add-village','api/village/get-add-village');
            app.closeModal('#cancel', '#myModal', '#myModal form');
            app.delete('.delete-village', 'api/village/delete');
       });
   </script>

@endsection