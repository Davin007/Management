
@if ($template == 'city')
    {!! Form::label('district', 'District') !!}
    {!! Form::select('district', $locations, null, ['class' => 'form-control', 'placeholder' => 'Please select']) !!}
@elseif ($template == 'district')
    {!! Form::label('commune', 'Commune') !!}
    {!! Form::select('commune', $locations, null, ['class' => 'form-control', 'placeholder' => 'Please select']) !!}
@elseif ($template == 'commune')
    {!! Form::label('villages', 'Village') !!}
    {!! Form::select('villages', $locations, null, ['class' => 'form-control', 'placeholder' => 'Please select']) !!}
@else
   <p>no data</p>
@endif