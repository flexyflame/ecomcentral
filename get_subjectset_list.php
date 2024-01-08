
<?php  
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");
    $SESSION = new ClassSession();

    $subjectset = "";
    if (isset($_GET['subjectset'])) { $subjectset = $_GET['subjectset']; }

    
    $query_result_array = array();

    // Call Data
      $dbconn = DB_Connect_Direct();
      $query = "SELECT * FROM subjectsetlist WHERE subjectset = '" . $subjectset . "';";
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
        print("Retreiving of subjectset list failed");
      } // end if ($result != false);0     
      DB_Close($dbconn);

        echo "<table class=\"responsive-card-table  table-expand hover\">";  
        echo "<thead>";
        echo "    <th class=\"sub-table-th\" width=\"10%\">Code</th>";
        echo "    <th class=\"sub-table-th\" width=\"30%\">Description</th>";
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: cadetblue;\">Test %</th>";
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: cornflowerblue;\">Exam %</th>"; 
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: darkgreen;\">Total</th>";
        echo "    <th class=\"sub-table-th\" width=\"20%\">Grade Set</th>";
        //echo "    <th class=\"sub-table-th\" width=\"10%\">Teacher</th>";
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: blueviolet;\">Action</th>";
        echo "</thead>";
        echo "<tbody>";

            foreach ($query_result_array as $obj) {
                echo "<tr>";

                echo "  <td valign=\"top\"data-label=\"Code:\">"; 
                echo "     <strong style=\"color: crimson; \">" . $obj->subjectcode . "</strong>";
                echo "  </td>";
                
                echo "  <td valign=\"top\"data-label=\"Description:\">";                             
                echo        DB_Subject_Description($obj->subjectcode);                           
                echo "  </td>";

                echo "  <td style=\"color: cadetblue;\" valign=\"top\"data-label=\"Test:\">";                             
                echo        $obj->test;                           
                echo "  </td>";

                echo "  <td style=\"color: cornflowerblue;\" valign=\"top\"data-label=\"Exam:\">";                             
                echo        $obj->exam;                           
                echo "  </td>";

                echo "  <td style=\"color: darkgreen;\" valign=\"top\"data-label=\"Total:\">";                             
                echo        $obj->test + $obj->exam;                           
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Grade Set:\">";   
                echo        DB_Subject_Gradeset_description($obj->gradeset);     
                echo "  </td>";

                /*echo "  <td valign=\"top\"data-label=\"Total:\">";                             
                echo        DB_Grade_name($obj->Teacher);             
                echo "  </td>";*/

                echo "  <td valign=\"top\"data-label=\"First Name:\">";                     
                echo "  <a style=\"margin-right: 10px;\" data-open=\"subjectsetlistDialog\"  onclick=\"getSubjectsetListOutput('" . $obj->subjectset . "', '" . $obj->subjectcode . "')\"><i class=\"fa fa-edit action-controls\" title=\"Edit Record\"></i> </a>";
                echo "  <a style=\"margin-right: 10px;\" href=\"" . $SESSION->Generate_Link("subjectset_overview", "list_dialog_aktion=subjectsetlist_delete&pkey=" . $obj->subjectset . "&subjectcode=" .  $obj->subjectcode . "") . "\"><i class=\"fa fa-trash action-controls\" title=\"Delete Record\"></i> </a>";
                                     
                echo "  </td>";

                echo "</tr>";
            } // end foreach ($query_result_array as $obj);
               
        echo "</tbody>";
    echo "</table>";


?>