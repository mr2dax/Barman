<?php 
# Settings & functions
require 'config.php';
require 'functions.php';

if (isset($_POST["inv_dates"])) {
	$id=$_POST["inv_dates"];
	# Constructing a query to get id of the selected inventory.
	$inv_table = "Inventory";
	$inv_query = "SELECT `Inv_Date` FROM " . $inv_table . " WHERE `ID`=\"" . $id . "\"";
	# Fetch results.
	$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_query);
	while($row = mysql_fetch_array($query_result)) {
		$date=$row['Inv_Date'];
	}
	$title_date = substr($date,0,10) . " selected.";
} else {
	# Constructing a query to get date of latest inventory.
	$inv_table = "Inventory";
	$inv_query = "SELECT MAX(`ID`) AS `ID`, MAX(`Inv_Date`) AS `Latest` FROM " . $inv_table . " WHERE 1=1";
	# Fetch results.
	$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_query);
	while($row = mysql_fetch_array($query_result)) {
		$date=$row['Latest'];
		$id=$row['ID'];
		$title_date = "latest inventory (" . substr($date,0,10) . ").";
	}
}
# Constructing a query to get date of previous inventory.
$inv_table = "Inventory";
$inv_query = "SELECT `ID`,`Inv_Date` FROM " . $inv_table . " WHERE `Inv_Date`<\"" . $date . "\" ORDER BY ID DESC LIMIT 1";
# Fetch results.
$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_query);
while($row = mysql_fetch_array($query_result)) {
	$prev_date=$row['Inv_Date'];
	$prev_date_id=$row['ID'];
}
if($prev_date<>"") {
	# Constructing a query to get all requisitions since previous inventory.
	$req_table = "Requisition";
	$req_query = "SELECT `Requisition` FROM " . $req_table . " WHERE `Req_Date`<=\"" . $date . "\" AND `Req_Date`>=\"" . $prev_date . "\"";
	# Fetch results.
	$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $req_query);
	while($row = mysql_fetch_array($query_result)) {
		$reqs=$reqs . "," .  $row['Requisition'];
	}
	$reqs = substr($reqs,1,strlen($reqs)-1);
	# Constructing a query to get all wastages since previous inventory.
	$waste_table = "Wastage";
	$waste_query = "SELECT `Name`, `Vol` FROM `" . $waste_table . "` WHERE `Date`<=\"" . $date . "\" AND `Date`>=\"" . $prev_date . "\"";
	# Fetch results.
	$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $waste_query);
	while($row = mysql_fetch_array($query_result)) {
		$wastes=$wastes . "," .  $row['Name'] . "-" . $row['Vol'];
	}
	$wastes = substr($wastes,1,strlen($wastes)-1);
	echo "<!DOCTYPE html PUBLIC\"-//W3C/DTD XHTML 1.0 Strict//EN\"\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\"><html><head><title> Consumption Report </title>";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\"></head><body><h1>Consumption Report of " . $title_date . "</h1></br><form action=\"\" method=\"POST\" id=\"inv_date_select\">";
	echo "Select Inventory Date: <select name=\"inv_dates\">";
	# Constructing a query to get all inventories.
	$inv_table = "Inventory";
	$inv_query = "SELECT `ID`, `Inv_Date` FROM " . $inv_table . " WHERE 1=1";
	# Fetch results.
	$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_query);
	# Draw drop-down list.
	print_inv_dates($query_result, $selected);
	# Frees up memory that is allocated for the query.
	mysql_free_result($query_result);
	echo "</select>";
	echo "<input type=\"submit\" value=\"Select\" /></form></br></br><form name=logout method=POST action=\"" . CONTROLLER . "\">";
	echo "<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>";
	# Constructing the query.
	$inv_table = "Inventory";
	$prev_inv_query = "SELECT Inventory FROM " . $inv_table . " WHERE ID=" . $prev_date_id;
	# Fetch results.
	$prev_inv_query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $prev_inv_query);
	# Constructing the query.
	$inv_table = "Inventory";
	$inv_query = "SELECT Inventory FROM " . $inv_table . " WHERE ID=" . $id;
	# Fetch results.
	$inv_query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_query);
	# Draw results table.
	$table_cols = array("name", "volume","previous </br>inventory</br>" . substr($prev_date,0,10),"requisitions</br> between</br> " . substr($prev_date,0,10) . " and " . substr($date,0,10),"Losses","selected </br>inventory</br>" . substr($date,0,10)," amount consumed","retail cost", "sold price");
	print_table_headers($table_cols);
	print_cons_rep_table($inv_query_result,$db_name,$db_service,$db_user,$db_pass,$reqs,$wastes,$prev_inv_query_result);
	# Frees up memory that is allocated for the query.
	mysql_free_result($inv_query_result);
} else{
	echo "No previous inventory to relate to. This must be the starting inventory.";
	echo "</br></br><form name=logout method=POST action=\"" . CONTROLLER . "\">";
	echo "<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>";
}
?>