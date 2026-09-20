<?php

    $arr = [[1, 3], [5, 6]];
    $x   = 100;

    echo "<h1>{$arr[1][0]} $x !!!<h1>";
?>
<h2> PHP Strings!</h2>
<img src="https://php.web-online.net.ua/wp-content/uploads/2016/09/Elephpant_sm.png" alt="" width=<?= "$x"?>>
<?php

echo "<img src=\"https://php.web-online.net.ua/wp-content/uploads/2016/09/Elephpant_sm.png\" alt=\"\" width=\"$x\">";
    $str = "<h2>Hello</h2>";
?> <?= $str ?>

<?php
$num = 5 ; 
$location = 'дереві' ; 
$format = '%d мавп сидять на %s ' ; 
printf ( $format."\n", $num, $location ); // 5 мавп сидять на дереві

$num = 15 ; 
$location = 'вікні' ; 

printf ( $format, $num, $location );
echo "\n";
$money1  =  68.75 ;  
$money2  =  54.35 ; 
$number = 362525200;
$money  =  $money1  +  $money2 ; 
echo $money; //виведе "123.1"; 
$formatted  =  sprintf ( "%.2f" ,  $money ); 
echo $formatted; //  виведе "123.10"
echo "\n";
$formatted  =  sprintf("%012.2f" ,  $money); 
echo $formatted."\n"; //  виведе "000123.100"
echo sprintf("%.3e", $number); // виведе 3.625e+8