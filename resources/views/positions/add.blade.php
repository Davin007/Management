<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => '/positions/store','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create Position</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                {!!Form:: label('position_title', 'Position') !!}
                {!! Form:: text('position_title',null, ['class' =>'form-control']) !!}
                {!!Form:: label('description', 'Description') !!}
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
    //insert position
    var app = new App();
    jQuery('#save').on('click',function () {
       var position_title = jQuery('#position_title').val();
       var description = jQuery('#description').val();
        app.insert('/api/position/create-position', {position_title: position_title, description: description}, '#modal-message');
    });
</script>
