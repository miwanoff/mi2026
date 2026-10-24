<?php
    include "header.php";
?>
<div class="wrap">
    <section class="hero" style="padding:0;margin-top:1.5rem">
        <div class="hero__text">
            <span class="chip">Тури за вашими критеріями</span>
            <h1>Тури за вашими датами, бюджетом і готелем</h1>
            <p>Порівнюйте ціни та обирайте тур за країною, транспортом, кількістю зірок і ціною.</p>
        </div>
        <div class="hero__img">
            <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1400&q=75" alt="Мальовничий краєвид для подорожі" width="1400" height="933">
        </div>
    </section>
    <form class="search" method="post" action="countries.php" name="myform">
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
        <div class="field">
            <label for="transport">Оберіть транспорт</label>
            <select name="transport" id="transport">
                <option value="bus">Автобус</option>
                <option value="plane">Літак</option>
                <option value="train">Потяг</option>
            </select>
        </div>
        <div class="field">
            <label for="stars">Зірки</label>
            <input type="number" name="stars" id="stars" min="1" max="5" value="3">
        </div>
        <div class="field">
            <label for="price">Ціна (між 100 та 1000): <span id="priceValue">1000</span></label>
            <input type="range" id="price" name="price" min="100" max="1000" step="50" value="1000" class="form-range">
        </div>
        <button class="btn btn--primary" type="submit" name="formSubmit">ОК</button>
    </form>
</div>
<?php require "db.php"; ?>
<div class="wrap" id="tours" style="margin-top:2rem">
    <h2>Усі тури</h2>
    <div class="grid">
        <?php foreach ($tours as $tour): ?>
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
</div>
<?php
include "footer.php";
?>