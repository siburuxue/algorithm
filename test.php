<?php
require "Collection.php";
use ZP\Collection;
$collection = new Collection();
$collection->set(0);
$collection->set(1);
$collection->set(2);
$collection->set(3);
$collection->set(4);
$collection->set(5);
$collection->set(6);
$collection->set(7);
$collection->set(8);
$collection->set(9);
$size = $collection->size();
$rs = $collection->del(3,2);
echo json_encode($rs);
echo "<br>";
$arr = $collection->get();
var_dump($arr);