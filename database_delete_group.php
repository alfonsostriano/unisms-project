<?php
require 'connect.php';

session_name('tzLogin');
// Starting the session
session_start();
$owner = $_SESSION['id'];

$group = $_GET['group'];

$query = "SELECT * FROM contacts WHERE owner = $owner";
$qry_result = mysql_query($query) or die(mysql_error());

while($list = mysql_fetch_array($qry_result)) {
    $id = $list['id'];
    if($group == $list['group']) {
        $newquery = $query = "UPDATE `contacts` SET `group` = NULL WHERE `id` = $id;";
        mysql_query($newquery) or die(mysql_error());
    } else {
        continue;
    }
}

require_once('address_book_gen.php');
