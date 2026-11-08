<?php
$a = ["a"=>"aa", "b"=>"bb", "c"=>[array("х"=>"хх")]];
$st = serialize($a);
echo $st;

$h = fopen ( 'db.txt' , 'w' ); 
fwrite($h, $st);
fclose($h);
// $d = unserialize($st);
// print_r($d);