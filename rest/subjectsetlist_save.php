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

    $select_subjectset = "";
    if (isset($_REQUEST['subjectset'])) { $select_subjectset = $_REQUEST['subjectset']; }

    $select_subjectcode = "";
    if (isset($_REQUEST['subjectcode'])) { $select_subjectcode = $_REQUEST['subjectcode']; }

    $text_test = "";
    if (isset($_REQUEST['test'])) { $text_test = $_REQUEST['test']; }

    $text_exam = "";
    if (isset($_REQUEST['exam'])) { $text_exam = $_REQUEST['exam']; }

    $select_list_gradeset = "";
    if (isset($_REQUEST['gradeset'])) { $select_list_gradeset = $_REQUEST['gradeset']; }

    //echo $list_dialog_aktion . ' : ' .  $select_subjectset;


   if (strcmp($list_dialog_aktion, "subjectsetlist_create") == 0) {

        $dbconn = DB_Connect_Direct();
        $query  = "INSERT INTO subjectsetlist (subjectset, ";
        $query .= "subjectcode, test, exam, gradeset) ";

        $query .= "VALUE ('" . $select_subjectset. "', ";
        $query .= "'" . $select_subjectcode . "', " . $text_test .  ", " . $text_exam .  ", '" . $select_list_gradeset .  "');";

        //echo $query;
        $result = DB_Query($dbconn, $query);
        if ($result != false) {
            $error_type = 'insert_success';
        } else {
            $error_type = 'insert_fail';
        } // end if ($result != false);0                    
        DB_Close($dbconn);

    }


    if (strcmp($list_dialog_aktion, "subjectsetlist_update") == 0) {

        if ($select_subjectset == '' || $select_subjectcode == '') {
           
            $error_type = 'subjectset_fail';
            print("No Subjectsetlist Code to be updated");

        } else {
            $dbconn = DB_Connect_Direct();
	        $query = "UPDATE subjectsetlist SET test = " . $text_test .  ", ";
	        $query .= "exam = " . $text_exam . ", gradeset = '" . $select_list_gradeset . "' ";
	        $query .= " WHERE subjectset = '" . $select_subjectset . "' AND subjectcode = '" . $select_subjectcode . "';";
	        
	        //echo $query;
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

	/*$query_result_array = array();    
	$dbconn = DB_Connect_Direct();


	$query = "SELECT COUNT(S.id) AS CNT, S.`status`, CASE S.`status`	WHEN 1 THEN 'Active' WHEN 2 THEN 'Suspended' ";
	$query .= "WHEN 3 THEN 'Transfered' WHEN 4 THEN 'Graduated' WHEN 5 THEN 'Inactive' WHEN 6 THEN 'Dismissed' ";
	$query .= "ELSE '***' END AS 'desc' FROM student AS S GROUP BY S.`status`;";
	$result = DB_Query($dbconn, $query);

	if ($result != false) {
		
	  while ($obj = DB_FetchObject($result)) { //Build Array from result
	      $query_result_array[] = $obj;
	  } // end while ($obj = DB_FetchObject($result));
	}

	echo json_encode($query_result_array);

	DB_FreeResult($result);
	DB_Close($dbconn);*/

?>