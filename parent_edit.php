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
    $parent_id = 0;
    if (isset($_GET['parent_id'])) { $parent_id = $_GET['parent_id']; }

    $parent_id = 0;
    if (isset($_REQUEST['parent_id'])) { $parent_id = $_REQUEST['parent_id']; }

    $text_name = "";
    if (isset($_REQUEST['text_name'])) { $text_name = $_REQUEST['text_name']; }

    $text_address1 = "";
    if (isset($_REQUEST['text_address1'])) { $text_address1 = $_REQUEST['text_address1']; }

    $text_address2 = "";
    if (isset($_REQUEST['text_address2'])) { $text_address2 = $_REQUEST['text_address2']; }

    $text_address3 = "";
    if (isset($_REQUEST['text_address3'])) { $text_address3 = $_REQUEST['text_address3']; }

     $text_tel1 = "";
    if (isset($_REQUEST['text_tel1'])) { $text_tel1 = $_REQUEST['text_tel1']; }

     $text_tel2 = "";
    if (isset($_REQUEST['text_tel2'])) { $text_tel2 = $_REQUEST['text_tel2']; }

     $text_email = "";
    if (isset($_REQUEST['text_email'])) { $text_email = $_REQUEST['text_email']; }

    $select_relation = "";
    if (isset($_REQUEST['select_relation'])) { $select_relation = $_REQUEST['select_relation']; }

    $select_profession = 0;
    if (isset($_REQUEST['select_profession'])) { $select_profession = $_REQUEST['select_profession']; }

    $check_pta_exec = 0;
    if (isset($_REQUEST['check_pta_exec'])) { $check_pta_exec = 1; }

     $text_comments = "";
    if (isset($_REQUEST['text_comments'])) { $text_comments = $_REQUEST['text_comments']; }


    if (strcmp($aktion, "parent_new") == 0) {
        $form_id = "form_parent_new";
        $form_name = "form_student_new";
        $page_titel = "Create New parent";
        $submit_button_titel = "Create Parent";
        $aktion = 'parent_create';

    }

    if (strcmp($aktion, "parent_create") == 0) {
        $form_id = "form_parent_create";
        $form_name = "form_parent_create";
        $page_titel = "Update Parent";
        $submit_button_titel = "Update Parent";

        if ($posted == TRUE) { 

            $id_parent = GetSequence('PARENT');

            //Create Parent
            $dbconn = DB_Connect_Direct();
            $query  = "INSERT INTO parents (id, ";
            $query .= "Name, addr1, addr2, addr3, Tel1, Tel2, email, ptype, profession, ptaexec, Comments) ";

            $query .= "VALUE ('" . $id_parent. "', ";
            $query .= "'" . $text_name . "', '" . $text_address1 .  "', '" . $text_address2 .  "', '" . $text_address3 .   "', '" . $text_tel1 .  "', '" . $text_tel2 .  "', '" . $text_email .  "', '" . $select_relation .  "', '" . $select_profession .  "', '" . $check_pta_exec . $text_comments . "');";

            echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                $error_type = 'insert_success';
                $aktion = 'parent_update';
                $posted = FALSE;
            } else {
                $error_type = 'insert_fail';
            } // end if ($result != false);0                    
            DB_Close($dbconn);
        }
    }

    if (strcmp($aktion, "parent_update") == 0) {
        $form_id = "form_parent_update";
        $form_name = "form_parent_update";
        $page_titel = "Update Parent";
        $submit_button_titel = "Update Parent";

        if ($posted == TRUE) { 

            $dbconn = DB_Connect_Direct();
            $query = "UPDATE parents SET Name = '" . $text_name . "', addr1 = '" . $text_address1 . "', addr2 = '" . $text_address2 .  "', addr3 = '" . $text_address3 . "', ";
            $query .= "Tel1 = '" . $text_tel1 . "', Tel2 = '" . $text_tel2 . "', email = '" . $text_email . "', ptype = '" . $select_relation . "', profession = '" . $select_profession . "', ptaexec = '" . $check_pta_exec . "', Comments = '" . $text_comments ."' ";
            $query .= " WHERE id = '" . $id_parent . "';";
            
            echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                $error_type = 'update_success';
                $aktion = 'parent_update';
            } else {
                $error_type = 'update_fail';
            } // end if ($result != false);0                    
            DB_Close($dbconn);
        } else {

            if ($parent_id == 0) {

                $error_type = 'id_parent_fail';
                print("No Parent ID to be updated");

            } else {
                // Call Data
                  $dbconn = DB_Connect_Direct();
                  $query = "SELECT * FROM parents WHERE id='" . $parent_id . "';";
                   echo $query;
                  $result = DB_Query($dbconn, $query);
                  if ($result != false) {
                    $obj = DB_FetchObject($result);

                    //Fill variables with data
                    $id_parent = $parent_id;
                    $text_name = $obj->Name;
                    $text_address1 = $obj->addr1;
                    $text_address2 = $obj->addr2;
                    $text_address3 = $obj->addr3;
                    $text_tel1 = $obj->Tel1;
                    $text_tel2 = $obj->Tel2;
                    $text_email = $obj->email;
                    $select_relation = $obj->ptype;
                    $select_profession = $obj->profession;
                    $check_pta_exec = $obj->ptaexec;
                    $text_comments = $obj->Comments;
                            
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
        <hr style="margin: 0px 40px 30px 40px; border-bottom: 1px solid #4c9cb4; max-width: initial;">                    
    </div>

    <!-- content rows -->
    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" id="<?php echo $form_id; ?>" name="<?php echo $form_name; ?>" method="post">
    <div class="row" style="padding-top:5px">  
        <!--Entry Controls-->
        <div class="small-12 medium-12 large-10 columns">
            <fieldset id="stammdaten">
                <legend><i>Please enter parent details: </i></legend>

                <div class="row">
                    <div class="small-12 medium-12 large-6 columns">
                        <label for="text_name" class="left inline">Name:</label>
                        <input name="text_name" type="text" id="text_name" placeholder="Name" value="<?php echo isset($text_name) ? $text_name : ''; ?>" />
                    </div>
                </div>

                <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <label for="text_address1" class="left inline">Address 1:</label>
                        <input name="text_address1" type="text" id="text_address1" placeholder="Address line 1" value="<?php echo isset($text_address1) ? $text_address1 : ''; ?>" />
                    </div>
                </div>

                <div class="row">
                    <div class="small-12 medium-12 large-6 columns">
                        <label for="text_address2" class="left inline">Address 2:</label>
                        <input name="text_address2" type="text" id="text_address2" placeholder="Address line 2" value="<?php echo isset($text_address2) ? $text_address2 : ''; ?>" />
                    </div>
                    <div class="small-12 medium-12 large-6 columns">
                        <label for="text_address3" class="left inline">Address 3:</label>
                        <input name="text_address3" type="text" id="text_address3" placeholder="Address line 3" value="<?php echo isset($text_address3) ? $text_address3 : ''; ?>" />
                    </div>
                </div>

                <div class="row">
                    <div class="small-12 medium-12 large-6 columns">
                        <label for="text_tel1" class="left inline">Telephone:</label>
                        <input name="text_tel1" type="text" id="text_tel1" placeholder="Telephone" value="<?php echo isset($text_tel1) ? $text_tel1 : ''; ?>" />
                    </div>
                    <div class="small-12 medium-12 large-6 columns">
                        <label for="text_tel2" class="left inline">Mobile:</label>
                        <input name="text_tel2" type="text" id="text_tel2" placeholder="Mobile" value="<?php echo isset($text_tel2) ? $text_tel2 : ''; ?>" />
                    </div>
                </div>

                <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <label for="text_email" class="left inline">E-Mail:</label>
                        <input name="text_email" type="text" id="text_email" placeholder="E-Mail" value="<?php echo isset($text_email) ? $text_email : ''; ?>" />
                    </div>
                </div>


                <div class="row">
                    <div class="small-6 medium-6 large-3 columns">
                        <label for="select_relation" class="left inline">Relation:</label>
                        <?php
                            $relation_selektiert = 0;
                            if (isset($select_relation)) {
                                $relation_selektiert = $select_relation;
                            }
                            $select_id = "select_relation";
                            $select_name = "select_relation";
                            $select_size = 1;
                            $select_extra_code = '';
                            $arr_option_values = array(0 => '');
                            echo $UTIL->SELECT_Relation($relation_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                        ?>
                    </div>
                    
                    <div class="small-6 medium-6 large-3 columns">
                        <label for="select_profession" class="left inline">Profession:</label>
                        <?php
                            $nprofession_selektiert = -1;
                            if (isset($select_profession)) {
                                $nprofession_selektiert = $select_profession;
                            }
                            $select_id = "select_profession";
                            $select_name = "select_profession";
                            $select_size = 1;
                            $select_extra_code = '';
                            $arr_option_values = array(0 => '');
                            echo $UTIL->SELECT_Profession($nprofession_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                        ?>
                    </div>

                    <div class="small-6 medium-6 large-3 columns">
                        <label for="check_boarder" class="left inline">:</label>
                        <?php
                            $pta_exec_selektiert = 0;
                            if (isset($check_pta_exec)) {
                                $pta_exec_selektiert = $check_pta_exec;
                            }
                            $select_id = "check_pta_exec";
                            $select_name = "check_pta_exec";
                            $select_extra_code = ' style="line-height: 2.8;"';
                            echo $UTIL->CHECK_PTA_EXEC($pta_exec_selektiert, $select_id, $select_name, $select_extra_code);
                        ?>
                    </div>

                </div>

                 <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <label for="text_comments" class="left inline">Comments:</label>
                        <input name="text_comments" type="text" id="text_comments" placeholder="Comments..." value="<?php echo isset($text_comments) ? $text_comments : ''; ?>" />
                    </div>
                </div>


                <div class="row">
                      
                    
                </div>

            </fieldset>

            <fieldset id="stammdaten">
                <legend><i>Parent details: </i></legend>

                <div class="row">
                    
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
                        <input name="page" type="hidden" id="page" value="parent_edit" />
                        <input name="id_parent" type="hidden" id="id_parent" value="<?php if (isset($id_parent)) echo $id_parent; ?>" />
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
                        <picture><img class="img_photo" id="img_photo" alt="Placeholder Picture" style="border-radius: 25px;" src="./images/school-logo.jpeg">
                        </picture>
                        <div style="text-align: center; text-align: center; font-weight: 600; color: brown;"><span id="id_member_show">ID: <?php if (isset($id_parent)) echo $id_parent; ?></span>
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