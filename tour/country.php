<?php
    require "db.php"; 

    $country = $_GET["country"];
    $transport = $_GET["transport"];
    $stars = $_GET["stars"];
    $price = $_GET["price"];
    
    include "header.php";
?>
<p>Ви обрали:</p>

<h2><?php echo $country ?></h2>
<p>Транспорт: <?= $transport ?></p>
<p>Зірки: <?= $stars ?></p>
<p>Макс. ціна: <?= $price ?></p>
<?php
    $tours_keys = [];
    foreach ($tours as $key => $tour) {
    if ($tour['country'] == $country) {
        $tours_keys[] = $key; // "0" => 3, "1" => 6 (for Mexico)
    }
    }

    for ($i = 0; $i < count($tours); $i++) {
    if (in_array($i, $tours_keys)) { 
        // echo "$i <br>";
        echo "<h3>name {$tours[$i]['name']}  </h3>";
        echo "<p>stars {$tours[$i]['stars']}  </p>";
        echo "<p>price {$tours[$i]['price']}  </p>";
        
        echo "<p>transport {$tours[$i]['transport']}  </p>"; 
        // echo $tours[$i]['name']. "<br>" ;
    }
    }

include "footer.php";