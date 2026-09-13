<?php

$arr = [1, 2, 3, "Hello"];
// foreach ($arr as &$value) {
//   $value = $value * 2;
//   echo "$value\n";
// }

// unset($value);

foreach ($arr as $key => $value) { 
  echo "$key"."-> "."$value\n";
}

print_r($arr);
var_dump($arr);