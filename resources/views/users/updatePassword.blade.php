<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => 'users/update-password','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                <div class="row">
                    {!! Form::hidden('id', $user, ['id' => 'id']) !!}
                    <div class="col-sm-12">
                        {!! Form::label('password', 'New Password') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-12">
                        {!! Form::label('password_confirm', 'Password Confirm') !!}
                        {!! Form::password('password_confirm', ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="margin-top-30px text-right">
                    {!! Form::button('Change Password', ['id'=>'save','class' => 'btn btn-primary btn-sm']) !!}
                    {!! Form::button('Cancel',['id'=>'cancel','class' => 'btn btn-danger btn-sm']) !!}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery('#myModal').modal('show');
    //update password
    var app = new App();
    jQuery('#save').on('click',function () {
        var password = jQuery('#password').val();
        var confirm = jQuery('#password_confirm').val();
        var userId = jQuery('#id').val();
        app.insert('/api/password/updatePassword',{
            password: password,
            confirm: confirm,
            id: userId
        },'#modal-message');
    });
</script>


