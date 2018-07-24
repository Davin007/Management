<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['url' => '/leave/store','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create Leave Request</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('leave_type', 'Leave Type') !!}
                        {!! Form::text('leave_type',null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('leave_duration', 'Leave Duration') !!}
                        {!! Form::text('leave_duration',null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-12">
                        {!! Form::label('leave_description', 'Description') !!}
                        {!! Form::textarea('leave_description',null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('assignee', 'Assignee') !!}
                        {!! Form::select('assignee',[] ,null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('department', 'Department') !!}
                        {!! Form::select('department',[] ,null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('start_date', 'Actual Start Date') !!}
                        {!! Form::date('start_date',null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('end_date', 'Actual End Date') !!}
                        {!! Form::date('end_date',null, ['class' => 'form-control']) !!}
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
        var leave_type = jQuery('#leave_type').val();
        var leave_duration  = jQuery('#leave_duration').val();
        var leave_description = jQuery('#leave_description').val();
        app.insert('/api/leave/create-leave', {
            leave_type: leave_type,
            leave_duration: leave_duration,
            leave_description: leave_description,
        }, '#modal-message');
    });
</script>
