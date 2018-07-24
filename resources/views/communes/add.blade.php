<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!Form::open(['url' => '/add','method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create Communes</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                {!!Form::label('district_name', 'District Name') !!}
                {!!Form::select('district_name',$data,null,['class' => 'form-control']) !!}
                {!!Form::label('commune_name', 'Commune Name') !!}
                {!!Form::text('commune_name',null, ['class' => 'form-control']) !!}
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
    //insert commune
    var app = new App();
    jQuery('#save').on('click',function () {
        var district_name = jQuery('#district_name').val();
        var commune_name = jQuery('#commune_name').val();
        app.insert('/api/commune/create-commune',{
            district_name: district_name,
            name: commune_name
        },'#modal-message');
    });
</script>