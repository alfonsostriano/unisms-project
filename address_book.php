<script type="text/javascript">
    //function to build the ajaxRequest
    function build_ajaxRequest() {
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
        return ajaxRequest;
    }

    //function to handle the remove contact request
    function remove_contact(name){
        var ajaxRequest = build_ajaxRequest();
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

    //function to handle the remove all contacts request
    function remove_all_contacts() {
        var answer = confirm("Delete all Contacts?")
        if(answer) {
            var ajaxRequest = build_ajaxRequest();
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
    }

    function edit_contact(id) {
        var contacts_list = document.getElementById("contacts_list");
        var edit_contact = document.getElementById("contact_edit");
        var name_edit = document.getElementById("name_edit");
        var phone_edit = document.getElementById("phone_edit");
        document.getElementById("edit_id").innerHTML = id;
        contacts_list.style.display = "none";
        edit_contact.style.display = "inline";

        //Get Name
        var ajaxRequest2 = build_ajaxRequest();
        // Create a function that will receive data sent from the server
        ajaxRequest2.onreadystatechange = function() {
            if(ajaxRequest2.readyState == 4) {
                var request = ajaxRequest2.responseText;
                name_edit.value = request;
            }
        }
        var queryString = "?nameid=" + id;
        ajaxRequest2.open("GET", "database_fetch_name.php" + queryString, true);
        ajaxRequest2.send(null);

        //Get Number
        var ajaxRequest = build_ajaxRequest();
        // Create a function that will receive data sent from the server
        ajaxRequest.onreadystatechange = function() {
            if(ajaxRequest.readyState == 4) {
                var request = ajaxRequest.responseText;             
                phone_edit.value = request;
            }
        }
        var queryString = "?nameid=" + id;
        ajaxRequest.open("GET", "database_fetch.php" + queryString, true);
        ajaxRequest.send(null);
    }
    function submit_contact_edit() {
        var contacts_list = document.getElementById("contacts_list");
        var edit_contact = document.getElementById("contact_edit");
        var name_edit = document.getElementById("name_edit").value;
        var phone_edit = document.getElementById("phone_edit").value;
        var edit_id = document.getElementById("edit_id").innerHTML;
        var ajaxRequest = build_ajaxRequest();
        // Create a function that will receive data sent from the server
        ajaxRequest.onreadystatechange = function() {
            if(ajaxRequest.readyState == 4) {
                var request = ajaxRequest.responseText;
                document.getElementById('contacts_list').innerHTML = request;
            }
        }

        var queryString = "?names=" + name_edit + "&phone=" + phone_edit + "&edit_id=" + edit_id;
        ajaxRequest.open("GET", "database_edit.php" + queryString, true);
        ajaxRequest.send(null);
        contacts_list.style.display = "inline";
        edit_contact.style.display = "none";
    }
    //function to handle a get number request
    function getNumber(name) {
        var ajaxRequest = build_ajaxRequest();
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

    //function to open and close the add contact panel
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
    
    

    //function to handle the add contact request
    function addcontactdatabase() {
        var ajaxRequest;  // The variable that makes Ajax possible!
        var names = document.getElementById('names').value;
        var phone = document.getElementById('phone').value;
        document.getElementById('names').value = "";
        document.getElementById('phone').value = "";
        var ajaxRequest = build_ajaxRequest();
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
          $(".msg_body").hide();
        //toggle the componenet with class msg_body
        $(".msg_head").click(function(){
          $(this).next(".msg_body").slideToggle(300);
        });
    }
    
    function add_fav(name) {
        var ajaxRequest = build_ajaxRequest();
        // Create a function that will receive data sent from the server
        ajaxRequest.onreadystatechange = function() {
            if(ajaxRequest.readyState == 4) {
                var request = ajaxRequest.responseText;
                document.getElementById('contacts_list').innerHTML = request;
            }
        }
        var queryString = "?nameid=" + name;
        ajaxRequest.open("GET", "database_add_fav.php" + queryString, true);
        ajaxRequest.send(null);
          $(".msg_body").hide();
      //toggle the componenet with class msg_body
      $(".msg_head").click(function(){
        $(this).next(".msg_body").slideToggle(300);
      });
      }

    //function to handle the search request
    function search(searchtext) {
        var ajaxRequest = build_ajaxRequest();
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

<script type="text/javascript">
$(document).ready(function(){
	//hide the all of the element with class msg_body
	$(".msg_body").hide();
	//toggle the componenet with class msg_body
	$(".msg_head").click(function(){
		$(this).next(".msg_body").slideToggle(300);
	});
});
</script>

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

            $alphabetically_sort = "ALTER TABLE `contacts` ORDER BY `names`";
            $qry_result = mysql_query($alphabetically_sort) or die(mysql_error());
            // Retrieve all the data from the "example" table
            $list_retrieve = mysql_query("SELECT * FROM contacts WHERE owner = '$id'")
            or die(mysql_error());
        ?>

        <div id="contacts_list">
                 <?php
                    require_once('address_book_gen.php');
                 ?>
                <div id="contact_edit">
                    <p>
                    <label for="names">Name: </label>
                    <input title='Insert contact name' id="name_edit" name="names"/>
                    </p>
                    <p>
                    <label for="phone">Phone: </label>
                    <input title='Insert contact number' id="phone_edit" name="phone"/>
                    </p>
                    <div id="edit_id"></div>
                    <button title="Submit Changes" id="confirm_edit" onclick="submit_contact_edit()">Ok</button>
                </div>
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