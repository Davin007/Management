<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => '/roles/store','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create Role</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                {!!Form::label('role_name', 'Role') !!}
                {!! Form::text('role_name',null, ['class' =>'form-control']) !!}
                {!!Form::label('description', 'Description') !!}
                {!! Form::textarea('description',null, ['class' =>'form-control']) !!}
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
        var role_name = jQuery('#role_name').val();
        var description = jQuery('#description').val();
        app.insert('/api/role/create-role',{role_name: role_name,description: description},'#modal-message');
    })
</script>