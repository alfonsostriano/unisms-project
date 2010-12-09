<?php
require 'connect.php';


session_name('tzLogin');
// Starting the session
session_start();
$owner = $_SESSION['id'];

	// Escape User Input to help prevent SQL Injection

$entryNum = 100;
$name = "contact";
for($i = 0; $i <= $entryNum; $i++) {
    //build query
    $query = "INSERT INTO `contacts` (`id`, `names`, `phone`, `owner`) VALUES (NULL, '".$name.$i."', '".$i.$i."', '".$owner."')";
    ////Execute query
    $qry_result = mysql_query($query) or die(mysql_error());
}

?>
