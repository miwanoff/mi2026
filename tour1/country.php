<?php
require "db.php";

$country   = isset($_GET["country"])   ? (string)$_GET["country"]   : "UK";
$transport = isset($_GET["transport"]) ? (string)$_GET["transport"] : "";
$stars     = isset($_GET["stars"])     ? (int)$_GET["stars"]        : 1;
$price     = isset($_GET["price"])     ? (int)$_GET["price"]        : 1000;

$stars = max(1, min(5, $stars));
$price = max(100, min(1000, $price));

include "header.php";
?>
<p>Ви обрали:</p>

<h2><?= htmlspecialchars($country) ?></h2>
<p>Транспорт: <?= htmlspecialchars($transport !== "" ? $transport : "будь-який") ?></p>
<p>Зірки: <?= $stars ?></p>
<p>Макс. ціна: <?= $price ?></p>
<?php
$results = [];
foreach ($tours as $tour) {
    if ($tour['country'] !== $country) {
        continue;
    }
    if ($transport !== "" && $tour['transport'] !== $transport) {
        continue;
    }
    if ($tour['stars'] < $stars) {
        continue;
    }
    if ($tour['price'] > $price) {
        continue;
    }
    $results[] = $tour;
}

if (empty($results)) {
    echo "<p>На жаль, за обраними критеріями турів не знайдено.</p>";
} else {
    foreach ($results as $tour) {
        echo "<h3>name " . htmlspecialchars($tour['name']) . "  </h3>";
        echo "<p>stars " . (int)$tour['stars'] . "  </p>";
        echo "<p>price " . (int)$tour['price'] . "  </p>";
        echo "<p>transport " . htmlspecialchars($tour['transport']) . "  </p>";
    }
}

include "footer.php";