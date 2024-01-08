<?php
	header('Content-Type: application/json');
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");

	$query_result_array = array();    
	$dbconn = DB_Connect_Direct();

	$query = "SELECT COUNT(student.id) AS CNT, student.grade, grade.`Name` FROM student ";
	$query .= "INNER JOIN grade ON student.grade = grade.grade WHERE student.`status` = 1 GROUP BY student.grade ;";
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