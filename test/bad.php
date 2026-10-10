<?php
ob_start();
?>

<html>
<?php
    header( "Content-Type: text/html; charset=utf-8" );
    echo "<body>";
    ?>

<h1>Bad</h1>

<?php
header("X-my-header: Hello world !") ;
ob_end_flush();