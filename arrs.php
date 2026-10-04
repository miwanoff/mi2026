<?php

function f() { 
  $x = 1;
  $y = 2;
  $z = 3;
  return array($x, $y, $z) ; 
} 

$arr = f(); 
// var_dump($arr);
// $a = $arr[0];
// $b = $arr[1];
// $c = $arr[2];


// list ($a, $b, $c) = $arr;

print_r([$a, $b, $c]);

function increment($a = 0,  $b = 0, $c = 0) {
  echo "Текущее значение: $a\n";// Поточне значення: 10
  $a++;
  echo "После увеличения: $a\n";// Після збільшення: 11
  
  echo ($b);
}
$num = 10;
echo "Початкове значення: $num\n";// 10
increment ();
echo "Значення не змінилося: $num\n";// 10;

function planets() {
  for($i = 0; $i < func_num_args(); $i ++) {
    echo func_get_arg($i) . "\n";
  }
}
planets ("Меркурій", "Венера", "Земля", "Марс");

$monthes = array (
	1 => "Січень",
	2 => "Лютий",
	// ...
	12 => "Грудень" 
      );

function getMonthName($n) {
    
	global $monthes;
    print_r( $GLOBALS ["num"]);
	return $monthes[$n];
}

echo getMonthName(2); // Лютий

echo $GLOBALS ["num"];