<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => '/update','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Update Commune</h4>
            </div>
            <div class="modal-body">
                {!! Form::hidden('id', $commune->id) !!}
                {!! Form::label('commune_name', 'Commune Name') !!}
                {!! Form::text('commune_name',$commune->name, ['class' => 'form-control']) !!}
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


