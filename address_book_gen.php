<?php
require 'connect.php';

session_name('tzLogin');
// Starting the session
session_start();
$owner = $_SESSION['id'];

	//build query
$query = "SELECT * FROM contacts WHERE owner = '$owner'";
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());



$response = "";


// CREATE THE GROUP CONTAING ALL THE CONTACTS
$response .= "<div id='message_list' class='msg_list'><p class='msg_head'>ALL</p><div class='msg_body'>";
$groups = array();
while($list = mysql_fetch_array($qry_result)) {
    $group = $list['group'];
    $name = $list['names'];
    $id = $list['id'];
        $response .= "<div id='single_contact'><h5 title='Click to insert number' id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h5>";
        $response .= "<img title='Add to fav' id='fav_button' src='img/fav.png' onclick='add_fav(".$id.")'/>";
        $response .= "<img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
        $response .= "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/></div>";

}
$response .= "</div>";

// CREATE THE FAVOURITE GROUP
$response .= "<p class='msg_head'>FAV</p><div class='msg_body'>";

$query_fav = "SELECT * FROM contacts WHERE favourite = 1";

$qry_result = mysql_query($query_fav) or die(mysql_error());

while($list = mysql_fetch_array($qry_result)) {
    $name = $list['names'];
    $id = $list['id'];
        $response .= "<div id='single_contact'><h5 title='Click to insert number' id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h5>";
        $response .= "<img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
        $response .= "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/></div>";
}

$query = "SELECT * FROM contacts WHERE owner = '".$owner."' ORDER BY `contacts`.`owner` ASC";
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());

$current_group = "";

while($list = mysql_fetch_array($qry_result)) {
    $group = $list['group'];
    $name = $list['names'];
    $id = $list['id'];
    if($group == "") continue;

    if(strcmp($group,$current_group)) {
        $current_group = $group;

        $response .= "</div>";
        $response .= "<p class='msg_head'>".$group."</p><div class='msg_body'>";
        $response .= "<div id='single_contact'><h5 title='Click to insert number' id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h5>";
        $response .= "<img title='Add to fav' id='fav_button' src='img/fav.png' onclick='add_fav(".$id.")'/>";
        $response .= "<img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
        $response .= "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/></div>";
    } else {
        $response .= "<div id='single_contact'><h5 title='Click to insert number' id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h5>";
        $response .= "<img title='Add to fav' id='fav_button' src='img/fav.png' onclick='add_fav(".$id.")'/>";
        $response .= "<img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
        $response .= "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/></div>";
    }
}

$response .= "</div></div>";
$response .= '<div id="contact_edit">
                    <p><label for="names">Name: </label><input title="Insert contact name" id="name_edit" name="names"/></p>
                    <p><label for="phone">Phone: </label><input title="Insert contact number" id="phone_edit" name="phone"/></p>
                    <div id="edit_id"></div>
                    <button title="Submit Changes" id="confirm_edit" onclick="submit_contact_edit()">Ok</button>
              </div>';
include ('google.php');
echo $response;
?>
