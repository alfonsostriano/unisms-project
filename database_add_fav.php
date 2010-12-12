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
// 
// 
// // Retrieve all the data from the "example" table
// $list_retrieve = mysql_query("SELECT * FROM contacts WHERE owner = '$owner'")
// or die(mysql_error());
// while ($list = mysql_fetch_array($list_retrieve)) {
// $name = $list['names'];
// $id = $list['id'];
// echo "<div id='contact'>";
//                 echo "<h4 id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h4>";
//                 echo "<img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
//                 echo "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/>";
//                 echo "</div>";
// }
// include 'google.php';
?>
