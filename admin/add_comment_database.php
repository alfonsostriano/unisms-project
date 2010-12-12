<?php
require '../connect.php';

// Retrieve data from Query String
$title = $_POST['title'];
$contents = $_POST['contents'];

// Escape User Input to help prevent SQL Injection
$title = mysql_real_escape_string($title);
$contents = mysql_real_escape_string($contents);

//build query
$query = "INSERT INTO `unisms`.`comunications` (`id`, `date`, `title`, `contents`) VALUES (NULL, NOW(), '".$title."', '".$contents."')";

//Execute query
mysql_query($query) or die(mysql_error());

header("Location:comunications.php")
?>
