
<?php  
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");
    $SESSION = new ClassSession();

    $gradeset = "";
    if (isset($_GET['gradeset'])) { $gradeset = $_GET['gradeset']; }

    
    $query_result_array = array();

    // Call Data
      $dbconn = DB_Connect_Direct();
      $query = "SELECT * FROM subjectgrade WHERE gradeset = '" . $gradeset . "';";
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
        print("Retreiving of subjectgrade list failed");
      } // end if ($result != false);0     
      DB_Close($dbconn);

        echo "<table class=\"responsive-card-table  table-expand hover\">";  
        echo "<thead>";
        echo "    <th class=\"sub-table-th\" width=\"10%\">Low</th>";
        echo "    <th class=\"sub-table-th\" width=\"30%\">High</th>";
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: cadetblue;\">Grade</th>";
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: cornflowerblue;\">Value</th>"; 
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: darkgreen;\">Comments</th>";
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: blueviolet;\">Action</th>";
        echo "</thead>";
        echo "<tbody>";

            foreach ($query_result_array as $obj) {
                echo "<tr>";

                echo "  <td style=\"color: cadetblue;\" valign=\"top\"data-label=\"Low:\">";                             
                echo        $obj->lowscore;                           
                echo "  </td>";

                echo "  <td style=\"color: cadetblue;\" valign=\"top\"data-label=\"Hogh:\">";                             
                echo        round($obj->highscore, 2);                           
                echo "  </td>";

                echo "  <td style=\"color: cadetblue;\" valign=\"top\"data-label=\"Grade:\">";                             
                echo        $obj->grade;                           
                echo "  </td>";

                echo "  <td style=\"color: cadetblue;\" valign=\"top\"data-label=\"Value:\">";                             
                echo        $obj->gradevalue;                           
                echo "  </td>";

                echo "  <td style=\"color: cadetblue;\" valign=\"top\"data-label=\"Comments:\">";                             
                echo        $obj->Comments;                           
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"First Name:\">";                     
                echo "  <a style=\"margin-right: 10px;\" data-open=\"subjectgradelistDialog\"  onclick=\"getSubjectgradesetListOutput('" . $obj->SubjectgradeID . "')\"><i class=\"fa fa-edit action-controls\" title=\"Edit Record\"></i> </a>";
                echo "  <a style=\"margin-right: 10px;\" href=\"" . $SESSION->Generate_Link("subjectgradeset_overview", "page_aktion=subjectgradesetlist_delete&subjectset=" . $obj->SubjectgradeID . "") . "\"><i class=\"fa fa-trash action-controls\" title=\"Delete Record\"></i> </a>";
                                     
                echo "  </td>";

                echo "</tr>";
            } // end foreach ($query_result_array as $obj);
               
        echo "</tbody>";
    echo "</table>";


?>