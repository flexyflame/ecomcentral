<?php
	header('Content-Type: application/json');
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");

	$query_result_array = array();    
	$dbconn = DB_Connect_Direct();

	$query = "SELECT COUNT(DISTINCT studentsubjects.id) AS CNT, studentsubjects.subjectcode, subjects.description FROM studentsubjects ";
	$query .= "INNER JOIN subjects	ON studentsubjects.subjectcode = subjects.pkey GROUP BY	studentsubjects.subjectcode ;";
	$result = DB_Query($dbconn, $query);

	if ($result != false) {
		
	  while ($obj = DB_FetchObject($result)) { //Build Array from result
	      $query_result_array[] = $obj;
	  } // end while ($obj = DB_FetchObject($result));
	}

	echo json_encode($query_result_array);

	DB_FreeResult($result);
	DB_Close($dbconn);

?>