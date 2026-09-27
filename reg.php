<?php
//$arr = [];

// if (preg_match_all('/\b\w{3,}\.(com|org|net)\b/', "the.exe beg.com cat1.org ghg", $arr)) {
//     print_r ($arr[0]);
    
//     print_r($arr);
// }
// else {
//     echo "!!!";
// } 

// $reg_4 = '/каво(варка|молка)/';
// $s = 'Продаються кавоварка та кавомолка';
// if (preg_match_all($reg_4, $s, $arr1))
// print_r($arr1);

// $s="the white queen";
// $r='/the (?:(red|white) (king|queen))/';
// if (preg_match($r, $s, $arr))
// print_r($arr);

// $r='/\b(?<!,)\w{3}\b/';
// $s="My little ,dog and cat;";
// if (preg_match_all($r, $s, $arr))
// print_r($arr);

// $r = '/(\w+)\s\1\s\1/';
// $s = 'cat cat cat also dog dog tiger tiger';
// if (preg_match_all($r, $s, $arr))
// print_r($arr);

// $str = "  15-11/2026  ";
// $reg= '/^\s*((\d+)\s*[^\w\d]\s*(\d+)\s*[^\w\d]\s*(\d+))\s*$/';
// preg_match($reg, $str, $matches);

// print_r($matches);
// echo "Дата: '$matches[1]' \n";
// echo "День: $matches[2] \n";
// echo "Місяць: $matches[3] \n";
// echo "Рік: $matches[4] \n";

$string = 'The quick brown fox jumped over the lazy dog.';
$patterns = array();
$patterns[0] = '/quick/';
$patterns[1] = '/brown/';
$patterns[2] = '/fox/';
$replacements = array();
$replacements[0] = 'slow';
$replacements[1] = 'black';
$replacements[2] = 'bear';
echo preg_replace($patterns, $replacements,
$string);

$str = "<p>Права пользователей:</p>
<ul>
  <li>Administrator</li>
  <li>Editor</li>
  <li>Subscriber</li>
</ul>";
$reg = '/<li>(\w+)<\/li>/';
$replace = '<li>$1</li>';
// <li><a href="http://www.php.kh.ua/script.php?role=Administrator">Administrator</a></li>
// <li><a href="http://www.php.kh.ua/script.php?role=Editor">Editor</a></li>
// <li><a href="http://www.php.kh.ua/script.php?role=Subscriber">Subscriber</a></li>