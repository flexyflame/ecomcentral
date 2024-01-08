<!--Include Header-->
<?php  

    $path = $_SERVER['DOCUMENT_ROOT'];
    $header = $path . "/includes/header.php";
    include ($header);

    $nav = $path . "/includes/nav.php";
    include ($nav);

    //require_once($path . "/includes/output_functions.php");  

    $aktion = "show";
    if (!empty($_REQUEST['page_aktion'])) { $aktion = $_REQUEST['page_aktion']; }

    $posted = FALSE;
    if (!empty($_REQUEST['posted_'])) { $posted = TRUE; }

    $id_users = 0;
    if (isset($_REQUEST['id_users'])) { $id_users = $_REQUEST['id_users']; }

    if (strcmp($aktion, "user_photo_update") == 0) {
        if ($posted == TRUE) { 
            if ($id_users != 0) {
                if ($_FILES['fileToUpload']['size'] == 0 && $_FILES['fileToUpload']['error'] == 0) {
                    // cover_image is empty (and not an error)
                    echo "<script>alert('No image was uploaded!')";
                } else {
                    $imagename=$_FILES["fileToUpload"]["name"]; 
                    // get the image extension
                    $extension = substr($imagename,strlen($imagename)-4,strlen($imagename));
                    // allowed extensions
                    $allowed_extensions = array(".jpg",".jpeg",".png",".gif");
                    // Validation for allowed extensions .in_array() function searches an array for a specific value.
                    if(!in_array($extension,$allowed_extensions)) {
                        echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";

                    } elseif ($_FILES["fileToUpload"]["size"] > 500000) {

                        echo "<script>alert('Sorry, your file is too large.  (Max: 50kb)');</script>";
                    } else {
                        //Get the content of the image and then add slashes to it 
                        $imagetmp=addslashes (file_get_contents($_FILES['fileToUpload']['tmp_name']));

                        $dbconn = DB_Connect_Direct();
                        $query = "UPDATE users SET photo = '" . $imagetmp . "' WHERE id = '" . $id_users . "';";
                        $result = DB_Query($dbconn, $query);
                        if ($result != false) {
                            echo "<script>alert('Photo uploaded successfully!');</script>";
                        } else {
                            echo "<script>alert('Photo upload FAILED!');</script>";
                        } // end if ($result != false);0                    
                        DB_Close($dbconn);
                    }
                }   
            }  
        }
        $aktion = 'student_update';
        $posted = FALSE;
    }

?>

<article>
    <div class="main-page" style="min-height: 660px; border: 1px solid #4c9cb4; border-radius: 10px; margin-bottom: 10px; max-width: 1260px;">
        <div class="container-fluid">
            <div class="row">
                 <div class="small-12 medium-8 large-10 columns" style="border-bottom: 1px solid #4c9cb4; margin: 0px -10px 0px 10px;">
                    <h2 class="title" style="margin: 5px 0 0 0;">Manage Users</h2>
                </div>
                
            </div> 
        </div>

        <div class="container-fluid">
            <div style="margin-top: 5px;">
                <ul class="accordion" data-accordion data-allow-all-closed="true" style="margin: 10px 25px">
                  <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title" style="padding: 15px 20px;">Advance Filter</a>
                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content style="padding: 5px;">
                        <div class="filter-cover">
                            <div class="row">
                                <div class="small-12 medium-4 large-4 columns">
                                    <label for="text_id_users_filter" class="left inline">User ID:</label>
                                    <input name="text_id_users_filter" type="text" id="text_id_users_filter" placeholder="User ID" oninput="Filter_Reload();" />
                                </div>
                                <div class="small-12 medium-4 large-4 columns">
                                    <label for="text_login_filter" class="left inline">Login:</label>
                                    <input name="text_login_filter" type="text" id="text_login_filter" placeholder="Login" oninput="Filter_Reload();"/>
                                </div>
                                <div class="small-6 medium-2 large-2 columns">
                                    <label for="select_supervisor_filter" class="left inline">Supervisor</label>
                                    <select id="select_supervisor_filter" name="select_supervisor_filter" onchange="Filter_Reload();">
                                        <option value="-1">Any</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="small-6 medium-2 large-2 columns">
                                    <label for="select_status_filter" class="left inline">Status</label>
                                    <select id="select_status_filter" name="select_status_filter" onchange="Filter_Reload();">
                                        <option value="-1">Any</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-12 medium-4 large-4 columns">
                                    <label for="text_name_filter" class="left inline">Name:</label>
                                    <input name="text_name_filter" type="text" id="text_name_filter" placeholder="Name" oninput="Filter_Reload();"/>
                                </div>
                                <div class="small-12 medium-4 large-4 columns">
                                    <label for="text_firstname_filter" class="left inline">First Name:</label>
                                    <input name="text_firstname_filter" type="text" id="text_firstname_filter" placeholder="First Name" oninput="Filter_Reload();"/>
                                </div>
                                <div class="small-12 medium-4 large-4 columns">
                                    <label for="text_email_filter" class="left inline">Email:</label>
                                    <input name="text_email_filter" type="text" id="text_email_filter" placeholder="Email" oninput="Filter_Reload();"/>
                                </div>
                            </div>

                        </div>
                    </div>
                  </li>
                </ul>
            </div>
        </div>

        <!-- content rows -->
        <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_users_overview" name="form_users_overview" method="post">
            <div class="row" style="padding-top:5px">   

                <div class="small-12 medium-4 large-4 columns limit-cover cell">
                    <div style="display: inline-flex; color: blue;" id="myTable_length">
                        <label style="display: inline-flex;">
                            <span style="padding: 9px 5px 0px 0px; color: #00ced1;;">Show </span> 
                            <select name="myTable_limit" id="myTable_limit" aria-controls="myTable">
                                <option value="3">3</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> 
                            <span style="padding: 9px 5px 0px 5px; color: #00ced1;"> entries</span> 
                        </label>
                    </div>
                </div>

                <div class="small-12 medium-5 large-5 columns search-cover cell">
                    <div id="myTable_filter" class="dataTables_filter">
                        <label style="display: flex;">
                            <span style="padding: 9px 5px 0px 0px; color: #00ced1;">Search: </span> 
                            <input type="search" style="font-size: inherit; margin: 0px;" placeholder="" aria-controls="myTable">
                        </label>
                    </div>
                </div>

                <div class="small-12 medium-3 large-3 columns buttons-cover">
                    <a class="button small btn-Table success" title="Save as CSV" href="/output_files.php?page_aktion=csv" onclick="SpinnerBlock();"><i class="fas fa-file" aria-hidden="true"></i></a>
                    <a class="button small btn-Table success" title="Save as Excel" href="/output_files.php?page_aktion=excel" onclick="SpinnerBlock();"><i class="fas fa-file-excel" aria-hidden="true"></i></a>
                    <a class="button small btn-Table success" title="Save PDF" href="/gen_pdf.php?page_aktion=pdf" target="_blank" onclick="SpinnerBlock();"><i class="fas fa-file-pdf" aria-hidden="true"></i></a>
                    <a class="button small btn-Table success" title="Print" href="/gen_pdf.php?page_aktion=print" target="_blank" onclick="SpinnerBlock();"><i class="fas fa-print" aria-hidden="true"></i></a>

                    <a class="button small btn-Table" title="Add Record" data-open="reveal_users_edit" onclick=""><i class="fas fa-plus-square" aria-hidden="true"></i></a>
                </div>

                <div class="large-12 small-centered columns" style="padding: 0px;">
                    <table class="responsive-card-table  table-expand hover" id="myTable">  
                        <thead>
                            <th width="10%">User ID</th>
                            <th width="15%">Login</th>
                            <th width="15%">Name</th>
                            <th width="15%">First Name</th>
                            <th width="15%">Email</th>
                            <th width="5%">Supervisor</th>
                            <th width="5%">Status</th>
                            <th width="10%">Photo</th>
                            <th width="10%">***</th>
                        </thead>
                        <tbody id="tbody_Overview">
                            
                        </tbody>
                    </table>
                </div>

                <div class="small-12 medium-12 large-12 columns limit-cover cell">
                    <div class="row">
                        <div class="small-12 medium-6 large-6 columns">
                            <div id="pagenav_info"></div>
                        </div>
                        <div class="small-12 medium-6 large-6 columns">
                            <div id="pagenav" role="status" aria-live="polite"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--Users Edit Reveal-->
    <div class="reveal large" id="reveal_users_edit" name="reveal_users_edit" data-reveal data-close-on-click="false" style="padding: 1rem; border: 2px solid #607D8B; border-radius: 15px;">
        <fieldset style="padding: 0; border: 0;">

            <div class="mobile-nav-bar title-bar" style="background-color: #567a92; margin-bottom: 15px; padding: 5px 10px;">
                <div class="title-bar-left">
                    <button class="menu-icon" type="button"></button>
                </div>
                <div class="title-bar-center">
                    <span id="create_text">Create New User</span>
                    <span id="edit_text">Edit User Detail</span>
                    <span id="copy_text">Copy User Record</span>
                </div>
                <div class="title-bar-right">
                    <button class="menu-icon" type="button"></button>
                </div>
            </div>

            <div class="row">
                <div class="small-12 medium-8 large-10 columns">
                    <div class="row">
                        <div class="small-4 medium-2 large-2 columns">
                            <label for="text_id_users" class="left inline">User ID:</label>
                            <input name="text_id_users" type="text" id="text_id_users" placeholder="User ID" value="" readonly />
                        </div>
                        <div class="small-8 medium-6 large-6 columns">
                            <label for="text_login" class="left inline">Login:</label>
                            <input name="text_login" type="text" id="text_login" placeholder="Login" value="" />
                        </div>
                        <div class="small-6 medium-2 large-2 columns">
                            <label for="select_supervisor" class="left inline">Supervosor</label>
                            <select id="select_supervisor" name="select_supervisor">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="small-6 medium-2 large-2 columns">
                            <label for="select_status" class="left inline">Status</label>
                            <select id="select_status" name="select_status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-12 medium-6 large-6 columns">
                            <label for="text_name" class="left inline">Name:</label>
                            <input name="text_name" type="text" id="text_name" placeholder="Name" value="" />
                        </div>

                        <div class="small-12 medium-6 large-6 columns">
                            <label for="text_firstname" class="left inline">First Name:</label>
                            <input name="text_firstname" type="text" id="text_firstname" placeholder="First Name" value="" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-12 medium-12 large-12 columns">
                            <label for="text_email" class="left inline">Email:</label>
                            <input name="text_email" type="text" id="text_email" placeholder="Email" value="" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-12 medium-12 large-12 columns">
                            <fieldset style="border: 1px solid #e6e6e6; border-radius: 10px; margin-bottom: 10px; padding: 5px 15px; background: aliceblue; color: #607D8B;">
                                <legend><i>Photo Upload: </i></legend>
                                <div class="row">
                                    <div class="small-12 medium-12 large-12 columns" style="display: inline-flex;">
                                        <input id="inputFileToLoad" type="file" onchange="encodeImageFileAsURL();" />             
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <!--Side bar-->
                <div class="small-12 medium-4 large-2 columns" style="border-left: 1px solid #e9e9e9;">
                    
                    <div class="responsive-picture team-picture">
                        <?php
                            if (!empty($image_content)) {
                                echo '<div><img class="img_photo" id="img_photo" alt="User Picture" style="border-radius: 10px; border: 1px solid #ddd;" src="data:image/jpeg;base64,' . base64_encode($image_content) . '"  /></div>' ;
                            } else {
                                echo '<div><img class="img_photo" id="img_photo" alt="User Picture" style="border-radius: 10px; border: 1px solid #ddd;" src="/images/undefined.png"  /></div>' ;
                            }
                        ?>
                        <div style="text-align: center; text-align: center; font-weight: 600; color: brown;"><span id="id_users_show" name="id_users_show"></span></div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="small-12 medium-2 large-2 columns"></div>
                <div class="small-12 medium-8 large-8 columns" style="border-top: dashed 1px #165366;">
                    <input name="id_produkt_hidden" type="hidden" id="id_produkt_hidden" value="0" />
                    <div class="button-group-option" data-grouptype="OR" style="margin: 5px 0px; padding: 0px;">
                        <a class="button alert radius" style="padding: 10px;" id="btn_abbrechen" name="btn_abbrechen" data-close aria-label="Close reveal">Cancel</a>
                        <a class="button success radius" style="padding: 10px;" id="btn_speichern" name="btn_speichern" onclick="Produkt_Erstellen();" data-element-index="10">Save</a>
                    </div>
                </div>
                <div class="small-12 medium-2 large-2 columns"></div>
            </div>
        </fieldset>
    </div>

</article>

<!--Include Nav_Footer and Footer-->
<?php 
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    include ($path . "/includes/nav_footer.php");
    include ($path . "/includes/footer.php");
?>


<script type="text/javascript">
    var text_id_users_filter = document.getElementById("text_id_users_filter");
    var text_login_filter = document.getElementById("text_login_filter");
    var text_name_filter = document.getElementById("text_name_filter");
    var text_firstname_filter = document.getElementById("text_firstname_filter");
    var text_email_filter = document.getElementById("text_email_filter");
    var select_supervisor_filter = document.getElementById("select_supervisor_filter");
    var select_status_filter = document.getElementById("select_status_filter");

    var myTable_limit = document.getElementById("myTable_limit");

    addLoadEvent(REST_Users_list(0, 0, myTable_limit.value));

    function encodeImageFileAsURL() {
        console.log('encodeImageFileAsURL()');

        var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];  //acceptable file types
        var filesSelected = document.getElementById("inputFileToLoad").files;
        var isSizeSuccess = false;

        if (filesSelected.length > 0) {

            var fileToLoad = filesSelected[0];

            var extension = fileToLoad.name.split('.').pop().toLowerCase(),  //file extension from input file
            isExtensionSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types
            //isSizeSuccess = fileTypes.size <= 500000;  //is size in acceptable types

            if (fileTypes.size < 500001) {
                isSizeSuccess = true;
            } else {
                isSizeSuccess = false;
                alert(fileToLoad.size + ' :: ' + isSizeSuccess);
            }  

            if (isExtensionSuccess) { //Extension OK
                if (isExtensionSuccess == true) { //Size OK

                    var fileReader = new FileReader();
                    fileReader.onload = function(fileLoadedEvent) {
                        var srcData = fileLoadedEvent.target.result; // <--- data: base64

                        var img_photo = document.getElementById("img_photo");
                        img_photo.src = srcData;
                        //alert("Converted Base64 version is " + img_photo.src);
                        //console.log("Converted Base64 version is " + img_photo.src);
                    }
                    fileReader.readAsDataURL(fileToLoad);

                } else { //Size NOT OK
                    //warning
                    alert('Sorry, your file is too large.  (Max: 50kb)');
                }

            } else {//Extension NOT OK
                //warning
                //alert('Sorry, your file is too large.  (Max: 50kb)');
                alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');

            }
        }
    }
    
    function Filter_Reload() {
        REST_Users_list(0, 0, myTable_limit.value);
    }

    function PageNav(show_num_pages, query_total, query_offset, query_limit) {  
        //alert(query_total + " " + query_offset + " " + query_limit);
        var div_pagenav = document.getElementById("pagenav");
        var div_pagenav_info = document.getElementById("pagenav_info");

        var innerHTML = '<p style="color: #2ba6cb;"><strong>Total Records:</strong> '+query_total+' entries</p>';
        div_pagenav_info.innerHTML=innerHTML; 

        if (div_pagenav == null) return;

        // Hilfsberechnungen
        var show_num_pages_half = Math.floor(show_num_pages / 2); // Hilfsberechnung für halbe Seitenzahlenanzeige
        var num_pages = Math.ceil(query_total / query_limit); // Anzahl aktueller Seiten
        var current_page = Math.floor(query_offset / query_limit); // aktuelle Seiten-Nr.  
        //
        // Vorherigen Content entfernen
        div_pagenav.innerHTML = '';
        
        var div_row_pagenav = document.createElement('div');    
        div_row_pagenav.className = 'row';
            
        var div_col_pagenav = document.createElement('div');
        div_col_pagenav.className = 'small-12 medium-12 large-12 columns';
        
        var li = null;
        var ul_pagenav = document.createElement('ul');
        ul_pagenav.className = 'pagination text-center';
        
        div_col_pagenav.appendChild(ul_pagenav);
        div_row_pagenav.appendChild(div_col_pagenav);
        div_pagenav.appendChild(div_row_pagenav);
        
        // Pfeil nach links anzeigen, wenn Datensatz > 1
        if (current_page > 0) {
            li = document.createElement('li');
            li.className = 'arrow';
            li.innerHTML = '<a class="class_spinner_id" onclick="REST_Users_list(' + query_total + ', ' + ((current_page - 1) * query_limit) + ', ' + query_limit + ');">&laquo;</a>';
            ul_pagenav.appendChild(li);
        }

        // Seitenanzeige aufbauen
        if (show_num_pages < num_pages) { // mehr Seiten als "Anzahl-Seiten" vorhanden
            if (current_page > show_num_pages_half) {
                // Seite 1 ...
                li = document.createElement('li');
                li.className = 'arrow';
                li.innerHTML = '<a class="class_spinner_id" onclick="REST_Users_list(' + query_total + ', ' + (0 * query_limit) + ', ' + query_limit + ');">1</a>';
                ul_pagenav.appendChild(li);
                
                li = document.createElement('li');
                li.className = 'unavailable';
                li.innerHTML = '<a>&hellip;</a>';
                ul_pagenav.appendChild(li);
            } // end if (current_page > show_num_pages_half);
            
            
            if (current_page <= show_num_pages_half) { // Seite 1..7
                for (i = 0; i < show_num_pages; i++) {
                    li = document.createElement('li');
                    if (i == current_page) {
                        li.className = 'current';
                    } else {
                        li.className = '';
                    }
                    li.innerHTML = '<a class="class_spinner_id" onclick="REST_Users_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
                    ul_pagenav.appendChild(li);
                } // end for (i);
                
            } else if (current_page >= ((num_pages - 1) - show_num_pages_half)) { // Seite (n-1) - 7 bis (n-1)
                for (i = (num_pages - show_num_pages); i < num_pages; i++) {
                    li = document.createElement('li');
                    if (i == current_page) {
                        li.className = 'current';
                    } else {
                        li.className = '';
                    }
                    li.innerHTML = '<a class="class_spinner_id" onclick="REST_Users_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
                    ul_pagenav.appendChild(li);
                } // end for (i);
                
            } else { // zwischen min und max Seiten
                    
                for (i = (current_page - show_num_pages_half); i <= (current_page + show_num_pages_half); i++) {
                    li = document.createElement('li');
                    if (i == current_page) {
                        li.className = 'current';
                    } else {
                        li.className = '';
                    }
                    li.innerHTML = '<a class="class_spinner_id" onclick="REST_Users_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
                    ul_pagenav.appendChild(li);
                } // end for (i);   
            }

            if (current_page < ((num_pages - 1) - show_num_pages_half) ) {
                // ... Seite n-1
                li = document.createElement('li');
                li.className = 'unavailable';
                li.innerHTML = '<a>&hellip;</a>';
                ul_pagenav.appendChild(li);             
                
                li = document.createElement('li');
                li.className = 'arrow';
                li.innerHTML = '<a class="class_spinner_id" onclick="REST_Users_list(' + query_total + ', ' + ((num_pages - 1) * query_limit) + ', ' + query_limit + ');">' + num_pages + '</a>';         
                ul_pagenav.appendChild(li);
            
            } // end if (current_page < (num_pages - show_num_pages_half) );

        } else { // weniger als 7 Seiten
        
            for (i = 0; i < num_pages; i++) {
                li = document.createElement('li');
                if (i == current_page) {
                    li.className = 'current';
                } else {
                    li.className = '';
                }
                li.innerHTML = '<a class="class_spinner_id" onclick="REST_Users_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
                ul_pagenav.appendChild(li);
            } // end for (i);
        } // end if (show_num_pages > num_pages);
        
        if (current_page < (num_pages - 1)) {
            li = document.createElement('li');
            li.className = 'arrow';
            li.innerHTML = '<a class="class_spinner_id" onclick="REST_Users_list(' + query_total + ', ' + ((current_page + 1) * query_limit) + ', ' + query_limit + ');">' + '&raquo;' + '</a>';      
            ul_pagenav.appendChild(li);     
        } // end if (current_page > 0)

        return;
    } // end PageNav();

    function REST_Users_list(query_total, query_offset, query_limit) {
        console.log('REST_Users_list()');

        //Prepare Table Filter
        var zFilter_Param   = '&id_users=' + text_id_users_filter.value + '&login=' + text_login_filter.value + '&name=' + text_name_filter.value + '&firstname=';
        zFilter_Param       += text_firstname_filter.value + '&email=' + text_email_filter.value + '&supervisor=' + select_supervisor_filter.value + '&status=' + select_status_filter.value;
        //alert(zFilter_Param);
        //
        var tbody_Overview = document.getElementById("tbody_Overview");

        //SpinnerStart(false);

        var xmlhttp;
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                // var str = xmlhttp.responseText;
                // alert(str);
                // alert(xmlhttp.responseXML);
                console.log(xmlhttp.responseXML);
                if (xmlhttp.responseXML == null) {
                    console.log('No data found!');
                    return;
                }

                tbody_Overview.innerHTML = '';

                var i_bgcolor = 0;

                var node_query_count = xmlhttp.responseXML.getElementsByTagName("query_count");
                var node_query_offset = xmlhttp.responseXML.getElementsByTagName("query_offset");
                var node_query_limit = xmlhttp.responseXML.getElementsByTagName("query_limit");
                var xml_query_count = node_query_count[0].childNodes[0].nodeValue;
                var xml_query_offset = node_query_offset[0].childNodes[0].nodeValue;
                var xml_query_limit = node_query_limit[0].childNodes[0].nodeValue;
                
                PageNav(7, xml_query_count, xml_query_offset, xml_query_limit); // (show_num_pages, query_total, query_offset, query_limit)

                var nodeUsers_List = xmlhttp.responseXML.getElementsByTagName("users_list");
                // alert(nodeUsers_List[0].childNodes.length);
                for (var i = 0; i < nodeUsers_List[0].childNodes.length; i++) {
                    // alert("NodeName: " + nodeUsers_List[0].childNodes[i].nodeName + " | NodeType:" + nodeUsers_List[0].childNodes[i].nodeType); 
                    if (nodeUsers_List[0].childNodes[i].nodeType == 1) {
                        var nodeUsers = nodeUsers_List[0].childNodes[i];
                        // alert(nodeUsers.childNodes.length);

                        var xml_id_users = 0,
                            xml_login = '',
                            xml_name = '',
                            xml_firstname = '',
                            xml_email = '',
                            xml_password = '',
                            xml_supervisor = 0;
                            xml_status = 0;
                            xml_photo = '';

                        for (var j = 0; j < nodeUsers.childNodes.length; j++) {
                            if (nodeUsers.childNodes[j].nodeType == 1) {
                                // alert("NodeName: " + nodeUsers.childNodes[j].nodeName + " | NodeType:" + nodeUsers.childNodes[j].nodeType + " | NodeValue: " +  nodeUsers.childNodes[j].childNodes[0].nodeValue); 
                                if (nodeUsers.childNodes[j].nodeName === 'id_users') xml_id_users = nodeUsers.childNodes[j].childNodes[0].nodeValue;
                                if (nodeUsers.childNodes[j].nodeName === 'login') xml_login = nodeUsers.childNodes[j].childNodes[0].nodeValue;
                                if (nodeUsers.childNodes[j].nodeName === 'name') xml_name = nodeUsers.childNodes[j].childNodes[0].nodeValue;
                                if (nodeUsers.childNodes[j].nodeName === 'firstname') xml_firstname = nodeUsers.childNodes[j].childNodes[0].nodeValue;
                                if (nodeUsers.childNodes[j].nodeName === 'email') xml_email = nodeUsers.childNodes[j].childNodes[0].nodeValue;
                                if (nodeUsers.childNodes[j].nodeName === 'password') xml_password = nodeUsers.childNodes[j].childNodes[0].nodeValue;
                                if (nodeUsers.childNodes[j].nodeName === 'supervisor') xml_supervisor = nodeUsers.childNodes[j].childNodes[0].nodeValue;
                                if (nodeUsers.childNodes[j].nodeName === 'status') xml_status = nodeUsers.childNodes[j].childNodes[0].nodeValue;
                                if (nodeUsers.childNodes[j].nodeName === 'photo') xml_photo = nodeUsers.childNodes[j].childNodes[0].nodeValue;

                            } // nodeType = ELEMENT_NODE
                        } // end for (j);
                        //alert (xml_id_users + " :: " + login + " :: " + xml_name + " :: " + firstname + " :: " + email);
                        //
                        bgcolor_row = '';
                        if ((i_bgcolor % 2) == 0) {
                            bgcolor_row = '<?php echo $UTIL->table_bg_color_even(); ?>';
                        } else {
                            bgcolor_row = '<?php echo $UTIL->table_bg_color_odd(); ?>';
                        }

                        var tr = document.createElement('tr');
                        tbody_Overview.appendChild(tr);
                        var td = [];

                        //---------------------------------------------------------------------//

                        td[0] = document.createElement('td');
                        td[0].setAttribute('bgcolor', bgcolor_row);
                        td[0].setAttribute('valign', 'top');
                        td[0].setAttribute('data-label', 'User ID:');

                        td[0].innerHTML = '';

                        td[0].innerHTML += '<div><span style="font-weight: 600; color: crimson;">' + xml_id_users + '</span></div>';

                        //---------------------------------------------------------------------//

                        td[1] = document.createElement('td');
                        td[1].setAttribute('bgcolor', bgcolor_row);
                        td[1].setAttribute('valign', 'top');
                        td[1].setAttribute('data-label', 'Login');

                        td[1].innerHTML = '';
                        td[1].innerHTML += '<div><span style="font-weight: 600; color: #004465;">' + utf8Decode(xml_login) + '</span></div>';

                        //---------------------------------------------------------------------//

                        td[2] = document.createElement('td');
                        td[2].setAttribute('bgcolor', bgcolor_row);
                        td[2].setAttribute('valign', 'top');
                        td[2].setAttribute('data-label', 'Name');

                        td[2].innerHTML = '';
                        td[2].innerHTML += '<div>' + utf8Decode(xml_name) + '</div>';


                        //---------------------------------------------------------------------//

                        td[3] = document.createElement('td');
                        td[3].setAttribute('bgcolor', bgcolor_row);
                        td[3].setAttribute('valign', 'top');
                        td[3].setAttribute('data-label', 'First name');

                        td[3].innerHTML = '';
                        td[3].innerHTML += '<div>' + utf8Decode(xml_firstname) + '</div>';

                        //---------------------------------------------------------------------//

                        td[4] = document.createElement('td');
                        td[4].setAttribute('bgcolor', bgcolor_row);
                        td[4].setAttribute('valign', 'top');
                        td[4].setAttribute('data-label', 'Email');

                        td[4].innerHTML = '';
                        td[4].innerHTML += '<div>' + utf8Decode(xml_email) + '</div>';


                        //---------------------------------------------------------------------//

                        /*td[5] = document.createElement('td');
                        td[5].setAttribute('bgcolor', bgcolor_row);
                        td[5].setAttribute('valign', 'top');
                        td[5].setAttribute('data-label', 'password');

                        td[5].innerHTML = '';
                        td[5].innerHTML += '<div>' + utf8Decode(xml_password) + '</div>';*/

                        //---------------------------------------------------------------------//

                        td[6] = document.createElement('td');
                        td[6].setAttribute('bgcolor', bgcolor_row);
                        td[6].setAttribute('valign', 'top');
                        td[6].setAttribute('data-label', 'Supervisor');

                        td[6].innerHTML = '';
                        td[6].innerHTML += '<p style="margin: 1px 0; color: #1779ba; text-align: center;"><span>' + ((xml_supervisor == 1) ? '<?php echo $UTIL->IMG_Activated(15, 15); ?>' : '<?php echo $UTIL->IMG_Deactivated(15, 15); ?>') + '</span></p>';

                        //---------------------------------------------------------------------//

                        td[7] = document.createElement('td');
                        td[7].setAttribute('bgcolor', bgcolor_row);
                        td[7].setAttribute('valign', 'top');
                        td[7].setAttribute('data-label', 'Status');

                        td[7].innerHTML = '';
                        td[7].innerHTML += '<p style="margin: 1px 0; color: #1779ba; text-align: center;"><span>' + ((xml_status == 1) ? '<?php echo $UTIL->IMG_Activated(15, 15); ?>' : '<?php echo $UTIL->IMG_Deactivated(15, 15); ?>') + '</span></p>';

                        //---------------------------------------------------------------------//

                        td[8] = document.createElement('td');
                        td[8].setAttribute('bgcolor', bgcolor_row);
                        td[8].setAttribute('valign', 'top');
                        td[8].setAttribute('data-label', 'Photo');

                        td[8].innerHTML = '';
                        //td[8].innerHTML += '<div><img class="img_photo" alt="User Picture" style="border-radius: 10px; border: 1px solid #ddd;" src="' + atob(xml_photo) + '"></div>';

                        if (xml_photo != '') {
                            //td[8].innerHTML += '<div><img class="img_photo" alt="User Picture" style="border-radius: 10px; border: 1px solid #ddd;" src="' + atob(xml_photo) + '"></div>';
                            //echo '<div><img class="img_photo" id="img_photo" alt="User Picture" style="border-radius: 10px; border: 1px solid #ddd;" src="data:image/jpeg;base64,' . base64_encode($image_content) . '"  /></div>' ;
                        } else {
                            td[8].innerHTML += '<div><img class="img_photo" alt="User Picture" style="border-radius: 10px; border: 1px solid #ddd;" src="/images/undefined.png"></div>';
                            //echo '<div><img class="img_photo" id="img_photo" alt="User Picture" style="border-radius: 10px; border: 1px solid #ddd;" src="/images/undefined.png"  /></div>' ;
                        }

                        //---------------------------------------------------------------------//

                        td[9] = document.createElement('td');
                        td[9].setAttribute('bgcolor', bgcolor_row);
                        td[9].setAttribute('valign', 'top');
                        td[9].setAttribute('data-label', '***');

                        td[9].innerHTML = '';
                        td[9].innerHTML += '<div><a href=""><i class="fa fa-edit action-controls" title="Edit Record"></i> </a></div>';

                        //---------------------------------------------------------------------//

                        tr.appendChild(td[0]);
                        tr.appendChild(td[1]);
                        tr.appendChild(td[2]);
                        tr.appendChild(td[3]);
                        tr.appendChild(td[4]);
                        //tr.appendChild(td[5]);
                        tr.appendChild(td[6]);
                        tr.appendChild(td[7]);
                        tr.appendChild(td[8]);
                        tr.appendChild(td[9]);

                        //---------------------------------------------------------------------//

                        i_bgcolor++;
                    } // nodeType = ELEMENT_NODE

                } // end for (i);

                //SpinnerStop(false);
            } // end if
        } // end onreadystatechange
        xmlhttp.ontimeout = function() {
            //SpinnerStop(false);
        }

        xmlhttp.open("POST", encodeURI("/api/xml/v1/users_list.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds

        post_parameters = GetAPIAccess();
        post_parameters += zFilter_Param; 

        post_parameters += "&query_offset=" + query_offset;
        post_parameters += "&query_limit=" + query_limit;

        //alert(post_parameters);
        console.log(post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_Users_list();


    /*$(document).ready( function () {    
        var table = $('#myTable').DataTable({
            responsive: true,
            stateSave: true,
            searchBuilder: true,
            searchBuilder: {columns: [1,2,3]},
            language: {searchBuilder: {clearAll: 'Reset' ,title: {0: 'Filter', _: 'Filters (%d)'},}},
            
            buttons: [ 
                {
                    extend: 'copy', 
                    text: '<i class="fa fa-copy" aria-hidden="true"></i>',
                    titleAttr: 'Copy to clipboard',
                    className:'btn-Table button success'
                },
                {
                    extend: 'csv', 
                    text: '<i class="fa fa-file" aria-hidden="true"></i>',
                    titleAttr: 'Save as CSV',
                    className:'btn-Table button primary'
                },
                {
                    extend: 'excel', 
                    text: '<i class="fa fa-file-excel" aria-hidden="true"></i>',
                    titleAttr: 'Save as Excel',
                    className:'btn-Table button success'
                },
                {
                    extend: 'pdf', 
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    titleAttr: 'Save PDF',
                    className:'btn-Table button success'
                },
                {
                    extend: 'print', 
                    text: '<i class="fa fa-print" aria-hidden="true"></i>',
                    titleAttr: 'Print',
                    className:'btn-Table button success'
                },],
        });

        table.searchBuilder.container().prependTo(".filter-cover");
        table.buttons().containers().prependTo(".buttons-cover");
    } );*/
</script>