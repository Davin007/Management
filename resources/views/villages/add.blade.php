<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!Form::open(['url' => 'village/add','method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create Village</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                {!!Form::label('commune_name','Commune Name') !!}
                {!!Form::select('commune_name',$data,null,['class' => 'form-control']) !!}
                {!!Form::label('village_name', 'Village Name') !!}
                {!!Form::text('village_name',null, ['class' => 'form-control']) !!}
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
    ///insert village
    var app = new App();
    jQuery('#save').on('click',function () {
        var commune_name = jQuery('#commune_name').val();
        var village_name = jQuery('#village_name').val();
        app.insert('/api/village/create-village',{
            commune_name: commune_name,
            name: village_name
        },'#modal-message')
    })
</script>
