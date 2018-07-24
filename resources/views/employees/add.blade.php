<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => '/employee/store','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create District</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <span id="modal-message"></span>
                    <div class="col-sm-6">
                        {!!Form::label('user_name','User Name') !!}
                        {!!Form::select('user_name',$user_name,null,['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('house_number', 'House Number') !!}
                        {!! Form::text('house_number',null, ['class' => 'form-control','required' => 'required']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('street_name', 'Street Name') !!}
                        {!! Form::text('street_name',null, ['class' => 'form-control','required' => 'required']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('gender','Gender') !!}
                        {!! Form::select('gender', ['Select gender','M'=> 'M','F'=> 'F'], null, ['class' =>'form-control'])!!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('city', 'City') !!}
                        {!! Form::select('city', $city, null, ['class' =>'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        <div id="district-block">
                            {!! Form::label('district', 'District') !!}
                            {!! Form::select('district', ['Select'] ,null, ['class' => 'form-control', 'disabled' => 'disabled', 'readonly' => 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="commune-block">
                            {!! Form::label('commune', 'Commune') !!}
                            {!! Form::select('commune', ['Select'], null, ['class' => 'form-control', 'disabled' => 'disabled', 'readonly' => 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="village-block">
                            {!! Form::label('villages', 'Village') !!}
                            {!! Form::select('villages', ['Select'],null, ['class' => 'form-control', 'disabled' => 'disabled', 'readonly' => 'readonly']) !!}
                        </div>
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
    jQuery(document).ready(function() {
        jQuery('#myModal').modal('show');
    });
    //insert employee
    var app = new App();
    jQuery('#save').on('click',function () {
        var user_name = jQuery('#user_name').val();
        var house_number = jQuery('#house_number').val();
        var street_name = jQuery('#street_name').val();
        var city = jQuery('#city').val();
        var gender = jQuery('#gender').val();
        var district = jQuery('#district').val();
        var commune = jQuery('#commune').val();
        var villages = jQuery('#villages').val();
        app.insert('/api/employee/create-employee',{
            user_name: user_name,
            house_number: house_number,
            street_name: street_name,
            city: city,
            gender: gender,
            district: district,
            commune: commune,
            villages: villages,
        },'#modal-message');
    })
</script>
