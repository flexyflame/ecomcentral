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

    $selected_pggroup_code = "";

    $query_where_temp = "";

    $code = "";
    if (isset($_REQUEST['code'])) { $code = $_REQUEST['code']; }

     $topic = "";
    if (isset($_REQUEST['topic'])) { $topic = $_REQUEST['topic']; }

    if (strcmp($aktion, "pggroup_delete") == 0) {
         $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            if ($code != "") {

                $query = "DELETE FROM pgtopic WHERE code = '" . $code . "';";
                //echo $query;
                $result = DB_Query($dbconn, $query);
                if ($result != false) {

                    $query = "DELETE FROM pggroup WHERE code = '" . $code . "';";
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


    if (strcmp($list_dialog_aktion, "pgtopiclist_delete") == 0) {
         $dbconn = DB_Connect_Direct();                
        if ($dbconn != false) {

            if ($topic != "") {

                $query = "DELETE FROM pgtopic WHERE code = '" . $code . "' AND topic = '" . $topic . "';";
                //echo $query;
                $result = DB_Query($dbconn, $query);
                if ($result != false) {
                    echo "<script>alert('Record DELETED successfullyyyy!');</script>";
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
            $query = "SELECT * FROM pggroup AS PG" . $query_where . " ORDER BY PG.seq ASC;";
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
                <h2 class="title" style="margin-bottom: 0px;">Manage Play Ground Topic Sets</h2>
            </div>
        </div> 
        <hr style="margin: 0px 40px 15px 40px; border-bottom: 1px solid #4c9cb4; max-width: initial;">                    
    </div>

    <!-- content rows -->
    <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_subjectgradeset" name="form_subjectgradeset" method="post">
        <div class="row" style="padding-top:5px">
            <div class="small-12 medium-12 large-12 columns" style="">
                <h5 style="border-bottom: 1px solid #c60f13; margin-left: 18px; color: cadetblue; padding-right: 30px; float: left; width: 85%;">Play Ground Topic Set:</h5>  
                <a class="hollow button" style="font-size: x-large; padding: 5px; margin: -5px 50px 0px; float: right;" title="Create New Play Ground Topic Set" data-open="pggroupDialog" onclick="PGGroupCreate();"><i class="fas fa-plus-square"></i></a>
            </div> 
              
            <div class="large-12 small-centered columns">
                <table class="responsive-card-table  table-expand hover">  
                    <thead>
                            <th width="5%">Seq.</th>
                            <th width="15%">Code</th>
                            <th width="75%">Description</th>
                            <th width="5%">Action</th>
                    </thead>
                    <tbody>
                        <?php
                            $i = 0;
                            foreach ($query_result_array as $obj) {
                                //Get the first subjectset code to display list below
                                if ($i == 0 ) { $selected_pggroup_code = $obj->code; }
                                $i++; 

                                echo "<tr>";

                                echo "  <td valign=\"top\"data-label=\"Code:\">"; 
                                echo        $obj->seq;
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"Code:\">"; 
                                echo "     <a onclick=\"getPGGroupList('" . $obj->code . "')\"><strong style=\"color: crimson; \">" . $obj->code . "</strong></a>";
                                echo "  </td>";
                                
                                echo "  <td valign=\"top\"data-label=\"Description:\">";                             
                                echo        $obj->description;                           
                                echo "  </td>";

                                echo "  <td valign=\"top\"data-label=\"First Name:\">";                     
                                echo "  <a style=\"margin-right: 10px;\" data-open=\"pggroupDialog\"  onclick=\"getPGGroupListOutput('" . $obj->code . "')\"><i class=\"fa fa-edit action-controls\" title=\"Edit Record\"></i> </a>";
                                echo "  <a style=\"margin-right: 10px;\" href=\"" . $SESSION->Generate_Link("pg_topic_group_overview", "page_aktion=pggroup_delete&code=" . $obj->code . "" ) . "\"><i class=\"fa fa-trash action-controls\" title=\"Delete Record\"></i> </a>";
                                                     
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
                <h5 style="border-bottom: 1px solid #ffae00; margin-left: 18px; color: #1779ba; padding-right: 30px; float: left; width: 85%;">Play Group Topic List:</h5>  
                <a class="hollow button" style="font-size: x-large; padding: 5px; margin: -5px 50px 0px; float: right;" title="Play Group Topic"  data-open="pgtopiclistDialog" onclick="getPGTopicListCreate();"><i class="fas fa-plus-square"></i></a>
                <input name="selected_pggroup_code" type="hidden" id="selected_pggroup_code" value="<?php if (isset($selected_pggroup_code)) echo $selected_pggroup_code; ?>" />
            </div> 
            <div class="large-12 small-centered columns" id="pgtopic_list">

            </div>
        </div>
    </form>

</div>

<!--PGGroup Reveal-->
<div class="tiny reveal" id="pggroupDialog" data-reveal>

    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <h4>Update Play Group Topic Set:</h4>
            <em style="color: #ddd;">Enter details of Play Group Topic Set...!</em>
        </div>       
    </div>

     <div class="row">
        <div class="small-4 medium-4 large-4 columns">
            <label for="text_seq" class="left inline">Seq.:</label>
            <input name="text_seq" type="number" id="text_seq" placeholder="Seq"  value="<?php echo isset($text_seq) ? $text_seq : ''; ?>" />
        </div>

        <div class="small-8 medium-8 large-8 columns">
            <label for="text_code" class="left inline">Code:</label>
            <input name="text_code" type="text" id="text_code" placeholder="Code" maxlength="10" oninput="this.value = this.value.toUpperCase()" value="<?php echo isset($text_code) ? $text_code : ''; ?>" />
        </div>
    </div>
  
    <div class="row">        
        <div class="small-12 medium-12 large-12 columns">
            <label for="text_description" class="left inline">Description:</label>
            <input name="text_description" type="text" id="text_description" placeholder="Description" maxlength="100" oninput="this.value = this.value.toUpperCase()" value="<?php echo isset($text_description) ? $text_description : ''; ?>" />
        </div>
    </div>

    <div class="button-group-option" style="padding: 0px 70px;" data-grouptype="OR">
        <a data-close aria-label="Close modal" class="button alert radius" style="color: #ffffff;">Cancel</a>
        <button class="button primary radius" onclick="getPGGroupSave() "  style="color: #ffffff;">Save</button>

        <input name="posted_" type="hidden" id="posted_" value="TRUE" /> 
        <input name="page" type="hidden" id="page" value="pg_topic_group_overview" />
        <!--<input name="pkey" type="hidden" id="pkey" value="<?php if (isset($selected_pggroup_code)) echo $selected_pggroup_code; ?>" />-->
        <input name="dialog_aktion" type="hidden" id="dialog_aktion" value="pggroup_create" />
    </div>

    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>

</div>

<!--PG Topic Reveal-->
<div class="tiny reveal" id="pgtopiclistDialog" data-reveal>

  <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" id="form_subjectgradelist_dialog" name="form_subjectgradelist_dialog" method="post">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <h4>Update Play Group Topic:</h4>
            <em style="color: #ddd;">Enter details of Play Group Topic...!</em>
        </div>
    </div>
  
    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <label for="select_code" class="left inline">PG Group:</label>
            <?php
                $code_selektiert = -1;
                if (isset($select_pggroupcode)) {
                    $code_selektiert = $select_pggroupcode;
                }
                $select_id = "select_code";
                $select_name = "select_code";
                $select_size = 1;
                $select_extra_code = 'disabled';
                $arr_option_values = array('' => '');
                echo $UTIL->SELECT_PGGroup($code_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
            ?>
        </div>
    </div>

     <div class="row">
        <div class="small-4 medium-4 large-4 columns">
            <label for="text_seq_list" class="left inline">Seq.:</label>
            <input name="text_seq_list" type="number" id="text_seq_list" placeholder="Seq"  value="" />
        </div>

        <div class="small-8 medium-8 large-8 columns">
            <label for="text_topic" class="left inline">Topic:</label>
            <input name="text_topic" type="text" id="text_topic" placeholder="Topic" maxlength="10" oninput="this.value = this.value.toUpperCase()" value="" />
        </div>
    </div>
  
    <div class="row">        
        <div class="small-12 medium-12 large-12 columns">
            <label for="text_description_list" class="left inline">Description:</label>
            <input name="text_description_list" type="text" id="text_description_list" placeholder="Description" maxlength="100" oninput="this.value = this.value.toUpperCase()" value="" />
        </div>
    </div>

    <div class="button-group-option" style="padding: 0px 70px;" data-grouptype="OR">
        <a data-close aria-label="Close modal" class="button alert radius" style="color: #ffffff;">Cancel</a>
        <button class="button primary radius" onclick="PGTopicListSave() "  style="color: #ffffff;">Save</button>
        
        <input name="posted_" type="hidden" id="posted_" value="TRUE" /> 
        <input name="page" type="hidden" id="page" value="pg_topic_group_overview" />
        <!--<input name="subjectgrade_id" type="hidden" id="subjectgrade_id" value="<?php if (isset($subjectgrade_id)) echo $subjectgrade_id; ?>" />-->
        <input name="list_dialog_aktion" type="hidden" id="list_dialog_aktion" value="pgtopiclist_create" />
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
        var var_code = document.getElementById("selected_pggroup_code").value;
        //Get Subjectset List
        getPGGroupList(var_code);

    }

    function getPGGroupSave() {
        console.log('getPGGroupSave()');

        var text_seq = document.getElementById("text_seq").value;
        var text_code = document.getElementById("text_code").value;
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
      xhttp.open("POST", encodeURI("/rest/pggroup_save.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";
      if (var_aktion != '') {$post_parameters += "&dialog_aktion=" + var_aktion;}
      if (text_seq != '') {$post_parameters += "&seq=" + text_seq;}
      if (text_code != '') {$post_parameters += "&code=" + text_code;}
      if (text_description != '') {$post_parameters += "&description=" + text_description;}

      //alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getPGGroupSave()

    function getPGGroupListOutput(var_code='') {
        console.log('getPGGroupListOutput()');

        //alert(var_gradeset);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = (xhttp.responseText.replace('[','')).replace(']','');
            var myObj = JSON.parse(str);
            //alert(str);
            document.getElementById("text_seq").value = myObj.seq;
            document.getElementById("text_code").value = myObj.code;
            document.getElementById("text_description").value = myObj.description;

            document.getElementById("dialog_aktion").value = 'pggroup_update';
            document.getElementById("text_code").disabled = true;
        }
      };
      xhttp.open("POST", encodeURI("/rest/pggroup_output.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";

      if (var_code != '') {$post_parameters += "&code=" + var_code;}

      //alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getPGGroupListOutput()


     function getPGGroupList(var_code) {
        console.log('getPGGroupList()');

        //Set Selected Subjectset code
        document.getElementById("selected_pggroup_code").value = var_code;

        //alert(var_code);

        var xhttp;
            if (var_code == "") {
                document.getElementById("pgtopic_list").innerHTML = "";
                return;
            }
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = xhttp.responseText;
              //alert(str);
             //alert(xhttp.responseText);
             //console.log(xhttp.responseText);
            document.getElementById("pgtopic_list").innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("GET", "/get_pgtopic_list.php?code="+var_code, true);
      xhttp.send();
    }// end getPGGroupList()


    function getPGTipicListOutput(var_code='', var_topic) {
        console.log('getPGTipicListOutput()');

        //alert(var_code + ' : ' + var_topic);

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var str = (xhttp.responseText.replace('[','')).replace(']','');
            var myObj = JSON.parse(str);
            //alert(str);

            document.getElementById("select_code").value = myObj.code;
            document.getElementById("text_seq_list").value = myObj.seq;
            document.getElementById("text_topic").value = myObj.topic;
            document.getElementById("text_description_list").value = myObj.description;

            document.getElementById("list_dialog_aktion").value = 'pgtopiclist_update';
            document.getElementById("text_topic").disabled = true;
        }
      };
      xhttp.open("POST", encodeURI("/rest/pgtopiclist_output.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";

      if (var_code != '') {$post_parameters += "&code=" + var_code;}
      if (var_topic != '') {$post_parameters += "&topic=" + var_topic;}

      //alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end getSubjectsetListOutput()


    function PGTopicListSave() {
        console.log('PGTopicListSave()');

        //var subjectgrade_id = document.getElementById("subjectgrade_id").value;
        var select_code = document.getElementById("select_code").value;
        var text_seq_list = document.getElementById("text_seq_list").value;
        var text_topic = document.getElementById("text_topic").value;
        var text_description_list = document.getElementById("text_description_list").value;

        var var_aktion = document.getElementById("list_dialog_aktion").value;

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
      xhttp.open("POST", encodeURI("/rest/pgtopiclist_save.php?"), true);
      xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

      $post_parameters = "test=test";
      if (var_aktion != '') {$post_parameters += "&list_dialog_aktion=" + var_aktion;}
      if (select_code != '') {$post_parameters += "&code=" + select_code;}
      if (text_seq_list != '') {$post_parameters += "&seq=" + text_seq_list;}
      if (text_topic != '') {$post_parameters += "&topic=" + text_topic;}
      if (text_description_list != '') {$post_parameters += "&description=" + text_description_list;}

      //alert($post_parameters);

      xhttp.send($post_parameters);

      return;
    }// end PGTopicListSave()

     function PGGroupCreate() {
        console.log('PGGroupCreate()');
        //Get Selected PGGroup code

        document.getElementById("text_seq").value = '';
        document.getElementById("text_code").value = '';
        document.getElementById("text_description").value = '';

        document.getElementById("text_code").disabled = false;


    } //end PGGroupCreate()

    function getPGTopicListCreate() {
        console.log('getPGTopicListCreate()');
        //Get Selected PGGroup code
        var var_code = document.getElementById("selected_pggroup_code").value;
        //alert(var_code);
        document.getElementById("list_dialog_aktion").value = 'pgtopiclist_create';

        document.getElementById("select_code").value = var_code;
        document.getElementById("text_seq_list").value = '';
        document.getElementById("text_topic").value = '';
        document.getElementById("text_description_list").value = '';

        document.getElementById("text_topic").disabled = false;
    } //end  getPGTopicListCreate()

</script>





<!--Include Footer-->
  <?php 

    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/footer.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-footer.php");
  ?>