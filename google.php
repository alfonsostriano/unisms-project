<?php
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
                  
                    foreach ($xml->phoneNumber as $p) {
                      $obj->phoneNumber[] = (string) $p;
                    }
                    
                    $results[] = $obj;
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
                    echo "<h4 id='contact_name' onclick='addGoogle($current_number)'>" . $name . "$i</h4>";
                    echo "<img id='delete_button' src='img/google_ico.png'>";
                    $i++;
                  }
                }
            }