<?php
require "db.php";

$country   = isset($_GET["country"])   ? (string)$_GET["country"]   : "UK";
$transport = isset($_GET["transport"]) ? (string)$_GET["transport"] : "";
$stars     = isset($_GET["stars"])     ? (int)$_GET["stars"]        : 1;
$price     = isset($_GET["price"])     ? (int)$_GET["price"]        : 1000;

$stars = max(1, min(5, $stars));
$price = max(100, min(1000, $price));

$results = [];
foreach ($tours as $tour) {
    if ($tour['country'] !== $country) continue;
    if ($transport !== "" && $tour['transport'] !== $transport) continue;
    if ($tour['stars'] < $stars) continue;
    if ($tour['price'] > $price) continue;
    $results[] = $tour;
}

include "header.php";
?>
<section class="wrap" style="padding-block: var(--sp-4)">
    <p>Ви обрали: <?= htmlspecialchars($country) ?> · Транспорт: <?= htmlspecialchars($transport !== "" ? $transport : "будь-який") ?> · Зірки: <?= $stars ?> · Макс. ціна: <?= $price ?></p>
    <?php if (empty($results)): ?>
        <div class="empty"><p>На жаль, за обраними критеріями турів не знайдено.</p></div>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($results as $tour): ?>
                <article class="card">
                    <div class="card__img"><img src="https://images.unsplash.com/<?= htmlspecialchars($tour['img']) ?>?auto=format&fit=crop&w=900&q=72" alt="<?= htmlspecialchars($tour['name']) ?>"></div>
                    <div class="card__body">
                        <h3><?= htmlspecialchars($tour['name']) ?></h3>
                        <p class="card__place"><?= htmlspecialchars($tour['country']) ?></p>
                        <div class="facts">
                            <div><dt>Зірки</dt><dd><?= (int)$tour['stars'] ?> ★</dd></div>
                            <div><dt>Ціна</dt><dd><?= (int)$tour['price'] ?></dd></div>
                            <div class="wide"><dt>Транспорт</dt><dd><?= htmlspecialchars($tour['transport']) ?></dd></div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <p><a class="btn btn--ghost btn--sm" href="index.php">Новий пошук</a></p>
</section>
<?php
include "footer.php";