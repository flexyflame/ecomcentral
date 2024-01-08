<!--Include Header-->
<?php  
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/header.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-header.php");

    //Page PHP -- Start--
    if (!isset($SESSION)) {
        die("SESSION Class not defined!");  
    }

    $aktion = "show";
    if (!empty($_REQUEST['page_aktion'])) { $aktion = $_REQUEST['page_aktion']; }

    $posted = FALSE;
    if (!empty($_REQUEST['posted_'])) { $posted = TRUE; }

    $select_term = "201201";

    $error_type = "";
    $form_id = "form_student";
    $form_name = "form_student";
    $page_titel = "Student Entry";
    $submit_button_titel = "Save";

      /*  $imgnewfile = "";
        // Posted Image Values
        //$imgtitle=$_POST['imagetitle'];
        $imgfile=$_FILES["fileToUpload"]["name"];
        if (isset($imgfile)) {
            
            // get the image extension
            $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
            // allowed extensions
            $allowed_extensions = array(".jpg","jpeg",".png",".gif");
            // Validation for allowed extensions .in_array() function searches an array for a specific value.
            if(!in_array($extension,$allowed_extensions)) {
                echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
            } else {
                //rename the image file
                $imgnewfile=md5($imgfile).$extension;
                echo $imgnewfile;
                // Code for move image into directory
                //move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],"uploadeddata/".$imgnewfile);
                // Query for insertion data into database
                $dbconn = DB_Connect_Direct();
                $query = "UPDATE student SET photo = '" . $imgnewfile . "' WHERE id = '" . $student_id . "';";
                 $result = DB_Query($dbconn, $query);
                if ($result != false) {
                    echo "<script>alert('Photo inserted successfully');</script>";
                    $error_type = 'update_success';
                } else {
                    echo "<script>alert('Photo not inserted');</script>";
                    $error_type = 'update_fail';
                } // end if ($result != false);0                    
                DB_Close($dbconn);
            }

        }*/
        
    
    


    
    //$id_student = GetSequence('STUDENT');
    //echo $id_student;
    $student_id = 0;
    if (isset($_GET['student_id'])) { $student_id = $_GET['student_id']; }

    $id_student = 0;
    if (isset($_REQUEST['id_student'])) { $id_student = $_REQUEST['id_student']; }

    $text_manual_id = "";
    if (isset($_REQUEST['text_manual_id'])) { $text_manual_id = $_REQUEST['text_manual_id']; }

    $text_lastname = "";
    if (isset($_REQUEST['text_lastname'])) { $text_lastname = $_REQUEST['text_lastname']; }

    $text_firstname = "";
    if (isset($_REQUEST['text_firstname'])) { $text_firstname = $_REQUEST['text_firstname']; }

    $text_othername = "";
    if (isset($_REQUEST['text_othername'])) { $text_othername = $_REQUEST['text_othername']; }

    $select_sex = 0;
    if (isset($_REQUEST['select_sex'])) { $select_sex = $_REQUEST['select_sex']; }

    $text_birthday = "";
    if (isset($_REQUEST['text_birthday'])) { $text_birthday = $_REQUEST['text_birthday']; }

    $text_house = "";
    if (isset($_REQUEST['text_house'])) { $text_house = $_REQUEST['text_house']; }

    $check_boarder = 0;
    if (isset($_REQUEST['check_boarder'])) { $check_boarder = 1; }

    $select_grade = "";
    if (isset($_REQUEST['select_grade'])) { $select_grade = $_REQUEST['select_grade']; }

    $text_room = "";
    if (isset($_REQUEST['text_room'])) { $text_room = $_REQUEST['text_room']; }

    $select_religion = "";
    if (isset($_REQUEST['select_religion'])) { $select_religion = $_REQUEST['select_religion']; }

    $text_homelanguage = "";
    if (isset($_REQUEST['text_homelanguage'])) { $text_homelanguage = $_REQUEST['text_homelanguage']; }

    $select_nationality = "";
    if (isset($_REQUEST['select_nationality'])) { $select_nationality = $_REQUEST['select_nationality']; }

    $select_status = "";
    if (isset($_REQUEST['select_status'])) { $select_status = $_REQUEST['select_status']; }

    $select_startyear = "";
    if (isset($_REQUEST['select_startyear'])) { $select_startyear = $_REQUEST['select_startyear']; }

    $select_yeargroup = "";
    if (isset($_REQUEST['select_yeargroup'])) { $select_yeargroup = $_REQUEST['select_yeargroup']; }

    $text_parent = "";
    if (isset($_REQUEST['text_parent'])) { $text_parent = $_REQUEST['text_parent']; }

    $image_content ="";
    if (isset($_REQUEST['img_photo'])) { $image_content = $_REQUEST['img_photo']; }


    if (strcmp($aktion, "student_photo_update") == 0) {
        if ($posted == TRUE) { 
            if ($student_id != 0) {
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
                        $query = "UPDATE student SET photo = '" . $imagetmp . "' WHERE id = '" . $id_student . "';";
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


    if (strcmp($aktion, "student_new") == 0) {
        $form_id = "form_student_new";
        $form_name = "form_student_new";
        $page_titel = "Create New Student";
        $submit_button_titel = "Create Student";
        $aktion = 'student_create';

    }

    if (strcmp($aktion, "student_create") == 0) {
        $form_id = "form_student_create";
        $form_name = "form_student_create";
        $page_titel = "Update Student";
        $submit_button_titel = "Update Student";

        if ($posted == TRUE) { 

            $id_student = GetSequence('STUDENT');

            //Create Student
            $dbconn = DB_Connect_Direct();
            $query  = "INSERT INTO student (id, ";
            $query .= "id2, lastname, firstname, othername, sex, birthday, boarder, nationality, grade, room, ";
            $query .= "house, parent, homelanguage, `status`, regdate, lastuser, startyear, yeargroup, religion) ";

            $query .= "VALUE ('" . $id_student . "', ";
            $query .= "'" . $text_manual_id . "', '" . $text_lastname .  "', '" . $text_firstname .  "', '" . $text_othername .   "', '" . $select_sex .  "', '" . $text_birthday .  "', '" . $check_boarder .  "', '" . $select_nationality .  "', '" . $select_grade .  "', '" . $text_room . "', ";

            $query .= "'" . $text_house . "', '" . $text_parent .  "', '" . $text_homelanguage .  "', '" . $select_status .   "', CURDATE(), '" . $_SESSION['id_users'] .  "', '" . $select_startyear .  "', '" . $select_yeargroup .  "', '" . $select_religion . "');";

            echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                $error_type = 'insert_success';
                $aktion = 'student_update';
                $posted = FALSE;
            } else {
                $error_type = 'insert_fail';
            } // end if ($result != false);0                    
            DB_Close($dbconn);
        }
    }


    if (strcmp($aktion, "student_update") == 0) {
        $form_id = "form_student_update";
        $form_name = "form_student_update";
        $page_titel = "Update Student";
        $submit_button_titel = "Update Student";

        if ($posted == TRUE) { 

            $dbconn = DB_Connect_Direct();
            $query = "UPDATE student SET id2 = '" . $text_manual_id . "', lastname = '" . $text_lastname . "', firstname = '" . $text_firstname .  "', othername = '" . $text_othername . "', ";
            $query .= "sex = '" . $select_sex . "', birthday = '" . $text_birthday . "', boarder = '" . $check_boarder . "', nationality = '" . $select_nationality . "', grade = '" . $select_grade . "', room = '" . $text_room . "', ";
            $query .= "house = '" . $text_house . "', parent = '" . $text_parent . "', homelanguage = '" . $text_homelanguage . "', `status` = '" . $select_status . "', lastuser = '" . $_SESSION['id_users'] . "',";
            $query .= "startyear = '" . $select_startyear . "', yeargroup = '" . $select_yeargroup . "', religion = '" . $select_religion . "' ";
            $query .= " WHERE id = '" . $id_student . "';";
            
            echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                $error_type = 'update_success';
                $aktion = 'student_update';
            } else {
                $error_type = 'update_fail';
            } // end if ($result != false);0                    
            DB_Close($dbconn);
        } else {

            if ($student_id == 0) {

                $error_type = 'id_student_fail';
                print("No Member ID to be updated");

            } else {
                // Call Data
                  $dbconn = DB_Connect_Direct();
                  $query = "SELECT * FROM student WHERE id='" . $student_id . "';";
                   echo $query;
                  $result = DB_Query($dbconn, $query);
                  if ($result != false) {
                    $obj = DB_FetchObject($result);

                    //Fill variables with data
                    $id_student = $student_id;
                    $text_manual_id = $obj->id2;
                    $text_lastname = $obj->lastname;
                    $text_firstname = $obj->firstname;
                    $text_othername = $obj->othername;
                    $select_sex = $obj->sex;
                    $text_baithday = $obj->birthday;
                    $text_house = $obj->house;
                    $check_boarder = $obj->boarder;
                    $select_grade = $obj->grade;
                    $text_room = $obj->room;
                    $select_religion = $obj->religion;
                    $text_homelanguage = $obj->homelanguage;
                    $select_nationality = $obj->nationality;
                    $select_status = $obj->status;
                    $select_startyear = $obj->startyear;
                    $select_yeargroup = $obj->yeargroup;
                    $text_parent = $obj->parent;
                    $image_content = $obj->photo;
                            
                    $error_type = 'call_data_success';
                    DB_FreeResult($result);
                  
                  } else {
                    $error_type = 'call_data_fail';
                    print("Editing of Member details failed");
                  } // end if ($result != false);0     

                  DB_Close($dbconn);

            }

        }
    }

?>

<div class="main-page" style="min-height: 660px; border: 1px solid #4c9cb4; border-radius: 10px; margin-bottom: 10px; max-width: 1260px;">
    <div class="container-fluid">
        <div class="row">
            <div class="columns">
                <h2 class="title" style="margin-bottom: 0px;"><?php echo $page_titel; ?></h2>
            </div>
        </div>   
        <!--<hr style="margin: 0px 40px 30px 40px; border-bottom: 1px solid #4c9cb4; max-width: initial;"> -->                   
    </div>

    <div class="row">
      <div class="columns">
        <ul class="accordion" data-accordion data-allow-all-closed="true">
          <li class="accordion-item is-active" data-accordion-item>
            <a href="#" class="accordion-title">Details</a>
            <div class="accordion-content" data-tab-content >
                
                <!-- content rows -->
                <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" id="<?php echo $form_id; ?>" name="<?php echo $form_name; ?>" method="post">
                    <div class="row" style="padding-top:5px">  
                        <!--Entry Controls-->
                        <div class="small-12 medium-12 large-10 columns">
                            <fieldset id="stammdaten" style="color: #607D8B;">
                                <legend><i>Please enter student details: </i></legend>

                                <div class="row">
                                    <div class="small-6 medium-6 large-2 columns">
                                        <label for="text_manual_id" class="left inline">Manual ID:</label>
                                        <input name="text_manual_id" type="text" id="text_manual_id" placeholder="Manual ID" value="<?php echo isset($text_manual_id) ? $text_manual_id : ''; ?>" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="small-12 medium-12 large-6 columns">
                                        <label for="text_lastname" class="left inline">Last Name:</label>
                                        <input name="text_lastname" type="text" id="text_lastname" placeholder="Last Name" value="<?php echo isset($text_lastname) ? $text_lastname : ''; ?>" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="small-12 medium-12 large-6 columns">
                                        <label for="text_firstname" class="left inline">First Name:</label>
                                        <input name="text_firstname" type="text" id="text_firstname" placeholder="First Name" value="<?php echo isset($text_firstname) ? $text_firstname : ''; ?>" />
                                    </div>
                                    <div class="small-12 medium-12 large-6 columns">
                                        <label for="text_othername" class="left inline">Other Name:</label>
                                        <input name="text_othername" type="text" id="text_othername" placeholder="Other Name" value="<?php echo isset($text_othername) ? $text_othername : ''; ?>" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="select_sex" class="left inline">Sex:</label>
                                        <?php
                                            $sex_selektiert = 0;
                                            if (isset($select_sex)) {
                                                $sex_selektiert = $select_sex;
                                            }
                                            $select_id = "select_sex";
                                            $select_name = "select_sex";
                                            $select_size = 1;
                                            $select_extra_code = '';
                                            $arr_option_values = array(0 => '');
                                            echo $UTIL->SELECT_Sex($sex_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                                        ?>
                                    </div>

                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="text_birthday" class="left inline">Birth Date:</label>
                                        <input name="text_birthday" type="date" id="text_birthday" placeholder="Birth Date" value="<?php echo isset($text_birthday) ? $text_birthday : ''; ?>" />
                                    </div>
                                    
                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="select_nationality" class="left inline">Nationality:</label>
                                        <?php
                                            $nationality_selektiert = -1;
                                            if (isset($select_nationality)) {
                                                $nationality_selektiert = $select_nationality;
                                            }
                                            $select_id = "select_nationality";
                                            $select_name = "select_nationality";
                                            $select_size = 1;
                                            $select_extra_code = '';
                                            $db_conn_opt = false;
                                            $arr_option_values = array(0 => '');
                                            echo $UTIL->SELECT_Nationality($nationality_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                        ?>
                                    </div>

                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="select_status" class="left inline">Status:</label>
                                        <?php
                                            $status_selektiert = 0;
                                            if (isset($select_status)) {
                                                $status_selektiert = $select_status;
                                            }
                                            $select_id = "select_status";
                                            $select_name = "select_status";
                                            $select_size = 1;
                                            $select_extra_code = '';
                                            $db_conn_opt = false;
                                            $arr_option_values = array(0 => '');
                                            echo $UTIL->SELECT_Status($status_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="select_grade" class="left inline">Class:</label>
                                        <?php
                                            $grade_selektiert = -1;
                                            if (isset($select_grade)) {
                                                $grade_selektiert = $select_grade;
                                            }
                                            $select_id = "select_grade";
                                            $select_name = "select_grade";
                                            $select_size = 1;
                                            $select_extra_code = '';
                                            $db_conn_opt = false;
                                            $arr_option_values = array(0 => '');
                                            echo $UTIL->SELECT_Grade($grade_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                        ?>
                                    </div>
                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="text_room" class="left inline">Room:</label>
                                        <input name="text_room" type="text" id="text_room" placeholder="Room" value="<?php echo isset($text_room) ? $text_room : ''; ?>" />
                                    </div>
                                    
                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="text_house" class="left inline">House:</label>
                                        <input name="text_house" type="text" id="text_house" placeholder="House" value="<?php echo isset($text_house) ? $text_house : ''; ?>" />
                                    </div>
                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="check_boarder" class="left inline">:</label>
                                        <?php
                                            $boarder_selektiert = 0;
                                            if (isset($check_boarder)) {
                                                $boarder_selektiert = $check_boarder;
                                            }
                                            $select_id = "check_boarder";
                                            $select_name = "check_boarder";
                                            $select_extra_code = ' style="line-height: 2.8;"';
                                            echo $UTIL->CHECK_Boarder($boarder_selektiert, $select_id, $select_name, $select_extra_code);
                                        ?>
                                    </div>

                                </div>

                                <div class="row">
                                    
                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="select_religion" class="left inline">Religion:</label>
                                        <?php
                                            $code_selektiert = -1;
                                            if (isset($select_religion)) {
                                                $code_selektiert = $select_religion;
                                            }
                                            $select_id = "select_religion";
                                            $select_name = "select_religion";
                                            $select_size = 1;
                                            $select_extra_code = '';
                                            $db_conn_opt = false;
                                            $arr_option_values = array(0 => '');
                                            echo $UTIL->SELECT_Religion($code_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                        ?>
                                    </div>
                                    
                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="text_homelanguage" class="left inline">1st. Language:</label>
                                        <input name="text_homelanguage" type="text" id="text_homelanguage" placeholder="1st. Language" value="<?php echo isset($text_homelanguage) ? $text_homelanguage : ''; ?>" />
                                    </div>
                                    
                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="select_startyear" class="left inline">Start Year:</label>
                                        <?php
                                            $startyear_selektiert = 0;
                                            if (isset($select_startyear)) {
                                                $startyear_selektiert = $select_startyear;
                                            }
                                            $select_id = "select_startyear";
                                            $select_name = "select_startyear";
                                            $select_size = 1;
                                            $select_extra_code = '';
                                            $db_conn_opt = false;
                                            $arr_option_values = array(0 => '');
                                            echo $UTIL->SELECT_StartYear($startyear_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                        ?>
                                    </div>
                                    
                                    <div class="small-6 medium-6 large-3 columns">
                                        <label for="select_yeargroup" class="left inline">Year Group:</label>
                                        <?php
                                            $yeargroup_selektiert = 0;
                                            if (isset($select_yeargroup)) {
                                                $yeargroup_selektiert = $select_yeargroup;
                                            }
                                            $select_id = "select_yeargroup";
                                            $select_name = "select_yeargroup";
                                            $select_size = 1;
                                            $select_extra_code = '';
                                            $db_conn_opt = false;
                                            $arr_option_values = array(0 => '');
                                            echo $UTIL->SELECT_YearGroup($yeargroup_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                        ?>
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset id="stammdaten" style="border: 1px solid #e6e6e6; border-radius: 10px; margin-bottom: 10px; padding: 5px 15px; color: #607D8B;">
                                <legend><i>Parent details: </i></legend>

                                <div class="row">
                                    <div class="small-6 medium-3 large-2 columns">
                                        <label for="text_parent" class="left inline">Parent ID:</label>
                                        <input name="text_parent" type="text" id="text_parent" placeholder="Parent ID"  value="<?php echo isset($text_parent) ? $text_parent : ''; ?>" readonly/>
                                    </div>
                                    <div class="small-6 medium-3 large-2 columns" style="padding: 30px 5px;">
                                        <div>
                                            <a href="#"><i class="fa fa-search action-controls" title="Select Parent"></i>&nbsp;&nbsp;</a>
                                            <a href="#"><i class="fa fa-edit action-controls" title="Edit Parent"></i>&nbsp;&nbsp;</a>
                                        </div>
                                    </div>
                                    <div class="small-12 medium-6 large-8 columns">
                                        <div id="parent_detail" class="row" style="font-size: smaller;">
                                            
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <!--Buttons-->
                            <div class="row">
                                <div class="small-12 medium-12 large-6 columns">
                                    <?php
                                        if (isset($error_type)) {
                                          if ($error_type == 'insert_success') {
                                            echo $UTIL->Print_Notification ('insert_success', 'success');
                                          } elseif ($error_type == 'insert_fail') {
                                            echo $UTIL->Print_Notification ('insert_fail', 'alert');
                                          } elseif ($error_type == 'update_success') {
                                            echo $UTIL->Print_Notification ('update_success', 'primary');
                                          } elseif ($error_type == 'update_fail') {
                                            echo $UTIL->Print_Notification ('update_fail', 'alert');
                                          } elseif ($error_type == 'id_student_fail') {
                                            echo $UTIL->Print_Notification ('id_student_fail', 'warning');
                                          } elseif ($error_type == 'call_data_success') {
                                            echo $UTIL->Print_Notification ('call_data_success', 'success');
                                          } elseif ($error_type == 'call_data_fail') {
                                            echo $UTIL->Print_Notification ('call_data_fail', 'alert');
                                          }
                                        } 
                                    ?>
                                </div>
                                <div class="small-12 medium-12 large-6 columns">
                                    <div class="Option-button" style="padding: 3px; float: right; font-size: small;">
                                        <input type="submit" class="small button round" style="min-width:250px; margin: 5px 5px;" value="<?php echo $submit_button_titel; ?>" />
                                        <input name="page" type="hidden" id="page" value="student_edit" />
                                        <input name="id_student" type="hidden" id="id_student" value="<?php if (isset($id_student)) echo $id_student; ?>" />
                                        <input name="page_aktion" type="hidden" id="page_aktion" value="<?php  echo $aktion; ?>" />
                                        <input name="posted_" type="hidden" id="posted_" value="TRUE" />                        
                                    </div>
                                   
                                </div>
                            </div>
                            
                        </div>
                        
                        <!--Side bar-->
                        <div class="small-12 medium-12 large-2 columns" style="border-left: 1px solid #e9e9e9;">
                            <div class="row">
                                <div class="small-12 medium-12 column" style="padding-top: 39px;">
                                    <div class="responsive-picture team-picture">

                                    <?php
                                        if (!empty($image_content)) {
                                            echo '<div><img class="img_photo" id="img_photo" alt="Student Picture" style="border-radius: 10px; border: 1px solid #ddd;" src="data:image/jpeg;base64,' . base64_encode($image_content) . '"  /></div>' ;
                                        } else {
                                            echo '<div><img class="img_photo" id="img_photo" alt="Student Picture" style="border-radius: 10px; border: 1px solid #ddd;" src="./images/undefined.png"  /></div>' ;
                                        }
                                        
                                    ?>

                                        <div style="text-align: center; text-align: center; font-weight: 600; color: brown;"><span id="id_member_show">ID: <?php if (isset($id_student)) echo $id_student; ?></span></div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

                <!-- Photo upload rows -->
                <div class="row  <?php echo ($aktion != 'student_update') ? 'hide' : ''; ?> ">
                    <div class="small-10 medium-10 large-10 columns">
                        <form id="photo_upload_form" enctype="multipart/form-data" method="post">
                            <fieldset style="border: 1px solid #e6e6e6; border-radius: 10px; margin-bottom: 10px; padding: 5px 15px; background: aliceblue; color: #607D8B;">
                                <legend><i>Photo Upload: </i></legend>
                                <div class="row">
                                    <div class="small-12 medium-12 large-12 columns" style="display: inline-flex;">
                                        <input type="file" name="fileToUpload" id="fileToUpload" style="font-size: smaller; margin-bottom: 10px;" required />
                                        <input type="submit" value="Upload Photo" name="submit" class="tiny button round" style="margin-bottom: 5px;">
                                        <input name="id_student" type="hidden" id="id_student" value="<?php if (isset($id_student)) echo $id_student; ?>" />
                                        <input name="page_aktion" type="hidden" id="page_aktion" value="student_photo_update" />
                                        <input name="posted_" type="hidden" id="posted_" value="TRUE" />                        
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="small-2 medium-2 large-2 columns" style="border-left: 1px solid #e9e9e9;">
                    </div>
                </div>  

            </div>
          </li>

          <li class="accordion-item" data-accordion-item>
            <a href="#" class="accordion-title">Records</a>
            <div class="accordion-content" data-tab-content>
              
                <!--Student Recorde-->
                <div class="row">
                    <div class="small-12 medium-10 large-10 columns">
                        <ul class="tabs" data-active-collapse="true" data-tabs id="collapsing-tabs">
                          <li class="tabs-title is-active"><a href="#subjects" aria-selected="true">Subjects</a></li>
                          <li class="tabs-title"><a href="#photo_history">Photo History</a></li>
                          <li class="tabs-title"><a href="#panel3c">Billing Details</a></li>
                          <li class="tabs-title"><a href="#panel4c">Exchange</a></li>
                          <li class="tabs-title"><a href="#panel5c">Comments</a></li>
                        </ul>

                        <div class="tabs-content" data-tabs-content="collapsing-tabs">
                          <div class="tabs-panel is-active" id="subjects">
                          </div>
                          <div class="tabs-panel" id="photo_history">
                            <p>Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
                          </div>
                          <div class="tabs-panel" id="panel3c">
                            <img class="thumbnail" src="">
                          </div>
                          <div class="tabs-panel" id="panel4c">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                          </div>
                          <div class="tabs-panel" id="panel5c">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                          </div>
                        </div>
                    </div>

                    <div class="small-12 medium-2 large-2 columns" style="padding: 0px 5px 0px 0px;">
                        <div class="row">
                            <div class="responsive-picture team-picture columns" style="margin-bottom: 15px;">
                                <?php
                                    if (!empty($image_content)) {
                                        echo '<div style="text-align: center;"><img class="img_photo1" id="img_photo1" alt="Student Picture" style="border-radius: 10px; border: 1px solid #ddd; max-width: 65%;" src="data:image/jpeg;base64,' . base64_encode($image_content) . '"  /></div>' ;
                                    } else {
                                        echo '<div style="text-align: center;"><img class="img_photo1" id="img_photo1" alt="Student Picture" style="border-radius: 10px; border: 1px solid #ddd; max-width: 65%;" src="./images/undefined.png"  /></div>' ;
                                    }
                                    
                                ?>
                                <div style="text-align: center; text-align: center; font-weight: 600; color: #757575; text-transform: uppercase; font-size: small;"><span id="id_member_show1"><?php echo $text_firstname . ' ' . $text_lastname; ?></span></div> 
                            </div>

                            <div class="small-12 medium-12 large-12 columns">
                                <label for="select_term" class="left inline">Term:</label>
                                <?php
                                    $term_selektiert = 0;
                                    if (isset($select_term)) {
                                        $term_selektiert = $select_term;
                                    }
                                    $select_id = "select_term";
                                    $select_name = "select_term";
                                    $select_size = 1;
                                    $select_extra_code = 'onchange="getStudentSubjects();" ';
                                    $db_conn_opt = false;
                                    $arr_option_values = null;
                                    echo $UTIL->SELECT_Student_term($term_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt, $student_id);
                                ?>
                            </div>
                            <div class="small-12 medium-12 large-12 columns" style="display: inline-grid;">
                                <button class="hollow button" href="#">Results Compare</button>
                                <button class="hollow button secondary" href="#">Term Report</button>
                                <button class="hollow button success" href="#">A/C Statement</button>
                                <button class="hollow button alert" href="#">Student SMS</button>
                                <button class="hollow button warning" href="#">EOT by SMS</button>
                                <button class="hollow button" href="#" disabled>Extras</button>
                            </div>

                        </div>
                        
                    </div>
                </div>

            </div>
          </li>
        </ul>
      </div>
    </div>



</div>

<script type="text/javascript">

    // When the page is loaded run function
    window.onload = onLoadFunctions(); 

    function onLoadFunctions() {
        console.log('onLoadFunctions()');

        //Get Parent Detail
        var var_parent_id = document.getElementById("text_parent");
        showParentDetail(var_parent_id.value); 

        //Get Student Subjects
        getStudentSubjects(); 

    }

    function showParentDetail(var_parent_id) {
      var xhttp;
      if (var_parent_id == "") {
        document.getElementById("parent_detail").innerHTML = "";
        return;
      }
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = xhttp.responseText;
              //alert(str);
             //alert(xhttp.responseText);
             //console.log(xhttp.responseText);
            document.getElementById("parent_detail").innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("GET", "/get_parent_detail.php?parent_id="+var_parent_id, true);
      xhttp.send();
    } //end showParentDetail(var_parent_id)

    function getStudentSubjects() {
        var var_student_id = document.getElementById("id_student").value;
        var term = document.getElementById("select_term");
        var var_term = term[term.selectedIndex].value;
        var var_classtype = term[term.selectedIndex].getAttribute("classtype");

        //alert(var_classtype);

        //alert(var_student_id + ' : ' + var_term)
        var xhttp;
            if (var_student_id == "") {
                document.getElementById("subjects").innerHTML = "";
                return;
            }
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = xhttp.responseText;
              //alert(str);
             //alert(xhttp.responseText);
             //console.log(xhttp.responseText);
            document.getElementById("subjects").innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("GET", "/get_student_subjects.php?student_id="+var_student_id + "&term=" + var_term + "&classtype=" + var_classtype, true);
      xhttp.send();
    }// end showParentDetail()

</script>


<!--Include Footer-->
  <?php 

    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/footer.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-footer.php");
  ?>