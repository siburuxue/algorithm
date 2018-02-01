<?php
class Stack{
    private $arr = [];

    public function push($obj){
        $this->arr[] = $obj;
    }

    public function pop(){
        $obj = array_pop($this->arr);
        return $obj;
    }

    public function count(){
        return count($this->arr);
    }
}
$flg1 = true;
$flg2 = true;
$str1 = "({[]}){}{}[]";
$str2 = "()[]{}{{{(}}})()";
$arr1 = str_split($str1);
$arr2 = str_split($str2);
$stack1 = new Stack();
$stack2 = new Stack();
$array = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
];
foreach ($arr1 as $v){
    if(array_key_exists($v,$array)){
        $stack1->push($v);
    }else{
        $obj = $stack1->pop();
        if($v != $array[$obj]){
            $flg1 = false;
        }
    }
}
if($stack1->count() > 0){
    $flg1 = false;
}
foreach ($arr2 as $v){
    if(array_key_exists($v,$array)){
        $stack2->push($v);
    }else{
        $obj = $stack2->pop();
        if($v != $array[$obj]){
            $flg2 = false;
        }
    }
}
if($stack2->count() > 0){
    $flg2 = false;
}
var_dump($flg1,$flg2);

max();
