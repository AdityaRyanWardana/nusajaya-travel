<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return view('user.profile');
    }

    public function calendar()
    {
        return view('user.calendar');
    }

    public function preferences()
    {
        return view('user.preferences');
    }
}
