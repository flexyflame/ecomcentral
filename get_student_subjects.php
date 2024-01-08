
<?php  
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

    $student_id = 0;
    if (isset($_GET['student_id'])) { $student_id = $_GET['student_id']; }

    $term = 0;
    if (isset($_GET['term'])) { $term = $_GET['term']; }

    $classtype = "";
    if (isset($_GET['classtype'])) { $classtype = $_GET['classtype']; }

    $query_result_array = array();

    if (strcmp($classtype, "PG") == 0) {

        // Call Data
    	  $dbconn = DB_Connect_Direct();
    	  $query = "SELECT * FROM vwpgstudenttopics WHERE id='" . $student_id . "' AND term='" . $term . "';";
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
    	    print("Editing of subjects details failed");
    	  } // end if ($result != false);0     
     	  DB_Close($dbconn);

    	echo "<table class=\"responsive-card-table  table-expand hover\">";  
    	echo "<thead>";
        echo "    <th class=\"sub-table-th\" width=\"15%\">Topic</th>";
        echo "    <th class=\"sub-table-th\" width=\"70%\" style=\"color: #8a8a8a;\">Description</th>";
        echo "    <th class=\"sub-table-th\" width=\"5%\" style=\"color: cadetblue; background: #d6f0d6;\" title=\"Very Good\" >VG</th>";
        echo "    <th class=\"sub-table-th\" width=\"5%\" style=\"color: #8a8a8a; background: #d1eff8;\" title=\"Good\" >G</th>";                            
        echo "    <th class=\"sub-table-th\" width=\"5%\" style=\"color: cornflowerblue; background: #ffe6e7;\" title=\"Needs Effort and Special Attention\" >NES</th>";
        echo "</thead>";
        echo "<tbody>";
           
                foreach ($query_result_array as $obj) {
                    echo "<tr>";
                    
                    echo "  <td valign=\"top\"data-label=\"Topic:\">"; 
                    echo "     <strong style=\"color: crimson; \">" . $obj->topic . "</strong>";
                    echo "  </td>";
                    
                    echo "  <td valign=\"top\"data-label=\"Description:\" style=\"color: #8a8a8a;\">";                             
                    echo        DB_PGTopic_Description($obj->topic);                           
                    echo "  </td>";
            switch ($obj->result) {
                case 1:
                    echo "  <td valign=\"top\"data-label=\"Very Good:\" style=\"background: #d6f0d6;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\" checked></td>";  
                    echo "  <td valign=\"top\"data-label=\"Good:\" style=\"background: #d1eff8;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\"></td>"; 
                    echo "  <td valign=\"top\"data-label=\"Needs Effort:\" style=\"background: #ffe6e7;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\"></td>";
                    break;
                case 2:
                    echo "  <td valign=\"top\"data-label=\"Very Good:\" style=\"background: #d6f0d6;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\"></td>";  
                    echo "  <td valign=\"top\"data-label=\"Good:\" style=\"background: #d1eff8;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\" checked></td>"; 
                    echo "  <td valign=\"top\"data-label=\"Needs Effort:\" style=\"background: #ffe6e7;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\"></td>";
                    break;
                case 3:
                    echo "  <td valign=\"top\"data-label=\"Very Good:\" style=\"background: #d6f0d6;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\"></td>";  
                    echo "  <td valign=\"top\"data-label=\"Good:\" style=\"background: #d1eff8;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\"></td>"; 
                    echo "  <td valign=\"top\"data-label=\"Needs Effort:\" style=\"background: #ffe6e7;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\" checked></td>";
                    break;
                default:
                    echo "  <td valign=\"top\"data-label=\"Very Good:\" style=\"background: #d6f0d6;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\"></td>";  
                    echo "  <td valign=\"top\"data-label=\"Good:\" style=\"background: #d1eff8;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\"></td>"; 
                    echo "  <td valign=\"top\"data-label=\"Needs Effort:\" style=\"background: #ffe6e7;\"><input class=\"table-check\" type=\"checkbox\" onclick=\"return false;\"></td>";
                    break;
            }
        
                    echo "</tr>";
                } // end foreach ($query_result_array as $obj);
                   
            echo "</tbody>";
        echo "</table>";

    } else { // if (strcmp($classtype, "ST") == 0)

        // Call Data
          $dbconn = DB_Connect_Direct();
          $query = "SELECT * FROM vwstudentsubjects WHERE id='" . $student_id . "' AND term='" . $term . "';";
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
            print("Editing of subjects details failed");
          } // end if ($result != false);0     
          DB_Close($dbconn);

        echo "<table class=\"responsive-card-table  table-expand hover\">";  
        echo "<thead>";
        echo "    <th class=\"sub-table-th\" width=\"19%\">Code</th>";
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: #8a8a8a;\">Test %</th>";
        echo "    <th class=\"sub-table-th\" width=\"8%\" style=\"color: cadetblue;\">Test</th>";
        echo "    <th class=\"sub-table-th\" width=\"12%\" style=\"color: #8a8a8a;\">Exam %</th>";                            
        echo "    <th class=\"sub-table-th\" width=\"8%\" style=\"color: cornflowerblue;\">Exam</th>";
        echo "    <th class=\"sub-table-th\" width=\"5%\">Rate</th>";
        echo "    <th class=\"sub-table-th\" width=\"10%\" style=\"color: darkgreen;\">Total</th>";
        echo "    <th class=\"sub-table-th\" width=\"5%\">Rank</th>";
        echo "    <th class=\"sub-table-th\" width=\"8%\">Grade</th>";
        echo "    <th class=\"sub-table-th\" width=\"15%\" style=\"color: blueviolet;\">Comment</th>";
        echo "</thead>";
        echo "<tbody>";
           
                foreach ($query_result_array as $obj) {
                    echo "<tr>";
                    
                    echo "  <td valign=\"top\"data-label=\"Code:\">"; 
                    echo "     <strong style=\"color: crimson; \">" . $obj->subjectcode . "</strong>";
                    echo "  </td>";
                    
                    echo "  <td valign=\"top\"data-label=\"Test %:\" style=\"color: #8a8a8a;\">";                             
                    echo        $obj->test;                           
                    echo "  </td>";

                    echo "  <td valign=\"top\"data-label=\"Test:\" style=\"color: cadetblue;\">";  
                    echo        $obj->Testresult;                      
                    echo "  </td>";

                    echo "  <td valign=\"top\"data-label=\"Exam %:\" style=\"color: #8a8a8a;\">";                             
                    echo        $obj->exam;                           
                    echo "  </td>";

                    echo "  <td valign=\"top\"data-label=\"Exam:\" style=\"color: cornflowerblue;\">";                             
                    echo        $obj->examresult;                           
                    echo "  </td>";

                    echo "  <td valign=\"top\"data-label=\"Rate:\">";                             
                    echo        $obj->prorate == 0 ? 'No' : 'Yes';                         
                    echo "  </td>";

                    echo "  <td valign=\"top\"data-label=\"Total:\" style=\"color: darkgreen;\">";  
                    echo        $obj->totalmark;                      
                    echo "  </td>";

                    echo "  <td valign=\"top\"data-label=\"Rank:\">";                             
                    echo        $obj->rank;                           
                    echo "  </td>";

                    echo "  <td valign=\"top\"data-label=\"Grade:\">";                             
                    echo "      <strong>" . $obj->examgrade . "</strong>";                           
                    echo "  </td>";

                     echo "  <td valign=\"top\"data-label=\"Comment:\" style=\"color: blueviolet;\">";                             
                    echo        $obj->Comments;                           
                    echo "  </td>";

                    

                    echo "</tr>";
                } // end foreach ($query_result_array as $obj);
                   
            echo "</tbody>";
        echo "</table>";

    }



?>