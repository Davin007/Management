<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => '/update/profilePassword','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Update Password</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                <div class="row">
                    <div class="col-md-12 col-sm-6 col-xs-12">
                        {!! Form::hidden('id', $user->user_id,['id' => 'id']) !!}
                        <div class="form-group">
                            <div class="col-lg-12">
                                {!! Form::label('old_password', 'Current Password') !!}
                                {!! Form::password('old_password', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                {!! Form::label('new_password', 'New Password') !!}
                                {!! Form::password('new_password', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                {!! Form::label('password_confirm', 'Password Confirm') !!}
                                {!! Form::password('password_confirm', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="margin-top-30px text-right">
                    {!! Form::button('Save Change', ['id'=>'save','class' => 'btn btn-primary btn-sm']) !!}
                    {!! Form::button('Cancel',['id'=>'cancel','class' => 'btn btn-danger btn-sm']) !!}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery('#myModal').modal('show');
    //edit profile information
    var app = new App();
    jQuery('#save').on('click',function () {
        var old_password = jQuery('#old_password').val();
        var password = jQuery('#new_password').val();
        var confirm = jQuery('#password_confirm').val();
        var userId = jQuery('#id').val();
        app.insert('/api/password/updateProfilePassword',{
            old_password: old_password,
            new_password: password,
            confirm: confirm,
            id: userId
        },'#modal-message');
    });
</script>
