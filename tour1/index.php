<?php
    include "header.php";
?>
<form method="post" action="countries.php" name="myform">
    <label for='formCountry'> Виберіть країну: </label>
    <select name="formCountry">
        <option value="UK">Великобританія</option>
        <option value="France">Франція</option>
        <option value="Mexico">Мексика</option>
        <option value="Japan">Японія</option>
        <option value="US">США</option>
    </select><br>
    <label for="transport">Оберіть транспотр</label>
    <select name="transport" id="transport">
        <option value="bus">Автобус</option>
        <option value="plane">Літак</option>
        <option value="train">Потяг</option>
    </select><br>
    <label for="transpostarsrt">Stars</label>
    <input type="number" name="stars" id="stars" min="1" max="5" value="3"><br>
    <label for="price">Ціна (між 100 та 1000):</label>
    <input type="range" id="price" name="price" min="100" max="1000" step="50" class="form-range"><br>
    <button name="formSubmit">ОК</button>
</form>
<?php
include "footer.php";
?>