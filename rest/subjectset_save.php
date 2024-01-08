<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

    header('Content-type: text/xml; charset=UTF-8');
	header('Cache-Control: no-cache');
	header('Cache-Control: no-store' , false);	


 //echo "<script>alert('nooo');</script>";
	$error_type = "NoReturn";

	$dialog_aktion = "";
    if (isset($_REQUEST['dialog_aktion'])) { $dialog_aktion = $_REQUEST['dialog_aktion']; }

    $text_pkey = "";
    if (isset($_REQUEST['pkey'])) { $text_pkey = $_REQUEST['pkey']; }

    $text_description = "";
    if (isset($_REQUEST['description'])) { $text_description = $_REQUEST['description']; }

    $select_level = "";
    if (isset($_REQUEST['level'])) { $select_level = $_REQUEST['level']; }

    $select_grade = "";
    if (isset($_REQUEST['grade'])) { $select_grade = $_REQUEST['grade']; }

    $select_gradeset = "";
    if (isset($_REQUEST['gradeset'])) { $select_gradeset = $_REQUEST['gradeset']; }

    echo $dialog_aktion . ' : ' .  $text_pkey;

   if (strcmp($dialog_aktion, "subjectset_create") == 0) {

        $dbconn = DB_Connect_Direct();
        $query  = "INSERT INTO subjectset (pkey, ";
        $query .= "description, level, grade, gradeset) ";

        $query .= "VALUE ('" . $text_pkey. "', ";
        $query .= "'" . $text_description . "', '" . $select_level .  "', '" . $select_grade .  "', '" . $select_gradeset .  "');";

        echo $query;
        $result = DB_Query($dbconn, $query);
        if ($result != false) {
            $error_type = 'insert_success';
        } else {
            $error_type = 'insert_fail';
        } // end if ($result != false);0                    
        DB_Close($dbconn);

    }


    if (strcmp($dialog_aktion, "subjectset_update") == 0) {

        if ($text_pkey == '') {
           
            $error_type = 'pkey_fail';
            print("No Subjectset Code to be updated");

        } else {
            $dbconn = DB_Connect_Direct();
	        $query = "UPDATE subjectset SET pkey = '" . $text_pkey . "', description = '" . $text_description . "', level = " . $select_level .  ", ";
	        $query .= "grade = '" . $select_grade . "', gradeset = '" . $select_gradeset . "' ";
	        $query .= " WHERE pkey = '" . $text_pkey . "';";
	        
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