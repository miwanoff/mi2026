<?php

$text  = "04.01.2020\n"; 
$text .= "31.12.2021\n"; 

// функція зворотного виклику
function next_year($matches) 
{
    // $d = $matches[1] + 1;
    // return ".$d.";
    print_r($matches);
    if ($matches[1] == 1){
        $m = "січня";
    }
    elseif ($matches[1] == 12){
        $m = "грудня";
    }
    return " $m ";
}

echo preg_replace_callback("/\.(\d{2})\./", "next_year", $text);