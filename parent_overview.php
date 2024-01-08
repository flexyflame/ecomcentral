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

        if (!empty($_REQUEST['text_id_parent'])) { $query_where_temp .= " AND (P.id='" . $_REQUEST['text_id_parent'] . "') "; }
        if (!empty($_REQUEST['text_name'])) { $query_where_temp .= " AND (P.name LIKE '%" . $_REQUEST['text_name'] . "%') "; }
        if (!empty($_REQUEST['text_email'])) { $query_where_temp .= " AND (P.email LIKE '%" . $_REQUEST['text_email'] . "%') "; }
        if (!empty($_REQUEST['text_tel1'])) { $query_where_temp .= " AND (P.Tel1 LIKE '%" . $_REQUEST['text_tel1'] . "%') "; }
        if (!empty($_REQUEST['text_tel2'])) { $query_where_temp .= " AND (P.Tel2 LIKE '%" . $_REQUEST['text_tel2'] . "%') "; }
        if ($_REQUEST['select_pta_exec'] != "") { $query_where_temp .= " AND (P.ptaexec=" . $_REQUEST['select_pta_exec'] . ") "; }
        if ($_REQUEST['select_profession'] != 0) { $query_where_temp .= " AND (P.profession=" . $_REQUEST['select_profession'] . ") "; }
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
            $query = "SELECT * FROM parents AS P" . $query_where . ";";
            //echo $query;
            $result = DB_Query($dbconn, $query);
            if ($result != false) {
                $query_total = DB_NumRows($result); 

                //echo $query_total;
                DB_FreeResult($result);
            }


            // Prepare Query
            $query =  "SELECT * FROM parents AS P ";
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
                <h2 class="title" style="margin-bottom: 0px;">Manage Parents</h2>
            </div>
            <div class="small-4 medium-4 large-4 columns" style="text-align: right;">
                <a class="hollow button" style="font-size: x-large; padding: 5px; margin: 10px 5px 0;"  data-open="parentSearch"><i class="fas fa-search"></i></a>
            </div>
        </div> 
        <hr style="margin: 0px 40px 30px 40px; border-bottom: 1px solid #4c9cb4; max-width: initial;">                    
    </div>

    <!-- content rows -->
    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_parent_overview" name="form_parent_overview" method="post">
        <div class="row" style="padding-top:5px">        
            <div class="large-12 small-centered columns">
                <table class="responsive-card-table  table-expand hover">  
                    <thead>
                            <th width="5%">ID</th>
                            <th width="25%">Name</th>
                            <th width="5%">Relation</th>
                            <th width="25%">Address</th>                            
                            <th width="5%">Mobile</th>
                            <th width="10%">E-Mail</th>
                            <th width="10%">Profession</th>
                            <th width="10%">PTA Exc.</th>
                            <th width="5%">Action</th>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($query_result_array as $obj) {
                                echo "<tr>";
                                
                                echo "  <td valign=\"top\"data-label=\"ID:\">"; 
                                echo "     <strong style=\"color: crimson; \">" . $obj->id . "</strong>";
                                echo "  </td>";
                                
                                echo "  <td valign=\"top\"data-label=\"Name:\">";                             
                                echo        $obj->Name;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Relation:\">";  
                                echo        Get_Relation($obj->ptype);                      
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Address:\">";                             
                                echo        $obj->addr1 . "<br>" . $obj->addr2 . "<br>" . $obj->addr3;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Mobile:\">";                             
                                echo        $obj->Tel2;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"E-Mail:\">";                             
                                echo        $obj->email;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Profession:\">";  
                                echo        Get_Profession($obj->profession);                      
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"PTA Exc.:\">";                             
                                echo        $obj->ptaexec == 0 ? 'No' : 'Yes';                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Action:\">";                             
                                echo "  <a href=\"" . $SESSION->Generate_Link("parent_edit", "page_aktion=parent_update&parent_id=" . $obj->id . "" ) . "\"><i class=\"fa fa-edit action-controls\" title=\"Edit Record\"></i> </a>";                      
                                echo "  </td>";

                                echo "</tr>";
                            } // end foreach ($query_result_array as $obj);
                        ?>                
                    </tbody>
                </table>
            </div>
            <input name="page" type="hidden" id="page" value="student_overview" />
            <input name="id_parent" type="hidden" id="id_parent" value="<?php if (isset($id_parent)) echo $id_parent; ?>" />
            <input name="page_aktion" type="hidden" id="page_aktion" value="student_overview" />
            <input name="posted" type="hidden" id="posted" value="yes" />
            <input name="page_limit" type="hidden" id="page_limit" value="<?php if (isset($query_limit)) echo $query_limit; ?>" />
        </div>

        <div class="row" style="padding: 0px 15px;">
            <div class="small-12 medium-12 large-12 columns" style="background-color: aliceblue;">
                <p style="margin-bottom: 0px">Number of Students: <strong><?php echo $query_total; ?></strong></p>
            </div>
        </div>

        <!-- Seiten Navigation-->
        <div class="row Table-Nav" style="margin: 10px 21px;">
            <?php
                if ( ($query_limit != 0) && ($query_total > 0) ) {
                    $page_nav_action = "page_aktion=show";

                    if (!empty($id_parent)) $page_nav_action .= "&id_parent=" . $id_parent;
                    Page_Nav("parent_overview", $page_nav_action, 7, $query_total, $query_limit, $query_offset);

                } // end if ( ($query_limit != 0) && ($query_total > 0) );
            ?>
        </div>
    </form>

</div>

<!--Student Search Reveal-->
<div class="small reveal" id="parentSearch" data-reveal>

  <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" id="<?php echo $form_id; ?>" name="<?php echo $form_name; ?>" method="post">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <h4>Filter Parents:</h4>
            <em style="color: #ddd;">Enter details to search for specific parents...!</em>
        </div>
    </div>
  
    <div class="row">
        <div class="small-3 medium-3 large-3 columns">
            <label for="text_id_parent" class="left inline">Parent ID:</label>
            <input name="text_id_parent" type="text" id="text_id_parent" placeholder="Parent ID" value="<?php echo isset($text_id_parent) ? $text_id_parent : ''; ?>" />
        </div>
       
        <div class="small-3 medium-3 large-3 columns">
            <label for="select_pta_exec" class="left inline">PTA Executive</label>
            <select id="select_pta_exec" name="select_pta_exec">
                <option value="">Any</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="small-3 medium-3 large-3 columns">
            <label for="select_profession" class="left inline">Profession:</label>
            <?php
                $profession_selektiert = -1;
                if (isset($select_profession)) {
                    $profession_selektiert = $select_profession;
                }
                $select_id = "select_profession";
                $select_name = "select_profession";
                $select_size = 1;
                $select_extra_code = '';
                $arr_option_values = array(0 => '');
                echo $UTIL->SELECT_Profession($profession_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
            ?>
        </div>

    </div>

    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <label for="text_name" class="left inline">Name:</label>
            <input name="text_name" type="text" id="text_name" placeholder="Name" value="<?php echo isset($text_name) ? $text_name : ''; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <label for="text_email" class="left inline">E-Mail:</label>
            <input name="text_email" type="text" id="text_email" placeholder="E-Mail" value="<?php echo isset($text_email) ? $text_email : ''; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="small-6 medium-6 large-6 columns">
            <label for="text_tel1" class="left inline">Telephone:</label>
            <input name="text_tel1" type="text" id="text_tel1" placeholder="Telephone" value="<?php echo isset($text_tel1) ? $text_tel1 : ''; ?>" />
        </div>
        <div class="small-6 medium-6 large-6 columns">
            <label for="text_tel2" class="left inline">Mobile:</label>
            <input name="text_tel2" type="text" id="text_tel2" placeholder="Mobile" value="<?php echo isset($text_tel2) ? $text_tel2 : ''; ?>" />
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