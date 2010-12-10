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

	// Escape User Input to help prevent SQL Injection
$names = mysql_real_escape_string($names);
$phone = mysql_real_escape_string($phone);
$edit_id = mysql_real_escape_string($edit_id);

	//build query
$query = "UPDATE `unisms`.`contacts` SET `names` = '".$names."', `phone`= '".$phone."' WHERE `contacts`.`id` = '".$edit_id."';";
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());

$alphabetically_sort = "ALTER TABLE `contacts` ORDER BY `names`";
$qry_result = mysql_query($alphabetically_sort) or die(mysql_error());

// Retrieve all the data from the "example" table
$list_retrieve = mysql_query("SELECT * FROM contacts WHERE owner = '$owner'")
or die(mysql_error());
while ($list = mysql_fetch_array($list_retrieve)) {
$name = $list['names'];
$id = $list['id'];
echo "<div id='contact'>";
                echo "<h4 id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h4>";
                echo "<img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
                echo "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/>";
                echo "</div>";
}
include 'google.php';
?>