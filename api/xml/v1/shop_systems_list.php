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
    $query_count = 0;
    $query_where_temp = "";
    //

    if (isset($_REQUEST['query_limit'])) { $query_limit = $_REQUEST['query_limit']; }
    if (isset($_REQUEST['query_offset'])) { $query_offset = $_REQUEST['query_offset']; }
    //
    if (isset($_REQUEST['id_shop_system'])) { 
    	if (($_REQUEST['id_shop_system'] != 0) && ($_REQUEST['id_shop_system'] != "")) {
    		$query_where_temp .= " AND (S.id_shop_system='" . $_REQUEST['id_shop_system'] . "') "; 
    	}
    }
    if (isset($_REQUEST['shop_type'])) { 
    	if ($_REQUEST['shop_type'] != 0) {
    		$query_where_temp .= " AND (S.shop_type='" . $_REQUEST['shop_type'] . "') "; 
    	}
    }

    if (isset($_REQUEST['id_customer'])) { 
    	if ($_REQUEST['id_customer'] != 0) {
    		$query_where_temp .= " AND (S.id_customer='" . $_REQUEST['id_customer'] . "') "; 
    	}
    }

    if (isset($_REQUEST['shop_name'])) { 
    	if ($_REQUEST['shop_name'] != "") {
    		$query_where_temp .= " AND (S.shop_name LIKE '%" . $_REQUEST['shop_name'] . "%') ";
    	} 
    }

    if (isset($_REQUEST['flag_aktiv'])) { 
    	if ($_REQUEST['flag_aktiv'] != "-1") {
    		$query_where_temp .= " AND (S.flag_aktiv=" . $_REQUEST['flag_aktiv'] . ") ";  
    	}
    }
    
    //
    $query_where = " WHERE (1=1)" . $query_where_temp . " ";
    //
    // Prepare Count Query
    $query =  "SELECT * ";
    $query .=  "FROM shop_systems AS S ";
    $query .= $query_where;
    $query .= ";";
    //Execute SQL query
	$result_count = DB_Query($dbconn, $query);
	$query_count = DB_NumRows($result_count);
	//

    // Prepare Output Query
    $query =  "SELECT S.id_shop_system, S.id_customer, C.Company AS customer_company, C.Contact_person AS customer_contact_person, S.shop_type, S.shop_name, S.shop_id, S.api_active, S.api_hostname, S.api_version, S.api_port, S.api_user, S.api_key, S.api_token, S.api_location, S.api_tracking, S.tracking_url, S.flag_process_pending_payment, S.flag_notify_customer, S.flag_import_missing_shipment_product, S.id_referenz1, S.id_referenz2, S.id_referenz3, S.str_custom1, S.str_custom2, S.str_custom3, S.flag_aktiv, S.flag_automatischer_abruf, S.flag_auftragsabruf_ohne_details ";

    $query .=  "FROM shop_systems AS S ";
    $query .=  "LEFT OUTER JOIN customer AS C ON (S.id_customer = C.id) ";

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
	$result_array = array();
	//echo $query;
	$http_result_data = '';
	$http_result_data .= '<ecomcentral_system>' . "\r\n";
	$http_result_data .= '	<timestamp>' . $t . '</timestamp>' . "\r\n";
	$http_result_data .= '	<timestamp_format>' . date("m/d/Y H:i:s",$t) . '</timestamp_format>' . "\r\n";
	$http_result_data .= '	<http_code>' . $http_code . '</http_code>' . "\r\n";
	$http_result_data .= '	<code>' . $code . '</code>' . "\r\n";
	$http_result_data .= '	<msg>' . $msg . '</msg>' . "\r\n";
	$http_result_data .= '	<client_ip>' . $ip . '</client_ip>' . "\r\n";

	$http_result_data .= '	<query_count>' . $query_count . '</query_count>' . "\r\n";
	$http_result_data .= '	<query_offset>' . $query_offset . '</query_offset>' . "\r\n";
	$http_result_data .= '	<query_limit>' . $query_limit . '</query_limit>' . "\r\n";

	if ($api_auth != false) {
		if ($result != false) {
			while ($obj = DB_FetchObject($result)) { //Build Array from result
			  $result_array[] = $obj;
			} // end while ($obj = DB_FetchObject($result));

			$http_result_data .= '<shop_systems_list>' . "\r\n";	
			foreach ($result_array as $obj_arr) {		
				$http_result_data .= '<shop_systems>' . "\r\n";

					$http_result_data .= '<id_shop_system>' . $obj_arr->id_shop_system . '</id_shop_system>' . "\r\n";
					$http_result_data .= '<id_customer><![CDATA[' . $obj_arr->id_customer . ']]></id_customer>' . "\r\n";
					$http_result_data .= '<customer_company><![CDATA[' . $obj_arr->customer_company . ']]></customer_company>' . "\r\n";
					$http_result_data .= '<customer_contact_person><![CDATA[' . $obj_arr->customer_contact_person . ']]></customer_contact_person>' . "\r\n";
					$http_result_data .= '<shop_type><![CDATA[' . $obj_arr->shop_type . ']]></shop_type>' . "\r\n";
					$http_result_data .= '<shop_name><![CDATA[' . $obj_arr->shop_name . ']]></shop_name>' . "\r\n";
					$http_result_data .= '<shop_id><![CDATA[' . $obj_arr->shop_id . ']]></shop_id>' . "\r\n";

					$http_result_data .= '<api_active>' . $obj_arr->api_active . '</api_active>' . "\r\n";
					$http_result_data .= '<api_hostname><![CDATA[' . $obj_arr->api_hostname . ']]></api_hostname>' . "\r\n";
					$http_result_data .= '<api_version><![CDATA[' . $obj_arr->api_version . ']]></api_version>' . "\r\n";
					$http_result_data .= '<api_port><![CDATA[' . $obj_arr->api_port . ']]></api_port>' . "\r\n";
					$http_result_data .= '<api_user><![CDATA[' . $obj_arr->api_user . ']]></api_user>' . "\r\n";
					$http_result_data .= '<api_key><![CDATA[' . $obj_arr->api_key . ']]></api_key>' . "\r\n";
					$http_result_data .= '<api_token><![CDATA[' . $obj_arr->api_token . ']]></api_token>' . "\r\n";
					$http_result_data .= '<api_location><![CDATA[' . $obj_arr->api_location . ']]></api_location>' . "\r\n";
					$http_result_data .= '<api_tracking><![CDATA[' . $obj_arr->api_tracking . ']]></api_tracking>' . "\r\n";
					$http_result_data .= '<tracking_url><![CDATA[' . $obj_arr->tracking_url . ']]></tracking_url>' . "\r\n";

					$http_result_data .= '<flag_process_pending_payment>' . $obj_arr->flag_process_pending_payment . '</flag_process_pending_payment>' . "\r\n";
					$http_result_data .= '<flag_notify_customer>' . $obj_arr->flag_notify_customer . '</flag_notify_customer>' . "\r\n";
					$http_result_data .= '<flag_import_missing_shipment_product>' . $obj_arr->flag_import_missing_shipment_product . '</flag_import_missing_shipment_product>' . "\r\n";

					$http_result_data .= '<id_referenz1><![CDATA[' . $obj_arr->id_referenz1 . ']]></id_referenz1>' . "\r\n";
					$http_result_data .= '<id_referenz2><![CDATA[' . $obj_arr->id_referenz2 . ']]></id_referenz2>' . "\r\n";
					$http_result_data .= '<id_referenz3><![CDATA[' . $obj_arr->id_referenz3 . ']]></id_referenz3>' . "\r\n";
					$http_result_data .= '<str_custom1><![CDATA[' . $obj_arr->str_custom1 . ']]></str_custom1>' . "\r\n";
					$http_result_data .= '<str_custom2><![CDATA[' . $obj_arr->str_custom2 . ']]></str_custom2>' . "\r\n";
					$http_result_data .= '<str_custom3><![CDATA[' . $obj_arr->str_custom3 . ']]></str_custom3>' . "\r\n";

					$http_result_data .= '<flag_aktiv>' . $obj_arr->flag_aktiv . '</flag_aktiv>' . "\r\n";
					$http_result_data .= '<flag_automatischer_abruf>' . $obj_arr->flag_automatischer_abruf . '</flag_automatischer_abruf>' . "\r\n";
					$http_result_data .= '<flag_auftragsabruf_ohne_details>' . $obj_arr->flag_auftragsabruf_ohne_details . '</flag_auftragsabruf_ohne_details>' . "\r\n";

				$http_result_data .= '</shop_systems>' . "\r\n";
			} // end foreach
			$http_result_data .= '</shop_systems_list>' . "\r\n";
		} 
	}

	$http_result_data .= '</ecomcentral_system>' . "\r\n";

	DB_FreeResult($result);
	DB_Close($dbconn);
	//
    //ob_clean();
    $http_result_data=preg_replace('/&(?![#]?[a-z0-9]+;)/i', "&amp;$1", $http_result_data);
    echo $http_result_data;
    return;

?>