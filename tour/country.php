<?php
require "db.php";

$country = $_GET["country"];
include "header.php";
?>
<p>Ви обрали:</p>

<h2><?= $country ?></h2>
<?php
include "footer.php" ;