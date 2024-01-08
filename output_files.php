<?php
 	$path = $_SERVER['DOCUMENT_ROOT'] ;
 	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/output_functions.php");  

    $aktion = "show";
    if (!empty($_REQUEST['page_aktion'])) { $aktion = $_REQUEST['page_aktion']; }



    $query_offset = 0;
    if (isset($_REQUEST['query_offset'])) { $query_offset = $_REQUEST['query_offset']; }

    $query_total = 0;
    $query_limit = 100;
    $query_result_array = array();

    $dbconn = DB_Connect_Direct();                
    if ($dbconn != false) {

        $query_where = " WHERE (1=1) ";

        // Gesamtzahl Datensätze aus der Query
        $query = "SELECT * FROM student AS S" . $query_where . ";";
        //echo $query;
        $result = DB_Query($dbconn, $query);
        if ($result != false) {
            $query_total = DB_NumRows($result); 

            //echo $query_total;
            DB_FreeResult($result);
        }


        // Prepare Query
        $query =  "SELECT * FROM student AS S ";
        $query .= $query_where;
        if ($query_limit != 0) {
            $query .= " LIMIT " . $query_limit . " OFFSET " . $query_offset;
        } // end if ($query_limit != 0);
        $query .= ";";

        $result = DB_Query($dbconn, $query);
        if ($result != false) {
            
            while ($obj = DB_FetchObject($result)) { //Build Array from result
                $query_result_array[] = $obj;
            } // end while ($obj = DB_FetchObject($result));
            DB_FreeResult($result);
            DB_Close($dbconn);
        }
    }


	if ($aktion == 'excel') {
		echo $aktion;
       Angebot_Export_XLS($query_result_array);

       //Excel_Out();
    }
?>


<!--<!DOCTYPE html>
<html>
<head>
<title>Output Test</title>
</head>
<body>

<h1>Excel Output</h1>
<p>This is an excel output test!!!.</p>
<a class="button primary" href="/myoutput_test.php?page_aktion=excel" onclick="SpinnerBlock();">Export Excel<i class="fa fa-file-excel" aria-hidden="true"></i></a>

</body>
</html>-->