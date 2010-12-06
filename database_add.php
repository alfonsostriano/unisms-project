<?php
require 'connect.php';


session_name('tzLogin');
// Starting the session
session_start();
$id = $_SESSION['id'];


	// Retrieve data from Query String
$names = $_GET['names'];
$phone = $_GET['phone'];

	// Escape User Input to help prevent SQL Injection
$names = mysql_real_escape_string($names);
$phone = mysql_real_escape_string($phone);


	//build query
$query = "INSERT INTO `unisms`.`contacts` (`id`, `names`, `phone`, `owner`) VALUES (NULL, '".$names."', '".$phone."', '".$id."')";
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());

echo $names; 
?>
