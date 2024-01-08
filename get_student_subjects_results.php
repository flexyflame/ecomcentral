
<?php  
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

    $student_id = 0;
    //if (isset($_REQUEST['student_id'])) { $student_id = $_REQUEST['student_id']; }

    $id_student = "";
    if (isset($_REQUEST['id_student'])) { $id_student = $_REQUEST['id_student']; }

    $subjectcode = "";
    if (isset($_REQUEST['subjectcode'])) { $subjectcode = $_REQUEST['subjectcode']; }

    $grade = "";
    if (isset($_REQUEST['grade'])) { $grade = $_REQUEST['grade']; }

    $room = "";
    if (isset($_REQUEST['room'])) { $room = $_REQUEST['room']; }

    $term = "";
    if (isset($_REQUEST['term'])) { $term = $_REQUEST['term']; }

    $sex = "";
    if (isset($_REQUEST['sex'])) { $sex = $_REQUEST['sex']; }

    $query_where_temp = " WHERE (1=1) ";

    //echo $query_where_temp;
    //
    if (!empty($id_student)) { $query_where_temp .= " AND (SS.id='" . $id_student . "') "; }
    if (!empty($subjectcode)) { $query_where_temp .= " AND (SS.subjectcode='" . $subjectcode . "') "; }
    if (!empty($grade)) { $query_where_temp .= " AND (SS.Grade='" . $grade . "') "; }
    if (!empty($room)) { $query_where_temp .= " AND (SS.Room='" . $room . "') "; }
    if (!empty($term)) { $query_where_temp .= " AND (SS.term='" . $term . "') "; } else { $query_where_temp .= " AND (SS.term='xx?!$$') "; }
    if (!empty($sex)) { $query_where_temp .= " AND (SS.sex=" . $sex . ") "; }

    $query_result_array = array();
    
    // Call Data
    $query_total = 0;
    $dbconn = DB_Connect_Direct();
    $query = "SELECT * FROM vwstudentsubjects AS SS " . $query_where_temp;
    $query .= "ORDER BY subjectcode ASC;";

    echo $query;

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

    echo "<div style=\"height: 450px; overflow: auto; background: #e6e6e6; padding-right: 0px; padding-left: 0px;\">";
    echo "<table class=\"responsive-card-table  table-expand hover\">";  
    echo "<thead style=\"background: #cbe4ff;\">";
    echo "    <th class=\"sub-table-th\" width=\"8%\"><span style=\"color: #607D8B;\">ID.</span><br>Test %</th>";
    echo "    <th class=\"sub-table-th\" width=\"10%\"><span style=\"color: #607D8B;\">Last Name</span><br><div><span class=\"cum100\" style=\"display: none;\">Test 100%</span></div></th>";
    echo "    <th class=\"sub-table-th\" width=\"10%\"><span style=\"color: #607D8B;\">First Name</span><br>Test Mark</th>";
    echo "    <th class=\"sub-table-th\" width=\"10%\"><span style=\"color: #607D8B;\">Other Name</span><br>Exam %</th>";
    echo "    <th class=\"sub-table-th\" width=\"10%\"><span style=\"color: #607D8B;\">Code</span><br><span class=\"exam100\" style=\"display: none;\">Exam 100%</span></th>";
    echo "    <th class=\"sub-table-th\" width=\"15%\"><span style=\"color: #607D8B;\">Description</span><br>Exam Mark</th>";
    echo "    <th class=\"sub-table-th\" width=\"7%\" style=\"color: #222;\"><br>Pro-Rate</th>";
    echo "    <th class=\"sub-table-th\" width=\"5%\" style=\"color: #222;\"><br>Total</th>";
    echo "    <th class=\"sub-table-th\" width=\"5%\" style=\"color: #222;\"><br>Assess</th>";
    echo "    <th class=\"sub-table-th\" width=\"5%\" style=\"color: #222;\"><br>Rank</th>";
    echo "    <th class=\"sub-table-th\" width=\"5%\" style=\"color: #222;\"><br>Grade</th>";
    echo "    <th class=\"sub-table-th\" width=\"5%\" style=\"color: #222;\"><br>Comment</th>";
    echo "    <th class=\"sub-table-th\" width=\"5%\" style=\"color: #222;\"><br>Teacher</th>";
    echo "</thead>";
    echo "<tbody>";
       
            foreach ($query_result_array as $obj) {
                echo "<tr>";

                echo "  <td valign=\"top\"data-label=\"ID:\">";
                echo "     <div>";
                echo "          <strong style=\"color: crimson; \">" . $obj->id . "</strong>";
                echo "     </div>";   
                echo "     <div>";
                echo            $obj->test; 
                echo "     </div>"; 
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Last Name:\">"; 
                echo "     <div>";
                echo "          <span style=\"color: #607D8B; \">" . $obj->lastname . "</span>";
                echo "     </div>";   
                echo "     <div class=\"cum100\" style=\"display: none;\">";
                echo            $obj->cum100; 
                echo "     </div>"; 
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"First Name:\">";
                echo "     <div>";
                echo "          <span style=\"color: #607D8B; \">" . $obj->firstname . "</span>";
                echo "     </div>";   
                echo "     <div>";
                echo            $obj->Testresult; 
                echo "     </div>"; 
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Other Name:\">"; 
                echo "     <div>";
                echo "          <span style=\"color: #607D8B; \">" . $obj->othername . "</span>";
                echo "     </div>";   
                echo "     <div>";
                echo            $obj->exam; 
                echo "     </div>"; 
                echo "  </td>";
                
                echo "  <td valign=\"top\"data-label=\"Code:\">"; 
                echo "     <div>";
                echo "          <span style=\"color: #607D8B; \">" . $obj->subjectcode . "</span>";
                echo "     </div>";   
                echo "     <div class=\"exam100\" style=\"display: none;\">";
                echo            $obj->exam100; 
                echo "     </div>"; 
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Description:\">"; 
                echo "     <div>";
                echo "          <span style=\"color: 607D8B; \">" . DB_Subject_Description($obj->subjectcode) . "</span>";
                echo "     </div>";   
                echo "     <div>";
                echo            $obj->examresult; 
                echo "     </div>"; 
                echo "  </td>";
            

                echo "  <td valign=\"top\"data-label=\"Pro-Rate:\" style=\"color: #222;\">";                             
                echo "     <br>";
                echo "     <div>";
                echo            "**"; 
                echo "     </div>";                           
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Total:\" style=\"color: #222;\">"; 
                echo "     <br>";
                echo "     <div>";
                echo            "007"; 
                echo "     </div>";                            
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Assess:\" style=\"color: #222;\">"; 
                echo "     <br>";
                echo "     <div>";
                echo            $obj->assesement; 
                echo "     </div>";                         
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Rank:\" style=\"color: #222;\">";    
                echo "     <br>";
                echo "     <div>";
                echo            "1st"; 
                echo "     </div>";                           
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Grade:\" style=\"color: #222;\">";   
                echo "     <br>";
                echo "     <div>";
                echo            "E"; 
                echo "     </div>";                           
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Comment:\" style=\"color: #222;\">";   
                echo "     <br>";
                echo "     <div>";
                echo            $obj->Comments; 
                echo "     </div>";                           
                echo "  </td>";

                echo "  <td valign=\"top\"data-label=\"Teacher:\" style=\"color: #222;\">";  
                echo "     <br>";
                echo "     <div>";
                echo            $obj->Teacher; 
                echo "     </div>";                           
                echo "  </td>";

                echo "</tr>";
            } // end foreach ($query_result_array as $obj);
               
        echo "</tbody>";
    echo "</table>";
    echo "</div>";
    if ($query_total > 0) {
        echo "<div>";
        echo "  <div class=\"row\" style=\"padding: 0px 15px;\">";
        echo "    <div class=\"small-12 medium-12 large-12 columns\" style=\"background-color: lightblue;\">";
        echo "        <p style=\"margin-bottom: 0px\">Number of Subjects: <strong>" . $query_total . "</strong></p>";
        echo "    </div>";
        echo "  </div>";
        echo "</div>";
    }
?>