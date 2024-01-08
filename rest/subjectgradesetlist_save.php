<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

    header('Content-type: text/xml; charset=UTF-8');
	header('Cache-Control: no-cache');
	header('Cache-Control: no-store' , false);	


 //echo "<script>alert('nooo');</script>";
	$error_type = "NoReturn";

	$list_dialog_aktion = "";
    if (isset($_REQUEST['list_dialog_aktion'])) { $list_dialog_aktion = $_REQUEST['list_dialog_aktion']; }


    $subjectgrade_id = "";
    if (isset($_REQUEST['subjectgrade_id'])) { $subjectgrade_id = $_REQUEST['subjectgrade_id']; }

    $select_gradeset = "";
    if (isset($_REQUEST['gradeset'])) { $select_gradeset = $_REQUEST['gradeset']; }

    $text_lowscore = "";
    if (isset($_REQUEST['lowscore'])) { $text_lowscore = $_REQUEST['lowscore']; }

    $text_highscore = "";
    if (isset($_REQUEST['highscore'])) { $text_highscore = $_REQUEST['highscore']; }

    $text_grade = "";
    if (isset($_REQUEST['grade'])) { $text_grade = $_REQUEST['grade']; }

    $text_grade_value = "";
    if (isset($_REQUEST['gradevalue'])) { $text_grade_value = $_REQUEST['gradevalue']; }

     $text_comments = "";
    if (isset($_REQUEST['comments'])) { $text_comments = $_REQUEST['comments']; }

    echo $list_dialog_aktion . ' : ' .  $subjectgrade_id;


   if (strcmp($list_dialog_aktion, "subjectgradesetlist_create") == 0) {

        $dbconn = DB_Connect_Direct();
        $query  = "INSERT INTO subjectgrade (gradeset, ";
        $query .= "lowscore, highscore, grade, gradevalue, Comments) ";

        $query .= "VALUE ('" . $select_gradeset. "', ";
        $query .= "" . $text_lowscore . ", " . $text_highscore .  ", '" . $text_grade .  "', '" . $text_grade_value .  "', '" . $text_comments .  "');";


        echo $query;
        $result = DB_Query($dbconn, $query);
        if ($result != false) {
            $error_type = 'insert_success';
        } else {
            $error_type = 'insert_fail';
        } // end if ($result != false);0                    
        DB_Close($dbconn);

    }


    if (strcmp($list_dialog_aktion, "subjectgradelist_update") == 0) {

        if ($subjectgrade_id == '') {
           
            $error_type = 'subjectgradeset_fail';
            print("No Subjectgradesetlist Code to be updated");

        } else {
            $dbconn = DB_Connect_Direct();
	        $query = "UPDATE subjectgrade SET gradeset = '" . $select_gradeset . "', lowscore = " . $text_lowscore . ", highscore = " . $text_highscore .  ", ";
	        $query .= "grade = '" . $text_grade . "', gradevalue = '" . $text_grade_value . "', Comments = '" . $text_comments . "' ";
	        $query .= " WHERE SubjectgradeID = " . $subjectgrade_id . ";";
	        
	        echo $query;
	        $result = DB_Query($dbconn, $query);
	        if ($result != false) {
	            $error_type = 'update_success';
	        } else {
	            $error_type = 'update_fail';
	        } // end if ($result != false);0                    
	        DB_Close($dbconn);

        }

    }

    echo $error_type;
?>