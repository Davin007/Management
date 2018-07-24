<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => '/status/store','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create Leave Status</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                <div class="row">
                    <div class="col-sm-12">
                        {!! Form::label('status_title', 'Title') !!}
                        {!! Form::text('status_title',null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-sm-12">
                        {!! Form::label('status_description', 'Description') !!}
                        {!! Form::textarea('status_description',null, ['class' => 'form-control']) !!}
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
        var status_title = jQuery('#status_title').val();
        var status_description  = jQuery('#status_description').val();
        app.insert('/api/status/create-status', {
            status_title: status_title,
            status_description: status_description,
        }, '#modal-message');
    });
</script>
