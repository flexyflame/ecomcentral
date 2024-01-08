
<?php  
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

    $parent_id = 0;
    if (isset($_GET['parent_id'])) { $parent_id = $_GET['parent_id']; }

    // Call Data
	  $dbconn = DB_Connect_Direct();
	  $query = "SELECT * FROM parents WHERE id='" . $parent_id . "';";
	   //echo $query;
	  $result = DB_Query($dbconn, $query);
	  if ($result != false) {
	    $obj = DB_FetchObject($result);

	    //Fill variables with data

	    $error_type = 'call_data_success';
	    DB_FreeResult($result);
	  
	  } else {
	    $error_type = 'call_data_fail';
	    print("Editing of Member details failed");
	  } // end if ($result != false);0     
 	  DB_Close($dbconn);

	  	echo "	<div class=\"small-12 medium-12 large-12 columns\">";
	  	echo "		<span>" . $obj->Name . "</span>";
	  	echo "	</div>";
		echo "	<div class=\"small-12 medium-12 large-12 columns\">";
		echo "		<span>" . $obj->addr1 . ", " . $obj->addr2 . " , " . $obj->addr3 . " </span>";
		echo "	</div>";
		echo "	<div class=\"small-12 medium-12 large-12 columns\">";
		echo "		<span>" . $obj->Tel2 . " / " . $obj->Tel1 . " </span>";
		echo "	</div>";
		echo "	<div class=\"small-12 medium-12 large-12 columns\">";
		echo "		<span>" . $obj->email . " </span>";
		echo "	</div>";
		echo "	<div class=\"small-12 medium-4 large-4 columns\">";
		echo "		<span><strong>Relation: </strong>" . Get_Relation($obj->ptype) . " </span>";
		echo "	</div>";
		echo "	<div class=\"small-12 medium-4 large-4 columns\">";
		echo "		<span><strong>Profession: </strong>" . Get_Profession($obj->profession) . " </span>";
		echo "	</div>";
		echo "	<div class=\"small-12 medium-4 large-4 columns\">";
		echo "		<span><strong>PTA Executive: </strong>" . ($obj->ptaexec == 0 ? 'No' : 'Yes') . " </span>";
		echo "	</div>";

?>