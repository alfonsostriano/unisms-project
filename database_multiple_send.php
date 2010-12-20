<?php
require 'connect.php';

session_name('tzLogin');
// Starting the session
session_start();
$owner = $_SESSION['id'];


	// Retrieve data from Query String
$group = $_GET['group'];

	// Escape User Input to help prevent SQL Injection
$group = mysql_real_escape_string($group);

if($group == 'all') {
    $query = "SELECT * FROM contacts WHERE owner = ".$owner;
}
else if($group == 'fav') {
    $query = "SELECT * FROM contacts WHERE contacts.favourite = 1 AND owner = ".$owner;
} else {
    $query = "SELECT * FROM contacts WHERE contacts.group = '$group' AND owner = ".$owner;
}

$qry_result = mysql_query($query) or die(mysql_error());


$display_string = '';
	// Insert a new row in the table for each person returned
    $row = mysql_fetch_array($qry_result);
    $display_string .= $row[phone];
while($row = mysql_fetch_array($qry_result)){
    $display_string .= ', ';
    $display_string .= $row[phone];
}
echo $display_string;
?>