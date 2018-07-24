<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => 'status/update','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Update Leave Status</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                {!! Form::hidden('id',$status->id) !!}
                {!! Form::label('status_title', 'Title') !!}
                {!! Form::text('status_title',$status->status_title, ['class' => 'form-control']) !!}
                {!! Form::label('status_description', 'Description') !!}
                {!! Form::textarea('status_description',$status->status_description, ['class' => 'form-control']) !!}
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
