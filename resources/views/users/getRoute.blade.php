<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['url' => 'user/set-permission','method'=>'post']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3 class="modal-title">User Permission</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <label for="username">Name : {{$user->user_full_name}}</label><br>
                    <label for="username">Email : {{$user->email}}</label><br>
                    <div class="checkbox text-right">
                        <label for="check-all"><input type="checkbox" name="choose" id="check-all" value="{{$user->user_id}}"> Select All</label>
                    </div>
                    <div class="well">
                       <div class="col-md-6">
                           @php $route = explode(',', $user->controller_id); @endphp
                           @foreach($controller_method as $value)
                                   <div class="checkbox">
                                       <label><input type="checkbox" @if (in_array($value->id, $route)) checked="checked" @endif class="checkbox check-one" name="routes[]" value="{{ $value->id }}">{{ $value->controller_action }}</label>
                                   </div>
                           @endforeach
                       </div>
                        <div class="col-md-6">
                            @foreach($controller_method as $value)
                                <div class="checkbox">
                                    <label>{{ $value->description }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="margin-top-30px">
                        {!! Form::submit('Assign', ['id'=>'save','class' => 'btn btn-primary btn-sm']) !!}
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
<script type="text/javascript">
    app.checkAll('#check-all', '.check-one');
</script>