<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

    //header('Content-type: text/xml; charset=UTF-8');
    header('Content-Type: application/json');
	header('Cache-Control: no-cache');
	header('Cache-Control: no-store' , false);	


 //echo "<script>alert('nooo');</script>";
	
    $text_code = "";
    if (isset($_REQUEST['code'])) { $text_code = $_REQUEST['code']; }


    //echo $text_gradeset;

   
	$query_result_array = array();    
	$dbconn = DB_Connect_Direct();

	$query = "SELECT * FROM pggroup WHERE code= '" . $text_code . "';";
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