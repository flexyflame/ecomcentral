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

    $error_type = "";
    $form_id = "form_parent";
    $form_name = "form_parent";
    $page_titel = "Parent Entry";
    $submit_button_titel = "Save";

    
    //$id_parent = GetSequence('PARENT');
    //echo $id_parent;
    $pkey = 0;
    if (isset($_GET['pkey'])) { $pkey = $_GET['pkey']; }

    $text_pkey = "";
    if (isset($_REQUEST['text_pkey'])) { $text_pkey = $_REQUEST['text_pkey']; }

    $text_description = "";
    if (isset($_REQUEST['text_description'])) { $text_description = $_REQUEST['text_description']; }

    $select_level = 0;
    if (isset($_REQUEST['select_level'])) { $select_level = $_REQUEST['select_level']; }

    $text_test = "";
    if (isset($_REQUEST['text_test'])) { $text_test = $_REQUEST['text_test']; }

    $text_exam = "";
    if (isset($_REQUEST['text_exam'])) { $text_exam = $_REQUEST['text_exam']; }

    $select_grade = "";
    if (isset($_REQUEST['select_grade'])) { $select_grade = $_REQUEST['select_grade']; }

    $select_gradeset = "";
    if (isset($_REQUEST['select_gradeset'])) { $select_gradeset = $_REQUEST['select_gradeset']; }

    $select_core = "";
    if (isset($_REQUEST['select_core'])) { $select_core = $_REQUEST['select_core']; }

     $text_seq = "";
    if (isset($_REQUEST['text_seq'])) { $text_seq = $_REQUEST['text_seq']; }


    if (strcmp($aktion, "subject_new") == 0) {
        $form_id = "form_subject_new";
        $form_name = "form_subject_new";
        $page_titel = "Create New Subject";
        $submit_button_titel = "Create Subject";
        $aktion = 'subject_create';

    }

    if (strcmp($aktion, "subject_create") == 0) {
        $form_id = "form_subject_create";
        $form_name = "form_subject_create";
        $page_titel = "Create Subject";
        $submit_button_titel = "Create Subject";

        if ($posted == TRUE) { 
            //Create Parent
            $dbconn = DB_Connect_Direct();
            $query  = "INSERT INTO subjects (pkey, ";
            $query .= "description, level, test, exam, grade, gradeset, core, seq) ";

            $query .= "VALUE ('" . $text_pkey. "', ";
            $query .= "'" . $text_description . "', '" . $select_level .  "', '" . $text_test .  "', '" . $text_exam .   "', '" . $select_grade .  "', '" . $select_gradeset .  "', '" . $select_core .  "', '" . $text_seq . "');";

            echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                $error_type = 'insert_success';
                $aktion = 'subject_update';
                $posted = FALSE;
            } else {
                $error_type = 'insert_fail';
            } // end if ($result != false);0                    
            DB_Close($dbconn);
        }
    }

    if (strcmp($aktion, "subject_update") == 0) {
        $form_id = "form_subject_update";
        $form_name = "form_subject_update";
        $page_titel = "Update Subject";
        $submit_button_titel = "Update Subject";

        if ($posted == TRUE) { 

            $dbconn = DB_Connect_Direct();
            $query = "UPDATE subjects SET pkey = '" . $text_pkey . "', description = '" . $text_description . "', level = '" . $select_level .  "', test = '" . $text_test . "', ";
            $query .= "exam = '" . $text_exam . "', grade = '" . $select_grade . "', gradeset = '" . $select_gradeset . "', core = '" . $select_core . "', seq = '" . $text_seq . "' ";
            $query .= " WHERE pkey = '" . $pkey . "';";
            
            echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                $error_type = 'update_success';
                $aktion = 'subject_update';
            } else {
                $error_type = 'update_fail';
            } // end if ($result != false);0                    
            DB_Close($dbconn);
        } else {

            if ($pkey == '0') {
               
                $error_type = 'id_parent_fail';
                print("No Subject Code to be updated");

            } else {
                // Call Data
                  $dbconn = DB_Connect_Direct();
                  $query = "SELECT * FROM subjects WHERE pkey='" . $pkey . "';";
                echo $query;
                  $result = DB_Query($dbconn, $query);
                  if ($result != false) {
                    $obj = DB_FetchObject($result);

                    //Fill variables with data
                    $text_pkey = $pkey;
                    $text_description = $obj->description;
                    $select_level = $obj->level;
                    $text_test = $obj->test;
                    $text_exam = $obj->exam;
                    $select_grade = $obj->grade;
                    $select_gradeset = $obj->gradeset;
                    $select_core = $obj->core;
                    $text_seq = $obj->seq;
                            
                    $error_type = 'call_data_success';
                    DB_FreeResult($result);
                  
                  } else {
                    $error_type = 'call_data_fail';
                    print("Editing of Sunject details failed");
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
        <hr style="margin: 0px 40px 30px 40px; border-bottom: 1px solid #4c9cb4; max-width: initial;">                    
    </div>

    <!-- content rows -->
    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" id="<?php echo $form_id; ?>" name="<?php echo $form_name; ?>" method="post">
    <div class="row" style="padding-top:5px">  
        <!--Entry Controls-->
        <div class="small-12 medium-12 large-10 columns">
            <fieldset id="stammdaten">
                <legend><i>Please enter subject details: </i></legend>

                <div class="row">
                     <div class="small-1 medium-1 large-1 columns">
                        <label for="text_seq" class="left inline">Sequence:</label>
                        <input name="text_seq" type="number" id="text_seq" placeholder="Sequence" value="<?php echo isset($text_seq) ? $text_seq : ''; ?>" />
                    </div>

                    <div class="small-3 medium-3 large-3 columns">
                        <label for="text_pkey" class="left inline">Code:</label>
                        <input name="text_pkey" type="text" id="text_pkey" placeholder="Code" value="<?php echo isset($text_pkey) ? $text_pkey : ''; ?>" />
                    </div>                                 
                </div>

                <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <label for="text_description" class="left inline">Description:</label>
                        <input name="text_description" type="text" id="text_description" placeholder="Description" value="<?php echo isset($text_description) ? $text_description : ''; ?>" />
                    </div>
                </div>

                <div class="row">
                    <div class="small-4 medium-4 large-4 columns">
                        <label for="select_core" class="left inline">Type:</label>
                        <?php
                            $type_selektiert = 0;
                            if (isset($select_core)) {
                                $type_selektiert = $select_core;
                            }
                            $select_id = "select_core";
                            $select_name = "select_core";
                            $select_size = 1;
                            $select_extra_code = '';
                            $db_conn_opt = false;
                            $arr_option_values = array(0 => '');
                            echo $UTIL->SELECT_Subject_Type($type_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                        ?>
                    </div>

                    <div class="small-4 medium-4 large-4 columns">
                        <label for="select_level" class="left inline">Level:</label>
                        <?php
                            $level_selektiert = 0;
                            if (isset($select_level)) {
                                $level_selektiert = $select_level;
                            }
                            $select_id = "select_level";
                            $select_name = "select_level";
                            $select_size = 1;
                            $select_extra_code = '';
                            $db_conn_opt = false;
                            $arr_option_values = array(0 => '');
                            echo $UTIL->SELECT_Subject_Level($level_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                        ?>
                    </div>

                    <div class="small-4 medium-4 large-4 columns">
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
                            $arr_option_values = array('' => '');
                            echo $UTIL->SELECT_Grade($grade_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                        ?>
                    </div>

                </div>

                 <div class="row">
                     <div class="small-2 medium-2 large-2 columns">
                        <label for="text_test" class="left inline">Class Test:</label>
                        <input name="text_test" type="number" id="text_test" placeholder="Sequence" value="<?php echo isset($text_test) ? $text_test : ''; ?>" />
                    </div>

                    <div class="small-2 medium-2 large-2 columns">
                        <label for="text_exam" class="left inline">Exam Result:</label>
                        <input name="text_exam" type="number" id="text_exam" placeholder="Code" value="<?php echo isset($text_exam) ? $text_exam : ''; ?>" />
                    </div>  

                    <div class="small-8 medium-8 large-8 columns">
                        <label for="select_gradeset" class="left inline">Grade Set:</label>
                        <?php
                            $gradeset_selektiert = -1;
                            if (isset($select_gradeset)) {
                                $gradeset_selektiert = $select_gradeset;
                            }
                            $select_id = "select_gradeset";
                            $select_name = "select_gradeset";
                            $select_size = 1;
                            $select_extra_code = '';
                            $arr_option_values = array('' => '');
                            echo $UTIL->SELECT_Gradeset($gradeset_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                        ?>
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
                          } elseif ($error_type == 'id_parent_fail') {
                            echo $UTIL->Print_Notification ('id_parent_fail', 'warning');
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
                        <input name="page" type="hidden" id="page" value="subjects_edit" />
                        <input name="text_pkey" type="hidden" id="text_pkey" value="<?php if (isset($text_pkey)) echo $text_pkey; ?>" />
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
                        <div style="text-align: center; text-align: center; font-weight: 600; color: brown;"><span id="id_member_show">Code: <?php if (isset($text_pkey)) echo $text_pkey; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

<!--Include Footer-->
  <?php 

    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/footer.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-footer.php");
  ?>