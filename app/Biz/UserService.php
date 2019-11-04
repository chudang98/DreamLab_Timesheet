<?php
namespace App\Biz;

use App\Repositories\Contracts\UserRepositoryInterface as User;
use Illuminate\Support\Facades\Hash;

class UserService{

    protected $User;

    public function __construct(User $User)
    {
        $this->User= $User;
    }

    //cẬp nhật tên
    public function updateName($name){
        $this->User->updateName(auth()->user()->id, $name);
    }

    //gọi hàm cập nhât tên và trả về đuôi của url
    public function updateProfile($request){
        if($request->name == auth()->user()->name){
            return auth()->user()->name;
        }
        else{
            $this::updateName($request->name);
            return 'successI';
        }
    }

    //kiếm tra PW đã đúng định dạng chưa
    public static function checkPW($str){
        $s = strlen($str);
        if($s>=8)
            for($i=0; $i<$s; $i++){
                if($str[$i] >= '0' && $str[$i] <='9'){
                    for($j=$i+1; $j<strlen($str); $j++)
                        if($str[$j] >= 'A' && $str[$j]<='z') return 0;
                }
                else if($str[$i] >= 'A' && $str[$i] <='z'){
                    for($j=$i+1; $j<$s; $j++)
                        if($str[$j] >= '0' && $str[$j] <='9') return 0;
                }
            }
        return 1;
    }

    //cập nhật PW, trả về đuôi URL
    public function updatePW($request){
        $user = $this->User->find(auth()->user()->id);
        if(Hash::check($request['old-password'],$user->password)){
            if($request['new-password'] == $request['old-password']){
                return 'new1';
            }
            else if(UserService::checkPW($request['new-password'])==1){
                return 'new2';
            }
            else if($request['new-password']!= $request['re-password']){
                return 'new3';
            }
            else{
                $this->User->updatePW(auth()->user()->id,bcrypt($request['new-password']));
                return 'successPW';
            }
        }
        else{
            return 'old';
        }
    }
}
