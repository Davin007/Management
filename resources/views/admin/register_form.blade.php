@extends('layouts.app')
@section('title','Page form')
@section('content')
    <h1 class="welcome text-center">Welcome to <br>SINET</h1>
    <div class="card card-container">
        <h2 class='login_title text-center'>Register Form</h2>
        <hr>
        {!! Form::open(['url' => '/users/store','method'=>'post']) !!}
            {!! Form::label('full_name', 'Full Name') !!}
            {!! Form::text('user_full_name',null, ['class' => 'form-control']) !!}
            {!! Form::label('email', 'Email') !!}
            {!! Form::email('email',null, ['class' => 'form-control']) !!}
            {!! Form::label('password', 'Password') !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
            {!! Form::label('confirm_password', 'Confirm Password') !!}
            {!! Form::password('confirm_password', ['class' => 'form-control']) !!}
        <div class="margin-top-10px">
            {!! Form::submit('Register', ['class' => 'btn btn-primary btn-sm']) !!}
        </div>
    </div>
@endsection