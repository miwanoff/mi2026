<?php

header("Content-Type: text/html; charset=utf-8");
header("X-my-header: Hello world !") ;
echo "<a href='./redirect.php'>redir</a><br>";
echo "<a href='./refresh.php'>refresh</a><br>";
echo "<a href='./bad.php'>bad</a><br>";
?>