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

    function get_innerHTML_request(url,domid) {
        var ajaxRequest = build_ajaxRequest();
        ajaxRequest.onreadystatechange = function() {
            if(ajaxRequest.readyState == 4) {
                var request = ajaxRequest.responseText;
                document.getElementById(domid).innerHTML = request;
                $(document).ready(function(){set_ready();});
            }
        }
        ajaxRequest.open("GET", url, true);
        ajaxRequest.send(null);
    }
    function get_value_request(url,domid) {
        var ajaxRequest = build_ajaxRequest();
        ajaxRequest.onreadystatechange = function() {
            if(ajaxRequest.readyState == 4) {
                var request = ajaxRequest.responseText;
                document.getElementById(domid).value = request;
                $(document).ready(function(){set_ready();});
            }
        }
        ajaxRequest.open("GET", url, true);
        ajaxRequest.send(null);
    }

    //function to handle the search request
    function search(searchtext) {
        get_innerHTML_request("database_search.php" + "?search=" + searchtext, "contacts_list");
        document.getElementById("contacts_list").style.padding = '0 0 0 20px';
    }

    function add_fav(name) {
        get_innerHTML_request("database_add_fav.php" + "?nameid=" + name, "contacts_list");
        set_ready();
    }

    //function to handle the remove contact request
    function remove_contact(name){
        get_innerHTML_request("database_remove.php" + "?nameid=" + name, "contacts_list");
        set_ready();
    }

    //function to handle the remove all contacts request
    function remove_all_contacts() {
        var answer = confirm("Delete all Contacts?")
        if(answer) {
            get_innerHTML_request("database_removeAll.php", "contacts_list");
            set_ready();
        }
    }

    //function to handle the add contact request
    function addcontactdatabase() {
        var names = document.getElementById('names').value;
        var phone = document.getElementById('phone').value;

        get_innerHTML_request("database_add.php" + "?names=" + names + "&phone=" + phone,"contacts_list");
        document.getElementById('names').value = "";
        document.getElementById('phone').value = "";
        set_ready();
    }

    //Function to handle the edit request
    function submit_contact_edit() {
        var name_edit = document.getElementById("name_edit").value;
        var phone_edit = document.getElementById("phone_edit").value;
        var edit_id = document.getElementById("edit_id").innerHTML;
        document.getElementById("message_list").style.display = "inline";
        document.getElementById("contact_edit").style.display = "none";
        get_innerHTML_request("database_edit.php" + "?names=" + name_edit + "&phone=" + phone_edit + "&edit_id=" + edit_id, "contacts_list");
        set_ready();
    }

    function edit_contact(id) {
        document.getElementById("message_list").style.display = "none";
        document.getElementById("contact_edit").style.display = "inline";
        document.getElementById("edit_id").innerHTML = id;

        get_value_request("database_fetch_name.php" + "?nameid=" + id, "name_edit");
        get_value_request("database_fetch.php" + "?nameid=" + id, "phone_edit");
        set_ready();
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

    function addGoogle(number) {
        var telephone = document.getElementById('telephone');
        if(telephone.value == '') {
            telephone.value = number;
        } else {
            telephone.value += ', ' + number;
        }
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

    function set_ready() {
        $(".msg_body").hide();
        //toggle the componenet with class msg_body
        $(".msg_head").click(function(){
            $(this).next(".msg_body").slideToggle(300);
        });
    }

    $(document).ready(function(){
            set_ready();
        });
</script>

<div id="add_book">
    <div id="AB_header">
            <img src="img/search.png" alt="spotlight">
            <input title="Search contact" type="text" id="searchbox" name="searchbox" value="  ...search"
                   onblur='if(this.value == "") {this.value = "  ...search";
                        search("");
                        get_innerHTML_request("address_book_gen.php","contacts_list")}
                        document.getElementById("contacts_list").style.padding = "0";'

                   onclick='if(this.value == "  ...search"){this.value = ""};'
                   onkeyup="search(this.value)"/>
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