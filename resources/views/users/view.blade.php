<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">User Detail</h4>
            </div>
            {!! Form::open() !!}
                <div class="modal-body">
                   <div class="row">
                       {!! Form::hidden('id', $user->user_id) !!}
                       <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                           <div class="text-center">
                               <img src=" @if(file_exists('upload/' . $user->thumbnail)) /upload/{{$user->thumbnail}} @else /upload/default.jpg @endif" id="thumbnail" class="img-thumbnail" alt="avatar">
                           </div>
                       </div>
                       <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                           {!! Form::label('full_name', 'Name') !!}
                           {!! Form::text('full_name', $user->user_full_name, ['class' => 'form-control','disabled']) !!}
                           {!! Form::label('email', 'Email') !!}
                           {!! Form::email('email', $user->email, ['class' => 'form-control','disabled']) !!}
                           {!! Form::label('department', 'Department') !!}
                           {!! Form::select('department', $user->departments, $user->department_id, ['class' =>'form-control','disabled']) !!}
                       </div>
                       <div class="col-sm-12">
                           {!! Form::label('position', 'Position') !!}
                           {!! Form::select('position', $user->positions, $user->position_id, ['class' => 'form-control','disabled']) !!}
                       </div>
                       <div class="col-sm-12">
                           {!! Form::label('role', 'Role') !!}
                           {!! Form::select('role', $user->roles, $user->role_id, ['class' => 'form-control','disabled']) !!}
                       </div>
                       <div class="col-sm-12">
                           {!! Form::label('branch', 'Branches') !!}
                           {!! Form::select('branch', $user->branchs, $user->branch_id, ['class' => 'form-control','disabled']) !!}
                       </div>
                   </div>
                </div>
                <div class="modal-footer">
                    {!! Form::button('Cancel',['id'=>'cancel','class' => 'btn btn-danger btn-sm']) !!}
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery('#myModal').modal('show');
</script>


