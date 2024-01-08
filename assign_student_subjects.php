<?php  
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/header.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-header.php");

    //Page PHP -- Start--
    if (!isset($SESSION)) {
        die("SESSION Class not defined!");  
    }

    $query_student_array = array();
    $query_subjectset_array = array();

    $aktion = "show";
    if (!empty($_REQUEST['page_aktion'])) { $aktion = $_REQUEST['page_aktion']; }

    $posted = FALSE;
    if (!empty($_REQUEST['posted_'])) { $posted = TRUE; }

    $select_term = "201201";

    $form_id = "form_assign_student_subjects";
    $form_name = "form_assign_student_subjects";
    $page_titel = "Assign Student Subjects";

    $student_id = 0;
    if (isset($_REQUEST['text_id_student'])) { $id_student = $_REQUEST['text_id_student']; }

    $id_student = "";
    if (isset($_REQUEST['text_id_student'])) { $id_student = $_REQUEST['text_id_student']; }

    $text_lastname = "";
    if (isset($_REQUEST['text_lastname'])) { $text_lastname = $_REQUEST['text_lastname']; }

    $text_firstname = "";
    if (isset($_REQUEST['text_firstname'])) { $text_firstname = $_REQUEST['text_firstname']; }

    $select_grade = -1;
    if (isset($_REQUEST['select_grade'])) { $select_grade = $_REQUEST['select_grade']; }

    $text_room = "";
    if (isset($_REQUEST['text_room'])) { $text_room = $_REQUEST['text_room']; }

    $query_where_temp = "";

    if ($posted == TRUE) {

        if (!empty($id_student)) { $query_where_temp .= " AND (S.id='" . $id_student . "') "; }
        if (!empty($text_lastname)) { $query_where_temp .= " AND (S.lastname LIKE '%" . $text_lastname . "%') "; }
        if (!empty($text_firstname)) { $query_where_temp .= " AND (S.firstname= LIKE '%" . $text_firstname . "%') "; }
        if (!empty($select_grade)) { $query_where_temp .= " AND (G.grade='" . $select_grade . "') "; }
        if (!empty($text_room)) { $query_where_temp .= " AND (S.room='" . $text_room . "') "; }
    } else {
        $query_where_temp .= " AND (S.id='xxx') ";
    }

//echo "$aktion";
//echo $id_student;

    $select_apply_using = -1;
    if (isset($_REQUEST['select_apply_using'])) { $select_apply_using = $_REQUEST['select_apply_using']; }

    $checked_overwrite = 0;
    if (isset($_REQUEST['checked_overwrite'])) { $checked_overwrite = $_REQUEST['checked_overwrite']; }

    $checked_overwrite_with_data = 0;
    if (isset($_REQUEST['checked_overwrite_with_data'])) { $checked_overwrite_with_data = $_REQUEST['checked_overwrite_with_data']; }

    $select_subjectset = -1;
    if (isset($_REQUEST['select_subjectset'])) { $select_subjectset = $_REQUEST['select_subjectset']; }

    $select_subjectcode = -1;
    if (isset($_REQUEST['select_subjectcode'])) { $select_subjectcode = $_REQUEST['select_subjectcode']; }

    $select_assign_term = -1;
    if (isset($_REQUEST['select_assign_term'])) { $select_assign_term = $_REQUEST['select_assign_term']; }

    if (strcmp($aktion, "show") == 0) {

        $query_offset = 0;
        if (isset($_REQUEST['query_offset'])) { $query_offset = $_REQUEST['query_offset']; }

        $query_total = 0;
        $query_limit = 100;
        
        $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            $query_where = " WHERE (1=1) AND S.grade  =  G.grade AND S.status = 1 " . $query_where_temp . " ";

            // Gesamtzahl Datensätze aus der Query
            $query = "SELECT S.id, S.grade , S.room , S.lastname , S.firstname , ";
            $query .= "S.othername, S.status, G.level FROM  grade AS G,  student AS S ". $query_where;
            $query .= " ORDER BY id ASC,  lastname ASC,  firstname ASC;";
            //echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                $query_total = DB_NumRows($result); 
                 while ($obj = DB_FetchObject($result)) { //Build Array from result
                    $query_student_array[] = $obj;
                } // end while ($obj = DB_F
                //echo $query_total;
                DB_FreeResult($result);
                DB_Close($dbconn);
            }

        }
    }

    $assign = "FALSE";
    if (isset($_REQUEST['assign_'])) { $assign = $_REQUEST['assign_']; }

   

    if ($assign == "TRUE") {
        switch ($select_apply_using) {
            case 0:
            //echo "1";
            // Current list + Subject Set
                if ($select_subjectset == -1 || empty($select_subjectset) ) {
                    echo "<script>alert('No Subject Set selected!');</script>";
                } else {

                    //GradeSet 
                    
                    if (GetSubjectSet ($select_subjectset)) {
                        foreach ($query_student_array as $obj_students) {
                            //echo $obj_students->id;
                            foreach ($query_subjectset_array as $obj_subjectset) {
                                //echo $obj_subjectset->subjectcode;

                                AllocateSubjectSet ($select_assign_term, $checked_overwrite, $checked_overwrite_with_data, $obj_students->id, $obj_students->grade, $obj_students->room, $obj_subjectset->subjectcode, $obj_subjectset->test, $obj_subjectset->exam, $obj_subjectset->gradeset);
                            } 
                        }  
                        
                    } 
                }
                break;
            
            case 1:
            //echo "2";
                // Current list + Subject(s)
                if ($select_subjectcode == -1 || empty($select_subjectcode) ) {
                    echo "<script>alert('No Subject selected!');</script>";
                } else {

                    //Get Subject Details
                    $Return_Data = GetSubjectDetail ($select_subjectcode);

                    if (!empty($Return_Data)) { //Subject already Allocated!
                        //Subject Code
                        foreach ($query_student_array as $obj_students) {
                            AllocateSubjectSet ($select_assign_term, $checked_overwrite, $checked_overwrite_with_data, $obj_students->id, $obj_students->grade, $obj_students->room, $select_subjectcode, $Return_Data[0]->test, $Return_Data[0]->exam, $Return_Data[0]->gradeset);
                        }
                    } else {
                        echo "<script>alert('Selected Subject do not exist!');</script>";
                    } 
                }

                break;
        }
    }

    function GetSubjectSet ($SubjectSet) {
        // retrieve subjects under specified subject list
        $query_total = 0;
        global $query_subjectset_array;
        
        $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            // GetSubjectSet
            $query = "SELECT * FROM  subjectsetlist WHERE subjectset = '" . $SubjectSet . "';";
            //echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {

                $query_total = DB_NumRows($result); 
                //echo $query_total;
                while ($obj = DB_FetchObject($result)) { //Build Array from result
                    $query_subjectset_array[] = $obj;
                } // end while ($obj = DB_F

                if ($query_total == 0) {
                    echo "<script>alert('No Subject define for subject Set!');</script>";
                    return false;
                }  
            }

            DB_FreeResult($result);
            DB_Close($dbconn);

            return true;
        }
    }


    function GetSubjectDetail ($Subjectcode) {
        //Retrieve Subject Details
        $query_result_array = array(); 

        $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            $query = "SELECT * FROM subjects WHERE pkey = '" . $Subjectcode . "';";
            //echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                while ($obj = DB_FetchObject($result)) { //Build Array from result
                    $query_result_array[] = $obj;
                } // end while ($obj = DB_FetchObject($result));
            }
            DB_FreeResult($result);
            DB_Close($dbconn);

            return $query_result_array;
        }
    }


    function CheckSubjectAllocated ($Term, $id, $Subjectcode) {
        // Determine if subject has already been allocated
        $query_result_array = array(); 

        $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            $query = "SELECT * FROM studentsubjects WHERE id = '" . $id . "' AND term = '" . $Term . "' AND subjectcode = '" . $Subjectcode . "';";
            //echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                while ($obj = DB_FetchObject($result)) { //Build Array from result
                    $query_result_array[] = $obj;
                } // end while ($obj = DB_FetchObject($result));
            }
            DB_FreeResult($result);
            DB_Close($dbconn);

            return $query_result_array;
        }
    }

    function DELETESubjectAllocated ($Term, $id, $Subjectcode) {
        // Determine if subject has already been allocated
        $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            $query = "DELETE FROM studentsubjects WHERE id = '" . $id . "' AND term = '" . $Term . "' AND subjectcode = '" . $Subjectcode . "';";
            //echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                DB_Close($dbconn);
            }
        }
    }

    function AllocateSubjectSet ($Term, $OverWrite, $EvenData, $id, $Grade, $Room, $Subjectcode, $Test, $Exam, $GradeSet) {
        //echo $Subjectcode;
        $DataEntered = false;
        $EntryExists = false;
        // Determine if subject has already been allocated
        $Return_Data = CheckSubjectAllocated ($Term, $id, $Subjectcode);

        if (!empty($Return_Data)) { //Subject already Allocated!
            $EntryExists = true;
            if ($Return_Data[0]->testresult != 0 || $Return_Data[0]->examresult != 0) {
                $DataEntered = true;
            }
            
        } 


        if ($EntryExists == true) {  // you may have to delete
            //echo "exit";
           if ($DataEntered == true) { // data entered, check if user has so requested
            //echo "entered";
            if ($OverWrite == 1 && $EvenData == 1) {
                    //echo "AA";
                    //Delete Allocation
                    DELETESubjectAllocated ($Term, $id, $Subjectcode);

                    //Insert new Allocation
                    InsertSubject ($id, $Grade, $Room, $Term, $Subjectcode, $Test, $Exam, $GradeSet);
               }
           } else {
                if ($OverWrite == 1) {
                    //echo "BB";
                    //Delete Allocation
                    DELETESubjectAllocated ($Term, $id, $Subjectcode);

                    //Insert new Allocation
                    InsertSubject ($id, $Grade, $Room, $Term, $Subjectcode, $Test, $Exam, $GradeSet);
                }
           }
        } else {
            //echo "CC";
            //Insert new Allocation
            InsertSubject ($id, $Grade, $Room, $Term, $Subjectcode, $Test, $Exam, $GradeSet);

        }
    }

    function InsertSubject($id, $Grade, $Room, $Term, $Subjectcode, $Test, $Exam, $GradeSet) {
        // Determine if subject has already been allocated
        $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            $query = "INSERT INTO  studentsubjects (id, grade, room, term, subjectcode, test, exam, gradeset) VALUES ('" . $id . "', '" . $Grade . "', '" . $Room . "', '" . $Term . "', '" . $Subjectcode . "', '" . $Test . "', '" . $Exam . "', '" . $GradeSet . "');";
            //echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
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

    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_student_overview" name="form_student_overview" method="post">
        <div class="row"> 
            <div class="small-12 medium-8 large-10 columns">
                <div class="students" id="students">
                    
                        <div class="row" style="padding-top:5px">        
                            <div class="large-12 small-centered columns" >
                                <table class="responsive-card-table  table-expand hover" id="myTable">  
                                    <thead>
                                            <th width="15%">Student ID</th>
                                            <th width="25%">First Name</th>
                                            <th width="25%">Last Name</th>
                                            <th width="5%">Grade/Room</th>
                                    </thead>                                    
                                    <tbody>                                       
                                        <?php
                                            $i = 0;
                                            foreach ($query_student_array as $obj) {
                                                //Get the first subjectset code to display list below
                                                if ($i == 0 ) { $student_id = $obj->id; }
                                                $i++; 

                                                echo "<tr>";
                                                
                                                echo "  <td valign=\"top\"data-label=\"ID:\">"; 
                                                echo "     <a onclick=\"getStudentSubjects('" . $obj->id . "')\"><strong style=\"color: crimson; \">" . $obj->id . "</strong></a>";
                                                echo "  </td>";
                                                
                                                echo "  <td valign=\"top\"data-label=\"First Name:\">";                             
                                                echo        $obj->firstname;                           
                                                echo "  </td>";

                                                echo "  <td valign=\"top\"data-label=\"Last Name:\">";                             
                                                echo        $obj->lastname;                           
                                                echo "  </td>";                                

                                                echo "  <td valign=\"top\"data-label=\"Grade/Room:\">";                             
                                                echo        $obj->grade . "/" . $obj->room;                           
                                                echo "  </td>";
                                                
                                                echo "</tr>";
                                            } // end foreach ($query_student_array as $obj);
                                        ?>  
                                                     
                                    </tbody>                                    
                                </table>
                            </div>
                            <input name="page" type="hidden" id="page" value="assign_student_subjects" />
                            <input name="posted" type="hidden" id="posted" value="yes" />
                            <input name="page_limit" type="hidden" id="page_limit" value="<?php if (isset($query_limit)) echo $query_limit; ?>" />
                        </div>

                        <div class="row">
                            <div class="callout" id="assign_subjects" data-toggler data-animate="hinge-in-from-top slide-out-down" style="display: none; width: 100%;">
                                <div class="row">
                                    <div class="small-12 medium-12 large-12 columns">
                                        <span>Assign Subjects to Students:</span>
                                    </div>
                                </div>
                              
                                <div class="row">
                                    <div class="small-12 medium-6 large-2 columns">
                                        <label for="select_apply_using" class="left inline">Apply using:</label>
                                        <select name="select_apply_using" id="select_apply_using" onchange="Apply_Using_Onchange();">
                                          <option value = 0>Subject Set</option>
                                          <option value = 1>Specific Subject</option>
                                        </select>
                                    </div>

                                    <div class="small-12 medium-6 large-3 columns" id="subject_set_cover">
                                        <label for="select_subjectset" class="left inline">Subject Set:</label>
                                        <?php
                                            $subjectset_selektiert = -1;
                                            if (isset($select_subjectset)) {
                                                $subjectset_selektiert = $select_subjectset;
                                            }
                                            $select_id = "select_subjectset";
                                            $select_name = "select_subjectset";
                                            $select_size = 1;
                                            $select_extra_code = '';
                                            $arr_option_values = array('' => '');
                                            echo $UTIL->SELECT_SubjectSet($subjectset_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                                        ?>
                                    </div>

                                    <div class="small-12 medium-6 large-3 columns hide" id="subject_cover">
                                        <label for="select_subjectcode" class="left inline">Subject:</label>
                                        <?php
                                            $subjectcode_selektiert = -1;
                                            if (isset($select_subjectcode)) {
                                                $subjectcode_selektiert = $select_subjectcode;
                                            }
                                            $select_id = "select_subjectcode";
                                            $select_name = "select_subjectcode";
                                            $select_size = 1;
                                            $select_extra_code = '';
                                            $arr_option_values = array('' => '');
                                            echo $UTIL->SELECT_SubjectCode($subjectcode_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                                        ?>
                                    </div>

                                    <div class="small-12 medium-6 large-3 columns">
                                        <label for="select_assign_term" class="left inline">School Term:</label>
                                        <?php
                                            $open_academic = true;
                                            $open_finance = false;

                                            $term_selektiert = 0;
                                            if (isset($select_assign_term)) {
                                                $term_selektiert = $select_assign_term;
                                            }
                                            $select_id = "select_assign_term";
                                            $select_name = "select_assign_term";
                                            $select_size = 1;
                                            $select_extra_code = 'onchange="Term_Onchange();" ';
                                            $db_conn_opt = false;
                                            $arr_option_values = null;
                                            echo $UTIL->SELECT_term($term_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt, $open_academic, $open_finance);
                                        ?>
                                    </div>

                                    <div class="small-12 medium-6 large-4 columns">
                                        <div class="row" style="padding: 5px 0 0px; border: 1px solid #4c9cb4; margin: 18px 0px 0px; border-radius: 3px;">
                                            <div class="small-12 medium-6 large-6 columns">
                                                <label><input type="checkbox" id="checked_overwrite" name="checked_overwrite" onclick="Overwrite_Onclick();" unchecked value="0">Overwrite?</label>
                                            </div>
                                            <div class="small-12 medium-6 large-6 columns">
                                                <label><input type="checkbox" id="checked_overwrite_with_data" name="checked_overwrite_with_data" onclick="Overwrite_with_data_Onclick()" unchecked disabled value="0">Even with Data</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                   <div class="small-6 medium-8 large-9 columns"></div>
                                   <div class="small-6 medium-4 large-3 columns" style="text-align: right;">
                                       <button class="button primary radius" type="submit" style="color: #ffffff; margin-bottom: auto;">Apply</button>
                                       <input name="assign_" type="hidden" id="assign_" value="FALSE" /> 
                                   </div>
                                </div>
                            </div>
                        </div>

                        <!-- Seiten Navigation
                        <div class="row Table-Nav" style="margin: 10px 40px;">
                            <?php
                                if ( ($query_limit != 0) && ($query_total > 0) ) {
                                    $page_nav_action = "page_aktion=show";

                                    if (!empty($id_student)) $page_nav_action .= "&id_student=" . $id_student;
                                    Page_Nav("assign_student_subjects", $page_nav_action, 7, $query_total, $query_limit, $query_offset);

                                } // end if ( ($query_limit != 0) && ($query_total > 0) );
                            ?>
                        </div>-->
                    
                </div>
            </div>

            <div class="small-12 medium-4 large-2 columns" style="border-left: 1px solid #e9e9e9;">
                <div class="row">
                    <div class="small-6 medium-12 large-12 columns">
                        <label for="text_id_student" class="left inline">Student ID:</label>
                        <input name="text_id_student" type="text" id="text_id_student" placeholder="Student ID" value="<?php echo isset($id_student) ? $id_student : ''; ?>" />
                    </div>
                    <div class="small-12 medium-12 large-12 columns">
                        <label for="text_lastname" class="left inline">Last Name:</label>
                        <input name="text_lastname" type="text" id="text_lastname" placeholder="Last Name" value="<?php echo isset($text_lastname) ? $text_lastname : ''; ?>" />
                    </div>           
                    <div class="small-12 medium-12 large-12 columns">
                        <label for="text_firstname" class="left inline">First Name:</label>
                        <input name="text_firstname" type="text" id="text_firstname" placeholder="First Name" value="<?php echo isset($text_firstname) ? $text_firstname : ''; ?>" />
                    </div>

                    <div class="small-12 medium-12 large-12 columns">
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
                    <div class="small-12 medium-12 large-12 columns">
                        <label for="text_room" class="left inline">Room:</label>
                        <input name="text_room" type="text" id="text_room" placeholder="Room" value="<?php echo isset($text_room) ? $text_room : ''; ?>" />
                    </div>

                  
                    <div class="small-12 medium-12 large-12 columns" style="display: inline-grid;">
                        <button class="hollow button success" id="btn_GetStudent" type="submit">Get Students</button>
                        <button class="hollow button alert" href="#">Clear Student</button>

                        <div class="switch small hollow button primary" style="display: inline-table; padding: 5px 5px;">
                          <input class="switch-input" id="largeSwitch" type="checkbox" name="exampleSwitch" data-toggle="assign_subjects" onclick="AssignClick();">
                          <label class="switch-paddle" for="largeSwitch" style="float: left;"></label>
                          <label style="color: #2ba6cb;">Assign</label>
                        </div>

                        <input name="posted_" type="hidden" id="posted_" value="TRUE" /> 
                        <input name="page_aktion" type="hidden" id="page_aktion" value="show" />
                        <input name="id_student" type="hidden" id="id_student" value="<?php if (isset($student_id)) echo $student_id; ?>" />
                    </div>
                </div>
            </div>
        </div>
    </form>

    <hr style="margin: 0px 40px 30px 40px; border-bottom: 1px solid #4c9cb4; max-width: initial;">     
    <div class="row">
        <div class="small-12 medium-8 large-10 columns" style="background: #e3f8ff; padding-right: 0px; padding-left: 0px; margin-bottom: 10px;">
            <div class="subjects" id="subjects">

            </div>
        </div>

        <div class="small-12 medium-4 large-2 columns" style="border-left: 1px solid #e9e9e9;">
            <div class="row">
                <div class="small-12 medium-12 large-12 columns">
                    <label for="select_term" class="left inline">School Term:</label>
                    <?php
                        $open_academic = false;
                        $open_finance = false;

                        $term_selektiert = 0;
                        if (isset($select_term)) {
                            $term_selektiert = $select_term;
                        }
                        $select_id = "select_term";
                        $select_name = "select_term";
                        $select_size = 1;
                        $select_extra_code = 'onchange="Term_Onchange();" ';
                        $db_conn_opt = false;
                        $arr_option_values = null;
                        echo $UTIL->SELECT_term($term_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt, $open_academic, $open_finance);
                    ?>
                </div>
                <div class="small-12 medium-12 large-12 columns" style="display: inline-grid;">
                    <button class="hollow button success" id="btn_assign" data-open="SynchroSubjectsDialog">Assign</button>
                    <button class="hollow button secondary">Copy To</button>                    
                    <button class="hollow button alert" href="#">Delete</button>
                </div>
            </div>
        </div>

    </div>
</div>

<!--Include Footer-->
<?php 

$path = $_SERVER['DOCUMENT_ROOT'] ;
$path .= "/includes/footer.php";
include ($path);
include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-footer.php");
?>

<script type="text/javascript">

    // When the page is loaded run function
    window.onload = onLoadFunctions(); 

    function onLoadFunctions() {
        console.log('onLoadFunctions()');

        var var_student_id = document.getElementById("id_student").value;

        //Get Student Subjects
        getStudentSubjects(var_student_id); 

    }

    function Term_Onchange() {
        var var_student_id = document.getElementById("id_student").value;
        //Get Student Subjects
        getStudentSubjects(var_student_id); 
    }


    function getStudentSubjects(var_student_id) {

        document.getElementById("id_student").value = var_student_id;
        
        var term = document.getElementById("select_term");
        var var_term = term[term.selectedIndex].value;
        //alert(var_student_id);

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
      xhttp.open("GET", "/get_assign_student_subjects.php?student_id="+var_student_id + "&term=" + var_term, true);
      xhttp.send();
    }// end showParentDetail()


    function  Apply_Using_Onchange() {
        console.log('Apply_Using_Onchange()');

        var select_apply_using = document.getElementById("select_apply_using");
        var subject_set = document.getElementById("subject_set_cover");
        var subject = document.getElementById("subject_cover");

        //alert(select_apply_using.value);

        if (select_apply_using.value == 0) {
            subject_set.classList.remove("hide");
            subject.classList.add("hide");
        } else {
            subject_set.classList.add("hide");
            subject.classList.remove("hide");
        }
      
    } //end Apply_Using_Onchange() {


    function Overwrite_Onclick() {

        var overwrite = document.getElementById("checked_overwrite");
        var overwrite_with_data = document.getElementById("checked_overwrite_with_data");

        if (overwrite.checked) {
            overwrite.value = 1;
            overwrite_with_data.value = 0;
            overwrite_with_data.removeAttribute("disabled");
        }  else {
            overwrite.value = 0;
            overwrite_with_data.value = 0;
            overwrite_with_data.checked=false;
            overwrite_with_data.setAttribute("disabled", true);
        }
    }

    function Overwrite_with_data_Onclick() {

        var overwrite_with_data = document.getElementById("checked_overwrite_with_data");

        if (overwrite_with_data.checked) {
            overwrite_with_data.value = 1;
        }  else {
            overwrite_with_data.value = 0;
        }
    }

    function AssignClick() {
        btn_GetStudent = document.getElementById('btn_GetStudent');
        currentvalue = document.getElementById('assign_').value;
        if(currentvalue == "FALSE"){
            document.getElementById("assign_").value="TRUE";
            btn_GetStudent.disabled = true;
        }else{
            document.getElementById("assign_").value="FALSE";
            btn_GetStudent.disabled = false;
        }
    }

    $(document).ready( function () {
        $('#myTable').DataTable( {
            "scrollY":        "400px",
            "scrollCollapse": true,
            "paging":         false
        });
    } );

</script>


