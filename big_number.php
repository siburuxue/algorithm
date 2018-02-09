<?php
function big_number($num1,$num2){
	$num1 = rtrim($num1,"0");
	$num1 = rtrim($num1,".");
	$num2 = rtrim($num2,"0");
	$num2 = rtrim($num2,".");
	$len1 = strlen($num1);
	$len2 = strlen($num2);
	$diff1 =  $len1 - (strpos($num1,".")?:$len1);
	$diff2 =  $len2 - (strpos($num2,".")?:$len2);
	$char_index1 = strpos($num1,".")?:$len1;
	$char_index2 = strpos($num2,".")?:$len2;
	$diff = abs($diff1 - $diff2);
	$char_index = max($diff1,$diff2);
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
	$num1 = str_pad($num1,$len,"0",STR_PAD_LEFT);
	$num2 = str_pad($num2,$len,"0",STR_PAD_LEFT);
	$arr1 = str_split($num1);
	$arr2 = str_split($num2);
	$arr = [];
	$mod = 0;
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
	if($char_index > 0){
		$num = substr($num,0,strlen($num) - $char_index + 1).".".substr($num,1 - $char_index);
		$num = rtrim($num,"0");
		$num = rtrim($num,".");
	}
	return $num;
}
$num1 = "1423547535454.34859347895";
$num2 = "543789538243290874093.545";
$num = big_number($num1,$num2);
echo $num;