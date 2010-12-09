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

    function remove_all_contacts() {
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
        ajaxRequest.open("GET", "database_removeAll.php", true);
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
        var image = document.getElementById('contact_button');
        var add_contact = document.getElementById('add_contact');
        if(image.alt == 0) {
            add_contact.style.display = "inline";
            image.src = "img/add_clicked2.png";
            image.alt = "1";
            image.title = "Close add contact";
        } else {
            add_contact.style.display = "none";
            image.src = "img/add2.png";
            image.alt = "0";
            image.title = "Open add contact";
        }
    }

    function addcontactdatabase() {
        var ajaxRequest;  // The variable that makes Ajax possible!
        var names = document.getElementById('names').value;
        var phone = document.getElementById('phone').value;
        document.getElementById('names').value = "";
        document.getElementById('phone').value = "";
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
        var queryString = "?names=" + names + "&phone=" + phone;
        ajaxRequest.open("GET", "database_add.php" + queryString, true);
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
<!--Build Test Address Book-->
<?php
    require_once('auto_generate_AB.php');
?>

<div id="add_book">
    <div id="AB_header">
        <div id="search">
            <input title="Search contact" type="text" id="searchbox" name="searchbox" value="  ...search" onblur='if(this.value == "") {this.value = "  ...search";search("")}' onclick='if(this.value == "  ...search"){this.value = ""}' onkeyup="search(this.value)"/>
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
                echo "<h4 title='Click to insert number' id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h4>";
                echo "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/>";
                echo "</div>";
            }  
            include 'google.php';
        ?>
        </div>
    </div> 
    <div id="AB_footer">
        <img title="Open add contact" id="contact_button" src="img/add2.png" alt="0" onclick="addContact()" />
        <img title="Delete all contacts" id="contact_button" src="img/trash.png" alt="trash" onclick="remove_all_contacts()"/>
    </div>
    <div id="add_contact">
            <p>
            <label for="names">Name: </label>
            <input title='Insert contact name' id="names" name="names"/>
            </p>
            <p>
            <label for="phone">Phone: </label>
            <input title='Insert contact number' id="phone" name="phone"/>
            </p>
            <button title='Add contact' id="add_button" onclick="addcontactdatabase()">Add</button>
    </div>
</div>