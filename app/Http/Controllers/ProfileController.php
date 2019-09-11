<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function editProfile(){
        return View('Profile.edit_profile');
    }
    public function updateProfile(){

        redirect('/editProfile');
    }
}
