<?php
require 'connect.php';


session_name('tzLogin');
// Starting the session
session_start();
$owner = $_SESSION['id'];


	//build query
$query = "SELECT DISTINCT `group` FROM `contacts` WHERE `owner` = '$owner'";

	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());

$response = "<div><label for='drop_down'>Group: </label>";
$response .= "<select title='Select group' id='select_group' name='drop_down' onchange='add_group_input()'>";
$response .= "<option value='none'>None</option>";
while ($row = mysql_fetch_array($qry_result)) {
    if($row['group'] != '') {
        $response .= "<option value='".$row[group]."'>".$row[group]."</option>";
    }
}
$response .= "<option value='other'>other.. </option>";
$response .= "</select></div>";
$response .= "<div id='add_form_new_group'><label for='insert_group'>New: </label><input name='insert_group' id='new_group' value='Insert Name'/></div>";
echo $response;
?>