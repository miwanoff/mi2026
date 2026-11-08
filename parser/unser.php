<?php
$filename = "db.txt";
$h = fopen($filename,"r+"); 
$tours = fread($h, filesize($filename));
$d = unserialize($tours);
print_r($d);