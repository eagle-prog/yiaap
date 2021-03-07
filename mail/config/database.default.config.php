<?php
$db_driver="mysql"; 
$db_server="localhost"; // Your Database Server name;
$db_username="yiaapc5_ymail"; // Your Database username;
$db_password="Gilmata4219x@"; // Your Database password;
$db_name="yiaapc5_ymail"; // Your Database name;
$db_tableprefix=""; // Table prefix if you want to add something.
$conn=mysqli_connect($db_server, $db_username, $db_password) or
die("Could not connect: " . mysqli_error($conn));
mysqli_select_db($conn,$db_name);
mysqli_query($conn, "set names utf8 collate utf8_unicode_ci");
?>
