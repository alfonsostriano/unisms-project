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
// CREATE THE FAVOURITE GROUP
$response .= "<div class='msg_list'><p class='msg_head'>FAV</p><div class='msg_body'>";
$query_fav = "SELECT * FROM contacts WHERE favourite = 1";
$qry_result = mysql_query($query_fav) or die(mysql_error());
while($list = mysql_fetch_array($qry_result)) {
    $name = $list['names'];
    $id = $list['id'];
        $response .= "<table width='100%'><tr><td width='70%'>";
        $response .= "<h4 title='Click to insert number' id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h4></td>";
        $response .= "<td width='30%'><img title='Add to fav' id='edit_button' src='img/fav.png' onclick='add_fav(".$id.")'/>";
        $response .= "<img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
        $response .= "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/></td></tr></table>";
}
$response .= "</div>";

$response .= "<div class='msg_list'><p class='msg_head'>ALL</p><div class='msg_body'>";
$groups = array();
while($list = mysql_fetch_array($qry_result)) {
    $group = $list['group'];
    $name = $list['names'];
    $id = $list['id'];
        $response .= "<table width='100%'><tr><td width='70%'>";
        $response .= "<h4 title='Click to insert number' id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h4></td>";
        $response .= "<td width='30%'><img title='Add to fav' id='edit_button' src='img/fav.png' onclick='add_fav(".$id.")'/>";
        $response .= "<img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
        $response .= "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/></td></tr></table>";
    
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
        $response .= "<table width='100%'><tr><td width='80%'>";
        $response .= "<h4 title='Click to insert number' id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h4></td>";
        $response .= "<td width='20%'><img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
        $response .= "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/></td></tr></table>";
    } else {
        $response .= "<table width='100%'><tr><td width='80%'>";
        $response .= "<h4 title='Click to insert number' id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h4></td>";
        $response .= "<td width='20%'><img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
        $response .= "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/></td></tr></table>";
    }

}

$response .= "</div>";
echo $response;
?>
