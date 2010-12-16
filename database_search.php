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
$response = "";
$qry_result = mysql_query($query) or die(mysql_error());
while ($list = mysql_fetch_array($qry_result)) {
    $name = $list['names'];
    $id = $list['id'];
        $response .= "<div id='single_contact'><h5 title='Click to insert number' id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h5>";
        $response .= "<img title='Add to fav' id='fav_button' src='img/unfav.png' onclick='add_fav(".$id.")'onMouseOver='change_to_fav_image(this)' onMouseOut='change_to_unfav_image(this)'/>";
        $response .= "<img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
        $response .= "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/></div>";
}

echo $response;
?>
