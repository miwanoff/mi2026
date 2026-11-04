<?php
    include "header.php";
    require_once "db.php";
    require_once "card_tour.php";
?>
<section class="hero" aria-labelledby="heroTitle">
    <img src="https://images.unsplash.com/photo-1563789031959-4c02bcb41319?auto=format&fit=crop&w=2000&q=70" alt="Санторіні" width="2000" height="1333" fetchpriority="high">
    <div class="wrap">
        <p class="eyebrow">Групові тури</p>
        <h1 id="heroTitle">Каталог турів TourKit</h1>
        <p class="lead">Оберіть напрямок, транспорт, кількість зірок та максимальну ціну.</p>
        <div class="btns">
            <a class="btn btn-primary" href="#catalog">Обрати тур</a>
        </div>
    </div>
</section>

<div class="wrap">
<form method="post" action="countries.php" name="myform" id="searchForm" class="search-panel" role="search" aria-label="Пошук і фільтри турів" autocomplete="off">
    <div class="row main">
        <div class="field">
            <label for="formCountry">Виберіть країну:</label>
            <select name="formCountry" id="formCountry">
                <option value="UK">Великобританія</option>
                <option value="France">Франція</option>
                <option value="Mexico">Мексика</option>
                <option value="Japan">Японія</option>
                <option value="US">США</option>
            </select>
        </div>
        <button type="submit" name="formSubmit" class="btn btn-primary">Знайти</button>
        <a href="index.php" class="btn btn-line">Очистити пошук</a>
    </div>
    <details class="adv" id="adv" open>
        <summary>Фільтри</summary>
        <div class="filters">
            <div class="field">
                <label for="transport">Оберіть транспорт</label>
                <select name="transport" id="transport">
                    <option value="bus">Автобус</option>
                    <option value="plane">Літак</option>
                    <option value="train">Потяг</option>
                </select>
            </div>
            <div class="field">
                <label for="stars">Зірки (мін.)</label>
                <input type="number" name="stars" id="stars" min="1" max="5" value="3">
            </div>
            <div class="field" style="grid-column:1/-1;">
                <label for="price">Максимальна ціна: <span id="priceValue">300</span> €</label>
                <input type="range" id="price" name="price" min="100" max="1000" step="50" value="300" class="form-range" oninput="document.getElementById(\'priceValue\').textContent = this.value">
            </div>
        </div>
    </details>
</form>
</div>

<section class="block" id="catalog" aria-labelledby="catTitle">
    <div class="wrap">
        <div class="head">
            <div>
                <h2 id="catTitle">Каталог турів</h2>
                <p class="note">Усі тури: <?php echo count($tours); ?></p>
            </div>
        </div>
        <div class="grid">
            <?php if (!empty($tours)): ?>
                <?php foreach ($tours as $tour): ?>
                    <?php renderTourCard($tour); ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Турів не знайдено</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
include "footer.php";
?>
