<?php
require 'connect.php';

session_name('tzLogin');
// Starting the session
session_start();
$id = $_SESSION['id'];
	//build query
$query = "DELETE FROM contacts WHERE owner = '$id'";
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());

require_once('address_book_gen.php');
?>

