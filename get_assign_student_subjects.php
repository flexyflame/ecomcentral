
<?php  
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

    $student_id = 0;
    if (isset($_GET['student_id'])) { $student_id = $_GET['student_id']; }

    $term = 0;
    if (isset($_GET['term'])) { $term = $_GET['term']; }

    $query_result_array = array();

    

    // Call Data
    $query_total = 0;
    $dbconn = DB_Connect_Direct();
    $query = "SELECT * FROM vwstudentsubjects WHERE id='" . $student_id . "' AND term='" . $term . "';";
    //echo $query;
    $result = DB_Query($dbconn, $query);
    if ($result != false) {
        //
        $query_total = DB_NumRows($result); 

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

    echo "<div>";
    echo "<table class=\"responsive-card-table  table-expand hover\">";  
    echo "<thead>";
    echo "    <th width=\"10%\" style=\"color: #222;\">Term</th>";
    echo "    <th width=\"10%\" style=\"color: #5143b0;\">Code</th>";
    echo "    <th width=\"20%\" style=\"color: blueviolet;\">Description</th>";
    echo "    <th width=\"10%\" style=\"color: #8a8a8a;\">Test %</th>";
    echo "    <th width=\"8%\" style=\"color: cadetblue;\">Test</th>";
    echo "    <th width=\"12%\" style=\"color: #8a8a8a;\">Exam %</th>";                            
    echo "    <th width=\"10%\" style=\"color: cornflowerblue;\">Exam</th>";
    echo "    <th width=\"15%\">Grade Set</th>";
    echo "    <th width=\"5%\">Class/Room</th>";
    echo "</thead>";
    echo "<tbody>";
       
            foreach ($query_result_array as $obj) {
                echo "<tr>";

                echo "  <td valign=\"top\"data-label=\"Term:\">"; 
                echo "     <strong style=\"color: #222; \">" . $obj->term . "</strong>";
                echo "  </td>";
                
                echo "  <td valign=\"top\"data-label=\"Code:\">"; 
                echo "     <strong style=\"color: #5143b0; \">" . $obj->subjectcode . "</strong>";
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Description:\">"; 
                echo "     <strong style=\"color: blueviolet; \">" . DB_Subject_Description($obj->subjectcode) . "</strong>";   
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

                echo "  <td valign=\"top\"data-label=\"Grade Set:\">";                             
                echo        DB_Subject_Gradeset_description($obj->gradeset);                         
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Class/Room:\">";                             
                echo        $obj->Grade . " / " . $obj->Room;                         
                echo "  </td>";

                echo "</tr>";
            } // end foreach ($query_result_array as $obj);
               
        echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "<div>";
    echo "<div class=\"row\" style=\"padding: 0px 15px;\">";
    echo "    <div class=\"small-12 medium-12 large-12 columns\" style=\"background-color: lightblue;\">";
    echo "        <p style=\"margin-bottom: 0px\">Number of Subjects: <strong>" . $query_total . "</strong></p>";
    echo "    </div>";
    echo "</div>";

    echo "</div>";

?>