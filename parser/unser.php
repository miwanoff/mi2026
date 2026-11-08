<?php
$filename = "db.txt";
$h = fopen($filename,"r+"); 
$content = fread($h, filesize($filename));
$d = unserialize($content);
print_r($d);