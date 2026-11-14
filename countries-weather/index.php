<?php
    require_once "functions.php";
    require_once __DIR__ . '/weather.php'; 

    $weather = getCapitalWeather($countries[0]['capital']);

if ($weather) {?>
<h2>Погода у столиці</h2>
<h3>
    <?php echo htmlspecialchars($weather['city']) ?>
</h3>
<p>
    Температура:
    <?php echo htmlspecialchars((string) $weather['temperature']) ?> °C
</p>
<p>
    <?php echo htmlspecialchars($weather['condition']) ?>
</p>
<p>
    Вологість: <?php echo htmlspecialchars((string) $weather['humidity']) ?>%
</p>
<p>
    Вітер: <?php echo htmlspecialchars((string) $weather['wind']) ?> км/год
</p>
<p>
    Оновлено: <?php echo htmlspecialchars($weather['updated']) ?>
</p>

<?php } else {?>
<p>Не вдалося отримати інформацію про погоду.</p>
<?php }?>


<?php

    $autorized = false;
    if (isset($_POST["go"])) {
    $login    = $_POST["login"]; 
    $password = $_POST["pass"]; 
    //echo "$login $password";
    if (check_autorize($login, $password)) {
        $autorized = true;
        echo "Hello, $login";
        if (check_admin($login, $password)) {
            echo "<a href='hello.php?login=$login'>Просмотр отчета</a>";
        }
    } else {
        echo "You are not registered";
    }
    }
    $user_form = '<form action="' . $_SERVER['PHP_SELF'] . '" method="post" name="autoForm">
    <input type="text" name="login" placeholder="Input login">
    <input type="password" name="pass" placeholder="Input password">
    <input type="submit" value="Go" name="go">
</form>';

    if (! $autorized) {
    echo $user_form;
    }

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
    $sort_countries = out_arr();
    if (isset($_POST['gosort'])) {
        $how_to_sort = $_POST['sort']; 
        sorting($how_to_sort); 
        $sort_countries = out_arr(); 
        //print_r($sort_countries);   

    }
    for ($i = 0; $i < count($sort_countries); $i++) {
        echo $sort_countries[$i];
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

    // if (isset($_POST["sort"])) {
    // $how_to_sort = $_POST["sort"]; 
    // sorting($how_to_sort); 
    
    // $out = out_arr();
    
    // if (count($out) > 0) {
    //     foreach ($out as $row) {
    //         echo $row;
    //     }
    // } else {
    //     echo "Nothing found...";
    // }
    // }

    if (isset($_POST['gosearch'])) {
    $data = test_input($_POST['search']); 
    $out  = out_search($data); 
    
    // виклик функції out_arr() з action.php для отримання массиву
    if (count($out) > 0) {
        foreach ($out as $row) { //вывод массива построчно
            echo $row;
        }
    } else // если нет данных
    {
        echo "Nothing found...";
    }
}