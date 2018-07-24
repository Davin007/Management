<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-navbar-collapse" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{action('HomeController@getIndex')}}">
                        <span class="sidebar-title">Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{action('UsersController@getList')}}">
                        <span class="sidebar-title">User</span>
                    </a>
                </li>
                <li>
                    <a href="{{action('EmployeesController@getList')}}">
                        <span class="sidebar-title">Employee</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="accordion-toggle collapsed toggle-switch"
                       data-toggle="dropdown"><span> Leaves</span> <i class="fa fa-caret-down"
                                                                      aria-hidden="true"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('/leave')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                Leave Request</a></li>
                        <li><a href="{{url('status')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                Leave Status</a></li>
                        <li class="divider"></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="accordion-toggle collapsed toggle-switch" data-toggle="dropdown"
                       href="#">
                        <span>Management</span> <i class="fa fa-caret-down" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu">
                        @if(\App\Permission::isAllowed('departments'))
                            <li><a href="{{action('DepartmentController@getList')}}"><i class="fa fa-angle-right"
                                                                                        aria-hidden="true"></i>
                                    Department</a></li>
                        @endif
                        <li class="divider"></li>
                        @if(\App\Permission::isAllowed('position'))
                            <li><a href="{{action('PositionController@getList')}}"><i class="fa fa-angle-right"
                                                                                      aria-hidden="true"></i>
                                    Position</a></li>
                        @endif
                        <li class="divider"></li>
                        @if(\App\Permission::isAllowed('roles'))
                            <li><a href="{{action('RoleController@getList')}}"><i class="fa fa-angle-right"
                                                                                  aria-hidden="true"></i>
                                    Role</a></li>
                        @endif
                        <li class="divider"></li>
                        @if(\App\Permission::isAllowed('branchs'))
                            <li><a href="{{action('BranchController@getList')}}"><i class="fa fa-angle-right"
                                                                                    aria-hidden="true"></i>
                                    Branch</a></li>
                        @endif
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="accordion-toggle collapsed toggle-switch" data-toggle="dropdown"
                       href="#"><span>Location</span> <i class="fa fa-caret-down" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu">
                        @if(\App\Permission::isAllowed('city'))
                            <li>
                                <a href="{{action('CityController@getList')}}"><i class="fa fa-angle-right"
                                                                                  aria-hidden="true"></i>
                                    City</a>
                            </li>
                        @endif
                        <li class="divider"></li>
                        @if(\App\Permission::isAllowed('district'))
                            <li>
                                <a href="{{action('DistrictController@getList')}}"><i class="fa fa-angle-right"
                                                                                      aria-hidden="true"></i>
                                    District</a>
                            </li>
                        @endif
                        <li class="divider"></li>
                        @if(\App\Permission::isAllowed('commune'))
                            <li>
                                <a href="{{action('CommunesController@getList')}}"><i class="fa fa-angle-right"
                                                                                      aria-hidden="true"></i>
                                    Commune</a>
                            </li>
                        @endif
                        <li class="divider"></li>
                        @if(\App\Permission::isAllowed('village'))
                            <li>
                                <a href="{{action('VillageController@getList')}}"><i class="fa fa-angle-right"
                                                                                     aria-hidden="true"></i>
                                    Village</a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="accordion-toggle collapsed toggle-switch" data-toggle="dropdown"
                       href="#">
                        <span>Setting</span> <i class="fa fa-caret-down" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{action('AccessLinkController@getAccessLink')}}"><i class="fa fa-angle-right"
                                                                                          aria-hidden="true"></i>
                                Access Links</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{action('PermissionController@getPermission')}}"><i class="fa fa-angle-right"
                                                                                          aria-hidden="true"></i>
                                Permissions</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    @if (\Illuminate\Support\Facades\Session::has('logged_in') && \Illuminate\Support\Facades\Session::get('logged_in'))
                        <a href="#" class="accordion-toggle collapsed toggle-switch" data-toggle="dropdown">
                            @if(file_exists('upload/' . \Illuminate\Support\Facades\Session::get('user')['thumbnail']))
                                <img class="img-circle" alt="avatar"
                                     id="{{ \Illuminate\Support\Facades\Session::get('user')['user_id'] }}"
                                     src="@if(\Illuminate\Support\Facades\Session::get('user')['thumbnail'] != '') {{ 'upload/' . \Illuminate\Support\Facades\Session::get('user')['thumbnail'] }}
                                     @else {{ \Illuminate\Support\Facades\Session::get('user')['user_id']}} @endif"
                                     width="30">
                            @else
                                <img class="img-circle"
                                     id="{{ \Illuminate\Support\Facades\Session::get('user')['user_id'] }}"
                                     alt="avatar" src="/defaultImage/default.jpg" width="30">
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li class="profile"><a href="#"
                                                   id="{{ \Illuminate\Support\Facades\Session::get('user')['user_id'] }}"><i
                                            class="fa fa-fw fa-cog" id="icons"></i> Edit Profile</a></li>
                            <li class="passwordProfile"><a href="#"
                                                           id="{{ \Illuminate\Support\Facades\Session::get('user')['user_id'] }}"><i
                                            class="fa fa-fw fa-key" id="icons"></i> Change Password</a></li>
                            <li class="divider"></li>
                            <li><a href="{{action('UsersController@logout')}}"><i
                                            class="fa fa-sign-out" id="icons"></i> Sign out</a></li>
                        </ul>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid" id="content">
    <div class="row">
        <div id="wrapper">
            <main id="page-content-wrapper" role="main"></main>
        </div>
        <br>
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="col-sm-12">
                @if (\Illuminate\Support\Facades\Session::has('errors'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{\Illuminate\Support\Facades\Session::get('errors')[0]}}
                        {{ Session::forget('errors') }}
                    </div>
                @elseif(\Illuminate\Support\Facades\Session::has('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{\Illuminate\Support\Facades\Session::get('success')}}
                        {{ Session::forget('success') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            @yield('content')
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="js/general.js"></script>
<script type="text/javascript">
    //insert and edit profile show popup
    var app = new App();
    app.editProfile('.profile', '/api/userProfile/editProfile');
    app.passworeProfile('.passwordProfile', '/api/profile-password/getProfilePassword');
    app.closeModal('#cancel', '#myModal', '#myModal form');

</script>
@yield('script')
</body>
</html>
