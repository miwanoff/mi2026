<?php
    if (isset($_POST['submit'])) {
    echo "Your First Name is:" . $_POST["FName"] . "<br/>";
    echo "Your Last Name is:" . $_POST["LName"] . "<br/>";
    echo "Your City is:" . $_POST["City"] . "<br/>";
    echo "Your State is:" . $_POST["State"] . "<br/>";
    echo "<br/>";
    echo "Your Message is:" . $_POST["Message"];
    
    print_r ($_POST['in']);
    echo count($_POST['in']);
    for ($i = 0; $i < count($_POST['in']); $i++) {
        echo $_POST['in'][$i] . '"<br/>';
    }

    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>A Web Page</title>
    <meta charset="utf-8" />
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        First Name:<br />
        <input type="text" name="FName" /><br />
        Last Name:<br />
        <input type="text" name="LName" /><br />
        City:<br />
        <input type="text" name="City" /><br />
        State:<br />
        <input type="text" name="State" /><br />
        Message:<br />
        <textarea name="Message" cols="30" rows="5">
      </textarea><br />
        <input type="submit" name="submit" value="Submit Data" /><br>
        <input type="text" name="in[]" value="1">
        <input type="text" name="in[]" value="2">
        <input type="text" name="in[]" value="3">
    </form>
</body>

</html>