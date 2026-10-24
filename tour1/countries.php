<?php
$country = "UK"; 
$redir   = "country.php";
if (isset($_POST['formSubmit'])) {
    $country   = $_POST['formCountry']; 
    $transport = $_POST['transport']; 
    $stars     = $_POST['stars']; 
    $price     = $_POST["price"]; 
    header("Location: $redir?country=$country&transport=$transport&stars=$stars&price=$price");
    exit();
}