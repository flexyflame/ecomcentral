
<?php  
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");
    $SESSION = new ClassSession();

    $code = "";
    if (isset($_GET['code'])) { $code = $_GET['code']; }

    
    $query_result_array = array();

    // Call Data
      $dbconn = DB_Connect_Direct();
      $query = "SELECT * FROM pgtopic WHERE code = '" . $code . "';";
       //echo $query;
      $result = DB_Query($dbconn, $query);
      if ($result != false) {
        //
        while ($obj = DB_FetchObject($result)) { //Build Array from result
            $query_result_array[] = $obj;
        } // end while ($obj = DB_FetchObject($result));
                
        $error_type = 'call_data_success';
        DB_FreeResult($result);
      
      } else { 
        $error_type = 'call_data_fail';
        print("Retreiving of PG Topic list failed");
      } // end if ($result != false);0     
      DB_Close($dbconn);

        echo "<table class=\"responsive-card-table  table-expand hover\">";  
        echo "<thead>";
        echo "    <th class=\"sub-table-th\" width=\"5%\">Seq.</th>";
        echo "    <th class=\"sub-table-th\" width=\"10%\">Code</th>";
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: cadetblue;\">Topic</th>";
        echo "    <th class=\"sub-table-th\" width=\"65%\" style=\"color: cornflowerblue;\">Description</th>"; 
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: blueviolet;\">Action</th>";
        echo "</thead>";
        echo "<tbody>";

            foreach ($query_result_array as $obj) {
                echo "<tr>";

                echo "  <td style=\"color: cadetblue;\" valign=\"top\"data-label=\"Seq.:\">";                             
                echo        $obj->seq;                           
                echo "  </td>";

                echo "  <td style=\"color: cadetblue;\" valign=\"top\"data-label=\"Code:\">";                             
                echo        $obj->code;                           
                echo "  </td>";

                echo "  <td style=\"color: cadetblue;\" valign=\"top\"data-label=\"Topic:\">";                             
                echo        $obj->topic;                           
                echo "  </td>";

                echo "  <td style=\"color: cadetblue;\" valign=\"top\"data-label=\"Description:\">";                             
                echo        $obj->description;                           
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"First Name:\">";                     
                echo "  <a style=\"margin-right: 10px;\" data-open=\"pgtopiclistDialog\"  onclick=\"getPGTipicListOutput('" . $obj->code . "', '" . $obj->topic . "')\"><i class=\"fa fa-edit action-controls\" title=\"Edit Record\"></i> </a>";
                echo "  <a style=\"margin-right: 10px;\" href=\"" . $SESSION->Generate_Link("pg_topic_group_overview", "list_dialog_aktion=pgtopiclist_delete&code=" . $obj->code . "&topic=" .  $obj->topic . "") . "\"><i class=\"fa fa-trash action-controls\" title=\"Delete Record\"></i> </a>";
                                     
                echo "  </td>";

                echo "</tr>";
            } // end foreach ($query_result_array as $obj);
               
        echo "</tbody>";
    echo "</table>";


?>