<?php
require_once "db.php";

$st = serialize($tours);
echo $st;

$h = fopen ( 'db.txt' , 'w' ); 
fwrite($h, $st);
fclose($h);
// $d = unserialize($st);
// print_r($d);