<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => 'update/profile','method'=>'post', 'id' => 'profile-form']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Personal Information</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                        <div class="text-center">
                            @if(file_exists('upload/' . $user->thumbnail))
                                <img src="/upload/{{$user->thumbnail}}" id="thumbnail" class="img-thumbnail" alt="avatar">
                            @else
                                <img src="/defaultImage/default.jpg" id="thumbnail" class="img-thumbnail" alt="avatar">
                            @endif
                            {{Form::label('avatar', 'Upload Photo',['class' => 'control-label'])}}
                            {{Form::file('avatar')}}
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                        {!! Form::hidden('id', $user->user_id,['id' => 'id']) !!}
                        <div class="form-group">
                            <div class="col-lg-8">
                                {!! Form::label('user_full_name', 'Full Name') !!}
                                {!! Form::text('user_full_name',$user->user_full_name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-8">
                                {!! Form::label('old_password', 'Current Password') !!}
                                {!! Form::password('old_password', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-8">
                                {!! Form::label('new_password', 'New Password') !!}
                                {!! Form::password('new_password', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-8">
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
    jQuery('#save').on('click', function () {
        var avatar = jQuery('#avatar').val();
        var old_password = jQuery('#old_password').val();
        var user_full_name = jQuery('#user_full_name').val();
        var password = jQuery('#new_password').val();
        var confirm = jQuery('#password_confirm').val();
        var userId = jQuery('#id').val();
        app.insert('/api/profile/getProfile', {
            thumbnail: avatar,
            user_full_name: user_full_name,
            old_password: old_password,
            new_password: password,
            confirm: confirm,
            id: userId
        }, '#modal-message');
    });

    //app.uploadImage('#avatar', '/api/profile/upload');
    jQuery('#avatar').change(function(e) {
        e.preventDefault();
        var file = this.files[0];
        if (file.size > 1048576) {
            swal({
                title: '',
                text: 'File cannot be greater than 1 M!',
                timer: 2000
            }).then(
                function () {},
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                        console.log('I was closed by the timer')
                    }
                }
            )
        }

        var form = new FormData(jQuery('#profile-form')[0]);
        if (file.type == 'image/jpeg' || file.type === 'image/jpg' || file.type == 'image/png') {
            // Loading
            jQuery.ajax({
                type: 'post',
                url: 'api/profile/upload',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                success: function (e) {
                    var image = JSON.parse(e);
                    if (image.error == 1) {
                        swal({
                            title: '',
                            text: 'We look something wrong!',
                            timer: 2000
                        }).then(
                            function () {},
                            // handling the promise rejection
                            function (dismiss) {
                                if (dismiss === 'timer') {
                                    console.log('We look something wrong!')
                                }
                            }
                        )
                    } else {
                        jQuery('#thumbnail, #' + image.user_id).removeAttr('src').attr('src', 'upload/' + image.file_name)
                    }
                },
                error: function () {
                    swal({
                        title: '',
                        text: 'We look something wrong!',
                        timer: 2000
                    }).then(
                        function () {},
                        // handling the promise rejection
                        function (dismiss) {
                            if (dismiss === 'timer') {
                                console.log('We look something wrong!')
                            }
                        }
                    )
                }
            });
        } else {
            swal({
                title: '',
                text: 'File is not an image that we allowed!',
                timer: 2000
            }).then(
                function () {},
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                        console.log('File is not an image that we allowed!')
                    }
                }
            )
        }
    });
</script>
