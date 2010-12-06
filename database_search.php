<?php
require 'connect.php';

session_name('tzLogin');
// Starting the session
session_start();
$id = $_SESSION['id'];



	// Retrieve data from Query String
$search = $_GET['search'];

	// Escape User Input to help prevent SQL Injection
$search = mysql_real_escape_string($search);


	//build query
$query = "SELECT * FROM contacts WHERE names LIKE '%$search%' AND owner = '$id'";
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());
$string = "";
while ($list = mysql_fetch_array($qry_result)) {
    $name = $list['names'];
    $id = $list['id'];
    $string .= "<h4 onclick='getNumber(".$id.")'>" . $name . "</h4>";
}
echo $string;

?>
