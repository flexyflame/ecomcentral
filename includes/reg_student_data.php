<?php
	header('Content-Type: application/json');
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");

	$query_result_array = array();    
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
	DB_Close($dbconn);

?>