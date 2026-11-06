<?php
require_once "functions.php";



$str_form_sort = '<h3>Сортувати по:</h3>
<form action="index.php" method="post" name="sort_form">
    <select name="sort" id="sort" size="1">
        <option value="name">назва країни</option>
        <option value="capital">столиця</option>
        <option value="area">площа</option>
        <option value="population">середнє населення</option>
    </select>
    <input type="submit" name="gosort" value="OK">
</form>';
echo $str_form_sort; 

if (isset($_POST['gosort'])) {
    $how_to_sort = $_POST['sort'];
    sorting($how_to_sort); 
    $sort_countries = out_arr(); 
    print_r($sort_countries);
}

$str_form_search = "
<div class=\"container\">
    <h3>Search:</h3>
    <form name='searchForm' action='index.php' method='post' onSubmit='return overify_login(this);'>
        <input type='text' name='search' class='form-control'>
        <input type='submit' name='gosearch' value='Confirm' class='btn btn-secondary my-2'>
        <input type='reset' name='clear' value='Reset' class='btn btn-secondary my-2'>
    </form>
</div>";

echo $str_form_search;