<?php
require "db.php";

$country   = isset($_GET["country"]) ? (string) $_GET["country"] : "UK";
$transport = isset($_GET["transport"]) ? (string) $_GET["transport"] : "bus";
$stars     = isset($_GET["stars"]) ? (int) $_GET["stars"] : 3;
$price     = isset($_GET["price"]) ? (int) $_GET["price"] : 1000;

$stars = max(1, min(5, $stars));
$price = max(100, min(1000, $price));

$transportMap = ['plane' => 'airplane', 'bus' => 'bus', 'train' => 'train'];
$transport = $transportMap[$transport] ?? $transport;

include "header.php";
?>
<p>Ви обрали:</p>

<h2><?php echo htmlspecialchars($country, ENT_QUOTES, 'UTF-8'); ?></h2>
<p>Транспорт: <?= htmlspecialchars($transport, ENT_QUOTES, 'UTF-8') ?></p>
<p>Зірки (мін.): <?= $stars ?></p>
<p>Макс. ціна: <?= $price ?></p>

<?php
$matched = [];
foreach ($tours as $tour) {
    if ($tour['country'] !== $country) {
        continue;
    }
    if ($tour['transport'] !== $transport) {
        continue;
    }
    if ((int) $tour['stars'] < $stars) {
        continue;
    }
    if ((int) $tour['price'] > $price) {
        continue;
    }
    $matched[] = $tour;
}

if (empty($matched)) {
    echo "<p>Турів не знайдено</p>";
} else {
    foreach ($matched as $tour) {
        echo "<h3>name " . htmlspecialchars($tour['name'], ENT_QUOTES, 'UTF-8') . "  </h3>";
        echo "<p>stars " . htmlspecialchars($tour['stars'], ENT_QUOTES, 'UTF-8') . "  </p>";
        echo "<p>price " . htmlspecialchars($tour['price'], ENT_QUOTES, 'UTF-8') . "  </p>";
        echo "<p>transport " . htmlspecialchars($tour['transport'], ENT_QUOTES, 'UTF-8') . "  </p>";
    }
}

include "footer.php";
?>