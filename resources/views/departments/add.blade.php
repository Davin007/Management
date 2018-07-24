<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => '/department/store','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create Department</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                {!!Form:: label('department_name', 'Department') !!}
                {!! Form:: text('department_name',null, ['class' =>'form-control']) !!}
                {!!Form:: label('description', 'Description') !!}
                {!! Form::textarea('description',null, ['class' =>'form-control']) !!}
            </div>
            <div class="modal-footer">
                <div class="margin-top-30px">
                    {!! Form::button('Save', ['id' => 'save','class' => 'btn btn-primary btn-sm']) !!}
                    {!! Form::button('Cancel',['id'=>'cancel','class' => 'btn btn-danger btn-sm']) !!}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery('#myModal').modal('show');
    // Insert department
    var app = new App();
    jQuery('#save').on('click', function () {
        var departmentName = jQuery('#department_name').val();
        var description  = jQuery('#description').val();
        app.insert('/api/department/create', {department_name: departmentName, description: description}, '#modal-message');
    });
</script>
