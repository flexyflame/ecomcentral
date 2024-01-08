<?php

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);


require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
//require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/class_benutzer.php");


class ClassSession {

	private $GLOBAL_SESSION_ID = "";
	private $GLOBAL_ID_USERS = 0;
	private $GLOBAL_LOGIN = "";
	private $GLOBAL_USERNAME = "";
	PUBLIC $GLOBAL_LOGIN_ACCESS = FALSE;
	PUBLIC $GLOBAL_SCHOOL_ACCESS = FALSE;
	
	private	$dbconn_intern;

	function __construct() {
		// constructor
		// parent::__construct(); ClassBenutzer Constructor aufrufen
		$this->dbconn_intern = DB_Connect_Direct();
   	}

   	public function get_client_ip() {
	    $ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	public function Auth() {
		$api_user = "ad_0000101";
  		$api_key = "DB007SS012021DKBCCTVDQZYGH1JHN8"; //"AA55MK192020IDKCJAHDQZYMAK1JFH9";

		// collect value of input field
		if (isset($_REQUEST['api_user'])) {
			if (isset($_REQUEST['api_key'])) {
				if ($_REQUEST['api_user'] == $api_user && $_REQUEST['api_key'] == $api_key) {
				    return TRUE;
				}
			}	
		}

		return FALSE;
	}

	//Get page
	public function Generate_Link($page = NULL, $args = NULL) {
		
		$g_ValidContentFiles = array(		
       array("name" => "index",
       	"path" => "/",
        "file" => "/index.php",
        "login_needed" => true),
       
       array("name" => "about",
       	"path" => "/",
        "file" => "/about.php",
        "login_needed" => true),

       array("name" => "features",
       	"path" => "/",
        "file" => "/features.php",
        "login_needed" => true),

       array("name" => "dashboard",
       	"path" => "/",
        "file" => "/dashboard.php",
        "login_needed" => true),

       array("name" => "student_overview",
       	"path" => "/",
        "file" => "/student_overview.php",
        "login_needed" => true),

       array("name" => "student_edit",
       	"path" => "/",
        "file" => "/student_edit.php",
        "login_needed" => true),

       array("name" => "parent_overview",
       	"path" => "/",
        "file" => "/parent_overview.php",
        "login_needed" => true),

       array("name" => "parent_edit",
       	"path" => "/",
        "file" => "/parent_edit.php",
        "login_needed" => true),

        array("name" => "get_parent_detail",
       	"path" => "/",
        "file" => "/get_parent_detail.php",
        "login_needed" => true),

       array("name" => "subjects_overview",
       	"path" => "/",
        "file" => "/subjects_overview.php",
        "login_needed" => true), 

       array("name" => "assign_student_subjects",
       	"path" => "/",
        "file" => "/assign_student_subjects.php",
        "login_needed" => true),

       array("name" => "subjects_edit",
       	"path" => "/",
        "file" => "/subjects_edit.php",
        "login_needed" => true),

       array("name" => "subjectset_overview",
       	"path" => "/",
        "file" => "/subjectset_overview.php",
        "login_needed" => true),

       array("name" => "subjectgradeset_overview",
       	"path" => "/",
        "file" => "/subjectgradeset_overview.php",
        "login_needed" => true),

       array("name" => "pg_topic_group_overview",
       	"path" => "/",
        "file" => "/pg_topic_group_overview.php",
        "login_needed" => true),

       array("name" => "members_edit",
       	"path" => "/",
        "file" => "/members_edit.php",
        "login_needed" => true),

       array("name" => "student_subjects_results",
       	"path" => "/",
        "file" => "/student_subjects_results.php",
        "login_needed" => true),

       array("name" => "shopify_cart_connection",
       	"path" => "/",
        "file" => "/shopify_cart_connection.php",
        "login_needed" => true),

       array("name" => "integration",
       	"path" => "/",
        "file" => "/integration.php",
        "login_needed" => true),

       array("name" => "users_overview",
       	"path" => "/administration/",
        "file" => "/users_overview.php",
        "login_needed" => true),

       array("name" => "shop_systems_overview",
       	"path" => "/administration/",
        "file" => "/shop_systems_overview.php",
        "login_needed" => true),

       array("name" => "shopify_overview",
       	"path" => "/api/api_shopify/",
        "file" => "/shopify_overview.php",
        "login_needed" => true),
       
   		);

		// check if page is valid
		$z_Path = "/";

		if ($page == NULL) {
			$page = "index"; 	

		} else {
			$login_needed = true;
			$content_file_found = false;
			foreach ($g_ValidContentFiles as $key => $daten) {	
				if ($page == $daten['name']) {

					$z_Path = $daten['path'];
					$page_php_ext = ($_SERVER['DOCUMENT_ROOT'] . $z_Path . $page . ".php");

					//echo $page_php_ext;

					if (file_exists($page_php_ext )) {
						$content_file_found = true;
						$login_needed = $daten['login_needed'];				
					} else {
						$content_file_found = false;
					} // end if (file_exists($page_php_ext));
				} // end if ($page == $daten['name']);
			} // end foreach



			if ($content_file_found == false) { // no valid page found: display defaults to "index_main"
		        $page = "content_404";
		        $page_php_ext = "/includes/content_404.php";
			} else { // valid page found
			
				// allright, don't change variables
				$page;
				$page_php_ext;

			} // end if

		}
	
		// prepare args (without & or ? on beginning)
		if ($args != NULL) {
			if ( (substr($args, 0, 1) == '&') || (substr($args, 0, 1) == '?') ) {
				$args = substr($args, 1, (strlen($args) - 1));
			} // end if
		} // end if ($args != NULL);

		// rawurlencode parameters
		$get_parameters_string = "";
		$args = str_replace("+", "%2B", $args);
		parse_str($args, $arr_get_parameters);
		foreach ($arr_get_parameters AS $key => $value) {
			$get_parameters_string .= "&" . $key . "=" . rawurlencode($value);
		} // end foreach	

		$retval = "";
		if ($page === "#") {
			$retval = "#";
		} else {
			$retval = $z_Path . rawurlencode($page) . ".php?" . $get_parameters_string;	
		}
		return $retval;
	}

	public function Session_Login($user, $pass) {
		//
		// Login USER
		$_SESSION['admin'] = FALSE;
		//
		$query_users = "SELECT * FROM users AS U WHERE U.Login='$user' AND U.Password='$pass';";
							
		$result_users = DB_Query($this->dbconn_intern, $query_users);
		if ($result_users != false) {
			if (DB_NumRows($result_users) > 0) {		
				$obj_users = DB_FetchObject($result_users);

				$_SESSION['id_users'] = $obj_users->id_users;
				$_SESSION['fullname'] = $obj_users->FirstName . " " . $obj_users->Name;
				$_SESSION['login_access'] = TRUE;
				$_SESSION['school_access'] = TRUE;

				if ($obj_users->Supervisor == 1) {
					//echo $obj_users->Name . ": ";
					$_SESSION['admin'] = TRUE;				
				} // end if

				DB_FreeResult($result_users);
				
				return TRUE;

			} // end if
		
		} // end if ($result != false);
	}

	/*public function Session_School_Check($school_code) {
		//
		// Login school
		$_SESSION['school_code'] = "";
		$_SESSION['school_access'] = FALSE;
		$_SESSION['login_access'] = FALSE;
		//
		$query_users = "SELECT * FROM systemset AS S WHERE S.id='$school_code';";
							
		$result_users = DB_Query($this->dbconn_intern, $query_users);
		if ($result_users != false) {
			if (DB_NumRows($result_users) > 0) {		
				$obj_users = DB_FetchObject($result_users);

				$_SESSION['school_access'] = TRUE;
				$_SESSION['school_code'] = $obj_users->id;
				$_SESSION['school_name'] = $obj_users->Name;

				DB_FreeResult($result_users);
				
				return TRUE;
			} // end if
		} // end if ($result != false);
	}*/		

} //end class ClassSession

?>