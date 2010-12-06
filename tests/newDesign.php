<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>My Homepage</title>
        <link rel="stylesheet" type="text/css" href="test.css" media="screen">

        <script type="text/javascript">
            function showAB() {
                var AB = document.getElementById('address_book');
                AB.style.display = "inline";
            }
            function hideAB() {
                var AB = document.getElementById('address_book');
                AB.style.display = "none";
            }
        </script>
    </head>

    <body onload="hideAB()">
        <nav></nav>
        <div id="main">
            <div id="sender">
                <form action="sms.php" method="get" id="send_sms">

		<input type="text" name="l_name" id="name"/>
		<label for="l_name">Last Name (e.g. Romanelli)</label><br />


		<input type="text" name="f_name" id="f_name"/>
		<label for="f_name">First Name (e.g. Marcello)</label><br />

		<input type="text" name="password" id="password"/>
		<label for="password">Password (USI-mail)</label><br />


		<input type="text" name="tel" id="tel"/>
		<label for="tel">Telephone Number</label><br />


		<textarea name="sms"></textarea>
		<label for="sms">Message</label><br />

                <input type="submit" value="Send message" id="send">
                </form><br /><br />
                <button onClick="showAB()">Open Add-book</button>
                <button onClick="hideAB()">Close Add-book</button>
            </div> 

            <div id="address_book">
                <table id="add-book">
                <th>NAME</th><th>NUMBER</th>
                <?php
                    // Make a MySQL Connection
                    mysql_connect("localhost", "root", "root") or die(mysql_error());
                    mysql_select_db("addressbook") or die(mysql_error());

                    // Retrieve all the data from the "example" table
                    $result = mysql_query("SELECT * FROM address")
                    or die(mysql_error());

                    // store the record of the "example" table into $row
                    // Print out the contents of the entry
                    while($row = mysql_fetch_array($result)){
                        echo "<tr><td>".$row['name']."</td><td>". $row['number'] . "</td></tr>";
                    }
                ?>
                </table>
            </div>
        </div>
    </body>
</html>
