<?php
$filename  = "db.txt"; 
$h         = fopen($filename, "r+"); 
$tours_ser = fread($h, filesize($filename)); 
$tours     = unserialize($tours_ser); 
$tours[]   = [
    'name'      => 'Sunny France', 
    'country'   => "France", 
    'stars'     => 4, 
    'price'     => 950, 
    'transport' => "train", 
    'img'       => "photo-1501785888041-af3ef285b470", 
]; 
print_r($tours);
// fclose($h);

// $h = fopen ( 'db.txt' , 'w' ); 
$st = serialize($tours);
fwrite($h, $st);
fclose($h);