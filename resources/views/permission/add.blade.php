<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!Form::open(['url' => '/api/permission/create-permission','method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create Permission</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                {!! Form::label('controller','Permission') !!}
                {!! Form::text('controller',null,['class' => 'form-control']) !!}
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
    var app = new App();
    jQuery('#save').on('click',function () {
        var controller = jQuery('#controller').val();
        app.insert('/api/permission/create-permission', {
            controller: controller,
        },'#modal-message');
    });
</script>