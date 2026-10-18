<?php
$country = "UK"; 
$redir   = "country.php";
if (isset($_POST['formSubmit'])) {
    $country   = $_POST['formCountry']; 
    $transport = $_POST['transport']; 
    $stars     = $_POST['stars']; 
    $price     = $_POST["price"]; 
    // $redir = "US.html";
    // switch ($v) {
    //     case "US":$redir = "US.html";
    //         break;
    //     case "UK":$redir = "UK.html";
    //         break;
    //     case "France":$redir = "France.html";
    //         break;
    //     case "Mexico":$redir = "Mexico.html";
    //         break;
    //     case "Japan":$redir = "Japan.html";
    //         break;
    //     default:echo ("Error!");exit();
    //         break;
    // }
    header("Location: $redir?country=$country&transport=$transport&stars=$stars&price=$price");
    exit();
}