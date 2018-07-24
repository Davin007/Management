<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => 'leave/update','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Update Leave Reques</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                {!! Form::hidden('id',$leave->id) !!}
                {!! Form::label('leave_type', 'Leave Type') !!}
                {!! Form::text('leave_type',$leave->leave_type, ['class' => 'form-control']) !!}
                {!! Form::label('leave_duration', 'Leave Duration') !!}
                {!! Form::text('leave_duration',$leave->leave_total_duration, ['class' => 'form-control']) !!}
                {!! Form::label('leave_description', 'Description') !!}
                {!! Form::textarea('leave_description',$leave->leave_description, ['class' => 'form-control']) !!}
            </div>
            <div class="modal-footer">
                <div class="margin-top-30px">
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
