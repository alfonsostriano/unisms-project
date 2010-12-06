<script type="text/javascript">

    function remove_contact(name){
      var ajaxRequest;  // The variable that makes Ajax possible!

        try {
            // Opera 8.0+, Firefox, Safari
            ajaxRequest = new XMLHttpRequest();
        } catch (e) {
            // Internet Explorer Browsers
            try {
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        // Create a function that will receive data sent from the server
        ajaxRequest.onreadystatechange = function() {
            if(ajaxRequest.readyState == 4) {
                var request = ajaxRequest.responseText;
                document.getElementById('contacts_list').innerHTML = request;
            }
        }
        var queryString = "?nameid=" + name;
        ajaxRequest.open("GET", "database_remove.php" + queryString, true);
        ajaxRequest.send(null);
    }
    
    function getNumber(name) {
        var ajaxRequest;  // The variable that makes Ajax possible!

        try {
            // Opera 8.0+, Firefox, Safari
            ajaxRequest = new XMLHttpRequest();
        } catch (e) {
            // Internet Explorer Browsers
            try {
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        // Create a function that will receive data sent from the server
        ajaxRequest.onreadystatechange = function() {
            if(ajaxRequest.readyState == 4) {
                var telephone = document.getElementById('telephone');
                var request = ajaxRequest.responseText;
                if(telephone.value == '') {
                    telephone.value = request;
                } else {
                    telephone.value += ', ' + request;
                }
            }
        }
        var queryString = "?nameid=" + name;
        ajaxRequest.open("GET", "database_fetch.php" + queryString, true);
        ajaxRequest.send(null);
    }

    function addContact() {
        var contacts_list = document.getElementById('contacts_list');
        var add_contact = document.getElementById('add_contact');
        add_contact.style.display = "inline";
    }
    

    function addcontactdatabase() {
        var ajaxRequest;  // The variable that makes Ajax possible!
        var names = document.getElementById('names').value
        var phone = document.getElementById('phone').value
        try {
            // Opera 8.0+, Firefox, Safari
            ajaxRequest = new XMLHttpRequest();
        } catch (e) {
            // Internet Explorer Browsers
            try {
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        // Create a function that will receive data sent from the server
        ajaxRequest.onreadystatechange = function() {
            if(ajaxRequest.readyState == 4) {
                var request = ajaxRequest.responseText;
                alert(names);
            }
        }
        var queryString = "?names=" + names + "&phone=" + phone;
        ajaxRequest.open("POST", "database_add.php" + queryString, true);
        ajaxRequest.send(null);
    }

    function search(searchtext) {

        var ajaxRequest;  // The variable that makes Ajax possible!
        try {
            // Opera 8.0+, Firefox, Safari
            ajaxRequest = new XMLHttpRequest();
        } catch (e) {
            // Internet Explorer Browsers
            try {
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        // Create a function that will receive data sent from the server
        ajaxRequest.onreadystatechange = function() {
            if(ajaxRequest.readyState == 4) {
                var request = ajaxRequest.responseText;
                document.getElementById("contacts_list").innerHTML = request;

            }
        }
        var queryString = "?search=" + searchtext;
        ajaxRequest.open("GET", "database_search.php" + queryString, true);
        ajaxRequest.send(null);
    }

    function addGoogle(number) {
        var telephone = document.getElementById('telephone');
        if(telephone.value == '') {
            telephone.value = number;
        } else {
            telephone.value += ', ' + number;
        }
    }
    

</script>

<div id="add_book">
    <div id="AB_header">
        <div id="change_view">
<!--            <button id="full_view" onClick="full_view()">Full View</button>-->
<!--            <button id="contact_view" onClick="contact_view()">Contact View</button>-->
        </div>
        <div id="search">
            <input type="text" id="searchbox" name="searchbox" value="  ...search" onblur='if(this.value == "") {this.value = "  ...search";search("")}' onclick='if(this.value == "  ...search"){this.value = ""}' onkeyup="search(this.value)"/>
        </div>
    </div>
    <div id="contatcs_page">
        <?php
            session_name('tzLogin');
            // Starting the session
            session_start();
            $id = $_SESSION['id'];
            // Make a MySQL Connection
            require_once 'connect.php';
            // Retrieve all the data from the "example" table
            $list_retrieve = mysql_query("SELECT * FROM contacts WHERE owner = '$id'")
            or die(mysql_error());
        ?>

        <div id="contacts_list">
        <?php
            while ($list = mysql_fetch_array($list_retrieve)) {
                $name = $list['names'];
                $id = $list['id'];
                echo "<div id='contact'>";
                echo "<h4 id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h4>";
                echo "<img id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/>";   
                //echo "<h4 onclick='remove_contact(".$id.")'> REMOVE </h4>";
                echo "</div>";
            }
            
            include 'google.php';
        ?>
        </div>
    </div> 
    <div id="AB_footer">
        <img src="img/add.png" onclick="addContact()">
    </div>
    <div id="add_contact">
        <form method="POST">
            <p>
            <label for="names">Name: </label>
            <input id="names" name="names"/>
            </p>
            <p>
            <label for="phone">Phone: </label>
            <input id="phone" name="phone"/>
            </p>
            <button onclick="addcontactdatabase()">Add</button>
        </form>
    </div>
</div>