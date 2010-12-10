 <?php
                            while ($list = mysql_fetch_array($list_retrieve)) {
                                $name = $list['names'];
                                $id = $list['id'];
                                echo "<div id='contact'>";
                                echo "<h4 title='Click to insert number' id='contact_name' onclick='getNumber(".$id.")'>" . $name . "</h4>";
                                echo "<img title='Edit contact' id='edit_button' src='img/edit.png' onclick='edit_contact(".$id.")'/>";
                                echo "<img title='Delete contact' id='delete_button' src='img/delete.png' onclick='remove_contact(".$id.")'/>";
                                echo "</div>";
                            }
                            include 'google.php';
                        ?>