<?php
//过滤敏感词汇
$str = "abcdefghijklmnopqrstuvwxyz";
$words = array('abc','def','abcf','defdd','adef');
$words1 = array();
usort($words,function($a,$b){
    return mb_strlen($a) - mb_strlen($b) < 0;
});
for($i = 0; $i < count($words);$i++){
    for($j = $i + 1;$j < count($words);$j++){
        if(strpos($words[$i],$words[$j]) !== false){
            $words1[] = $words[$i];
        }
    }
}
$len = mb_strlen($words1[0]);
$array = array();
$total = mb_strlen($str);
$mod = $total % $len;
$num = $total - $mod;
for($i = 0;$i < $num / $len;$i++){
    $array[] = mb_substr($str,$i * $len,$len);
}
$end = mb_substr($str,$num);
if($end != ''){
    $array[] = $end;
}
$rs = array();
$count = count($array);
for($i = 0;$i < count($words1);$i++){
    for($j = 0; $j < $count;$j++){
        if(strpos($array[$j],$words1[$i]) !== false){
            $rs[] = $words1[$i];
            $j = $count;
        }
    }
    if(!in_array($rs,$words1[$i])){
        for($k = 1;$k < $count;$k++){
            $sub = $array[$k - 1].$array[$k];
            if(strpos($sub,$words1[$i]) !== false){
                $rs[] = $words1[$i];
                $k = $count;
            }
        }
    }
}
echo json_encode($rs);
