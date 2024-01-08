<!--Include Header-->
<?php  
    
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/header.php";
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/output_functions.php");  
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

        if (!empty($_REQUEST['text_id_student'])) { $query_where_temp .= " AND (S.id='" . $_REQUEST['text_id_student'] . "') "; }
        if (!empty($_REQUEST['text_manual_id'])) { $query_where_temp .= " AND (S.id2='" . $_REQUEST['text_manual_id'] . "') "; }
        if (!empty($_REQUEST['text_lastname'])) { $query_where_temp .= " AND (S.lastname LIKE '%" . $_REQUEST['text_lastname'] . "%') "; }
        if (!empty($_REQUEST['text_firstname'])) { $query_where_temp .= " AND (S.firstname= LIKE '%" . $_REQUEST['text_firstname'] . "%') "; }
        if (!empty($_REQUEST['text_othername'])) { $query_where_temp .= " AND (S.othername= LIKE '%" . $_REQUEST['text_othername'] . "%') "; }
        if (!empty($_REQUEST['select_sex'])) { $query_where_temp .= " AND (S.sex=" . $_REQUEST['select_sex'] . ") "; }
        if (!empty($_REQUEST['text_birthday'])) { $query_where_temp .= " AND (S.birthday='" . $_REQUEST['text_birthday'] . "') "; }
        if (!empty($_REQUEST['text_house'])) { $query_where_temp .= " AND (S.house='" . $_REQUEST['text_house'] . "') "; }
        if ($_REQUEST['select_boarder'] != "") { $query_where_temp .= " AND (S.boarder=" . $_REQUEST['select_boarder'] . ") "; }
        if ($_REQUEST['select_grade'] != -1) { $query_where_temp .= " AND (S.grade='" . $_REQUEST['select_grade'] . "') "; }
        if (!empty($_REQUEST['text_room'])) { $query_where_temp .= " AND (S.room='" . $_REQUEST['text_room'] . "') "; }
        if ($_REQUEST['select_status'] != -1) { $query_where_temp .= " AND (S.status=" . $_REQUEST['select_status'] . ") "; }
        if ($_REQUEST['select_startyear'] != -1) { $query_where_temp .= " AND (S.startyear=" . $_REQUEST['select_startyear'] . ") "; }
        if ($_REQUEST['select_yeargroup'] != -1) { $query_where_temp .= " AND (S.yeargroup=" . $_REQUEST['select_yeargroup'] . ") "; }
        if (!empty($_REQUEST['text_parent'])) { $query_where_temp .= " AND (S.parent='" . $_REQUEST['text_parent'] . "') "; }
    }

    $xls_export = "";
    if (!empty($_REQUEST['xls_export'])) { $xls_export = $_REQUEST['xls_export']; }

 
    $aktion = "show";
    if (!empty($_REQUEST['page_aktion'])) { $aktion = $_REQUEST['page_aktion']; }

    if (strcmp($aktion, "show") == 0) {

        $query_offset = 0;
        if (isset($_REQUEST['query_offset'])) { $query_offset = $_REQUEST['query_offset']; }

        $query_total = 0;
        $query_limit = 100;
        $query_result_array = array();

        $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            $query_where = " WHERE (1=1)" . $query_where_temp . " ";

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
    }

    
    if ($xls_export == 1) {
       //Student_Export_XLS($query_result_array);

       Excel_Out();
    }



?>

<div class="main-page" style="min-height: 660px; border: 1px solid #4c9cb4; border-radius: 10px; margin-bottom: 10px; max-width: 1260px;">
    <div class="container-fluid">
        <div class="row">
             <div class="small-10 medium-6 large-6 columns" style="border-bottom: 1px solid #4c9cb4; margin: 0px -10px 0px 10px;">
                <h2 class="title" style="margin: 5px 0 0 0;">Manage Students</h2>
            </div>
            <div class="small-2 medium-2 large-2 columns" style="text-align: right;">
                <a class="hollow button" style="font-size: x-large; padding: 5px; margin: 8px -12px 0px;"  data-open="studentSearch"><i class="fas fa-search"></i></a>
            </div>
            <div class="small-12 medium-4 large-4 columns buttons-cover"></div>
        </div> 
    </div>

    <div class="container-fluid">
        <div style="margin-top: 5px;">
            <ul class="accordion" data-accordion data-allow-all-closed="true">
              <li class="accordion-item" data-accordion-item>
                <!-- Accordion tab title -->
                <a href="#" class="accordion-title">Advance Filter</a>
                <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                <div class="accordion-content" data-tab-content style="padding: 5px;">
                    <div class="small-12 medium-12 large-12 columns filter-cover"></div>
                </div>
              </li>
            </ul>
        </div>
    </div>

    

    <!-- content rows -->
    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_student_overview" name="form_student_overview" method="post">
        <div class="row" style="padding-top:5px">   

            <div class="large-12 small-centered columns">
                <table class="responsive-card-table  table-expand hover" id="myTable">  
                    <thead>
                            <th width="5%">ID</th>
                            <th width="15%">First Name</th>
                            <th width="15%">Last Name</th>
                            <th width="5%">Sex</th>
                            <th width="5%">Grade/Room</th>
                            <th width="10%">Nationality</th>
                            <th width="5%">Parent</th>
                            <th width="5%">Boarder</th>
                            <th width="5%">Status</th>
                            <th width="10%">Year Group</th>
                            <th width="5%">Action</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($query_result_array as $obj) {
                                echo "<tr>";
                                
                                echo "  <td valign=\"top\"data-label=\"ID:\">"; 
                                echo "     <strong style=\"color: crimson; \">" . $obj->id . "</strong>";
                                echo "  </td>";
                                
                                echo "  <td valign=\"top\"data-label=\"First Name:\">";                             
                                echo        $obj->firstname;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Last Name:\">";                             
                                echo        $obj->lastname;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Sex Name:\">";                             
                                echo        $obj->sex == 1 ? 'Male' : 'Female';                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Grade/Room:\">";                             
                                echo        $obj->grade . "/" . $obj->room;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Nationality:\">";                             
                                echo        $obj->nationality;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Parent:\">"; 
                                echo "      <a class=\"class_spinner_id\" title=\"Click to open Parent!\" href=\"" .  $SESSION->Generate_Link("parent_edit", "page_aktion=parent_update&parent_id=" . $obj->parent  . "" ) . "\">" . $obj->parent . "</a>";            
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Boarder:\">";                             
                                echo        $obj->boarder == 0 ? 'No' : 'Yes';                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Status:\">";  
                                echo        Get_Status($obj->status);                      
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Year Group:\">";                             
                                echo        $obj->startyear . " - " . $obj->yeargroup;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Action:\">";                             
                                echo "  <a href=\"" . $SESSION->Generate_Link("student_edit", "page_aktion=student_update&student_id=" . $obj->id . "" ) . "\"><i class=\"fa fa-edit action-controls\" title=\"Edit Record\"></i> </a>";                      
                                echo "  </td>";

                                echo "</tr>";
                            } // end foreach ($query_result_array as $obj);
                        ?>                
                    </tbody>
                </table>
            </div>
            <input name="page" type="hidden" id="page" value="student_overview" />
            <input name="id_student" type="hidden" id="id_student" value="<?php if (isset($id_student)) echo $id_student; ?>" />
            <input name="page_aktion" type="hidden" id="page_aktion" value="student_overview" />
            <input name="posted" type="hidden" id="posted" value="yes" />
            <input name="page_limit" type="hidden" id="page_limit" value="<?php if (isset($query_limit)) echo $query_limit; ?>" />
        </div>

        <!--<div class="row" style="padding: 0px 15px;">
            <div class="small-12 medium-12 large-12 columns" style="background-color: aliceblue;">
                <p style="margin-bottom: 0px">Number of Students: <strong><?php echo $query_total; ?></strong></p>
            </div>
        </div>-->

        <!-- Seiten Navigation
        <div class="row Table-Nav" style="margin: 10px 21px;">
            <?php
                if ( ($query_limit != 0) && ($query_total > 0) ) {
                    $page_nav_action = "page_aktion=show";

                    if (!empty($id_student)) $page_nav_action .= "&id_student=" . $id_student;
                    Page_Nav("student_overview", $page_nav_action, 7, $query_total, $query_limit, $query_offset);

                } // end if ( ($query_limit != 0) && ($query_total > 0) );
            ?>
        </div>-->


    </form>

    <?php
        echo "<a href=\"" . $SESSION->Generate_Link('student_overview', 'xls_export=1&page_aktion=show') . "\" onclick=\"SpinnerBlock();\"  class=\"button\"><i class=\"fa fa-file-excel\" aria-hidden=\"true\"></i><span style=\"text-align: justify;\">Export XLS</span></a>";

        //echo "<button onclick='' >Click me</button>";
        //echo "  <div><button onclick='" . Student_Export_XLS($query_result_array) . "'>Click me to export XLS</button></div>";  
    ?>

</div>

<!--Student Search Reveal-->
<div class="small reveal" id="studentSearch" data-reveal>

  <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" id="<?php echo $form_id; ?>" name="<?php echo $form_name; ?>" method="post">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <h4>Filter Students:</h4>
            <em style="color: #ddd;">Enter details to search for specific students...!</em>
        </div>
    </div>
  
    <div class="row">
        <div class="small-3 medium-3 large-3 columns">
            <label for="text_id_student" class="left inline">Student ID:</label>
            <input name="text_id_student" type="text" id="text_id_student" placeholder="Student ID" value="<?php echo isset($text_id_student) ? $text_id_student : ''; ?>" />
        </div>
        <div class="small-3 medium-3 large-3 columns">
            <label for="text_manual_id" class="left inline">Manual ID:</label>
            <input name="text_manual_id" type="text" id="text_manual_id" placeholder="Manual ID" value="<?php echo isset($text_manual_id) ? $text_manual_id : ''; ?>" />
        </div>
        <div class="small-3 medium-3 large-3 columns">
            <label for="select_boarder" class="left inline">Boarder</label>
            <select id="select_boarder" name="select_boarder">
                <option value="">Any</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="small-3 medium-3 large-3 columns">
            <label for="text_parent" class="left inline">Parent ID:</label>
            <input name="text_parent" type="text" id="text_parent" placeholder="Parent ID" value="<?php echo isset($text_parent) ? $text_parent : ''; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <label for="text_lastname" class="left inline">Last Name:</label>
            <input name="text_lastname" type="text" id="text_lastname" placeholder="Last Name" value="<?php echo isset($text_lastname) ? $text_lastname : ''; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="small-6 medium-6 large-6 columns">
            <label for="text_firstname" class="left inline">First Name:</label>
            <input name="text_firstname" type="text" id="text_firstname" placeholder="First Name" value="<?php echo isset($text_firstname) ? $text_firstname : ''; ?>" />
        </div>
        <div class="small-6 medium-6 large-6 columns">
            <label for="text_othername" class="left inline">Other Name:</label>
            <input name="text_othername" type="text" id="text_othername" placeholder="Other Name" value="<?php echo isset($text_othername) ? $text_othername : ''; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="small-3 medium-3 large-3 columns">
            <label for="select_sex" class="left inline">Sex:</label>
            <?php
                $sex_selektiert = 0;
                if (isset($select_sex)) {
                    $sex_selektiert = $select_sex;
                }
                $select_id = "select_sex";
                $select_name = "select_sex";
                $select_size = 1;
                $select_extra_code = '';
                $arr_option_values = array(0 => '');
                echo $UTIL->SELECT_Sex($sex_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
            ?>
        </div>

        <div class="small-3 medium-3 large-3 columns">
            <label for="text_birthday" class="left inline">Birth Date:</label>
            <input name="text_birthday" type="date" id="text_birthday" placeholder="Birth Date" value="<?php echo isset($text_birthday) ? $text_birthday : ''; ?>" />
        </div>

        <div class="small-3 medium-3 large-3 columns">
            <label for="select_status" class="left inline">Status:</label>
            <?php
                $status_selektiert = 0;
                if (isset($select_status)) {
                    $status_selektiert = $select_status;
                }
                $select_id = "select_status";
                $select_name = "select_status";
                $select_size = 1;
                $select_extra_code = '';
                $db_conn_opt = false;
                $arr_option_values = array(-1 => '');
                echo $UTIL->SELECT_Status($status_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
            ?>
        </div>

        <div class="small-3 medium-3 large-3 columns">
            <label for="select_startyear" class="left inline">Start Year:</label>
            <?php
                $startyear_selektiert = 0;
                if (isset($select_startyear)) {
                    $startyear_selektiert = $select_startyear;
                }
                $select_id = "select_startyear";
                $select_name = "select_startyear";
                $select_size = 1;
                $select_extra_code = '';
                $db_conn_opt = false;
                $arr_option_values = array(-1 => '');
                echo $UTIL->SELECT_StartYear($startyear_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="small-3 medium-3 large-3 columns">
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
                $db_conn_opt = false;
                $arr_option_values = array(-1 => '');
                echo $UTIL->SELECT_Grade($grade_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
            ?>
        </div>
        <div class="small-3 medium-3 large-3 columns">
            <label for="text_room" class="left inline">Room:</label>
            <input name="text_room" type="text" id="text_room" placeholder="Room" value="<?php echo isset($text_room) ? $text_room : ''; ?>" />
        </div>
        
        <div class="small-3 medium-3 large-3 columns">
            <label for="text_house" class="left inline">House:</label>
            <input name="text_house" type="text" id="text_house" placeholder="House" value="<?php echo isset($text_house) ? $text_house : ''; ?>" />
        </div>
        
        <div class="small-3 medium-3 large-3 columns">
            <label for="select_yeargroup" class="left inline">Year Group:</label>
            <?php
                $yeargroup_selektiert = 0;
                if (isset($select_yeargroup)) {
                    $yeargroup_selektiert = $select_yeargroup;
                }
                $select_id = "select_yeargroup";
                $select_name = "select_yeargroup";
                $select_size = 1;
                $select_extra_code = '';
                $db_conn_opt = false;
                $arr_option_values = array(-1 => '');
                echo $UTIL->SELECT_YearGroup($yeargroup_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
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


  <script type="text/javascript">
    $(document).ready( function () {
    
        var table = $('#myTable').DataTable({
            responsive: true,
            stateSave: true,
            searchBuilder: true,
            searchBuilder: {columns: [1,2,3]},
            language: {searchBuilder: {clearAll: 'Reset' ,title: {0: 'Filter', _: 'Filters (%d)'},}},
            
            buttons: [ 
                {
                    extend: 'copy', 
                    text: '<i class="fa fa-copy" aria-hidden="true"></i>',
                    titleAttr: 'Copy to clipboard',
                    className:'btn-Table button success'
                },
                {
                    extend: 'csv', 
                    text: '<i class="fa fa-file" aria-hidden="true"></i>',
                    titleAttr: 'Save as CSV',
                    className:'btn-Table button primary'
                },
                {
                    extend: 'excel', 
                    text: '<i class="fa fa-file-excel" aria-hidden="true"></i>',
                    titleAttr: 'Save as Excel',
                    className:'btn-Table button success'
                },
                {
                    extend: 'pdf', 
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    titleAttr: 'Save PDF',
                    className:'btn-Table button success'
                },
                {
                    extend: 'print', 
                    text: '<i class="fa fa-print" aria-hidden="true"></i>',
                    titleAttr: 'Print',
                    className:'btn-Table button success'
                },],
        });

        table.searchBuilder.container().prependTo(".filter-cover");
        table.buttons().containers().prependTo(".buttons-cover");

    } );


    /*$(function($) {
        $('#table_id').DataTable();

        $('#example2').DataTable( {
            "scrollY":        "300px",
            "scrollCollapse": true,
            "paging":         false
        } );

        $('#example3').DataTable();
    });*/

</script>