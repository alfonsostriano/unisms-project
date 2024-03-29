<?php
require("login.php");
require 'facebook/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
 'appId'  => '165794976794246',
 'secret' => 'aae8c39f79b500e362a4d4a265258ecc',
 'cookie' => true,
));

$session = $facebook->getSession();

$me = null;
// Session based API call.
if ($session) {
 try {
   $uid = $facebook->getUser();
   $me = $facebook->api('/me');
 } catch (FacebookApiException $e) {
   error_log($e);
 }
}
$url = $_SERVER['REQUEST_URI'];
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>UNISMS</title>

        <link rel="stylesheet" type="text/css" href="view.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="demo.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="address_book.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="login_panel/css/slide.css" media="screen" />

        <link rel="apple-touch-icon" href="img/icon.png"/>
        <link rel="shortcut icon" href="img/favicon.ico"/>


        <script type='text/javascript' src='admin/js/jquery-1.4.2.min.js'></script> <!-- jquery library --> 
        <script type='text/javascript' src='admin/js/jquery-ui-1.8.5.custom.min.js'></script> <!-- jquery UI -->

        <script type="text/javascript" src="login_panel/js/slide.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://tab-slide-out.googlecode.com/files/jquery.tabSlideOut.v1.3.js"></script>
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        

        <script type="text/javascript">
            $( function() {
                $('.slide-out-div').tabSlideOut({
                    tabHandle: '.handle',                     //class of the element that will become your tab
                    pathToTabImage: 'img/address_book.png', //path to the image for the tab //Optionally can be set using css
                    imageHeight: '122px',                     //height of tab image           //Optionally can be set using css
                    imageWidth: '40px',                       //width of tab image            //Optionally can be set using css
                    tabLocation: 'right',                      //side of screen where tab lives, top, right, bottom, or left
                    speed: 600,                               //speed of animation
                    action: 'click',                          //options: 'click' or 'hover', action to trigger animation
                    topPos: '100px',                          //position from the top/ use if tabLocation is left or right
                    leftPos: '20px',                          //position from left/ use if tabLocation is bottom or top
                    fixedPosition: true                      //options: true makes it stick(fixed position) on scroll
                });

            });
            
            
        </script>
        
        <script type="text/javascript">
            function tos(){
            var html = "<h1>UNIsms Terms of Service</h1><h3>Preamble</h3><p>These Terms of Service describe the terms and conditions under which the administrators of the UNIsms service provide a service of message sending. Access to this Service is subject to compliance with these Terms of Service. Any user of this Service cannot access this Service without having previously been made aware of these Terms of Use and unreservedly agreed to them.</p>";
            html += "<h3>Guaranties</h3><p>The Information contained in this Site can in no way have a contractual and / or official value.  Accordingly, you agree to use this service at your own risk. You assume all the costs of any service needed.</p>";
            html += "<h3>Indemnification</h3><p>You agree to indemnify and guarantee UNIsms against any claim or action, losses, and expenses (including court fees) resulting from the violation of the Terms of Service, copyright infraction, or public order troubling.</p>";
            html += "<h3>Contact</h3><p>For any questions or inquiries about our terms of service, you can contact us at marcello.romanelli@usi.ch</p>";
            document.getElementById('facebook').innerHTML = html;
            
            }

      FB.logout(function(response) {
      
      });

        </script>


    </head>

    <body onload="var add_contact = document.getElementById('add_contact'); add_contact.style.display = 'none';">
        <div id="toppanel">
            <div id="panel">
                <div class="content clearfix">
                   
                    
                    <?php
                  if($me && !$_SESSION['id']){
                     $query  = "SELECT FBid FROM tz_members";
                     $query_result = mysql_query($query);
          while($r = mysql_fetch_array($query_result)){
          if($me[id] == $r[0]){
                    if(!strpos($url,'iframe')){
                    echo '<script language="javascript">alert("Ti sei collegato con l\'account facebook di '.$me[name].'. Per collegarti con un altro account, fai il logout da facebook.")</script>;';}
                    $query  = "SELECT usr, id, email, save FROM tz_members WHERE FBid='$me[id]'";
                    $query_result = mysql_query($query);
                    $result = mysql_fetch_row($query_result);
                    $_SESSION['usr'] = $result[0];
                    $_SESSION['id'] = $result[1];
                    $_SESSION['mail'] = $result[2];
                    $_SESSION['rememberMe'] = $result[3];
                break;
                    }
                                             
}
}
                    
                    
                    if (!$_SESSION['id']):
                    ?>
                        <div class="left">
                      <h1>Instructions</h1>
                        <ul>
                          <li>Register using your USI username and email</li>
                          <li>Choose a password</li>
                          <li>Login immediately</li>
                          <li>Start to send free sms!</li>
                        </ul>
                    </div>


                        <div class="left">
                            <!-- Login Form -->
                            <form class="clearfix" action="" method="post">
                            <h1>Registered Users</h1>

                        <?php
                        // Show if there are errors
                        
                        if ($_SESSION['msg']['login-err']) {
                            echo '<div class="err">' . $_SESSION['msg']['login-err'] . '</div>';
                            unset($_SESSION['msg']['login-err']);
                        }
                        ?>

                            <label class="grey" for="username">Username:</label>
                            <input class="field" type="text" name="username" id="username" value="" size="23" />

                            <label class="grey" for="password">Password:</label>
                            <input class="field" type="password" name="password" id="password" size="23" />

                            <label><input name="rememberMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> &nbsp;Remember me</label>
                            <div class="clear"></div>
                            <input type="submit" name="submit" value="Login" class="bt_login" />
                        </form>
            <?php
            if(!strpos($url,'iframe') && !$me){?>
      
                <fb:login-button></fb:login-button>
                <?php }?>
                      </div>

                    <div class="left right">
                        <!-- Register Form -->
                        <form action="" method="post">
                            <h1>Not registered yet? Sign Up!</h1>

                        <?php
                        if ($_SESSION['msg']['reg-err']) {
                            echo '<div class="err">' . $_SESSION['msg']['reg-err'] . '</div>';
                            unset($_SESSION['msg']['reg-err']);
                        }

                        if ($_SESSION['msg']['reg-success']) {
                            echo '<div class="success">' . $_SESSION['msg']['reg-success'] . '</div>';
                            unset($_SESSION['msg']['reg-success']);
                        }
?>

                            <label class="grey" for="username">USI Username (e.g. romanelm):</label>
                            <input class="field" type="text" name="username" id="username" value="" size="23" />

                            <label class="grey" for="email">USI Email (e.g. marcello.romanelli@usi.ch):</label>
                            <input class="field" type="text" name="email" id="email" size="23" />

                            <label class="grey" for="email">Password:</label>
                            <input class="field" type="password" name="password" id="password" size="23" />

                            
                            <label><input name="tos" id="tos" type="checkbox" checked="checked" value="1" /> &nbsp;I accept the <a href="#" onclick="tos()">TOS</a></label>
                            <div class="clear"></div>
                            
                            <input type="submit" name="submit" value="Register" class="bt_register" />
                        </form>
                    </div>

<?php
                        else:
            $query  = "SELECT FBid FROM tz_members WHERE usr='{$_SESSION['usr']}'";
                         $query_result = mysql_query($query);
                         $result = mysql_fetch_row($query_result);
                        if (!(in_array($me[id], $result)) && $me) {
                          mysql_query("UPDATE tz_members SET FBid ='$me[id].' WHERE usr='{$_SESSION['usr']}'");
                        echo '<script language="javascript">alert("Questo account e l\'account facebook di '.$me[name].' sono stati collegati.")</script>;';

            }
?>

                        <div class="left">
                        <h1>UNISms Utilities</h1>
                        <h2>Google Contacts Connect</h2>
                        <?php
                          $query  = "SELECT gsave FROM tz_members WHERE usr='{$_SESSION['usr']}'";
                          $query_result = mysql_query($query);
                          $result = mysql_fetch_array($query_result);
                          $password_saved = $result['gsave'];
                          
                          if($password_saved == 0){
                        ?>
                          <form action="" method="post">
                            <label class="grey" for="username">Gmail address:</label>
                            <input class="field" type="text" name="gemail" id="gemail" value="" size="23" />

                            <label class="grey" for="gpass">Password:</label>
                            <input class="field" type="password" name="gpass" id="gpass" size="23" />

                            <input type="submit" name="submit" value="Synchronize" class="bt_register" />
                        </form>
                        <?php
                          }
                          if($password_saved == 1){
                        ?>
                        <h5>Your UNIsms account is already connected with your Gmail</h5>
                        <h2><a href="?stopsync">STOP SYNC WITH GOOGLE</a></h2>
                        <?php
                          }
                        ?>
                    </div>
                    
                    <div class="left">

                        <h1>Settings</h1>

                        <?php
                          echo("<h3>MAIL</h3> ".$_SESSION['mail']."<br />");
                          echo("<h3>USERNAME</h3> ".$_SESSION['usr']."<br />");
                          ?>
                        <form action="" method="post">
                            <h3>PASSWORD</h3>

<!--                            <label class="grey" for="password">Enter a new password for your account:</label>-->
                            <input class="field" type="password" name="new_password" id="password" size="23" />

                            <input type="submit" name="submit" value="Change" class="bt_register" />
                        </form>
                        


                    </div>

                    <div class="left right">
                        <h1><a href="?logoff" onclick="FB.logout();">Logout</a></h1>
                        <p>Exit the current session. Next time you'll try to login you'll have to reinsert your username and password</p>
                        <hr />
                        <h2><a href="?delete">DELETE ACCOUNT</a></h2>
                        <p>Remove your account and all your informations from our databases</p>
                        <hr />
                        <h2><a href="?remove_password">REMOVE PASSWORD</a></h2>
                        <p>Remove your USI mailbox password from ours databases</p>

                    </div>

<?php
                            endif;
?>
                        </div>
                    </div> <!-- /login -->

                    <!-- The tab on top -->
                    <div class="tab">
                        <ul class="login">
                            <li class="left">&nbsp;</li>
                            <?php
                            $mail = $_SESSION['mail'];
                            $exploded = explode(".", $mail);
                            $name = ucfirst($exploded[0]);
                            ?>
                            <li>Hi <?php echo $_SESSION['usr'] ? $name : 'Guest'; ?>!</li>
                            <li class="sep">|</li>
                            <li id="toggle">
                                <a id="open" class="open" href="#"><?php echo $_SESSION['id'] ? 'View settings' : 'Log In | Register'; ?></a>
                                <a id="close" style="display: none;" class="close" href="#">Close Panel</a>
                            </li>
                            <li class="right">&nbsp;</li>
                        </ul>
                    </div> <!-- / top -->

                </div> <!--panel -->


<?php
                            if ($_SESSION['id']) {
                                include("sender.php");
                            }
                            else{
?>

    <div id="facebook">
  <script type="text/javascript">FB.init("165794976794246");</script>
  <fb:fan profile_id="132505266801785" stream="1" connections="10" width="450"></fb:fan>
  <div style="font-size:8px; padding-left:10px">
  </div>

<?php
}

?>  
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId   : '<?php echo $facebook->getAppId(); ?>',
          session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
        });

        // whenever the user logs in, we refresh the page
        FB.Event.subscribe('auth.login', function() {
          window.location.reload();
        });
      };

      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>
  
    </body>
</html>