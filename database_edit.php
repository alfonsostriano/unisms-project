<?php
require 'connect.php';


session_name('tzLogin');
// Starting the session
session_start();
$owner = $_SESSION['id'];


	// Retrieve data from Query String
$names = $_GET['names'];
$phone = $_GET['phone'];
$edit_id = $_GET['edit_id'];
$group = $_GET['group'];


	// Escape User Input to help prevent SQL Injection
$names = mysql_real_escape_string($names);
$phone = mysql_real_escape_string($phone);
$edit_id = mysql_real_escape_string($edit_id);
$group = mysql_real_escape_string($group);

if ($group == 'none') {
    $query = "UPDATE `unisms`.`contacts` SET `names` = '".$names."', `phone`= '".$phone."', `group`= NULL WHERE `contacts`.`id` = '".$edit_id."';";
} else {
    $query = "UPDATE `unisms`.`contacts` SET `names` = '".$names."', `phone`= '".$phone."', `group`= '".$group."' WHERE `contacts`.`id` = '".$edit_id."';";
}
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());

require_once('address_book_gen.php');
?>