<?php

require_once('phpmailer/class.phpmailer.php');
require_once 'connect.php';
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

session_name('tzLogin');
session_start();

$mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch
$mail->PluginDir = 'phpmailer/';
$mail->IsSMTP(); // telling the class to use SMTP

try {
  	$mail->Host       = "mail.usi.ch"; 	// SMTP server
  	$mail->SMTPAuth   = true;                  // enable SMTP authentication
  	$mail->Port       = 25;                 	  
	  $mail->SMTPSecurity   = "ssl";
	 
	  $mail->CharSet="windows-1251";


		$uname = $_SESSION['usr'];
		$mail->Username = strtolower($uname);
		
    $save = $_POST['save'];
    
    $id = $_SESSION['id'];
        
    
    if($save){
      $save = 1;
      $pass_to_save = $_POST["password"];
      print_r($pass_to_save);
      mysql_query ("UPDATE tz_members SET save = '$save' WHERE id = $id");
      mysql_query ("UPDATE tz_members SET mailpass = '$pass_to_save' WHERE id = $id");      
    }
    
    // If the user write his password on the form
    if($_POST["password"] != null){
      // get it and use it
		  $mail->Password = $_POST["password"];
    } 
    // otherwise if there's no password
    else if($_POST["password"] == null){
       // try to get it from the database
       
       $query  = "SELECT mailpass FROM tz_members WHERE id = $id";
       $query_result = mysql_query($query);
       $result = mysql_fetch_array($query_result);
       $password_saved = $result['mailpass'];
       // and try to use it as password
       $mail->Password = $password_saved;
    }

      // Set the reply-to address
  		$mail->AddReplyTo('none@lu.unisi.ch');
    
    // Take the numers
    $data = $_POST["tel"];
    // And split it with respect to the comma
    $recievers = explode(",", $data);

    // Then add each reciver
    foreach ($recievers as $number){
		  $mail->AddAddress($number.'@sms.switch.ch');
    }
    
    // Take the user email from the session and set it
    $usr_mail= $_SESSION["mail"];
		$mail->SetFrom($usr_mail);

    // Get the sms text
		$sms = $_POST["sms"];

    // Compute the length of each sms
    $max_length= 160 - strlen($usr_mail) - 1;

		// Check the length of the sms. If it's more than 160char(email included) then we
		// have to split it
		if(strlen($sms)<$max_length){
			$mail->Body = $sms; 

			if(!$mail->Send()){
  				echo "ERROR";
  			} else{
  			  $query  = "UPDATE tz_members SET sms_counter=sms_counter+1 WHERE id = $id";
          mysql_query($query);
          echo "
          <div class='notification success'> 
            <span></span> 
            <div class='text'> 
              <p><strong>Message sent!</strong> Your message has been succesfully sent to ". $data ."</p> 
            </div> 
          </div>      
          
          ";
  			} 
  			
		} 
		// The message must be sended by multiple messages
		else {
			$how_many_sms = ceil(strlen($sms)/$max_length);
			$i=0;
			$start_at = 0;
			while($i<$how_many_sms){
				$current_part = substr($sms, $start_at , $max_length);
				$mail->Body = $current_part; 
  				$mail->Send();
  				$i = $i + 1;
  				$start_at = $start_at + $max_length;
          $query  = "UPDATE tz_members SET sms_counter=sms_counter+1 WHERE id = $id";
          mysql_query($query);
			}
          echo "
          <div class='notification success'> 
            <span></span> 
            <div class='text'> 
              <p><strong>Message sent!</strong> Your message has been succesfully sent.</p> 
            </div> 
          </div>      
          
          ";
		}
		

} catch (phpmailerException $e) {
  echo "
          <div class='notification error'> 
            <span></span> 
            <div class='text'> 
              <p><strong>Error!</strong>" . $e->errorMessage() . "</p> 
            </div>
          </div>      
          
          ";
} catch (Exception $e) {
  echo "
          <div class='notification error'> 
            <span></span> 
            <div class='text'> 
              <p><strong>Error!</strong>" . $e->getMessage() . "</p> 
            </div>
          </div>      
          
          ";
}

?>
