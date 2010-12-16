<?php
require 'connect.php';


session_name('tzLogin');
// Starting the session
session_start();
$owner = $_SESSION['id'];

$list = $_GET['list'];


	//build query
$query = "SELECT DISTINCT `group` FROM `contacts` WHERE `owner` = '$owner'";

	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());

$response = "<div><label for='drop_down'>Group: </label>";
if($list == 'add') {
    $response .= "<select title='Select group' id='select_group_add' name='drop_down' onchange='add_group_input(0)'>";
} else {
    $response .= "<select title='Select group' id='select_group_edit' name='drop_down' onchange='add_group_input(1)'>";
}
$response .= "<option value='none'>None</option>";
while ($row = mysql_fetch_array($qry_result)) {
    if($row['group'] != '') {
        $response .= "<option value='".$row[group]."'>".$row[group]."</option>";
    }
}
$response .= "<option value='other'>other.. </option>";
$response .= "</select></div>";
if($list == 'add') {
    $response .= "<div id='add_form_new_group_add'><label for='insert_group'>New: </label><input name='insert_group' id='new_group_add' value='..'/></div>";
} else {
    $response .= "<div id='add_form_new_group_edit'><label for='insert_group'>New: </label><input name='insert_group' id='new_group_edit' value='..'/></div>";
}

echo $response;
?>