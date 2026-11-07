<?php

$filename = __DIR__ . DIRECTORY_SEPARATOR . "my_file1.html"; 

// $h    = fopen($filename, "x+"); // Буде відкритий файл нульової довжини "my_file.html" для записи.
// $text = "Ми вивчаємо PHP";

// if ($h) {
//     if (fwrite($h, $text)) {
//         echo "Запис зроблено успішно";
//     } else {
//         echo "Виникла помилка при запису даних";
//     }
// }
// else {
//     echo "Не вдалося відкрити або створити файл.";
// }
// fclose($h);

// $h = fopen($filename,"r+"); // відкриваємо файл на запис та читання
// $content = fread($h, filesize($filename));// зчитує вміст всього файлу
// echo $content; // виводить вміст файлу на екран
// fclose($h);

// $file = fopen("test.txt", "r");
// echo fgets($file)."\n";

// while(!feof($file)) 
// { 
//     echo fgets($file)."\n"; 
// }

// $file = fopen("contacts.csv", "r"); 
// print_r(fgetcsv($file)); 
// fclose($file);

//  $list = array ( 
//  array('aaa', 'bbb', 'ccc', 'dddd'), 
//  array('123', '456', '789'), 
//  array('aaa', 'bbb') 
//  ); 

//  $fp = fopen ( 'file.csv' , 'w' ); 

//  foreach ($list as $fields) { 
//      fputcsv ($fp , $fields); 
//  } 
//  fclose ($fp);

// $arr = file("test.txt");
// foreach ($arr as $i => $a) {
//     echo $i, ": ", $a;
// }

// $n = readfile ("https://www.php.net/");
//  if (!$n) 
//     echo "Ошибка чтения из файла"; // если ошибка была, то выводим сообщение
//  else 
//     echo $n; // если ошибки не было, то выводим число считанных символов

// $homepage = file_get_contents('http://www.example.com/'); 
//  echo $homepage;

// echo realpath("."); 
// echo realpath("..");

// $dir    = 'poems';
// $files = scandir($dir, 1);
// print_r($files);

//  for ($i = 0; $i < count($files); $i++) { // проходимо по масиву назв файлів
//         if ($files[$i] != '.' && $files[$i] != '..') { // крім поточної та батьківської директорії           
//             echo $files[$i] . "\n";            
//      }
//  }

$path = "poems-html";
$poemsPath = "poems";
if (!is_dir($path)) {
    mkdir($path);
}
if (is_dir($poemsPath)) { // якщо існує папка "poems"
    $files = scandir($poemsPath, 1); // отримуємо масив назв файлів, що містяться в папці "poems"
    for ($i = 0; $i < count($files); $i++) { // проходимо по масиву назв файлів
        if ($files[$i] != '.' && $files[$i] != '..') { // крім поточної та батьківської директорії
            $filename = $poemsPath . "/" . $files[$i]; // додаємо до імені файлу ім'я папки poems /
            echo $filename . "\n";
            $file = fopen($filename, "r"); // відкриваємо файл
            $content = fread($file, filesize($filename)); // читаємо вміст файлу
            $new_filename = pathinfo($files[$i], PATHINFO_FILENAME); // отримуємо ім'я файлу без розширення
            echo $new_filename;
            $html = fopen($path . "/" . $new_filename . ".html", "w");  // створюємо новий html файл
            
            fwrite($html, $content); // пишемо туди отриманий вміст
            fclose($file); // закриваємо файл з папки poems
            fclose($html); // закриваємо файл з папки poems-html
     }
  }
}