<?php
require 'connect.php';


session_name('tzLogin');
// Starting the session
session_start();
$owner = $_SESSION['id'];


// Retrieve data from Query String
$nameid = $_GET['nameid'];
echo($nameid);
  // Escape User Input to help prevent SQL Injection
$nameid = mysql_real_escape_string($nameid);

  //build query
$query = "UPDATE `unisms`.`contacts` SET `favourite`=1 WHERE `contacts`.`id` = '$nameid'";

  //Execute query

mysql_query($query) or die(mysql_error());

require_once('address_book_gen.php')
?>
