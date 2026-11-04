<?php
function renderTourCard($tour) {
    $imgPart = isset($tour['img']) ? $tour['img'] : '';
    $imgUrl = '';
    if (!empty($imgPart)) {
        $imgUrl = 'https://images.unsplash.com/' . htmlspecialchars($imgPart, ENT_QUOTES, 'UTF-8') . '?auto=format&fit=crop&w=900&q=72';
    }
    $name = htmlspecialchars($tour['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $country = htmlspecialchars($tour['country'] ?? '', ENT_QUOTES, 'UTF-8');
    $stars = isset($tour['stars']) ? (int)$tour['stars'] : 0;
    $price = htmlspecialchars($tour['price'] ?? '', ENT_QUOTES, 'UTF-8');
    $transport = htmlspecialchars($tour['transport'] ?? '', ENT_QUOTES, 'UTF-8');
    ?>
    <article class="card">
        <div class="card-img">
            <?php if ($imgUrl): ?>
                <img src="<?= $imgUrl ?>" alt="<?= $name ?>" loading="lazy" onerror="this.style.display='none'; this.parentElement.classList.add('card-img-fallback');">
            <?php else: ?>
                <div class="card-img-fallback"></div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div>
                <p class="route"><?= $country ?></p>
                <h3><?= $name ?></h3>
            </div>
            <dl class="meta">
                <div class="wide"><dt>Транспорт</dt><dd><?= $transport ?></dd></div>
                <div class="wide"><dt>Зірки</dt><dd><?= $stars ?></dd></div>
            </dl>
            <div class="card-foot">
                <div class="price">
                    <strong><?= $price ?> €</strong>
                    <small>за особу</small>
                </div>
                <span class="btn btn-primary" aria-disabled="true">Детальніше</span>
            </div>
        </div>
    </article>
    <?php
}
