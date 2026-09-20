<?php
// $pizza = "шматок1 шматок2 шматок3 шматок4 шматок5 шматок6"; 
// $pieces = explode ( " " , $pizza, -4 );
// print_r($pieces);

// $array = ["і'мя" , "пошта" , "телефон"]; 
// $comma_separated = join ( ", " , $array ); 
// echo $comma_separated ; // им'я, пошта, телефон

// $str = "Привіт! Сьогодні ми вивчаємо роботу з рядками. Автор.";
// $pos = mb_stripos ( $str, "Сьогодні");
// if ($pos !== false)
//   echo "$pos "; //  16 
// else
//   echo "No result";

// $email = 'name@example.com' ; 
// $domain = strstr ( $email , '@' ); 
// echo $domain ; // выводит @example.com
// $user = strstr ( $email , '@' , true ); 
// echo $user ; // 

// $phrase = "Ви повинні їсти фрукти щодня. Та ще фрукти дуже корисні"; // об'єкт - рядок
// $healthy = "фрукти"; // значення, яке замінюватимемо
// $sweets = "цукерки"; // значення, яким замінюватимемо
// $newphrase = str_replace($healthy, $sweets, $phrase, $с); // робимо заміну
// echo $newphrase. " ". $с; // Ви повинні їсти цукерки щодня.

// $greeting = ["Привіт", "Привіт всім!", "Привіт, люба!"]; // объект - массив
// $new_greet = str_replace("Привіт", "Доброго ранку", $greeting); // делаем замену
// print_r($new_greet); 

// $greeting = array("Привіт", "Привіт всім!", "Привіт, люба!","Вітаю", "Hello!", "Hi"); // объект - массив
// $search = array ("Привіт", "Вітаю", "Hi");  // значения, которые будем заменять
// $replace = array ("Доброго ранку",  "Доброго дня", "Hello");  // значения, которыми будем заменять
// $new_greet = str_replace($search, $replace, $greeting); // делаем замену
// print_r($new_greet); //выводим полученный массив

// $st =" 
// <strong>Жирний текст</strong> 
// <em>Курсивний Teкст</em> 
// <а href='http://www.php-lab.ua'>Посилання</а> 
// a<x && y>d ";
// echo "Початковий текст $st"; 
// echo "Після видалення тегів: ",strip_tags($st);

$text = "The quick brown fox jumped over the lazy dog.";
$newtext = wordwrap($text, 20, "<br />\n");
echo $newtext;