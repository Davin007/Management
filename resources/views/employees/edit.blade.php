<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => '/employee/update','method'=>'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Update User</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {!! Form::hidden('id', $data->user_id) !!}
                    <div class="col-sm-6">
                        {!! Form::label('full_name', 'Name') !!}
                        {!! Form::text('full_name',$data->user_full_name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email',  $data->email, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('department', 'Department') !!}
                        {!! Form::select('department', $data->departments, $data->department_id, ['class' =>'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('position', 'Position') !!}
                        {!! Form::select('position', $data->positions, $data->position_id, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('branch', 'Branches') !!}
                        {!! Form::select('branch',$data->branch, $data->branch_id, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('house_number', 'House Number') !!}
                        {!! Form::text('house_number',$employee->house_number, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('street_name', 'Street Name') !!}
                        {!! Form::text('street_name',$employee->street_name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('gender','Gender') !!}
                        {!! Form::select('gender', ['Select gender','M'=> 'M','F'=> 'F'], $employee->sex, ['class' =>'form-control'])!!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('city', 'City') !!}
                        {!! Form::select('city',$city,null, ['class' =>'form-control']) !!}
                    </div>
                    <div class="col-sm-6">
                        <div id="district-block">
                            {!! Form::label('district', 'District') !!}
                            {!! Form::select('district', $district ,null, ['class' => 'form-control','disabled' => 'disabled', 'readonly' => 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="commune-block">
                            {!! Form::label('commune', 'Commune') !!}
                            {!! Form::select('commune',$commune, null, ['class' => 'form-control', 'disabled' => 'disabled', 'readonly' => 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="village-block">
                            {!! Form::label('villages', 'Village') !!}
                            {!! Form::select('villages',$village,null, ['class' => 'form-control', 'disabled' => 'disabled', 'readonly' => 'readonly']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="margin-top-30px text-right">
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


