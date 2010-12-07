<?php
require("login.php");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>UNISMS</title>

        <link rel="stylesheet" type="text/css" href="view.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="demo.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="login_panel/css/slide.css" media="screen" />

        <link rel="apple-touch-icon" href="img/icon.png"/>
        <link rel="shortcut icon" href="img/favicon.ico"/>

        <script src="javascripts/prototype.js" type="text/javascript"></script>
        <script src="javascripts/scriptaculous.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
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


    </head>

    <body onload="var add_contact = document.getElementById('add_contact'); add_contact.style.display = 'none'">

        <div id="toppanel">
            <div id="panel">
                <div class="content clearfix">
                   
                    
                    <?php
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


                            <input type="submit" name="submit" value="Register" class="bt_register" />
                        </form>
                    </div>

<?php
                        else:
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
                        <h1><a href="?logoff">Logout</a></h1>
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
<script src="http://static.ak.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US" type="text/javascript"></script>
<script type="text/javascript">FB.init("4cdb821df2c0741721f683c820581a78");</script>
<fb:fan profile_id="132505266801785" stream="1" connections="10" width="450"></fb:fan>
<div style="font-size:8px; padding-left:10px">
<a href="http://www.facebook.com/pages/SMSwitch-SMS-Gratis-per-studenti-USI/132505266801785">SMSwitch</a> on Facebook</div>
</div>

<?php
}
?>


    </body>
</html>