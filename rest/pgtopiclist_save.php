<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

    header('Content-type: text/xml; charset=UTF-8');
	header('Cache-Control: no-cache');
	header('Cache-Control: no-store' , false);	


 //echo "<script>alert('nooo');</script>";
	$error_type = "NoReturn";

	$list_dialog_aktion = "";
    if (isset($_REQUEST['list_dialog_aktion'])) { $list_dialog_aktion = $_REQUEST['list_dialog_aktion']; }


    $text_code = "";
    if (isset($_REQUEST['code'])) { $text_code = $_REQUEST['code']; }

    $text_topic = "";
    if (isset($_REQUEST['topic'])) { $text_topic = $_REQUEST['topic']; }

    $text_seq = "";
    if (isset($_REQUEST['seq'])) { $text_seq = $_REQUEST['seq']; }

    $text_description = "";
    if (isset($_REQUEST['description'])) { $text_description = $_REQUEST['description']; }


    //echo $list_dialog_aktion . ' : ' .  $text_topic;


   if (strcmp($list_dialog_aktion, "pgtopiclist_create") == 0) {

        $dbconn = DB_Connect_Direct();
        $query  = "INSERT INTO pgtopic (seq, code, topic, description) ";
        $query .= "VALUE (" . $text_seq . ", '" . $text_code .  "', '" . $text_topic .  "', '" . $text_description .  "');";


        //echo $query;
        $result = DB_Query($dbconn, $query);
        if ($result != false) {
            $error_type = 'insert_success';
        } else {
            $error_type = 'insert_fail';
        } // end if ($result != false);0                    
        DB_Close($dbconn);

    }


    if (strcmp($list_dialog_aktion, "pgtopiclist_update") == 0) {

        if ($text_topic == '') {
           
            $error_type = 'topic_fail';
            print("No Topic Code to be updated");

        } else {
            $dbconn = DB_Connect_Direct();
	        $query = "UPDATE pgtopic SET seq = " . $text_seq . ", description = '" . $text_description . "' ";
	        $query .= " WHERE code = '" . $text_code . "' AND topic = '" . $text_topic . "';";
	        
	        //echo $query;
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
?>