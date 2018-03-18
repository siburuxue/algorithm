<?php
function big_number($number1,$type="+",$number2){
    $bl1 = strpos($number1,".") === false;
    $bl2 = strpos($number2,".") === false;
    if($type == '*' || $type == '/'){
        if($bl1 ^ $bl2){
            return "-".big_number($number1,$type,$number2);
        }
    }else{
        if($type == '+'){
            if($bl1 && !$bl2){
                return big_number($number1,"-",substr($number2,1));
            }else if(!$bl1 && $bl2){
                return big_number($number2,"-",substr($number1,1));
            }else if(!$bl1 && !$bl2){
                return "-".big_number(substr($number2,1),"+",substr($number1,1));
            }
        }else{
            if($bl1 && !$bl2){
                return big_number($number1,"+",substr($number2,1));
            }else if($bl1 && !$bl2){
                return "-".big_number($number2,"+",substr($number1,1));
            }else if(!$bl1 && !$bl2){
                return big_number(substr($number2,1),"-",substr($number1,1));
            }
        }
    }
    $num1 = (string)$number1;
    $num2 = (string)$number2;
    if($type != '/'){
        $num1 = ltrim($num1,"0");
        $num2 = ltrim($num2,"0");
    }
    $len1 = strlen($num1);
    $len2 = strlen($num2);
    $len = max($len1,$len2);
    $num1 = str_pad($num1,$len,"0",STR_PAD_LEFT);
    $num2 = str_pad($num2,$len,"0",STR_PAD_LEFT);
    $arr1 = str_split($num1);
    $arr2 = str_split($num2);
    $arr = [];
    $mod = 0;
    $flg = true;
    if($type == '-'){
        for ($z = 0;$z < count($arr1);$z++){
            if($arr1[$z] < $arr2[$z]){
                $flg = false;
                break;
            }else if($arr1[$z] > $arr2[$z]){
                $flg = true;
                break;
            }
        }
    }
    $num = "";
    if($type == '+'){
        for($i = $len - 1;$i >=0;$i--){
            $num = (int)$arr1[$i] + (int)$arr2[$i] + $mod;
            if($num >= 10){
                $num -= 10;
                $mod = 1;
            }else{
                $mod = 0;
            }
            array_unshift($arr,$num);
        }
        if($mod > 0){
            array_unshift($arr,$mod);
        }
        $num = implode("",$arr);
    }else if($type == '-'){
        for($i = $len - 1;$i >= 0;$i--){
            if((int)$arr2[$i] + $mod == 10){
                $num = (int)$arr1[$i];
                $mod = 1;
            }else{
                $num = (int)$arr1[$i] - (int)$arr2[$i] - $mod;
                if($num < 0){
                    $mod = 1;
                    $num = 10 + $num;
                }else{
                    $mod = 0;
                }
            }
            array_unshift($arr,abs($num));
        }
        $num = implode("",$arr);
    }else if($type == '*'){
        for($i = $len - 1;$i >= 0;$i--){
            $sub_arr = [];
            for($j = $len - 1;$j >= 0;$j--){
                $num = (int)$arr1[$i] * (int)$arr2[$j] + $mod;
                if($num >= 10){
                    $mod = floor($num / 10);
                    $num = $num % 10;
                }else{
                    $mod = 0;
                }
                array_unshift($sub_arr,$num);
            }
            if($mod != 0){
                array_unshift($sub_arr,$mod);
            }
            $str = implode("",$sub_arr);
            $str = str_pad($str,strlen($str) + ($len - 1 - $i),"0",STR_PAD_RIGHT);
            $arr[] = $str;
            $mod = 0;
        }
        $num = 0;
        while(count($arr) > 0){
            $number = array_pop($arr);
            if(ltrim($number,"0") > 0){
                $num = big_number($num,"+",ltrim($number,"0"));
            }
        }
    }else if($type == '/'){
        $diff_len = abs($len1 - $len2);
        $sub_len = $len1 - $diff_len;
        while($sub_len <= $len1){
            $i = 0;
            $sub_num = substr($num1,0,$sub_len);
            $mod = implode("",$arr);
            while(true){
                $s = $mod.(++$i);
                $result = big_number($s,"*",$num2);
                if(strlen($result) > strlen($sub_num)){
                    $arr[] = $i - 1;
                    break;
                }else{
                    if($result == $sub_num){
                        $arr[] = $i;
                        break;
                    }else{
                        $result = str_pad($result,strlen($sub_num),"0",STR_PAD_LEFT);
                        $result_arr1 = str_split($result);
                        $result_arr2 = str_split($sub_num);
                        $bl = false;
                        for($k = 0;$k < count($result_arr1);$k++){
                            if($result_arr1[$k] > $result_arr2[$k]){
                                $arr[] = $i - 1;
                                $bl = true;
                                break;
                            }else{
                                break;
                            }
                        }
                        if($bl){
                            break;
                        }
                    }
                }
            }
            $sub_len++;
        }
        $num = ltrim($num,"0");
        if($type == '-'){
            $num = ltrim($num,"0");
            if(!$flg){
                $num = "-".$num;
            }
        }
        return $num;
    }
}