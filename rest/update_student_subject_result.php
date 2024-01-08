<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

  

 //echo "<script>alert('nooo');</script>";
	$error_type = "NoReturn";

	$id = "";
    if (isset($_REQUEST['id'])) { $id = $_REQUEST['id']; }

    $subjectcode = "";
    if (isset($_REQUEST['subjectcode'])) { $subjectcode = $_REQUEST['subjectcode']; }

    $gradeset = "";
    if (isset($_REQUEST['gradeset'])) { $gradeset = $_REQUEST['gradeset']; }

    $grade = "";
    if (isset($_REQUEST['grade'])) { $grade = $_REQUEST['grade']; }

    $room = "";
    if (isset($_REQUEST['room'])) { $room = $_REQUEST['room']; }

    $term = "";
    if (isset($_REQUEST['term'])) { $term = $_REQUEST['term']; }

    $testresult = 'NULL';
    if (isset($_REQUEST['testresult'])) { $testresult = $_REQUEST['testresult']; }

    $examresult = 'NULL';
    if (isset($_REQUEST['examresult'])) { $examresult = $_REQUEST['examresult']; }

    $cum100 = 'NULL';
    if (isset($_REQUEST['cum100'])) { $cum100 = $_REQUEST['cum100']; }

    $exam100 = 'NULL';
    if (isset($_REQUEST['exam100'])) { $exam100 = $_REQUEST['exam100']; }

    $prorate = 0;
    if (isset($_REQUEST['prorate'])) { $prorate = $_REQUEST['prorate']; }

    $totalmark = 'NULL';
    if (isset($_REQUEST['totalmark'])) { $totalmark = $_REQUEST['totalmark']; }

       $query_where_temp = " WHERE (1=1) ";

        if (!empty($id)) { $query_where_temp .= " AND (id='" . $id . "') "; }
        if (!empty($subjectcode)) { $query_where_temp .= " AND (subjectcode='" . $subjectcode . "') "; }
        if (!empty($grade)) { $query_where_temp .= " AND (grade='" . $grade . "') "; }
        if (!empty($room)) { $query_where_temp .= " AND (room='" . $room . "') "; }
        if (!empty($term)) { $query_where_temp .= " AND (term='" . $term . "') "; }

    //echo $dialog_aktion . ' : ' .  $text_gradeset;

    $ret = DB_GetGrade($gradeset, $subjectcode, $totalmark);
    $vals = explode(';', $ret);
    $grade = $vals[0];
    $gradevalue = $vals[1];
    $comments = $vals[2];
    //echo $grade . "::" . $gradevalue. "::" . $comments;


    $dbconn = DB_Connect_Direct();
    $query = "UPDATE studentsubjects SET testresult = " . $testresult . ", examresult = " . $examresult . ", cum100 =  " . $cum100 . ", exam100 = " . $exam100 . ", prorate = " . $prorate . ", totalmark = " . $totalmark . " , examgrade = '" . $grade . "', gradevalue = '" . $gradevalue . "', comments = '" . $comments . "' " . $query_where_temp . ";";

    $result = DB_Query($dbconn, $query);
    if ($result != false) {
        $error_type = 'Update successful!';
    } else {
        $error_type = 'Update failed!';
    } // end if ($result != false);0                    
    DB_Close($dbconn);

    echo $error_type;

?>