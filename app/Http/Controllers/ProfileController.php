<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function checkPW($str){
        if(strlen($str)>=8)
            for($i=0; $i<strlen($str); $i++){
                if($str[$i] >= '0' && $str[$i] <='9'){
                    for($j=$i+1; $j<strlen($str); $j++)
                        if($str[$j] >= 'A' && $str[$j]<='z') return 0;
                }
                else if($str[$i] >= 'A' && $str[$i] <='z'){
                    for($j=$i+1; $j<strlen($str); $j++)
                        if($str[$j] >= '0' && $str[$j] <='9') return 0;
                }
            }
        return 1;
    }
    public function editProfile($alert){
        $data['alert']= $alert;
        return View('Profile.edit_profile', $data);
    }
    public function updateProfile(){
        if($_POST['name'] == auth()->user()->name){
            return redirect('/editProfile/'.auth()->user()->name);
        }
        else{
            $user = User::where('id', auth()->user()->id)->first();
            $user->name = $_POST['name'];
            $user->save();
            return redirect('/editProfile/successI');
        }

    }
    public function changePassword($alert){
        $data['alert']= $alert;
        return View('Profile.change_password',$data);
    }
    public function updatePassword(){
        $user = User::where('id', auth()->user()->id)->first();
        if(Hash::check($_POST['old-password'],$user->password)){
            if($_POST['new-password'] == $_POST['old-password']){
                return redirect('/changePassword/new1');
            }
            else if($this->checkPW($_POST['new-password'])==1){
                return redirect('/changePassword/new2');
            }
            else if($_POST['new-password']!= $_POST['re-password']){
                return redirect('/changePassword/new3');
            }
            else{

                $user->password= bcrypt($_POST['new-password']);
                $user->save;
                return redirect('/editProfile/successPW');
            }
        }
        else{
            return redirect('/changePassword/old');
        }
    }
}
