<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => 'branch/update','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Update Branch</h4>
            </div>
            <div class="modal-body">
                {!! Form::hidden('id', $branches->id) !!}
                {!! Form::label('branch', 'Branch') !!}
                {!! Form::text('branch_title',$branches->branch_title, ['class' => 'form-control']) !!}
                {!! Form::label('description', 'Description') !!}
                {!! Form::textarea('description',$branches->description, ['class' => 'form-control']) !!}
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


