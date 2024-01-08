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

    
     $selected_subjectset_code = "";

     $query_where_temp = "";

    $pkey = "";
    if (isset($_GET['pkey'])) { $pkey = $_GET['pkey']; }

    $subjectcode = "";
    if (isset($_GET['subjectcode'])) { $subjectcode = $_GET['subjectcode']; }

 
    if (strcmp($aktion, "subjectset_delete") == 0) {
         $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            if ($pkey != "") {

                
                $query = "DELETE FROM subjectsetlist WHERE subjectset = '" . $pkey . "';";
                //echo $query;
                $result = DB_Query($dbconn, $query);
                if ($result != false) {

                    $query = "DELETE FROM subjectset WHERE pkey = '" . $pkey . "';";
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


    if (strcmp($list_dialog_aktion, "subjectsetlist_delete") == 0) {
         $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            if ($pkey != "") {
                $query = "DELETE FROM subjectsetlist WHERE subjectset = '" . $pkey . "' AND subjectcode = '" . $subjectcode . "';";
                //echo $query;
                $result = DB_Query($dbconn, $query);
                if ($result != false) {
                    echo "<script>alert('Record DELETED successfullyy!');</script>";
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
            $query = "SELECT * FROM subjectset AS S" . $query_where . ";";
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
                <h2 class="title" style="margin-bottom: 0px;">Manage Subject Sets</h2>
            </div>
        </div> 
        <hr style="margin: 0px 40px 15px 40px; border-bottom: 1px solid #4c9cb4; max-width: initial;">                    
    </div>

    <!-- content rows -->
    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_subjectset" name="form_subjectset" method="post">
        <div class="row" style="padding-top:5px">
            <div class="small-12 medium-12 large-12 columns" style="">
                <h5 style="border-bottom: 1px solid #c60f13; margin-left: 41px; color: cadetblue; padding-right: 30px; float: left; width: 80%;">Subject Set:</h5>  
                <a class="hollow button" style="font-size: x-large; padding: 5px; margin: -5px 50px 0px; float: right;" title="Create New Subject Set" data-open="subjectsetDialog" onclick="getSubjectsetCreate();"><i class="fas fa-plus-square"></i></a>
            </div> 
              
            <div class="large-12 small-centered columns">
                <table class="responsive-card-table  table-expand hover">  
                    <thead>
                            <th width="5%">Code</th>
                            <th width="25%">Description</th>
                            <th width="10%">Level</th>                            
                            <th width="10%">Class</th>
                            <th width="15%">Grade Set</th>
                            <th width="5%">Action</th>
                    </thead>
                    <tbody>
                        <?php
                            $i = 0;
                            foreach ($query_result_array as $obj) {
                                //Get the first subjectset code to display list below
                                if ($i == 0 ) { $selected_subjectset_code = $obj->pkey; }
                                $i++; 

                                echo "<tr>";

                                echo "  <td valign=\"top\"data-label=\"Code:\">"; 
                                echo "     <a onclick=\"getSubjectsetList('" . $obj->pkey . "')\"><strong style=\"color: crimson; \">" . $obj->pkey . "</strong></a>";
                                echo "  </td>";
                                
                                echo "  <td valign=\"top\"data-label=\"Description:\">";                             
                                echo        $obj->description;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Level:\">";                             
                                echo        Get_Subject_Level($obj->level);                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Class:\">";                             
                                echo        DB_Grade_name($obj->grade);                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Total:\">";                             
                                echo        DB_Subject_Gradeset_description($obj->gradeset);            
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"First Name:\">";                     
                                echo "  <a style=\"margin-right: 10px;\" data-open=\"subjectsetDialog\"  onclick=\"getSubjectsetOutput('" . $obj->pkey . "')\"><i class=\"fa fa-edit action-controls\" title=\"Edit Record\"></i> </a>";
                                echo "  <a style=\"margin-right: 10px;\" href=\"" . $SESSION->Generate_Link("subjectset_overview", "page_aktion=subjectset_delete&pkey=" . $obj->pkey . "" ) . "\"><i class=\"fa fa-trash action-controls\" title=\"Delete Record\"></i> </a>";
                                                     
                                echo "  </td>";

                                echo "</tr>";
                            } // end foreach ($query_result_array as $obj);
                        ?>                
                    </tbody>
                </table>
            </div>

            
            
        </div>
    </form>

    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_subjectset" name="form_subjectset" method="post">
        <div class="row" style="padding-top:5px">
            <div class="small-12 medium-12 large-12 columns" style="">
                <h5 style="border-bottom: 1px solid #ffae00; margin-left: 41px; color: #1779ba; padding-right: 30px; float: left; width: 80%;">Subject Set List:</h5>  
                <a class="hollow button" style="font-size: x-large; padding: 5px; margin: -5px 50px 0px; float: right;" title="Add Subject"  data-open="subjectsetlistDialog" onclick="getSubjectsetListCreate();"><i class="fas fa-plus-square"></i></a>
                <input name="selected_subjectset_code" type="hidden" id="selected_subjectset_code" value="<?php if (isset($selected_subjectset_code)) echo $selected_subjectset_code; ?>" />
            </div> 
            <div class="large-12 small-centered columns" id="subjectsetlist">

            </div>
        </div>
    </form>

</div>

<!--Subjectset Reveal-->
<div class="tiny reveal" id="subjectsetDialog" data-reveal>

  <!--<form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" id="form_subjectset_dialog" name="form_subjectset_dialog" method="post">-->
    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <h4>Update Subject Set:</h4>
            <em style="color: #ddd;">Enter details of Subject Set...!</em>
        </div>
    </div>
  
    <div class="row">
        <div class="small-12 medium-6 large-6 columns">
            <label for="text_pkey" class="left inline">Code:</label>
            <input name="text_pkey" type="text" id="text_pkey" placeholder="Code" maxlength="10" oninput="this.value = this.value.toUpperCase()" value="<?php echo isset($text_pkey) ? $text_pkey : ''; ?>" />
        </div>
       
        <div class="small-12 medium-12 large-12 columns">
            <label for="text_description" class="left inline">Description:</label>
            <input name="text_description" type="text" id="text_description" placeholder="Description" maxlength="100" oninput="this.value = this.value.toUpperCase()" value="<?php echo isset($text_description) ? $text_description : ''; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="small-12 medium-6 large-6 columns">
            <label for="select_level" class="left inline">Level:</label>
            <?php
                $level_selektiert = 0;
                if (isset($select_level)) {
                    $level_selektiert = $select_level;
                }
                $select_id = "select_level";
                $select_name = "select_level";
                $select_size = 1;
                $select_extra_code = '';
                $db_conn_opt = false;
                $arr_option_values = array('' => '');
                echo $UTIL->SELECT_Subject_Level($level_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
            ?>
        </div>

        <div class="small-12 medium-6 large-6 columns  columns">
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

        <div class="small-12 medium-8 large-8  columns">
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
        <button class="button primary radius" onclick="getSubjectsetSave() "  style="color: #ffffff;">Save</button>

        <input name="posted_" type="hidden" id="posted_" value="TRUE" /> 
        <input name="page" type="hidden" id="page" value="subjectset_overview" />
        <input name="pkey" type="hidden" id="pkey" value="<?php if (isset($text_pkey)) echo $text_pkey; ?>" />
        <input name="dialog_aktion" type="hidden" id="dialog_aktion" value="subjectset_create" />
    </div>

    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
  <!--</form>-->
</div>

<!--Subjectset List Reveal-->
<div class="tiny reveal" id="subjectsetlistDialog" data-reveal>

  <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" id="form_subjectsetlist_dialog" name="form_subjectsetlist_dialog" method="post">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <h4>Update Subject Set List:</h4>
            <em style="color: #ddd;">Enter details of Subject Set List...!</em>
        </div>
    </div>
  
    <div class="row">
        <div class="small-12 medium-8 large-8 columns">
            <label for="select_subjectset" class="left inline">Subject Set:</label>
            <?php
                $subjectset_selektiert = -1;
                if (isset($select_subjectset)) {
                    $subjectset_selektiert = $select_subjectset;
                }
                $select_id = "select_subjectset";
                $select_name = "select_subjectset";
                $select_size = 1;
                $select_extra_code = 'disabled';
                $arr_option_values = array('' => '');
                echo $UTIL->SELECT_SubjectSet($subjectset_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
            ?>
        </div>
       
        <div class="small-12 medium-12 large-12 columns">
            <label for="select_subjectcode" class="left inline">Subject Code:</label>
            <?php
                $subjectcode_selektiert = -1;
                if (isset($select_subjectcode)) {
                    $subjectcode_selektiert = $select_subjectcode;
                }
                $select_id = "select_subjectcode";
                $select_name = "select_subjectcode";
                $select_size = 1;
                $select_extra_code = 'onchange="Select_Subjectcode_OnChange(this.value);"';
                $arr_option_values = array('' => '');
                echo $UTIL->SELECT_SubjectCode($subjectcode_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
            ?>
        </div>
    </div>

    <div class="row">
         <div class="small-6 medium-6 large-6 columns">
            <label for="text_test" class="left inline">Class Test:</label>
            <input name="text_test" type="number" id="text_test" placeholder="Test" value="<?php echo isset($text_test) ? $text_test : ''; ?>" />
        </div>

        <div class="small-6 medium-6 large-6 columns">
            <label for="text_exam" class="left inline">Exam Result:</label>
            <input name="text_exam" type="number" id="text_exam" placeholder="Exam" value="<?php echo isset($text_exam) ? $text_exam : ''; ?>" />
        </div>  

        <div class="small-12 medium-8 large-8 columns">
            <label for="select_list_gradeset" class="left inline">Grade Set:</label>
            <?php
                $gradeset_selektiert_2 = -1;
                if (isset($select_list_gradeset)) {
                    $gradeset_selektiert_2 = $select_list_gradeset;
                }
                $select_id = "select_list_gradeset";
                $select_name = "select_list_gradeset";
                $select_size = 1;
                $select_extra_code = '';
                $arr_option_values = array('' => '');
                echo $UTIL->SELECT_Gradeset($gradeset_selektiert_2, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
            ?>
        </div>

    </div>

    <!--<div class="row">
        <div class="small-6 medium-6 large-6 columns">
            <label for="select_teacher" class="left inline">Teacher:</label>
            <?php
                $gradeset_selektiert = -1;
                if (isset($select_teacher)) {
                    $gradeset_selektiert = $select_teacher;
                }
                $select_id = "select_teacher";
                $select_name = "select_teacher";
                $select_size = 1;
                $select_extra_code = '';
                $arr_option_values = array('' => '');
                echo $UTIL->SELECT_Gradeset($gradeset_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
            ?>
        </div>
    </div>-->

    <div class="button-group-option" style="padding: 0px 70px;" data-grouptype="OR">
        <a data-close aria-label="Close modal" class="button alert radius" style="color: #ffffff;">Cancel</a>
        <button class="button primary radius" onclick="getSubjectsetListSave() "  style="color: #ffffff;">Save</button>
        
        <input name="posted_" type="hidden" id="posted_" value="TRUE" /> 
        <input name="page" type="hidden" id="page" value="subjectset_overview" />
        <input name="select_list_gradeset" type="hidden" id="select_list_gradeset" value="<?php if (isset($select_list_gradeset)) echo $select_list_gradeset; ?>" />
        <input name="select_subjectcode" type="hidden" id="select_subjectcode" value="<?php if (isset($select_subjectcode)) echo $select_subjectcode; ?>" />
        <input name="list_dialog_aktion" type="hidden" id="list_dialog_aktion" value="subjectsetlist_create" />
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
        var var_subjectset = document.getElementById("selected_subjectset_code").value;
        //Get Subjectset List
        getSubjectsetList(var_subjectset);

    }

    function getSubjectsetSave() {
        var text_pkey = document.getElementById("text_pkey").value;
        var text_description = document.getElementById("text_description").value;
        var select_level = document.getElementById("select_level").value;
        var select_grade = document.getElementById("select_grade").value;
        var select_gradeset = document.getElementById("select_gradeset").value;

        var var_aktion = document.getElementById("dialog_aktion").value;

        //alert(var_aktion);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = xhttp.responseText;
              //alert(str);
              location.reload();
             //alert(xhttp.responseText);
             //console.log(xhttp.responseText);
            //document.getElementById("subjectsetDialog").innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("POST", encodeURI("/rest/subjectset_save.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";
      if (var_aktion != '') {$post_parameters += "&dialog_aktion=" + var_aktion;}
      if (text_pkey != '') {$post_parameters += "&pkey=" + text_pkey;}
      if (text_description != '') {$post_parameters += "&description=" + text_description;}
      if (select_level != '') {$post_parameters += "&level=" + select_level;}
      if (select_grade != '') {$post_parameters += "&grade=" + select_grade;}
      if (select_gradeset != '') {$post_parameters += "&gradeset=" + select_gradeset;}

      //alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getSubjectsetSave()

    function getSubjectsetOutput(var_pkey='') {

        //alert(var_pkey);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = (xhttp.responseText.replace('[','')).replace(']','');
            var myObj = JSON.parse(str);
            //alert(str);
            document.getElementById("text_pkey").value = myObj.pkey;
            document.getElementById("text_description").value = myObj.description;
            document.getElementById("select_level").value = myObj.level;
            document.getElementById("select_grade").value = myObj.grade;
            document.getElementById("select_gradeset").value = myObj.gradeset;

            document.getElementById("dialog_aktion").value = 'subjectset_update';
        }
      };
      xhttp.open("POST", encodeURI("/rest/subjectset_output.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";

      if (var_pkey != '') {$post_parameters += "&pkey=" + var_pkey;}

      //alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getSubjectsetOutput()


     function getSubjectsetList(var_subjectset) {

        //Set Selected Subjectset code
        document.getElementById("selected_subjectset_code").value = var_subjectset;

        //alert(var_subjectset);

        var xhttp;
            if (var_subjectset == "") {
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
            document.getElementById("subjectsetlist").innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("GET", "/get_subjectset_list.php?subjectset="+var_subjectset, true);
      xhttp.send();
    }// end showParentDetail()


    function getSubjectsetListOutput(var_subjectset='', var_subjectcode='') {

        //alert(var_subjectset + ' : ' + var_subjectcode);

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = (xhttp.responseText.replace('[','')).replace(']','');
            var myObj = JSON.parse(str);
            //alert(str);

            document.getElementById("select_subjectset").value = myObj.subjectset;
            document.getElementById("select_subjectcode").value = myObj.subjectcode;
            document.getElementById("text_test").value = myObj.test;
            document.getElementById("text_exam").value = myObj.exam;
            document.getElementById("select_list_gradeset").value = myObj.gradeset;
            //document.getElementById("select_teacher").value = myObj.teacher;

            document.getElementById("list_dialog_aktion").value = 'subjectsetlist_update';
            document.getElementById("select_subjectcode").disabled = true;
        }
      };
      xhttp.open("POST", encodeURI("/rest/subjectsetlist_output.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";

      if (var_subjectset != '') {$post_parameters += "&subjectset=" + var_subjectset;}
      if (var_subjectcode != '') {$post_parameters += "&subjectcode=" + var_subjectcode;}

      //alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getSubjectsetListOutput()


    function getSubjectsetListSave() {
        var select_subjectset = document.getElementById("select_subjectset").value;
        var select_subjectcode = document.getElementById("select_subjectcode").value;
        var text_test = document.getElementById("text_test").value;
        var text_exam = document.getElementById("text_exam").value;
        var select_list_gradeset = document.getElementById("select_list_gradeset").value;

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
      xhttp.open("POST", encodeURI("/rest/subjectsetlist_save.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";
      if (var_aktion != '') {$post_parameters += "&list_dialog_aktion=" + var_aktion;}
      if (select_subjectset != '') {$post_parameters += "&subjectset=" + select_subjectset;}
      if (select_subjectcode != '') {$post_parameters += "&subjectcode=" + select_subjectcode;}
      if (text_test != '') {$post_parameters += "&test=" + text_test;}
      if (text_exam != '') {$post_parameters += "&exam=" + text_exam;}
      if (select_list_gradeset != '') {$post_parameters += "&gradeset=" + select_list_gradeset;}

      alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getSubjectsetlistSave()


    function Select_Subjectcode_OnChange(var_pkey='') {

        //alert(var_pkey);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = (xhttp.responseText.replace('[','')).replace(']','');
            var myObj = JSON.parse(str);
            //alert(str);
            document.getElementById("text_test").value = myObj.test;
            document.getElementById("text_exam").value = myObj.exam;
            document.getElementById("select_list_gradeset").value = myObj.gradeset;
        }
      };
      xhttp.open("POST", encodeURI("/rest/subject_output.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";

      if (var_pkey != '') {$post_parameters += "&pkey=" + var_pkey;}

      //alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getSubjectsetOutput()


    function getSubjectsetCreate() {
        //Get Selected Subjectset code
       
        document.getElementById("text_pkey").value = '';
        document.getElementById("text_description").value = '';
        document.getElementById("select_level").value = '';
        document.getElementById("select_grade").value = '';
        document.getElementById("select_gradeset").value = '';
    }

    function getSubjectsetListCreate() {
        //Get Selected Subjectset code
        var var_subjectset = document.getElementById("selected_subjectset_code").value;
        //alert(var_subjectset);
        document.getElementById("list_dialog_aktion").value = 'subjectsetlist_create';

        document.getElementById("select_subjectset").value = var_subjectset;
        document.getElementById("select_subjectcode").value = '';
        document.getElementById("text_test").value = '';
        document.getElementById("text_exam").value = '';
        document.getElementById("select_list_gradeset").value = '';

        document.getElementById("select_subjectset").disabled = true;
    }

</script>





<!--Include Footer-->
  <?php 

    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/footer.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-footer.php");
  ?>