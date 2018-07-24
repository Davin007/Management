<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => '/city/update','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Update City</h4>
            </div>
            <div class="modal-body">
                {!! Form::hidden('id', $city->id) !!}
                {!! Form::label('city_name', 'City Name') !!}
                {!! Form::text('city_name',$city->name, ['class' => 'form-control']) !!}
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


