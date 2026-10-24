<?php
$redir = "country.php";
if (isset($_POST['formSubmit'])) {
    $country   = isset($_POST['formCountry']) ? (string) $_POST['formCountry'] : "UK";
    $transport = isset($_POST['transport']) ? (string) $_POST['transport'] : "bus";
    $stars     = isset($_POST['stars']) ? (int) $_POST['stars'] : 3;
    $price     = isset($_POST['price']) ? (int) $_POST['price'] : 1000;

    $stars = max(1, min(5, $stars));
    $price = max(100, min(1000, $price));

    // Normalize transport to match DB values
    $transportMap = ['plane' => 'airplane', 'bus' => 'bus', 'train' => 'train'];
    $transport = $transportMap[$transport] ?? $transport;

    $query = http_build_query([
        'country'   => $country,
        'transport' => $transport,
        'stars'     => $stars,
        'price'     => $price,
    ]);
    header("Location: $redir?$query");
    exit();
}
?>