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

// -------------------

require_once 'Zend/Loader.php';
                Zend_Loader::loadClass('Zend_Gdata');
                Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
                Zend_Loader::loadClass('Zend_Http_Client');
                Zend_Loader::loadClass('Zend_Gdata_Query');
                Zend_Loader::loadClass('Zend_Gdata_Feed');
                
                // set credentials for ClientLogin authentication
                  include 'connect.php';
                  $query  = "SELECT gsave FROM tz_members WHERE usr='{$_SESSION['usr']}'";
                  $query_result = mysql_query($query);
                  $result = mysql_fetch_array($query_result);
                  $password_saved = $result['gsave'];
                  
                  if($password_saved == 1){
                    $id = $_SESSION['id'];
                    
                    $query  = "SELECT gemail FROM tz_members WHERE id = $id";
                    $query_result = mysql_query($query);
                    $result = mysql_fetch_array($query_result);
                    $gemail = $result['gemail'];
                    $user = $gemail;
                    
                    $query  = "SELECT gpass FROM tz_members WHERE id = $id";
                    $query_result = mysql_query($query);
                    $result = mysql_fetch_array($query_result);
                    $gpass = $result['gpass'];
                    $pass = $gpass;
                  } else{
                    return;
                  }
                
                try {
                  // perform login and set protocol version to 3.0
                  $client = Zend_Gdata_ClientLogin::getHttpClient(
                    $user, $pass, 'cp');
                  $gdata = new Zend_Gdata($client);
                  $gdata->setMajorProtocolVersion(3);
                  
                  // perform query and get result feed
                  $query = new Zend_Gdata_Query('http://www.google.com/m8/feeds/contacts/default/full');
                  $query->maxResults = 1000;
                  $feed = $gdata->getFeed($query);
                  
                  // parse feed and extract contact information
                  // into simpler objects
                  $results = array();
                  foreach($feed as $entry){
                    $xml = simplexml_load_string($entry->getXML());
                    $obj = new stdClass;
                    $obj->name = (string) $entry->title;
                    if(strlen(strstr($obj->name,$search))>0){
                      foreach ($xml->phoneNumber as $p) {
                        $obj->phoneNumber[] = (string) $p;
                      } 
                    
                      $results[] = $obj;
                    } else continue;
                  }
                } catch (Exception $e) {
                  die('ERROR:' . $e->getMessage());  
                }
                
            foreach ($results as $r) {
                $name = $r->name;
                $number = $r->phoneNumber;
                if(count($number) != 0){
                  $i = 1;
                  
                  foreach($number as $current_number){
                    if($current_number != ""){
                      $response .= "<div id='single_contact'><h5 title='Click to insert number' id='contact_name' onclick='addGoogle($current_number)'>" . $name . "</h5>";
                      $response .= "<img id='google_ico' src='img/google_ico.png'></div>";
                    }
                    $i++;
                  }
                  
                }
            }
            
echo $response;
?>
