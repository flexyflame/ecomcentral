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
	$query_result_array = array();    
	$dbconn = DB_Connect_Direct();


	//Prepare SQL query parameters
    $query_limit = 100;
    $query_offset = 0;
    $query_where_temp = "";
    //
    if (isset($_REQUEST['query_limit'])) { $query_offset = $_REQUEST['query_limit']; }
    if (isset($_REQUEST['query_offset'])) { $query_offset = $_REQUEST['query_offset']; }
    //
    if (isset($_REQUEST['text_id_student'])) { $query_where_temp .= " AND (S.id='" . $_REQUEST['text_id_student'] . "') "; }
    if (isset($_REQUEST['text_manual_id'])) { $query_where_temp .= " AND (S.id2='" . $_REQUEST['text_manual_id'] . "') "; }
    if (isset($_REQUEST['text_lastname'])) { $query_where_temp .= " AND (S.lastname LIKE '%" . $_REQUEST['text_lastname'] . "%') "; }
    if (isset($_REQUEST['text_firstname'])) { $query_where_temp .= " AND (S.firstname= LIKE '%" . $_REQUEST['text_firstname'] . "%') "; }
    if (isset($_REQUEST['text_othername'])) { $query_where_temp .= " AND (S.othername= LIKE '%" . $_REQUEST['text_othername'] . "%') "; }
    if (isset($_REQUEST['select_sex'])) { $query_where_temp .= " AND (S.sex=" . $_REQUEST['select_sex'] . ") "; }
    if (isset($_REQUEST['text_birthday'])) { $query_where_temp .= " AND (S.birthday='" . $_REQUEST['text_birthday'] . "') "; }
    if (isset($_REQUEST['text_house'])) { $query_where_temp .= " AND (S.house='" . $_REQUEST['text_house'] . "') "; }
    if (isset($_REQUEST['select_boarder'])) { $query_where_temp .= " AND (S.boarder=" . $_REQUEST['select_boarder'] . ") "; }
    if (isset($_REQUEST['select_grade'])) { $query_where_temp .= " AND (S.grade='" . $_REQUEST['select_grade'] . "') "; }
    if (isset($_REQUEST['text_room'])) { $query_where_temp .= " AND (S.room='" . $_REQUEST['text_room'] . "') "; }
    if (isset($_REQUEST['select_status'])) { $query_where_temp .= " AND (S.status=" . $_REQUEST['select_status'] . ") "; }
    if (isset($_REQUEST['select_startyear'])) { $query_where_temp .= " AND (S.startyear=" . $_REQUEST['select_startyear'] . ") "; }
    if (isset($_REQUEST['select_yeargroup'])) { $query_where_temp .= " AND (S.yeargroup=" . $_REQUEST['select_yeargroup'] . ") "; }
    if (isset($_REQUEST['text_parent'])) { $query_where_temp .= " AND (S.parent='" . $_REQUEST['text_parent'] . "') "; }
    //
    $query_where = " WHERE (1=1)" . $query_where_temp . " ";
    //
    // Prepare Query
    $query =  "SELECT S.*, ";
    $query .=  "P.Name, P.addr1 AS P_addr1, P.addr2 AS P_addr2, P.addr3 AS P_addr3, P.Tel1, P.Tel2, P.email, ";
    $query .=  "P.Comments AS P_Comments, P.photo AS P_photo, P.ptype, P.profession, P.ptaexec ";
    $query .=  "FROM student AS S LEFT JOIN parents AS P ON S.parent = P.id";
    $query .= $query_where;
    if ($query_limit != 0) {
        $query .= " LIMIT " . $query_limit . " OFFSET " . $query_offset;
    } // end if ($query_limit != 0);
    $query .= ";";
   
//echo $query;
   	//Execute SQL query
	$result = DB_Query($dbconn, $query);

	//Prepare xml hearder
	$t=time();
	if ($api_auth != false) {
		if ($result != false) {
			$http_code = 200;
			$code = 1;
			$msg = "Data available";
		} else {
			$http_code = 400;
			$code = 0;
			$msg = "NO Data available";
		}
	} else {
		$http_code = 400;
		$code = 1;
		$msg = "Invalid API Access";
	}

	$ip = $SESSION->get_client_ip();
	//echo $query;
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
		  while ($obj = DB_FetchObject($result)) { //Build Array from result
		      $student_result_array[] = $obj;
		  } // end while ($obj = DB_FetchObject($result));

		$http_result_data .= '<student_list>' . "\r\n";	
			foreach ($student_result_array as $obj_arr) {		
				$http_result_data .= '<student>' . "\r\n";
					$http_result_data .= '<id>' . $obj_arr->id . '</id>' . "\r\n";
					$http_result_data .= '<id2>' . $obj_arr->id2 . '</id2>' . "\r\n";
					$http_result_data .= '<lastname><![CDATA[' . $obj_arr->lastname . ']]></lastname>' . "\r\n";
					$http_result_data .= '<firstname><![CDATA[' . $obj_arr->firstname . ']]></firstname>' . "\r\n";
					$http_result_data .= '<othername><![CDATA[' . $obj_arr->othername . ']]></othername>' . "\r\n";
					$http_result_data .= '<sex>' . $obj_arr->sex . '</sex>' . "\r\n";
					$http_result_data .= '<birthday>' . $obj_arr->birthday . '</birthday>' . "\r\n";
					$http_result_data .= '<boarder>' . $obj_arr->boarder . '</boarder>' . "\r\n";
					$http_result_data .= '<nationality>' . $obj_arr->nationality . '</nationality>' . "\r\n";
					$http_result_data .= '<grade>' . $obj_arr->grade . '</grade>' . "\r\n";
					$http_result_data .= '<room>' . $obj_arr->room . '</room>' . "\r\n";
					$http_result_data .= '<house>' . $obj_arr->house . '</house>' . "\r\n";					
					$http_result_data .= '<photo><![CDATA[' . base64_encode($obj_arr->photo) . ']]></photo>' . "\r\n";
					$http_result_data .= '<photodate>' . $obj_arr->photodate . '</photodate>' . "\r\n";
					$http_result_data .= '<homelanguage>' . $obj_arr->homelanguage . '</homelanguage>' . "\r\n";
					$http_result_data .= '<status>' . $obj_arr->status . '</status>' . "\r\n";
					$http_result_data .= '<regdate>' . $obj_arr->regdate . '</regdate>' . "\r\n";
					$http_result_data .= '<regschool>' . $obj_arr->regschool . '</regschool>' . "\r\n";
					$http_result_data .= '<addr1><![CDATA[' . $obj_arr->addr1 . ']]></addr1>' . "\r\n";
					$http_result_data .= '<addr2><![CDATA[' . $obj_arr->addr2 . ']]></addr2>' . "\r\n";
					$http_result_data .= '<addr3><![CDATA[' . $obj_arr->addr3 . ']]></addr3>' . "\r\n";
					$http_result_data .= '<Comments><![CDATA[' . $obj_arr->Comments . ']]></Comments>' . "\r\n";
					$http_result_data .= '<regcomments><![CDATA[' . $obj_arr->regcomments . ']]></regcomments>' . "\r\n";
					$http_result_data .= '<billname><![CDATA[' . $obj_arr->billname . ']]></billname>' . "\r\n";
					$http_result_data .= '<billaddr1><![CDATA[' . $obj_arr->billaddr1 . ']]></billaddr1>' . "\r\n";
					$http_result_data .= '<billaddr2><![CDATA[' . $obj_arr->billaddr2 . ']]></billaddr2>' . "\r\n";
					$http_result_data .= '<billaddr3><![CDATA[' . $obj_arr->billaddr3 . ']]></billaddr3>' . "\r\n";
					$http_result_data .= '<lastmodify>' . $obj_arr->lastmodify . '</lastmodify>' . "\r\n";
					$http_result_data .= '<lastuser>' . $obj_arr->lastuser . '</lastuser>' . "\r\n";
					$http_result_data .= '<reggrade>' . $obj_arr->reggrade . '</reggrade>' . "\r\n";
					$http_result_data .= '<ExamId>' . $obj_arr->ExamId . '</ExamId>' . "\r\n";
					$http_result_data .= '<BillSet>' . $obj_arr->BillSet . '</BillSet>' . "\r\n";
					$http_result_data .= '<Scholarship>' . $obj_arr->Scholarship . '</Scholarship>' . "\r\n";
					$http_result_data .= '<UseStudentBillAddr>' . $obj_arr->UseStudentBillAddr . '</UseStudentBillAddr>' . "\r\n";
					$http_result_data .= '<yeargroup>' . $obj_arr->yeargroup . '</yeargroup>' . "\r\n";
					$http_result_data .= '<religion>' . $obj_arr->religion . '</religion>' . "\r\n";
					$http_result_data .= '<startyear>' . $obj_arr->startyear . '</startyear>' . "\r\n";
					$http_result_data .= '<parent>' . $obj_arr->parent . '</parent>' . "\r\n";
					//Get Parent Details
					$http_result_data .= '<parent_detail>' . "\r\n";
						$http_result_data .= '<name><![CDATA[' . $obj_arr->Name . ']]></name>' . "\r\n";
						$http_result_data .= '<p_addr1><![CDATA[' . $obj_arr->P_addr1 . ']]></p_addr1>' . "\r\n";
						$http_result_data .= '<p_addr2><![CDATA[' . $obj_arr->P_addr2 . ']]></p_addr2>' . "\r\n";
						$http_result_data .= '<p_addr3><![CDATA[' . $obj_arr->P_addr3 . ']]></p_addr3>' . "\r\n";
						$http_result_data .= '<tel1>' . $obj_arr->Tel1 . '</tel1>' . "\r\n";
						$http_result_data .= '<tel2>' . $obj_arr->Tel2 . '</tel2>' . "\r\n";
						$http_result_data .= '<email><![CDATA[' . $obj_arr->email . ']]></email>' . "\r\n";
						$http_result_data .= '<p_comments><![CDATA[' . $obj_arr->P_Comments . ']]></p_comments>' . "\r\n";
						$http_result_data .= '<p_photo><![CDATA[' . base64_encode($obj_arr->P_photo) . ']]></p_photo>' . "\r\n";
						$http_result_data .= '<ptype>' . $obj_arr->ptype . '</ptype>' . "\r\n";
						$http_result_data .= '<profession>' . $obj_arr->profession . '</profession>' . "\r\n";
						$http_result_data .= '<ptaexec>' . $obj_arr->ptaexec . '</ptaexec>' . "\r\n";
					$http_result_data .= '</parent_detail>' . "\r\n";
					//END Parent Details
				$http_result_data .= '</student>' . "\r\n";
			} // end foreach
		$http_result_data .= '</student_list>' . "\r\n";
		} 
	}

	$http_result_data .= '</e_soft_school_system>' . "\r\n";

	//ob_clean();
	echo $http_result_data;

	DB_FreeResult($result);
	DB_Close($dbconn);

?>