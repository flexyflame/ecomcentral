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
    $id_shop_system = 0;
    if (isset($_REQUEST['id_shop_system'])) { $id_shop_system = $_REQUEST['id_shop_system']; }
    $id_customer = 0;
    if (isset($_REQUEST['id_customer'])) { $id_customer = $_REQUEST['id_customer']; }
    $shop_type = 0;
    if (isset($_REQUEST['shop_type'])) { $shop_type = $_REQUEST['shop_type']; }
    $shop_name = "";
    if (isset($_REQUEST['shop_name'])) { $shop_name = $_REQUEST['shop_name']; }
    $shop_id = "";
    if (isset($_REQUEST['shop_id'])) { $shop_id = $_REQUEST['shop_id']; }
    $api_active = 0;
    if (isset($_REQUEST['api_active'])) { $api_active = $_REQUEST['api_active']; }
    $api_hostname = "";
    if (isset($_REQUEST['api_hostname'])) { $api_hostname = $_REQUEST['api_hostname']; }
    $api_version = "";
    if (isset($_REQUEST['api_version'])) { $api_version = $_REQUEST['api_version']; }
    $api_port = "";
    if (isset($_REQUEST['api_port'])) { $api_port = 1; }
    $text_api_user = "";
    if (isset($_REQUEST['text_api_user'])) { $text_api_user = $_REQUEST['text_api_user']; }
    $text_api_key = "";
    if (isset($_REQUEST['text_api_key'])) { $text_api_key = $_REQUEST['text_api_key']; }
    $text_api_token = "";
    if (isset($_REQUEST['text_api_token'])) { $text_api_token = $_REQUEST['text_api_token']; }
    $api_location = "";
    if (isset($_REQUEST['api_location'])) { $api_location = $_REQUEST['api_location']; }
    $api_tracking = "";
    if (isset($_REQUEST['api_tracking'])) { $api_tracking = $_REQUEST['api_tracking']; }
    $tracking_url = "";
    if (isset($_REQUEST['tracking_url'])) { $tracking_url = $_REQUEST['tracking_url']; }
    $flag_process_pending_payment = 0;
    if (isset($_REQUEST['flag_process_pending_payment'])) { $flag_process_pending_payment = $_REQUEST['flag_process_pending_payment']; }
    $flag_notify_customer = 0;
    if (isset($_REQUEST['flag_notify_customer'])) { $flag_notify_customer = $_REQUEST['flag_notify_customer']; }
    $flag_import_missing_shipment_product = 0;
    if (isset($_REQUEST['flag_import_missing_shipment_product'])) { $flag_import_missing_shipment_product = $_REQUEST['flag_import_missing_shipment_product']; }
    $flag_automatischer_abruf = 0;
    if (isset($_REQUEST['flag_automatischer_abruf'])) { $flag_automatischer_abruf = $_REQUEST['flag_automatischer_abruf']; }
    $flag_auftragsabruf_ohne_details = 0;
    if (isset($_REQUEST['flag_auftragsabruf_ohne_details'])) { $flag_auftragsabruf_ohne_details = $_REQUEST['flag_auftragsabruf_ohne_details']; }

    $id_referenz1 = "";
    if (isset($_REQUEST['id_referenz1'])) { $id_referenz1 = $_REQUEST['id_referenz1']; }
    $id_referenz2 = "";
    if (isset($_REQUEST['id_referenz2'])) { $id_referenz2 = $_REQUEST['id_referenz2']; }
    $id_referenz3 = "";
    if (isset($_REQUEST['id_referenz3'])) { $id_referenz3 = $_REQUEST['id_referenz3']; }
    $str_custom1 = "";
    if (isset($_REQUEST['str_custom1'])) { $str_custom1 = $_REQUEST['str_custom1']; }
    $str_custom2 = "";
    if (isset($_REQUEST['str_custom2'])) { $str_custom2 = $_REQUEST['str_custom2']; }
    $str_custom3 = "";
    if (isset($_REQUEST['str_custom3'])) { $str_custom3 = $_REQUEST['str_custom3']; }
    $flag_aktiv = "";
    if (isset($_REQUEST['flag_aktiv'])) { $flag_aktiv = $_REQUEST['flag_aktiv']; }
    
    //
    if (($id_shop_system == 0) || ($id_shop_system == "")) {
		// Create Shop Systems Query
		$query  = "INSERT INTO shop_systems(";
		$query .= "id_customer, shop_type, shop_name, shop_id, api_active, api_hostname, api_version, api_port, api_user, ";
		$query .= "api_key, api_token, api_location, api_tracking, tracking_url, flag_process_pending_payment, flag_notify_customer, "; 
		$query .= "flag_import_missing_shipment_product, id_referenz1, id_referenz2, id_referenz3, str_custom1, str_custom2, str_custom3, "; 
		$query .= "flag_aktiv, flag_automatischer_abruf, flag_auftragsabruf_ohne_details) "; 

		$query .= "VALUE ('" . $id_customer . "', '" . $shop_type . "', '" . $shop_name . "', '" . $shop_id . "', '" . $api_active . "', ";
		$query .= "'" . $api_hostname . "', '" . $api_version . "', '" . $api_port . "', '" . $text_api_user . "', '" . $text_api_key . "', '" . $text_api_token . "', '" . $api_location . "', ";
		$query .= "'" . $api_tracking . "', '" . $tracking_url . "', '" . $flag_process_pending_payment . "', '" . $flag_notify_customer . "', '" . $flag_import_missing_shipment_product . "', ";
		$query .= "'" . $id_referenz1 . "', '" . $id_referenz2 . "', '" . $id_referenz3 . "', '" . $str_custom1 . "', '" . $str_custom2 . "', '" . $str_custom3 . "', '" . $flag_aktiv . "', ";
		$query .= "'" . $flag_automatischer_abruf . "', '" . $flag_auftragsabruf_ohne_details . "');";

		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		$msg = "Record Create successfully";
	} else {

		// Update Shop Systems Query
		$query  = "UPDATE shop_systems SET ";
		$query .= "id_customer = '" . $id_customer . "', shop_type = '" . $shop_type . "', shop_name = '" . $shop_name . "', shop_id = '" . $shop_id . "', ";
		$query .= "api_active = '" . $api_active . "', api_hostname = '" . $api_hostname . "', api_version = '" . $api_version . "', api_port = '" . $api_port . "', api_user = '" . $text_api_user . "', ";
		$query .= "api_key = '" . $text_api_key . "', api_token = '" . $text_api_token . "', api_location = '" . $api_location . "', api_tracking = '" . $api_tracking . "', tracking_url = '" . $tracking_url . "', ";
		$query .= "flag_process_pending_payment = '" . $flag_process_pending_payment . "', flag_notify_customer = '" . $flag_notify_customer . "', "; 
		$query .= "flag_import_missing_shipment_product = '" . $flag_import_missing_shipment_product . "', id_referenz1 = '" . $id_referenz1 . "', id_referenz2 = '" . $id_referenz2 . "', id_referenz3 = '" . $id_referenz3 . "', ";
		$query .= "str_custom1 = '" . $str_custom1 . "', str_custom2 = '" . $str_custom2 . "', str_custom3 = '" . $str_custom3 . "', "; 
		$query .= "flag_aktiv = '" . $flag_aktiv . "', flag_automatischer_abruf = '" . $flag_automatischer_abruf . "', flag_auftragsabruf_ohne_details = '" . $flag_auftragsabruf_ohne_details . "' "; 
		$query .= "WHERE  id_shop_system = " . $id_shop_system . ";";

		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		$msg = "Record updated successfully";
	}
    
	//Prepare xml hearder
	$t=time();
	if ($api_auth != false) {
		if ($result != false) {
			$http_code = 200;
			$code = 1;
			//$msg = "Record Create successfully";
		} else {
			$http_code = 400;
			$code = 0;
			$msg = "Record could NOT create";
		}
	} else {
		$http_code = 400;
		$code = 1;
		$msg = "Invalid API Access";
	}

	$ip = $SESSION->get_client_ip();
	$http_result_data = '';
	$http_result_data .= '<ecomcentral_system>' . "\r\n";
	$http_result_data .= '<timestamp>' . $t . '</timestamp>' . "\r\n";
	$http_result_data .= '<timestamp_format>' . date("m/d/Y H:i:s",$t) . '</timestamp_format>' . "\r\n";
	$http_result_data .= '<http_code>' . $http_code . '</http_code>' . "\r\n";
	$http_result_data .= '<code>' . $code . '</code>' . "\r\n";
	$http_result_data .= '<msg>' . $msg . '</msg>' . "\r\n";
	$http_result_data .= '<client_ip>' . $ip . '</client_ip>' . "\r\n";

	if ($api_auth != false) {
		if ($result != false) {
			$http_result_data .= '<shop_systems>' . "\r\n";
			$http_result_data .= '	<id_shop_system>' . $id_shop_system . '</id_shop_system>' . "\r\n";
			$http_result_data .= '</shop_systems>' . "\r\n";
		} 
	}

	$http_result_data .= '</ecomcentral_system>' . "\r\n";

	ob_clean();
	echo $http_result_data;

	//DB_FreeResult($result);
	DB_Close($dbconn);

?>