<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => '/users/store','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create User</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('user_name', 'User Name') !!}
                        {!! Form::text('user_name',null, ['class' => 'form-control','placeholder'=>'user name']) !!}
                    </div>

                    <div class="col-sm-6">
                        {!! Form::label('user_full_name', 'Name') !!}
                        {!! Form::text('user_full_name',null, ['class' => 'form-control','placeholder'=>'user full name']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email',null, ['class' => 'form-control','placeholder'=>'email']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('password', 'Password') !!}
                        {!! Form::password('password', ['class' => 'form-control','placeholder'=>'password']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('password_confirmation', 'Confirm Password') !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control','placeholder'=>'confirm password']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('department', 'Department') !!}
                        {!! Form::select('department', $departments, null, ['class' =>'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('positions', 'Position') !!}
                        {!! Form::select('positions',$positions ,null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('role', 'Role') !!}
                        {!! Form::select('role', $roles, null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('branch', 'Branches') !!}
                        {!! Form::select('branch', $branches ,null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="margin-top-30px">
                    {!! Form::button('Save', ['id'=>'save','class' => 'btn btn-primary btn-sm']) !!}
                    {!! Form::button('Cancel',['id'=>'cancel','class' => 'btn btn-danger btn-sm']) !!}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery('#myModal').modal('show');
    // Insert user message
    var app = new App();
    jQuery('#save').on('click', function () {
        var username = jQuery('#user_name').val();
        var user_full_name  = jQuery('#user_full_name').val();
        var email = jQuery('#email').val();
        var password = jQuery('#password').val();
        var password_confirmation = jQuery('#password_confirmation').val();
        var department = jQuery('#department').val();
        var positions = jQuery('#positions').val();
        var role = jQuery('#role').val();
        var branch = jQuery('#branch').val();
        app.insert('/api/user/insert-user', {
            user_full_name: user_full_name,
            user_name: username,
            email: email,
            password: password,
            password_confirmation: password_confirmation,
            department: department,
            positions: positions,
            role: role,
            branch: branch
        }, '#modal-message');
    });
</script>
