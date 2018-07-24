@extends('layouts.default')
@section('title','Page form')
@section('content')
    <h1 class="welcome text-center">Welcome to <br>SINET</h1>
    <div class="card">
        <h2 class='login_title text-center'>Login</h2>
        <hr>
        {!! Form::open(['url' => '/users/login','method'=>'post']) !!}
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email',null, ['class' => 'form-control','placeholder'=>'Email or Name']) !!}
        {!! Form::label('password', 'Password') !!}
        {!! Form::password('password', ['class' => 'form-control','placeholder'=>'password']) !!}
        <br>
        <div class="margin-top-10px">
            {!! Form::submit('Login', ['class' => 'btn btn-primary btn-sm']) !!}
        </div>
    </div><!-- /card-container -->
@endsection