<?php
$country = "UK";
$redir   = "country.php";

if (isset($_POST['formSubmit'])) {
    $country   = isset($_POST['formCountry']) ? (string)$_POST['formCountry'] : "UK";
    $transport = isset($_POST['transport'])   ? (string)$_POST['transport']   : "";
    $stars     = isset($_POST['stars'])      ? (int)$_POST['stars']          : 1;
    $price     = isset($_POST['price'])      ? (int)$_POST['price']          : 1000;

    $stars = max(1, min(5, $stars));
    $price = max(100, min(1000, $price));

    $allowedCountries = ["UK", "France", "Mexico", "Japan", "US"];
    if (!in_array($country, $allowedCountries, true)) {
        $country = "UK";
    }
    $allowedTransport = ["", "bus", "plane", "train"];
    if (!in_array($transport, $allowedTransport, true)) {
        $transport = "";
    }

    header("Location: $redir?country=" . urlencode($country) . "&transport=" . urlencode($transport) . "&stars=$stars&price=$price");
    exit();
}