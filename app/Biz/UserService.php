<?php
namespace App\Biz;

class UserService{

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

}
