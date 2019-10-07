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
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function editProfile($alert){
        $data['alert']= $alert;
        return View('Profile.edit_profile', $data);
    }
    public function updateProfile(Request $request){
        if($request->name == auth()->user()->name){
            return redirect('/editProfile/'.auth()->user()->name);
        }
        else{
            $user = User::where('id', auth()->user()->id)->first();
            $user->name = $request->name;
            $user->save();
            return redirect('/editProfile/successI');
        }

    }
    public function changePassword($alert){
        $data['alert']= $alert;
        return View('Profile.change_password',$data);
    }
    public function updatePassword(Request $request){
        $user = User::where('id', auth()->user()->id)->first();
        if(Hash::check($request['old-password'],$user->password)){
            if($request['new-password'] == $request['old-password']){
                return redirect('/changePassword/new1');
            }
            else if(UserService::checkPW($request['new-password'])==1){
                return redirect('/changePassword/new2');
            }
            else if($request['new-password']!= $request['re-password']){
                return redirect('/changePassword/new3');
            }
            else{
                $user->password= bcrypt($request['new-password']);
                $user->save();
                return redirect('/editProfile/successPW');
            }
        }
        else{
            return redirect('/changePassword/old');
        }
    }
}
