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
    </select>
    <button name="formSubmit">ОК</button>
</form>
<?php 
include "footer.php";
?>