<?php

define('INCLUDE_CHECK',true);

require 'connect.php';
require 'functions.php';
// Those two files can be included only if INCLUDE_CHECK is defined


session_name('tzLogin');
// Starting the session

session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks

session_start();

if($_SESSION['id'] && !isset($_COOKIE['tzRemember']) && !$_SESSION['rememberMe'])
{
	// If you are logged in, but you don't have the tzRemember cookie (browser restart)
	// and you have not checked the rememberMe checkbox:

	$_SESSION = array();
	session_destroy();
	
	// Destroy the session
}


if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();	
	header("Location: index.php");
	exit;
}

if(isset($_GET['delete']))
{
  mysql_query("DELETE FROM tz_members WHERE usr='{$_SESSION['usr']}'"); 
  $_SESSION = array();
  session_destroy();
  header("Location: index.php");
  exit;
}

if(isset($_GET['remove_password']))
{
  mysql_query ("UPDATE tz_members SET save = 0 WHERE usr='{$_SESSION['usr']}'");
  mysql_query ("UPDATE tz_members SET mailpass = '' WHERE usr='{$_SESSION['usr']}'");
  header("Location: index.php");
  exit;
}


if(isset($_GET['stopsync']))
{
  mysql_query ("UPDATE tz_members SET gsave = 0 WHERE usr='{$_SESSION['usr']}'");
  mysql_query ("UPDATE tz_members SET gpass = '' WHERE usr='{$_SESSION['usr']}'");
  mysql_query ("UPDATE tz_members SET gemail = '' WHERE usr='{$_SESSION['usr']}'");
  
  header("Location: index.php");
  exit;
}





if($_POST['submit']=='Login')
{
	// Checking whether the Login form has been submitted
	
	$err = array();
	// Will hold our errors
	
	
	if(!$_POST['username'] || !$_POST['password'])
		$err[] = 'All the fields must be filled in!';
	
	if(!count($err))
	{
		$_POST['username'] = mysql_real_escape_string($_POST['username']);
		$_POST['password'] = mysql_real_escape_string($_POST['password']);
		$_POST['rememberMe'] = (int)$_POST['rememberMe'];
		
		// Escaping all input data

		$row = mysql_fetch_assoc(mysql_query("SELECT id,usr,email FROM tz_members WHERE usr='{$_POST['username']}' AND pass='".md5($_POST['password'])."'"));
		if($row['usr'])
		{
			// If everything is OK login
			
			$_SESSION['usr']=$row['usr'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['mail'] = $row['email'];
			$_SESSION['rememberMe'] = $_POST['rememberMe'];
			
			// Store some data in the session
			
			setcookie('tzRemember',$_POST['rememberMe']);
		}
		else $err[]='Wrong username and/or password!';
	}
	
	if($err)
	$_SESSION['msg']['login-err'] = implode('<br />',$err);
	// Save the error messages in the session

	header("Location: index.php");
	exit;
}

else if($_POST['submit']=='Register')
{
	// If the Register form has been submitted
	
	$err = array();
	
	if(strlen($_POST['username'])<3 || strlen($_POST['username'])>32)
	{
		$err[]='Your username must be between 3 and 32 characters!';
	}
	
  // The user name can contain letters between a and z
	if(preg_match('/[^a-z]+/i',$_POST['username']))
	{
		$err[]='Your username must contains only letters!';
	}
	
	
	// Check if we enter a non-usi email
	$posted_email = $_POST['email'];
	$exploded_email = explode("@", $posted_email);
	$email_domain = $exploded_email[1];
  
	if(!$posted_email || $email_domain!="usi.ch")
	{
		$err[]='Your email is not valid!';
	}
	
  if($_POST['tos'] != 1){
    $err[]='You must accept the terms of service!';
  }
  // If there are no errors we can insert the user in the database
	if(!count($err))
	{
		
		
		$_POST['password'] = mysql_real_escape_string($_POST['password']);
		$_POST['email'] = mysql_real_escape_string($_POST['email']);
		$_POST['username'] = mysql_real_escape_string($_POST['username']);
    $_POST['tos'] = mysql_real_escape_string($_POST['tos']);
		
		
		mysql_query("INSERT INTO tz_members(usr,pass,email,regIP,dt,tos)
						VALUES(
						
							'".$_POST['username']."',
							'".md5($_POST['password'])."',
							'".$_POST['email']."',
							'".$_SERVER['REMOTE_ADDR']."',
							NOW(),
							'".$_POST['tos']."'
						)");
		
		if(mysql_affected_rows($link)==1)
		{
		  $uname = $_POST['username'];
      $uname = mysql_real_escape_string($uname);
      
		  $query_result = mysql_query("SELECT id FROM tz_members WHERE usr='$uname'");
      $row = mysql_fetch_array($query_result);
		  $_SESSION['usr']=$uname;
      $_SESSION['id'] = $row['id'];
      $_SESSION['mail'] = $_POST['email'];
      $_SESSION['rememberMe'] = "true";
      
      // Store some data in the session
      
      setcookie('tzRemember',"false");
      // TODO: SEND EMAIL
			
		}
		else $err[]='This username is already taken!';
	}

	if(count($err))
	{
		$_SESSION['msg']['reg-err'] = implode('<br />',$err);
	}	
	
	header("Location: index.php");
	exit;
}

$script = '';

if($_SESSION['msg'])
{
	// The script below shows the sliding panel on page load
	
	$script = '
	<script type="text/javascript">
	
		$(function(){
		
			$("div#panel").show();
			$("#toggle a").toggle();
		});
	
	</script>';
	
}
else if($_POST['submit']=='Change')
{
    $id = $_SESSION['id'];
    mysql_query ("UPDATE tz_members SET pass = '".md5($_POST['new_password'])."' WHERE id = $id");
    echo ("Your new password is: " . $_POST['new_password']);
}

else if($_POST['submit']=='Synchronize')

{
    $id = $_SESSION['id'];
    mysql_query("UPDATE tz_members SET gemail = '". $_POST['gemail'] ."' WHERE id = $id");
    mysql_query("UPDATE tz_members SET gpass = '". $_POST['gpass'] ."' WHERE id = $id");
    mysql_query("UPDATE tz_members SET gsave = 1 WHERE id = $id");
    
}
?>