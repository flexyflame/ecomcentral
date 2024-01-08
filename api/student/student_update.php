<?php
	//require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

    //Create Session
	$SESSION = new ClassSession();
	$UTIL = new ClassUtil($SESSION);

	if (!isset($_SESSION)) { 
	//Start Session
	  session_start();
	}

	$_SESSION['error_type'] = '';

	header('Content-type: text/xml; charset=UTF-8');
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Expires: " . date("D, d M Y 12:00:00 GMT", time() - 86400));
	header("Pragma: no-cache"); // HTTP/1.0
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

    $api_auth = $SESSION->Auth();
	$dbconn = DB_Connect_Direct();
	$result = false;
	$query  = "";

	//Prepare SQL query parameters
    $id_student = 0;
    if (isset($_REQUEST['id_student'])) { $id_student = $_REQUEST['id_student']; }
    $text_manual_id = "";
    if (isset($_REQUEST['text_manual_id'])) { $text_manual_id = $_REQUEST['text_manual_id']; }
    $text_lastname = "";
    if (isset($_REQUEST['text_lastname'])) { $text_lastname = $_REQUEST['text_lastname']; }
    $text_firstname = "";
    if (isset($_REQUEST['text_firstname'])) { $text_firstname = $_REQUEST['text_firstname']; }
    $text_othername = "";
    if (isset($_REQUEST['text_othername'])) { $text_othername = $_REQUEST['text_othername']; }
    $select_sex = 0;
    if (isset($_REQUEST['select_sex'])) { $select_sex = $_REQUEST['select_sex']; }
    $text_birthday = "";
    if (isset($_REQUEST['text_birthday'])) { $text_birthday = $_REQUEST['text_birthday']; }
    $text_house = "";
    if (isset($_REQUEST['text_house'])) { $text_house = $_REQUEST['text_house']; }
    $check_boarder = 0;
    if (isset($_REQUEST['check_boarder'])) { $check_boarder = 1; }
    $select_grade = "";
    if (isset($_REQUEST['select_grade'])) { $select_grade = $_REQUEST['select_grade']; }
    $text_room = "";
    if (isset($_REQUEST['text_room'])) { $text_room = $_REQUEST['text_room']; }
    $select_religion = "";
    if (isset($_REQUEST['select_religion'])) { $select_religion = $_REQUEST['select_religion']; }
    $text_homelanguage = "";
    if (isset($_REQUEST['text_homelanguage'])) { $text_homelanguage = $_REQUEST['text_homelanguage']; }
    $select_nationality = "";
    if (isset($_REQUEST['select_nationality'])) { $select_nationality = $_REQUEST['select_nationality']; }
    $select_status = "";
    if (isset($_REQUEST['select_status'])) { $select_status = $_REQUEST['select_status']; }
    $id_users = "";
    if (isset($_REQUEST['id_users'])) { $id_users = $_REQUEST['id_users']; }
    $id_users = "";
    if (isset($_REQUEST['id_users'])) { $id_users = $_REQUEST['id_users']; }
    $select_startyear = "";
    if (isset($_REQUEST['select_startyear'])) { $select_startyear = $_REQUEST['select_startyear']; }
    $select_yeargroup = "";
    if (isset($_REQUEST['select_yeargroup'])) { $select_yeargroup = $_REQUEST['select_yeargroup']; }
    $text_parent = "";
    if (isset($_REQUEST['text_parent'])) { $text_parent = $_REQUEST['text_parent']; }
    $image_content ="";
    if (isset($_REQUEST['img_photo'])) { $image_content = $_REQUEST['img_photo']; }

    //
     if ($id_student != 0) {
		if ($id_student != "") {
			// Update Student Query
			$query = "UPDATE student SET id2 = '" . $text_manual_id . "', lastname = '" . $text_lastname . "', firstname = '" . $text_firstname .  "', othername = '" . $text_othername . "', ";
            $query .= "sex = '" . $select_sex . "', birthday = '" . $text_birthday . "', boarder = '" . $check_boarder . "', nationality = '" . $select_nationality . "', grade = '" . $select_grade . "', room = '" . $text_room . "', ";
            $query .= "house = '" . $text_house . "', parent = '" . $text_parent . "', homelanguage = '" . $text_homelanguage . "', `status` = '" . $select_status . "', lastuser = '" . $id_users . "',";
            $query .= "startyear = '" . $select_startyear . "', yeargroup = '" . $select_yeargroup . "', religion = '" . $select_religion . "' ";
            $query .= " WHERE id = '" . $id_student . "';";

            echo $query;
		   	//Execute SQL query
			$result = DB_Query($dbconn, $query);
		}
	}
   
	//Prepare xml hearder
	$t=time();
	if ($api_auth != false) {
		if ($result != false) {
			$http_code = 200;
			$code = 1;
			$msg = "Record Updated successfully";
		} else {
			$http_code = 400;
			$code = 0;
			$msg = "Record could NOT update";
		}
	} else {
		$http_code = 400;
		$code = 1;
		$msg = "Invalid API Access";
	}

	$ip = $SESSION->get_client_ip();
	$http_result_data = '';
	$http_result_data .= '<e_soft_school_system>' . "\r\n";
	$http_result_data .= '<timestamp>' . $t . '</timestamp>' . "\r\n";
	$http_result_data .= '<timestamp_format>' . date("m/d/Y H:i:s",$t) . '</timestamp_format>' . "\r\n";
	$http_result_data .= '<http_code>' . $http_code . '</http_code>' . "\r\n";
	$http_result_data .= '<code>' . $code . '</code>' . "\r\n";
	$http_result_data .= '<msg>' . $msg . '</msg>' . "\r\n";
	$http_result_data .= '<client_ip>' . $ip . '</client_ip>' . "\r\n";

	if ($api_auth != false) {
		if ($result != false) {
		$http_result_data .= '<student_list>' . "\r\n";	
			$http_result_data .= '<student>' . "\r\n";
				$http_result_data .= '<id>' . $id_student . '</id>' . "\r\n";
				$http_result_data .= '<info>Data updated!</info>' . "\r\n";
			$http_result_data .= '</student>' . "\r\n";
		$http_result_data .= '</student_list>' . "\r\n";

		} 
	}

	$http_result_data .= '</e_soft_school_system>' . "\r\n";

	//ob_clean();
	echo $http_result_data;

	//DB_FreeResult($result);
	DB_Close($dbconn);

?>