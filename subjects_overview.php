<!--Include Header-->
<?php  
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/header.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-header.php");

    //Page PHP -- Start--
    if (!isset($SESSION)) {
        die("SESSION Class not defined!");  
    }
    $err = FALSE;

    $posted = FALSE;
    if (!empty($_REQUEST['posted_'])) { $posted = TRUE; }

    $query_where_temp = "";

    if ($posted == TRUE) {

        if (!empty($_REQUEST['text_pkey'])) { $query_where_temp .= " AND (S.pkey='" . $_REQUEST['text_pkey'] . "') "; }
        if (!empty($_REQUEST['text_description'])) { $query_where_temp .= " AND (S.description LIKE '%" . $_REQUEST['text_description'] . "%') "; }
        if ($_REQUEST['select_level'] != 0) { $query_where_temp .= " AND (S.level=" . $_REQUEST['select_level'] . ") "; }
        if (!empty($_REQUEST['select_grade'])) { $query_where_temp .= " AND (S.grade='" . $_REQUEST['select_grade'] . "') "; }
        if (!empty($_REQUEST['select_gradeset'])) { $query_where_temp .= " AND (S.gradeset='" . $_REQUEST['select_gradeset'] . "') "; }
        if ($_REQUEST['select_core'] != 0) { $query_where_temp .= " AND (S.core=" . $_REQUEST['select_core'] . ") "; }
        
    }

 
    $aktion = "show";
    if (!empty($_REQUEST['page_aktion'])) { $aktion = $_REQUEST['page_aktion']; }

    if (strcmp($aktion, "show") == 0) {

        $query_offset = 0;
        if (isset($_REQUEST['query_offset'])) { $query_offset = $_REQUEST['query_offset']; }

        $query_total = 0;
        $query_limit = 10;
        $query_result_array = array();

        $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            $query_where = " WHERE (1=1)" . $query_where_temp . " ";

            // Gesamtzahl Datensätze aus der Query
            $query = "SELECT * FROM subjects AS S" . $query_where . ";";
            //echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                $query_total = DB_NumRows($result); 

                //echo $query_total;
                DB_FreeResult($result);
            }


            // Prepare Query
            $query =  "SELECT * FROM subjects AS S ";
            $query .= $query_where;
            if ($query_limit != 0) {
                $query .= " LIMIT " . $query_limit . " OFFSET " . $query_offset;
            } // end if ($query_limit != 0);
            $query .= ";";

            echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                
                while ($obj = DB_FetchObject($result)) { //Build Array from result
                    $query_result_array[] = $obj;
                } // end while ($obj = DB_FetchObject($result));
                DB_FreeResult($result);
                DB_Close($dbconn);
            }
        }
    }

?>

<div class="main-page" style="min-height: 660px; border: 1px solid #4c9cb4; border-radius: 10px; margin-bottom: 10px; max-width: 1260px;">
    <div class="container-fluid">
        <div class="row">
             <div class="small-8 medium-8 large-8 columns">
                <h2 class="title" style="margin-bottom: 0px;">Manage Subjects</h2>
            </div>
            <div class="small-4 medium-4 large-4 columns" style="text-align: right;">
                <a class="hollow button" style="font-size: x-large; padding: 5px; margin: 10px 5px 0;"  data-open="subjectSearch"><i class="fas fa-search"></i></a>
            </div>
        </div> 
        <hr style="margin: 0px 40px 30px 40px; border-bottom: 1px solid #4c9cb4; max-width: initial;">                    
    </div>

    <!-- content rows -->
    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_subjects_overview" name="form_subjects_overview" method="post">
        <div class="row" style="padding-top:5px">        
            <div class="large-12 small-centered columns">
                <table class="responsive-card-table  table-expand hover">  
                    <thead>
                            <th width="5%">Seq.</th>
                            <th width="5%">Code</th>
                            <th width="25%">Description</th>
                            <th width="5%">Type</th>
                            <th width="10%">Level</th>                            
                            <th width="10%">Class</th>
                            <th width="10%" style="color: cadetblue;">Class Test</th>
                            <th width="5%" style="color: cornflowerblue;">Exam</th>
                            <th width="5%" style="color: darkgreen;">Total</th>
                            <th width="15%">Grade Set</th>
                            <th width="5%">Action</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($query_result_array as $obj) {
                                echo "<tr>";

                                echo "  <td valign=\"top\"data-label=\"Seq.:\">";                             
                                echo        $obj->seq;                           
                                echo "  </td>";
                                
                                echo "  <td valign=\"top\"data-label=\"Code:\">"; 
                                echo "     <strong style=\"color: crimson; \">" . $obj->pkey . "</strong>";
                                echo "  </td>";
                                
                                echo "  <td valign=\"top\"data-label=\"Description:\">";                             
                                echo        $obj->description;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Type:\">";  
                                echo        Get_Subject_Type($obj->core);                      
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Level:\">";                             
                                echo        Get_Subject_Level($obj->level);                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Class:\">";                             
                                echo        DB_Grade_name($obj->grade);                           
                                echo "  </td>";

                                echo "  <td valign=\"top\" style=\"color: cadetblue;\" data-label=\"Class Test:\">";                             
                                echo        $obj->test;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\" style=\"color: cornflowerblue;\" data-label=\"Exam Result:\">";  
                                echo        $obj->exam;                      
                                echo "  </td>";

                                echo "  <td valign=\"top\" style=\"color: darkgreen;\" data-label=\"Total:\">";                             
                                echo        $obj->test + $obj->exam;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Total:\">";                             
                                echo        DB_Subject_Gradeset_description($obj->gradeset);                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"First Name:\">";                             
                                echo "  <a href=\"" . $SESSION->Generate_Link("subjects_edit", "page_aktion=subject_update&pkey=" . $obj->pkey . "" ) . "\"><i class=\"fa fa-edit action-controls\" title=\"Edit Record\"></i> </a>";                      
                                echo "  </td>";

                                echo "</tr>";
                            } // end foreach ($query_result_array as $obj);
                        ?>                
                    </tbody>
                </table>
            </div>
            <input name="page" type="hidden" id="page" value="subjects_overview" />
            <input name="pkey" type="hidden" id="pkey" value="<?php if (isset($text_pkey)) echo $text_pkey; ?>" />
            <input name="page_aktion" type="hidden" id="page_aktion" value="subjects_overview" />
            <input name="posted" type="hidden" id="posted" value="yes" />
            <input name="page_limit" type="hidden" id="page_limit" value="<?php if (isset($query_limit)) echo $query_limit; ?>" />
        </div>

        <!-- Seiten Navigation-->
        <div class="row Table-Nav" style="margin: 10px 40px;">
            <?php
                if ( ($query_limit != 0) && ($query_total > 0) ) {
                    $page_nav_action = "page_aktion=show";

                    if (!empty($text_pkey)) $page_nav_action .= "&pkey=" . $text_pkey;
                    Page_Nav("subjects_overview", $page_nav_action, 7, $query_total, $query_limit, $query_offset);

                } // end if ( ($query_limit != 0) && ($query_total > 0) );
            ?>
        </div>
    </form>

</div>

<!--Student Search Reveal-->
<div class="small reveal" id="subjectSearch" data-reveal>

  <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" id="form_search" name="form_search" method="post">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <h4>Filter Subjects:</h4>
            <em style="color: #ddd;">Enter details to search for specific subject...!</em>
        </div>
    </div>
  
    <div class="row">
        <div class="small-3 medium-3 large-3 columns">
            <label for="text_pkey" class="left inline">Code:</label>
            <input name="text_pkey" type="text" id="text_pkey" placeholder="Code" value="<?php echo isset($text_pkey) ? $text_pkey : ''; ?>" />
        </div>
       
        <div class="small-9 medium-9 large-9 columns">
            <label for="text_description" class="left inline">Description:</label>
            <input name="text_description" type="text" id="text_description" placeholder="Description" value="<?php echo isset($text_description) ? $text_description : ''; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="small-6 medium-6 large-6 columns">
            <label for="select_core" class="left inline">Type:</label>
            <select id="select_core" name="select_core">
                <option value="">Any</option>
                <option value="1">Core</option>
                <option value="2">Elective</option>
                <option value="3">General</option>
            </select>
        </div>

        <div class="small-6 medium-6 large-6 columns">
            <label for="select_level" class="left inline">Level:</label>
            <select id="select_level" name="select_level">
                <option value="">Any</option>
                <option value="1">Pre-School</option>
                <option value="2">Primary</option>
                <option value="3">Junior High</option>
                <option value="3">Senior High</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="small-6 medium-6 large-6 columns">
            <label for="select_grade" class="left inline">Class:</label>
            <?php
                $grade_selektiert = -1;
                if (isset($select_grade)) {
                    $grade_selektiert = $select_grade;
                }
                $select_id = "select_grade";
                $select_name = "select_grade";
                $select_size = 1;
                $select_extra_code = '';
                $arr_option_values = array('' => '');
                echo $UTIL->SELECT_Grade($grade_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
            ?>
        </div>

        <div class="small-6 medium-6 large-6 columns">
            <label for="select_gradeset" class="left inline">Grade Set:</label>
            <?php
                $gradeset_selektiert = -1;
                if (isset($select_gradeset)) {
                    $gradeset_selektiert = $select_gradeset;
                }
                $select_id = "select_gradeset";
                $select_name = "select_gradeset";
                $select_size = 1;
                $select_extra_code = '';
                $arr_option_values = array('' => '');
                echo $UTIL->SELECT_Gradeset($gradeset_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
            ?>
        </div>
    </div>

    <div class="button-group-option" style="padding: 0px 70px;" data-grouptype="OR">
        <a data-close aria-label="Close modal" class="button alert radius" style="color: #ffffff;">Cancel</a>
        <button class="button primary radius" type="submit" style="color: #ffffff;">Apply</button>
        <input name="posted_" type="hidden" id="posted_" value="TRUE" /> 
    </div>

    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
  </form>
</div>


<!--Include Footer-->
  <?php 

    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/footer.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-footer.php");
  ?>