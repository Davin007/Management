@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="panel user" id="panel">
        <a href="{{ action('UsersController@getList') }}"><span>{{ $users }}</span>Users</a>
    </div>
    <div class="panel post" id="panel">
        <a href="{{ action('AccessLinkController@getAccessLink') }}"><span>{{ $route  }}</span>Routes</a>
    </div>
    <div class="panel users" id="panel">
        <a href="{{ action('EmployeesController@getList') }}"><span>{{ $employee }}</span>Employees</a>
    </div>
    <div class="modal-template"></div>
@endsection