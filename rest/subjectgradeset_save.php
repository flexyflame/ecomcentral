<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

    header('Content-type: text/xml; charset=UTF-8');
	header('Cache-Control: no-cache');
	header('Cache-Control: no-store' , false);	


 //echo "<script>alert('nooo');</script>";
	$error_type = "NoReturn";

	$dialog_aktion = "";
    if (isset($_REQUEST['dialog_aktion'])) { $dialog_aktion = $_REQUEST['dialog_aktion']; }

    $text_gradeset = "";
    if (isset($_REQUEST['gradeset'])) { $text_gradeset = $_REQUEST['gradeset']; }

    $text_description = "";
    if (isset($_REQUEST['description'])) { $text_description = $_REQUEST['description']; }

    //echo $dialog_aktion . ' : ' .  $text_gradeset;

   if (strcmp($dialog_aktion, "subjectgradeset_create") == 0) {

        $dbconn = DB_Connect_Direct();
        $query  = "INSERT INTO subjectgradeset (gradeset, description) ";

        $query .= "VALUE ('" . $text_gradeset. "', '" . $text_description .  "');";

        echo "<script>alert($query);</script>";

        $result = DB_Query($dbconn, $query);
        if ($result != false) {
            $error_type = 'insert_success';
        } else {
            $error_type = 'insert_fail';
        } // end if ($result != false);0                    
        DB_Close($dbconn);

    }


    if (strcmp($dialog_aktion, "subjectgradeset_update") == 0) {

        if ($text_gradeset == '') {
           
            $error_type = 'pkey_fail';
            print("No Subjectgradeset Code to be updated");

        } else {
            $dbconn = DB_Connect_Direct();
	        $query = "UPDATE subjectgradeset SET gradeset = '" . $text_gradeset . "', description = '" . $text_description . "' ";
	        $query .= " WHERE gradeset = '" . $text_gradeset . "';";
	        
	        echo "<script>alert($query);</script>";

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