<?php
$v = "France";
if (isset($_POST['formSubmit'])) {
    $v = $_POST['formCountry'];
    $redir = "US.html";
    switch ($v) {
        case "US":$redir = "US.html";
            break;
        case "UK":$redir = "UK.html";
            break;
        case "France":$redir = "France.html";
            break;
        case "Mexico":$redir = "Mexico.html";
            break;
        case "Japan":$redir = "Japan.html";
            break;
        default:echo ("Error!");exit();
            break;
    }
    header("Location: $redir");
    exit();
}