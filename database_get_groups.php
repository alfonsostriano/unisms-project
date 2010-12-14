<?php
require 'connect.php';

session_name('tzLogin');
// Starting the session
session_start();
$id = $_SESSION['id'];

$query = "SELECT DISTINCT group FROM contacts";
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());


	// Insert a new row in the table for each person returned
while($row = mysql_fetch_array($qry_result)){
	$display_string .= $row[group];
}
echo $display_string;
?>
