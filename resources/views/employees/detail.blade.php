<div class="modal fade modal-md" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open() !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Employee Detail</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {!! Form::hidden('id', $data->user_id) !!}
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                        <div class="text-center">
                            @if(file_exists('upload/' . $data->thumbnail))
                                <img src="/upload/{{$data->thumbnail}}" id="thumbnail" class="img-thumbnail" alt="avatar">
                            @else
                                <img src="/default/default.jpg" id="thumbnail" class="img-thumbnail" alt="avatar">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                        {!! Form::label('full_name', 'Name') !!}
                        {!! Form::text('full_name',$data->user_full_name, ['class' =>'form-control','disabled']) !!}
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email', $data->email, ['class' =>'form-control','disabled']) !!}
                        {!! Form::label('gender','Gender') !!}
                        {!! Form::select('gender', ['Select gender','M'=> 'M','F'=> 'F'],$employee->sex, ['class' =>'form-control','disabled'])!!}
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        {!! Form::label('department', 'Department') !!}
                        {!! Form::select('department', $data->departments, $data->department_id, ['class' =>'form-control','disabled']) !!}
                        {!! Form::label('position', 'Position') !!}
                        {!! Form::select('position', $data->positions, $data->position_id, ['class' => 'form-control','disabled']) !!}
                        {!! Form::label('branch', 'Branches') !!}
                        {!! Form::select('branch',$data->branch, $data->branch_id, ['class' => 'form-control','disabled']) !!}
                        {!! Form::label('house_number', 'House Number') !!}
                        {!! Form::text('house_number',$employee->house_number, ['class' => 'form-control','disabled']) !!}
                        {!! Form::label('street_name', 'Street Name') !!}
                        {!! Form::text('street_name',$employee->street_name, ['class' => 'form-control','disabled']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="margin-top-30px text-right">
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


