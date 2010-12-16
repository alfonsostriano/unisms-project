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

    function get_innerHTML_request(url,domid,ready) {
        var ajaxRequest = build_ajaxRequest();
        ajaxRequest.onreadystatechange = function() {
            if(ajaxRequest.readyState == 4) {
                var request = ajaxRequest.responseText;
                document.getElementById(domid).innerHTML = request;
                if(ready) {
                    $(document).ready(function(){set_ready();});
                }
            }
        }
        ajaxRequest.open("GET", url, true);
        ajaxRequest.send(null);
    }

    function get_value_request(url,domid,ready) {
        var ajaxRequest = build_ajaxRequest();
        ajaxRequest.onreadystatechange = function() {
            if(ajaxRequest.readyState == 4) {
                var request = ajaxRequest.responseText;
                document.getElementById(domid).value = request;
                if(ready) {
                    $(document).ready(function(){set_ready();});
                }
            }
        }
        ajaxRequest.open("GET", url, true);
        ajaxRequest.send(null);
    }

    //function to handle the search request
    function search(searchtext) {
        get_innerHTML_request("database_search.php" + "?search=" + searchtext, "contacts_list",false);
    }

    function add_fav(name) {
        get_innerHTML_request("database_add_fav.php" + "?nameid=" + name, "contacts_list",true);
    }

    //function to handle the remove contact request
    function remove_contact(name){
        get_innerHTML_request("database_remove.php" + "?nameid=" + name, "contacts_list",true);
    }

    //function to handle the remove all contacts request
    function remove_all_contacts() {
        var answer = confirm("Delete all Contacts?")
        if(answer) {
            get_innerHTML_request("database_removeAll.php", "contacts_list",true);
        }
    }

    function generate_drop_down(list) {
        if(list == 'add') {
            get_innerHTML_request("database_droplist.php" + "?list=" + list, "drop_down_list_add",false);
        } else {
            get_innerHTML_request("database_droplist.php", "drop_down_list_edit",false);
        }
    }

    function delete_group(group) {
        get_innerHTML_request("database_delete_group.php" + "?group=" + group, "contacts_list", true);
    }

    function cancel_contact_edit() {
        document.getElementById("message_list").style.display = "inline";
        document.getElementById("contact_edit").style.display = "none";
    }

    //function to handle the add contact request
    function addcontactdatabase() {
        var names = document.getElementById('names').value;
        var phone = document.getElementById('phone').value;
        var select = document.getElementById('select_group_add');
        var group = select.options[select.selectedIndex].value;
        if(group == 'other') {
           group = document.getElementById('new_group_add').value;
        }
        get_innerHTML_request("database_add.php" + "?names=" + names + "&phone=" + phone + "&group=" + group,"contacts_list",true);
        document.getElementById('names').value = "";
        document.getElementById('phone').value = "";
        document.getElementById('new_group_add').value = "";
        generate_drop_down('add');
    }

    //function to add the group input in the add form
    function add_group_input(number) {
        if(number == 0) {
            var list = 'add';
        } else {
            var list = 'edit';
        }
        var select = document.getElementById('select_group_' + list);
        var group_choice = select.options[select.selectedIndex].value;
        if (group_choice == 'other') {
            document.getElementById('add_form_new_group_' + list).style.display = "inline";
        } else {
            document.getElementById('add_form_new_group_' + list).style.display = "none";
        }
    }
    //Function to handle the edit request
    function submit_contact_edit() {
        var name_edit = document.getElementById("name_edit").value;
        var phone_edit = document.getElementById("phone_edit").value;
        var edit_id = document.getElementById("edit_id").innerHTML;
        var select = document.getElementById('select_group_edit');
        var group = select.options[select.selectedIndex].value;
        if(group == 'other') {
           group = document.getElementById('new_group_edit').value;
        }
        document.getElementById("message_list").style.display = "inline";
        document.getElementById("contact_edit").style.display = "none";
        get_innerHTML_request("database_edit.php" + "?names=" + name_edit + "&phone=" + phone_edit + "&edit_id=" + edit_id + "&group=" + group, "contacts_list",true);
    }

    function edit_contact(id) {
        document.getElementById("message_list").style.display = "none";
        document.getElementById("contact_edit").style.display = "inline";
        document.getElementById("edit_id").innerHTML = id;
        generate_drop_down('edit');
        get_value_request("database_fetch_name.php" + "?nameid=" + id, "name_edit",false);
        get_value_request("database_fetch.php" + "?nameid=" + id, "phone_edit",false);
    }

    //function to open and close the add contact panel
    function addContact() {
        var image = document.getElementById('contact_button');
        var add_contact = document.getElementById('add_contact');
        if(image.alt == 0) {
            add_contact.style.display = "inline";
            image.src = "img/add3_clicked.png";
            image.alt = "1";
            image.title = "Close add contact";
            generate_drop_down('add');
        } else {
            add_contact.style.display = "none";
            image.src = "img/add3.png";
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
            $(this).next(".msg_body").slideToggle(200);
        });
    }
    
    function close_notification(){
          // Close the notificaton
    $('.notification span').click(function() {
       jQuery(this).parents('.notification').fadeOut(800);
    });
  
  // Change the cursor
    $('.notification').hover(function() {
      jQuery(this).css('cursor','pointer');
    }, function() {
      jQuery(this).css('cursor','auto');
    }); // Close notifications
    }
    
     function change_to_del_image(image) {
        image.src = "img/group_delete.png";
    }
    function change_to_undel_image(image) {
        image.src = "img/group_undelete.png";
    }

    function change_to_fav_image(image){
        image.src = "img/fav.png";
    }
    function change_to_unfav_image(image){
        image.src = "img/unfav.png";
    }
    function change_to_del(image) {
        image.src = "img/delete.png";
    }
    function change_to_undel(image) {
        image.src = "img/undelete.png";
    }

    $(document).ready(function(){
            set_ready();
            close_notification();
     });
</script>
<?php //require_once("auto_generate_AB.php"); ?>
<div id="add_book">
    <div id="AB_header">
            <img title="Delete Search Entry"src="img/search_delete.png" alt="spotlight"
                 onclick='document.getElementById("searchbox").value = "  ...search";
                          get_innerHTML_request("address_book_gen.php","contacts_list",true);'
                 onMouseOver='this.src = "img/search_undelete.png";' onMouseOut='this.src = "img/search_delete.png";'>
            <input title="Search contact" type="text" id="searchbox" name="searchbox" value="  ...search"
                   onblur='if(this.value == "") {this.value = "  ...search";}'
                   onclick='if(this.value == "  ...search"){this.value = ""};'
                   onkeyup="search(this.value)"/>
    </div>
    <div id="contatcs_page">
        <div id="contacts_list">
                 <?php
                    require_once('address_book_gen.php');
                 ?>
        </div>
    </div>
    <div id="stats">

    </div>
    <div id="AB_footer">
        <img title="Open add contact" id="contact_button" src="img/add3.png" alt="0" onclick="addContact()" />
        <img title="Delete all contacts" id="contact_button" src="img/trash.png" alt="trash" onclick="remove_all_contacts()"/>
        <img title="Statistics" id="contact_button" src="img/stats.png" alt="stats"/>
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
            <p id="drop_down_list_add">
            </p>
            <button title='Add contact' id="add_button" onclick="addcontactdatabase()">Add</button>
    </div>
</div>
