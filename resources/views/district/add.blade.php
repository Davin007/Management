<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!Form::open(['url' => 'district/add','method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create District</h4>
            </div>
            <div class="modal-body">
                <span id="modal-message"></span>
                {!!Form::label('city_name','City Name') !!}
                {!!Form::select('city_name',$data,null,['class' =>'form-control']) !!}
                {!!Form::label('district_name', 'District Name') !!}
                {!!Form::text('district_name',null, ['class' => 'form-control']) !!}
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
    //insert district
    var app = new App();
    jQuery('#save').on('click',function(){
        var city_name = jQuery('#city_name').val();
       var district_name = jQuery('#district_name').val();
       app.insert('/api/district/create-district',{city_name: city_name,name:district_name},'#modal-message');
    });
</script>