<?php
require "db.php";
require_once "card_tour.php";

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
<section class="wrap block" style="padding-block:var(--sp-5) var(--sp-6);">
    <h1 style="font-family:var(--font-head);font-size:var(--fs-h2);margin-bottom:var(--sp-4);">Результати пошуку</h1>
    <p style="font-size:var(--fs-small);color:#52676a;margin-bottom:var(--sp-4);">
        Країна: <strong><?php echo htmlspecialchars($country, ENT_QUOTES, 'UTF-8'); ?></strong> |
        Транспорт: <strong><?php echo htmlspecialchars($transport, ENT_QUOTES, 'UTF-8'); ?></strong> |
        Мін. зірки: <strong><?php echo $stars; ?></strong> |
        Макс. ціна: <strong><?php echo $price; ?> €</strong>
    </p>

<?php
$matched = [];
foreach ($tours as $tour) {
    if ($tour['country'] !== $country) {
        continue;
    }
    if ($tour['transport'] !== $transport) {
        continue;
    }
    if ((int)$tour['stars'] < $stars) {
        continue;
    }
    if ((int)$tour['price'] > $price) {
        continue;
    }
    $matched[] = $tour;
}

if (empty($matched)) {
    echo "<p style='font-size:var(--fs-small);color:#52676a;'>На жаль, за вашим запитом турів не знайдено.</p>";
} else {
    echo '<div class="grid">';
    foreach ($matched as $tour) {
        renderTourCard($tour);
    }
    echo '</div>';
}
?>
</section>
<?php
include "footer.php";
?>
