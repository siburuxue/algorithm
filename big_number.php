<?php
function big_number($num1,$type="+",$num2,$precision="3",$mode=PHP_ROUND_HALF_UP){
    $len1 = strlen($num1);
	$len2 = strlen($num2);
    $dik_index1 = strpos($num1,".");
    $dik_index2 = strpos($num2,".");
	$diff1 =  $len1 - ($dik_index1?:$len1);
	$diff2 =  $len2 - ($dik_index2?:$len2);
	$diff = abs($diff1 - $diff2);
	if($diff1 > $diff2){
		$num2 = str_pad($num2,$len2 + $diff,"0",STR_PAD_RIGHT);
	}else{
		$num1 = str_pad($num1,$len1 + $diff,"0",STR_PAD_RIGHT);
	}
	$num1 = str_replace(".","",$num1);
	$num2 = str_replace(".","",$num2);
	$len1 = strlen($num1);
	$len2 = strlen($num2);
	$len = max($len1,$len2);
    if($type == "+" || $type == '-'){
        if($dik_index1 != -1 && $dik_index2 != -1){
            $char_index = max($dik_index1,$dik_index2);
        }else if($dik_index1 != -1 && $dik_index2 == -1){
            $char_index = $dik_index1;
        }else if($dik_index1 == -1 && $dik_index2 != -1){
            $char_index = $dik_index2;
        }else{
            $char_index = 0;
        }
    }else if($type == '*'){
        if($dik_index1 != -1 && $dik_index2 != -1){
            $char_index = 2 * max($dik_index1,$dik_index2);
        }else if($dik_index1 != -1 && $dik_index2 == -1){
            $char_index = $dik_index1;
        }else if($dik_index1 == -1 && $dik_index2 != -1){
            $char_index = $dik_index2;
        }else{
            $char_index = 0;
        }
    }else if($type == '/'){
        if($dik_index1 != -1 && $dik_index2 != -1){
            $char_index = abs($dik_index1 - $dik_index2);
        }else if($dik_index1 != -1 && $dik_index2 == -1){
            $char_index = $dik_index1;
        }else if($dik_index1 == -1 && $dik_index2 != -1){
            $char_index = $dik_index2;
        }else{
            $char_index = 0;
        }
    }
    if($type != "/"){
        $num1 = str_pad($num1,$len,"0",STR_PAD_LEFT);
        $num2 = str_pad($num2,$len,"0",STR_PAD_LEFT);
    }
	$arr1 = str_split($num1);
	$arr2 = str_split($num2);
	$arr = [];
	$mod = 0;
    $flg = true;
	if($type == '+'){
        for($i = $len - 1;$i >= 0;$i--){
            $num = (int)$arr1[$i] + (int)$arr2[$i] + $mod;
            if($num >= 10){
                $num -= 10;
                $mod = 1;
            }else{
                $mod = 0;
            }
            array_unshift($arr,$num);
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
                if($num > 10){
                    $mod = floor($num / 10);
                    $num = $num % 10;
                }else{
                    $mod = 0;
                }
                array_unshift($sub_arr,$num);
            }
            $str = implode("",$sub_arr);
            $str = str_pad($str,strlen($str) + ($len - 1 - $i),"0",STR_PAD_RIGHT);
            $arr[] = $str;
        }
        $num = 0;
        while(count($arr) > 0){
            $number = array_pop($arr);
            $num = big_number($num ,"+",ltrim($number,0));
        }
    }else if($type == '/'){
	    $diff_len = $len1 - $len2;
	    $sub_len = $len1 - $diff_len;
	    if($diff_len > 0){
            while($sub_len <= $len1){
                $i = 0;
                $sub_num = substr($num1,0,$sub_len);
                $mod = implode("",$arr);
                while(true){
                    $result = big_number($mod.(++$i), '*', $num2);
                    if(strlen($result) > strlen($sub_num)){
                        $arr[] = $i - 1;
                        break;
                    }else{
                        if($result == $sub_num){
                            $arr[] = $i;
                            break;
                        }else{
                            $result_arr1 = str_split($result);
                            $result_arr2 = str_split($sub_num);
                            $bl = false;
                            foreach ($result_arr1 as $k => $v){
                                if($v > $result_arr2[$k]){
                                    $arr[] = $i - 1;
                                    $bl = true;
                                    break;
                                }else if($v < $result_arr2[$k]){
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
            $num = implode("",$arr);
        }else{

        }
    }
	if($char_index > 0){
		$num = substr($num,0,strlen($num) - $char_index + 1).".".substr($num,1 - $char_index);
		$num = rtrim($num,"0");
		$num = rtrim($num,".");
	}
	if($type == '-'){
        $num = ltrim($num,"0");
        if(!$flg){
            $num = "-".$num;
        }
    }
	return $num;
}
//1234567853454363465346349
//2314367532543256476858768765
//363867261633620806602445697110920929920374202728427988985
$num1 = "45";
$num2 = "3";
$num = big_number($num1,"/",$num2);
echo $num;