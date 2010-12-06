<?php
if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');  #
 // onclick="new Effect.Shake('page'); return false;" style="line-height:20px;"

?>
<script type="text/javascript">

	var max = 159 - <?php echo strlen($_SESSION['mail']); ?>;
	function limiter(){
	var tex = document.getElementById("sms").value;
	var len = tex.length;
	var numMessages = parseInt(len/max) + 1;
	var countChar = len % max;
	document.getElementById("counter").innerHTML = countChar + "/" + numMessages;
}
</script>

<div id="page">

<fieldset>

<form action="sms.php" method="post" id="send_sms">

  
  <?php
  include 'connect.php';
  $query  = "SELECT save FROM tz_members WHERE usr='{$_SESSION['usr']}'";
  $query_result = mysql_query($query);
  $result = mysql_fetch_array($query_result);
  $password_saved = $result['save'];
  
  if($password_saved != 1){
    $html_save='
      <p class="password">  
    <input type="password" name="password" id="password"/>
    <label for="password">Password (of your USI mailbox)</label>
    </p>
    
    <p> 
       <input type="checkbox" name="save" id="save"/>
       <label for="save">Save Password?</label>
    </p>
    ';
    echo $html_save;
  }
  ?>
	
	<p class="tel">  
    <input type="text" name="tel" id="telephone"/>
    <label for="tel">Telephone Number</label>
  </p>
    
	<p class="sms">	
		<textarea name="sms" id="sms" onkeyup=limiter()></textarea>
		<label for="sms">Message</label>
	</p>
	<p>	<a id="counter">0/1</a></p>
	<p class="submit">
		<input type="submit" value="Send message" id="send" />
	</p>
</form>
</fieldset> 

</div>

<div class="slide-out-div">
    <a class="handle" href="#">Content</a>
    <?php
    require_once("address_book.php");
    ?>
</div>
