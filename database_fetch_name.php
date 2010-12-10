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
$query = "SELECT * FROM contacts WHERE id = '$nameid'";
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());


	// Insert a new row in the table for each person returned
while($row = mysql_fetch_array($qry_result)){
	$display_string = $row[names];
}
echo $display_string;
?>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
