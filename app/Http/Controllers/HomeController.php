<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct() {
        $this->middleware(['user.management', 'user.role.permission']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data['users'] = \App\User::get()->count();
        $data['employee'] = \App\Employee::get()->count();
        $data['route'] = \App\ControllerAction::get()->count();
        return view('dashboard.dashboard',$data);
    }
}
