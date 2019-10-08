<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\User;
use App\Biz\UserService;
use phpDocumentor\Reflection\Types\Boolean;

class ProfileController extends Controller
{
    protected $UserService;
    public function __construct(UserService $UserService)
    {
        $this->middleware('auth');
        $this->UserService = $UserService;
    }


    public function editProfile($alert){
        $data['alert']= $alert;
        return View('Profile.edit_profile', $data);
    }

    public function updateProfile(Request $request){
        $data = $this->UserService->updateProfile($request);
        return redirect('/editProfile/'.$data);
    }

    public function changePassword($alert){
        $data['alert']= $alert;
        return View('Profile.change_password',$data);
    }

    public function updatePassword(Request $request){
        $data = $this->UserService->updatePW($request);
        if($data == 'successPW')
             return redirect('/editProfile/'.$data);
        else
            return redirect('/changePassword/'.$data);
    }
}
