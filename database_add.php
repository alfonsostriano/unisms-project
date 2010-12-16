<?php
require 'connect.php';


session_name('tzLogin');
// Starting the session
session_start();
$owner = $_SESSION['id'];


	// Retrieve data from Query String
$names = $_GET['names'];
$phone = $_GET['phone'];
$group = $_GET['group'];

	// Escape User Input to help prevent SQL Injection
$names = mysql_real_escape_string($names);
$phone = mysql_real_escape_string($phone);
$group = mysql_real_escape_string($group);

if($group == 'none') {
    $query = "INSERT INTO `unisms`.`contacts` (`id`, `names`, `phone`, `owner`, `group`, `favourite`) VALUES (NULL, '".$names."', '".$phone."', '".$owner."', NULL, '0')";
} else {
    $query = "INSERT INTO `unisms`.`contacts` (`id`, `names`, `phone`, `owner`, `group`, `favourite`) VALUES (NULL, '".$names."', '".$phone."', '".$owner."', '".$group."', '0')";
}
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());

require_once('address_book_gen.php');
?>
