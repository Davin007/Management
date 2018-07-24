<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => 'users/update','method'=>'post']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Update User</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('id', $user->user_id) !!}
                        <div class="col-sm-6">
                            {!! Form::label('full_name', 'Name') !!}
                            {!! Form::text('full_name', $user->user_full_name, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('department', 'Department') !!}
                            {!! Form::select('department', $user->departments, $user->department_id, ['class' =>'form-control']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('position', 'Position') !!}
                            {!! Form::select('position', $user->positions, $user->position_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('role', 'Role') !!}
                            {!! Form::select('role', $user->roles, $user->role_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('branch', 'Branches') !!}
                            {!! Form::select('branch', $user->branchs, $user->branch_id, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="margin-top-30px text-right">
                        {!! Form::submit('Save', ['id'=>'save','class' => 'btn btn-primary btn-sm']) !!}
                        {!! Form::button('Cancel',['id'=>'cancel','class' => 'btn btn-danger btn-sm']) !!}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery('#myModal').modal('show');
</script>


