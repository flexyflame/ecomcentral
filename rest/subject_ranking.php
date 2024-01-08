<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

  

 //echo "<script>alert('nooo');</script>";
	$error_type = "NoReturn";

	$id = "";
    if (isset($_REQUEST['id'])) { $id = $_REQUEST['id']; }

    $subjectcode = "";
    if (isset($_REQUEST['subjectcode'])) { $subjectcode = $_REQUEST['subjectcode']; }

    $grade = "";
    if (isset($_REQUEST['grade'])) { $grade = $_REQUEST['grade']; }

    $room = "";
    if (isset($_REQUEST['room'])) { $room = $_REQUEST['room']; }

    $term = "";
    if (isset($_REQUEST['term'])) { $term = $_REQUEST['term']; }

       $query_where_temp = " WHERE (1=1) ";

        if (!empty($id)) { $query_where_temp .= " AND (id='" . $id . "') "; }
        if (!empty($subjectcode)) { $query_where_temp .= " AND (subjectcode='" . $subjectcode . "') "; }
        if (!empty($grade)) { $query_where_temp .= " AND (grade='" . $grade . "') "; }
        if (!empty($room)) { $query_where_temp .= " AND (room='" . $room . "') "; }
        if (!empty($term)) { $query_where_temp .= " AND (term='" . $term . "') "; }

    $dbconn = DB_Connect_Direct();
    $query = "SELECT * FROM studentsubjects " . $query_where_temp;
    $query .= "ORDER BY subjectcode ASC;";

    //echo $query;

    $result = DB_Query($dbconn, $query);
    if ($result != false) {
        //
        $query_total = DB_NumRows($result); 

        while ($obj = DB_FetchObject($result)) { //Build Array from result
            $query_result_array[] = $obj;
        } // end while ($obj = DB_FetchObject($result));
        DB_FreeResult($result);
    } 
    

    foreach ($query_result_array as $obj) {
        $ret = DB_GetGrade($obj->gradeset, $obj->subjectcode, $obj->totalmark);
        $vals = explode(';', $ret);
        $grade = $vals[0];
        $gradevalue = $vals[1];
        $comments = $vals[2];
        echo $grade . "::" . $gradevalue. "::" . $comments;
        
        // Update StudentSubjects             
        if ($dbconn != false) {

            $query = "UPDATE studentsubjects SET examgrade = '" . $grade . "', gradevalue = '" . $gradevalue . "', comments = '" . $comments . "' WHERE (1=1) AND studentsubjectsid ='" . $obj->studentsubjectsid . "';";
            //echo $query;
            //$result = DB_Query($dbconn, $query);
            if ($result != false) {
                
            }
        }
        
    }

    DB_Close($dbconn);
?>