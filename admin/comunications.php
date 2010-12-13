<?php
require '../connect.php';
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <title>UNIsms Admin</title>
        <link type="text/css" href="./style.css" rel="stylesheet" /> <!-- the layout css file -->
        <link type="text/css" href="./css/jquery.cleditor.css" rel="stylesheet" />

        <script type='text/javascript' src='./js/jquery-1.4.2.min.js'>
        </script> <!-- jquery library -->
        <script type='text/javascript' src='./js/jquery-ui-1.8.5.custom.min.js'>
        </script> <!-- jquery UI -->
        <script type='text/javascript' src='./js/cufon-yui.js'>
        </script> <!-- Cufon font replacement -->
        <script type='text/javascript' src='./js/colaboratelight_400.font.js'>
        </script> <!-- the Colaborate Light font -->
        <script type='text/javascript' src='./js/easytooltip.js'>
        </script> <!-- element tooltips -->
        <script type='text/javascript' src='./js/jquery.tablesorter.min.js'>
        </script> <!-- tablesorter -->
        <!--[if IE 8]>
        <script type='text/javascript' src='http://hello.amnesio.com/js/excanvas.js'></script>
        <link rel="stylesheet" href="http://hello.amnesio.com/css/IEfix.css" type="text/css" media="screen" />
        <![endif]-->

        <!--[if IE 7]>
        <script type='text/javascript' src='http://hello.amnesio.com/js/excanvas.js'></script>
        <link rel="stylesheet" href="http://hello.amnesio.com/css/IEfix.css" type="text/css" media="screen" />
        <![endif]-->

        <script type='text/javascript' src='./js/visualize.jquery.js'>
        </script> <!-- visualize plugin for graphs / statistics -->
        <script type='text/javascript' src='./js/iphone-style-checkboxes.js'>
        </script> <!-- iphone like checkboxes -->
        <script type='text/javascript' src='./js/jquery.cleditor.min.js'>
        </script> <!-- wysiwyg editor -->
        <script type='text/javascript' src='./js/custom.js'>
        </script> <!-- the "make them work" script -->
        <meta charset="UTF-8">
    </head>
    <body>

        <div id="container">
                
                <div id="primary_right">
                    <div class="inner">

                        <h1>UNIsms Admin</h1>
                        <ul class="dash">

                            <li class="fade_hover tooltip" title="Post a new comunication">
                                <a href="#">
                                <img src="./assets/icons/dashboard/2.png" alt="" />
                                <span>News</span>
                                </a>
                            </li>
                            <li class="fade_hover tooltip">
                                <span class="bubble">
                                <?php
                                
                                 $query = "SELECT COUNT(*) FROM tz_members";
                                 //Execute query
                                 $qry_result = mysql_query($query) or die(mysql_error());

                                 // Insert a new row in the table for each person returned
                                 while($row = mysql_fetch_array($qry_result)){
                                  echo($row['COUNT(*)']); 
                                 }
                                ?>
                                </span>
                                <a href="users.php">
                                <img src="./assets/icons/dashboard/54.png" alt="" />
                                <span>Users</span>
                                </a>
                            </li>
                            <li class="fade_hover tooltip" title="Website Statistics">
                                <a href="#">
                                <img src="./assets/icons/dashboard/81.png" alt="" />
                                <span>Statistics</span>
                                </a>
                            </li>
                           
                            
                            <li class="fade_hover tooltip dialog_link" title="End current session">
                                <a href="#">
                                <img src="./assets/icons/dashboard/118.png" alt="" />
                                <span>Logout</span>
                                </a>
                            </li>
                        </ul> <!-- end dashboard items -->
                        
                        <div id="dialog" title="Modals with Hello!">
                            <h2>Hello! This is a modal window!</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, est volutpat auctor fermentum, urna lectus lobortis urna, eu aliquam libero justo vitae tortor.
                            </p>
                            <p>
                                Vivamus ornare lacus ac sapien placerat congue eu a felis. Duis lobortis turpis non arcu accumsan imperdiet. Sed quis porta metus. Cras placerat orci et orci ornare pulvinar. Aenean tristique malesuada molestie. Vestibulum pretium nulla eu metus faucibus at congue quam mollis. Donec elit risus, varius eleifend commodo id, tincidunt vitae magna. Nunc fringilla mi a diam aliquam aliquet
                            </p>
                        </div>
                        <hr />

                            
            <fieldset>
            <legend>Communication EDITOR</legend>
            <FORM action="add_comment_database.php" method="POST">
              <p><label>Title</label>
              <input class="lf" name="title" id="title" type="text" value="title" /> </p>

            <textarea class="editor" name="contents" id="contents">
              Write your comunication here!
            </textarea>
            <input class="button" type="submit" value="Submit" /> <input class="button" type="reset" value="Reset" />
            </fieldset>
            </FORM>
            <hr />
            
           <h2 style="clear:both;">Recent comunications</h2>

            <?php
                 $query = "SELECT * FROM comunications ORDER BY id DESC LIMIT 10";
                 //Execute query
                 $qry_result = mysql_query($query) or die(mysql_error());

                 // Insert a new row in the table for each person returned
                 while($row = mysql_fetch_array($qry_result)){
                 echo '<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">';
                 echo '<div class="portlet-header ui-widget-header ui-corner-all">
                       <span class="ui-icon ui-icon-circle-arrow-s"></span>'. $row['title'] . ' (' . $row['date'] . ')' .'</div>';
                 echo '<div class="portlet-content" style="display: block;">';
                 echo '<p>';
                 echo $row['contents'];
                 echo '</p>';
                 echo '</div>';
                 echo '</div>';
       
                }
            ?>
              
           
                            
                                  
                                    
                          

                            <div class="clearboth">

                            </div>
                            <hr />
                        </div>
                    </div>
                     </div>
                    </div>
    </body>
</html>
