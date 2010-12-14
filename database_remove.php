<?php
require 'connect.php';

session_name('tzLogin');
// Starting the session
session_start();
$id = $_SESSION['id'];

// Retrieve data from Query String
$nameid = $_GET['nameid'];

// Escape User Input to help prevent SQL Injection
$nameid = mysql_real_escape_string($nameid);

	//build query
$query = "DELETE FROM contacts WHERE id = '$nameid'";
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());

require_once('address_book_gen.php');
?>
