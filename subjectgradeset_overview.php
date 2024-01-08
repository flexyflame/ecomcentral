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

    $aktion = "show";
    if (!empty($_REQUEST['page_aktion'])) { $aktion = $_REQUEST['page_aktion']; }

    $list_dialog_aktion = "show";
    if (!empty($_REQUEST['list_dialog_aktion'])) { $list_dialog_aktion = $_REQUEST['list_dialog_aktion']; }


     $selected_subjectgradeset_code = "";

     $query_where_temp = "";

    $gradeset = "";
    if (isset($_GET['gradeset'])) { $gradeset = $_GET['gradeset']; }

    $SubjectgradeID = "";
    if (isset($_GET['SubjectgradeID'])) { $SubjectgradeID = $_GET['SubjectgradeID']; }


    if (strcmp($aktion, "subjectgradeset_delete") == 0) {
         $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            if ($gradeset != "") {

                $query = "DELETE FROM subjectgrade WHERE gradeset = '" . $gradeset . "';";
                //echo $query;
                $result = DB_Query($dbconn, $query);
                if ($result != false) {

                    $query = "DELETE FROM subjectgradeset WHERE gradeset = '" . $gradeset . "';";
                    //echo $query;
                    $result = DB_Query($dbconn, $query);
                    if ($result != false) {
                        echo "<script>alert('Record DELETED successfully!');</script>";
                    }
                }
                DB_Close($dbconn);
            }
            
        }
        $aktion = "show";
    }


    if (strcmp($list_dialog_aktion, "subjectgrade_delete") == 0) {
         $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            if ($SubjectgradeID != "") {

                $query = "DELETE FROM subjectgrade WHERE SubjectgradeID = '" . $SubjectgradeID . "';";
                //echo $query;
                $result = DB_Query($dbconn, $query);
                if ($result != false) {
                    echo "<script>alert('Record DELETED successfully!');</script>";
                }
            
                DB_Close($dbconn);
            }
            
        }
        $aktion = "show";
    }

    if (strcmp($aktion, "show") == 0) {

        $query_result_array = array();

        $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            $query_where = " WHERE (1=1)" . $query_where_temp . " ";

            // Gesamtzahl Datensätze aus der Query
            $query = "SELECT * FROM subjectgradeset AS S" . $query_where . ";";
            //echo $query;
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
                <h2 class="title" style="margin-bottom: 0px;">Manage Subject Grade Sets</h2>
            </div>
        </div> 
        <hr style="margin: 0px 40px 15px 40px; border-bottom: 1px solid #4c9cb4; max-width: initial;">                    
    </div>

    <!-- content rows -->
    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_subjectgradeset" name="form_subjectgradeset" method="post">
        <div class="row" style="padding-top:5px">
            <div class="small-12 medium-12 large-12 columns" style="">
                <h5 style="border-bottom: 1px solid #c60f13; margin-left: 18px; color: cadetblue; padding-right: 30px; float: left; width: 85%;">Subject Grade Set:</h5>  
                <a class="hollow button" style="font-size: x-large; padding: 5px; margin: -5px 50px 0px; float: right;" title="Create New Subject Grade Set" data-open="subjectgradesetDialog" onclick="getSubjectgradeCreate();"><i class="fas fa-plus-square"></i></a>
            </div> 
              
            <div class="large-12 small-centered columns">
                <table class="responsive-card-table  table-expand hover">  
                    <thead>
                            <th width="20%">Grade Set</th>
                            <th width="75%">Description</th>
                            <th width="5%">Action</th>
                    </thead>
                    <tbody>
                        <?php
                            $i = 0;
                            foreach ($query_result_array as $obj) {
                                //Get the first subjectset code to display list below
                                if ($i == 0 ) { $selected_subjectgradeset_code = $obj->gradeset; }
                                $i++; 

                                echo "<tr>";

                                echo "  <td valign=\"top\"data-label=\"Code:\">"; 
                                echo "     <a onclick=\"getSubjectsetList('" . $obj->gradeset . "')\"><strong style=\"color: crimson; \">" . $obj->gradeset . "</strong></a>";
                                echo "  </td>";
                                
                                echo "  <td valign=\"top\"data-label=\"Description:\">";                             
                                echo        $obj->description;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"First Name:\">";                     
                                echo "  <a style=\"margin-right: 10px;\" data-open=\"subjectgradesetDialog\"  onclick=\"getSubjectGradesetOutput('" . $obj->gradeset . "')\"><i class=\"fa fa-edit action-controls\" title=\"Edit Record\"></i> </a>";
                                echo "  <a style=\"margin-right: 10px;\" href=\"" . $SESSION->Generate_Link("subjectgradeset_overview", "page_aktion=subjectgradeset_delete&gradeset=" . $obj->gradeset . "" ) . "\"><i class=\"fa fa-trash action-controls\" title=\"Delete Record\"></i> </a>";
                                                     
                                echo "  </td>";

                                echo "</tr>";
                            } // end foreach ($query_result_array as $obj);
                        ?>                
                    </tbody>
                </table>
            </div>

            
            
        </div>
    </form>

    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_subjectgrade" name="form_subjectgrade" method="post">
        <div class="row" style="padding-top:5px">
            <div class="small-12 medium-12 large-12 columns" style="">
                <h5 style="border-bottom: 1px solid #ffae00; margin-left: 18px; color: #1779ba; padding-right: 30px; float: left; width: 85%;">Subject Grade List:</h5>  
                <a class="hollow button" style="font-size: x-large; padding: 5px; margin: -5px 50px 0px; float: right;" title="Add Subject Grading"  data-open="subjectgradelistDialog" onclick="getSubjectgradesetListCreate();"><i class="fas fa-plus-square"></i></a>
                <input name="selected_subjectgradeset_code" type="hidden" id="selected_subjectgradeset_code" value="<?php if (isset($selected_subjectgradeset_code)) echo $selected_subjectgradeset_code; ?>" />
            </div> 
            <div class="large-12 small-centered columns" id="subjectgradelist">

            </div>
        </div>
    </form>

</div>

<!--Subjectset Reveal-->
<div class="tiny reveal" id="subjectgradesetDialog" data-reveal>

    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <h4>Update Subject Grdae Set:</h4>
            <em style="color: #ddd;">Enter details of Subject Grade Set...!</em>
        </div>
    </div>
  
    <div class="row">
        <div class="small-3 medium-3 large-3 columns">
            <label for="text_gradeset" class="left inline">Grade Set:</label>
            <input name="text_gradeset" type="text" id="text_gradeset" placeholder="Code" maxlength="10" oninput="this.value = this.value.toUpperCase()" value="<?php echo isset($text_gradeset) ? $text_gradeset : ''; ?>" />
        </div>
       
        <div class="small-9 medium-9 large-9 columns">
            <label for="text_description" class="left inline">Description:</label>
            <input name="text_description" type="text" id="text_description" placeholder="Description" maxlength="100" oninput="this.value = this.value.toUpperCase()" value="<?php echo isset($text_description) ? $text_description : ''; ?>" />
        </div>
    </div>

    <div class="button-group-option" style="padding: 0px 70px;" data-grouptype="OR">
        <a data-close aria-label="Close modal" class="button alert radius" style="color: #ffffff;">Cancel</a>
        <button class="button primary radius" onclick="getSubjectgradesetSave() "  style="color: #ffffff;">Save</button>

        <input name="posted_" type="hidden" id="posted_" value="TRUE" /> 
        <input name="page" type="hidden" id="page" value="subjectgradeset_overview" />
        <input name="pkey" type="hidden" id="pkey" value="<?php if (isset($text_gradeset)) echo $text_gradeset; ?>" />
        <input name="dialog_aktion" type="hidden" id="dialog_aktion" value="subjectgradeset_create" />
    </div>

    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>

</div>

<!--Subjectset List Reveal-->
<div class="tiny reveal" id="subjectgradelistDialog" data-reveal>

  <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" id="form_subjectgradelist_dialog" name="form_subjectgradelist_dialog" method="post">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <h4>Update Subject Grading:</h4>
            <em style="color: #ddd;">Enter details of Subject grading...!</em>
        </div>
    </div>
  
    <div class="row">
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

    <div class="row">
         <div class="small-4 medium-4 large-4  columns">
            <label for="text_lowscore" class="left inline">Low Score:</label>
            <input name="text_lowscore" type="number" id="text_lowscore" placeholder="0,00" value="<?php echo isset($text_lowscore) ? $text_lowscore : ''; ?>" />
        </div>

        <div class="small-4 medium-4 large-4  columns">
            <label for="text_highscore" class="left inline">High Score:</label>
            <input name="text_highscore" type="number" id="text_highscore" placeholder="0,00" value="<?php echo isset($text_highscore) ? $text_highscore : ''; ?>" />
        </div>  
    </div>

    <div class="row">
         <div class="small-4 medium-4 large-4  columns">
            <label for="text_grade" class="left inline">Grade:</label>
            <input name="text_grade" type="text" id="text_grade" placeholder="Grade..." value="<?php echo isset($text_grade) ? $text_grade : ''; ?>" />
        </div>

        <div class="small-4 medium-4 large-4  columns">
            <label for="text_grade_value" class="left inline">Grade Value:</label>
            <input name="text_grade_value" type="number" id="text_grade_value" placeholder="0,00" value="<?php echo isset($text_grade_value) ? $text_grade_value : ''; ?>" />
        </div>  
    </div>

    <div class="row">
         <div class="small-12 medium-12 large-12 columns">
            <label for="text_comments" class="left inline">Comments:</label>
            <input name="text_comments" type="text" id="text_comments" placeholder="Very Good..." maxlength="100" oninput="this.value = this.value.toUpperCase()"value="<?php echo isset($text_comments) ? $text_comments : ''; ?>" />
        </div>
    </div>


    <div class="button-group-option" style="padding: 0px 70px;" data-grouptype="OR">
        <a data-close aria-label="Close modal" class="button alert radius" style="color: #ffffff;">Cancel</a>
        <button class="button primary radius" onclick="getSubjectsetListSave() "  style="color: #ffffff;">Save</button>
        
        <input name="posted_" type="hidden" id="posted_" value="TRUE" /> 
        <input name="page" type="hidden" id="page" value="subjectgradeset_overview" />
        <input name="subjectgrade_id" type="hidden" id="subjectgrade_id" value="<?php if (isset($subjectgrade_id)) echo $subjectgrade_id; ?>" />
        <input name="list_dialog_aktion" type="hidden" id="list_dialog_aktion" value="subjectgradelist_create" />
    </div>

    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
  </form>
</div>


<script type="text/javascript">

     // When the page is loaded run function
    window.onload = onLoadFunctions(); 

    function onLoadFunctions() {
        console.log('onLoadFunctions()');

    //Set Selected Subjectset code
        var var_subjectset = document.getElementById("selected_subjectgradeset_code").value;
        //Get Subjectset List
        getSubjectsetList(var_subjectset);

    }

    function getSubjectgradesetSave() {
        var text_gradeset = document.getElementById("text_gradeset").value;
        var text_description = document.getElementById("text_description").value;

        var var_aktion = document.getElementById("dialog_aktion").value;

        //alert(var_aktion);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = xhttp.responseText;
              alert(str);
              location.reload();
             //alert(xhttp.responseText);
             //console.log(xhttp.responseText);
            //document.getElementById("subjectsetDialog").innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("POST", encodeURI("/rest/subjectgradeset_save.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";
      if (var_aktion != '') {$post_parameters += "&dialog_aktion=" + var_aktion;}
      if (text_gradeset != '') {$post_parameters += "&gradeset=" + text_gradeset;}
      if (text_description != '') {$post_parameters += "&description=" + text_description;}

      alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getSubjectsetSave()

    function getSubjectGradesetOutput(var_gradeset='') {

        //alert(var_gradeset);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = (xhttp.responseText.replace('[','')).replace(']','');
            var myObj = JSON.parse(str);
            //alert(str);
            document.getElementById("text_gradeset").value = myObj.gradeset;
            document.getElementById("text_description").value = myObj.description;

            document.getElementById("dialog_aktion").value = 'subjectgradeset_update';
            document.getElementById("text_gradeset").disabled = true;
        }
      };
      xhttp.open("POST", encodeURI("/rest/subjectgradeset_output.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";

      if (var_gradeset != '') {$post_parameters += "&gradeset=" + var_gradeset;}

      //alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getSubjectGradesetOutput()


     function getSubjectsetList(var_gradeset) {

        //Set Selected Subjectset code
        document.getElementById("selected_subjectgradeset_code").value = var_gradeset;

        //alert(var_gradeset);

        var xhttp;
            if (var_gradeset == "") {
                document.getElementById("subjectsetlist").innerHTML = "";
                return;
            }
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = xhttp.responseText;
              //alert(str);
             //alert(xhttp.responseText);
             //console.log(xhttp.responseText);
            document.getElementById("subjectgradelist").innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("GET", "/get_subjectgrade_list.php?gradeset="+var_gradeset, true);
      xhttp.send();
    }// end showParentDetail()


    function getSubjectgradesetListOutput(var_subjectgrade_id='') {

        alert(var_subjectgrade_id);

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = (xhttp.responseText.replace('[','')).replace(']','');
            var myObj = JSON.parse(str);
            //alert(str);

            document.getElementById("select_gradeset").value = myObj.gradeset;
            document.getElementById("text_lowscore").value = myObj.lowscore;
            document.getElementById("text_highscore").value = myObj.highscore;
            document.getElementById("text_grade").value = myObj.grade;
            document.getElementById("text_grade_value").value = myObj.gradevalue;
            document.getElementById("text_comments").value = myObj.Comments;

            document.getElementById("subjectgrade_id").value = myObj.SubjectgradeID;

            document.getElementById("list_dialog_aktion").value = 'subjectgradelist_update';
            document.getElementById("select_gradeset").disabled = true
        }
      };
      xhttp.open("POST", encodeURI("/rest/subjectgradelist_output.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";

      if (var_subjectgrade_id != '') {$post_parameters += "&subjectgrade_id=" + var_subjectgrade_id;}

      //alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getSubjectsetListOutput()


    function getSubjectsetListSave() {
        var subjectgrade_id = document.getElementById("subjectgrade_id").value;
        var select_gradeset = document.getElementById("select_gradeset").value;
        var text_lowscore = document.getElementById("text_lowscore").value;
        var text_highscore = document.getElementById("text_highscore").value;
        var text_grade = document.getElementById("text_grade").value;
        var text_grade_value = document.getElementById("text_grade_value").value;
        var text_comments = document.getElementById("text_comments").value;

        var var_aktion = document.getElementById("list_dialog_aktion").value;

        //alert(var_aktion);

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = xhttp.responseText;
              alert(str);
              location.reload();
             //alert(xhttp.responseText);
             //console.log(xhttp.responseText);
            //document.getElementById("subjectsetDialog").innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("POST", encodeURI("/rest/subjectgradesetlist_save.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";
      if (var_aktion != '') {$post_parameters += "&list_dialog_aktion=" + var_aktion;}
      if (subjectgrade_id != '') {$post_parameters += "&subjectgrade_id=" + subjectgrade_id;}
      if (select_gradeset != '') {$post_parameters += "&gradeset=" + select_gradeset;}
      if (text_lowscore != '') {$post_parameters += "&lowscore=" + text_lowscore;}
      if (text_highscore != '') {$post_parameters += "&highscore=" + text_highscore;}
      if (text_grade != '') {$post_parameters += "&grade=" + text_grade;}
      if (text_grade_value != '') {$post_parameters += "&gradevalue=" + text_grade_value;}
      if (text_comments != '') {$post_parameters += "&comments=" + text_comments;}

      alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getSubjectsetlistSave()


    function getSubjectgradeCreate() {
        //Get Selected Subjectset code
       
        document.getElementById("text_gradeset").value = '';
        document.getElementById("text_description").value = '';

        document.getElementById("text_gradeset").disabled=false;

    }

    function getSubjectgradesetListCreate() {
        //Get Selected Subjectset code
        var var_gradeset = document.getElementById("selected_subjectgradeset_code").value;
        alert(var_gradeset);
        document.getElementById("list_dialog_aktion").value = 'subjectgradesetlist_create';

        document.getElementById("select_gradeset").value = var_gradeset;
        document.getElementById("text_lowscore").value = '';
        document.getElementById("text_highscore").value = '';
        document.getElementById("text_grade").value = '';
        document.getElementById("text_grade_value").value = '';
        document.getElementById("text_comments").value = '';

        document.getElementById("select_gradeset").disabled = true;
    }

</script>





<!--Include Footer-->
  <?php 

    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/footer.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-footer.php");
  ?>