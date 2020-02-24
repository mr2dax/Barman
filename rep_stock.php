<?php 
# Settings & functions
require 'config.php';
require 'functions.php';

# Constructing a query to get date of latest inventory.
$inv_table = "Inventory";
$inv_query = "SELECT MAX(`ID`) AS `ID`, MAX(`Inv_Date`) AS `Latest` FROM " . $inv_table . " WHERE 1=1";
# Fetch results.
$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_query);
while($row = mysql_fetch_array($query_result)) {
	$date=$row['Latest'];
	$id=$row['ID'];
}
# Constructing a query to get all requisitions since previous inventory.
$req_table = "Requisition";
$req_query = "SELECT `Requisition` FROM " . $req_table . " WHERE `Req_Date`>=\"" . $date . "\"";
# Fetch results.
$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $req_query);
while($row = mysql_fetch_array($query_result)) {
	$reqs=$reqs . "," .  $row['Requisition'];
}
$reqs = substr($reqs,1,strlen($reqs)-1);
# Print site.
echo "<!DOCTYPE html PUBLIC\"-//W3C/DTD XHTML 1.0 Strict//EN\"\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\"><html><head><title> Consumption Report </title>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\"></head><body><h1>Stock as of " . date("Y-m-d") . "</h1>";
echo "<form name=logout method=POST action=\"" . CONTROLLER . "\">";
echo "<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>";
# Constructing the query.
$inv_table = "Inventory";
$inv_query = "SELECT Inventory FROM " . $inv_table . " WHERE ID=" . $id;
# Fetch results.
$inv_query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_query);
# Draw results table.
$table_cols = array("name", "volume","stock");
print_table_headers($table_cols);
print_stock_table($inv_query_result,$db_name,$db_service,$db_user,$db_pass,$reqs);
# Frees up memory that is allocated for the query.
mysql_free_result($inv_query_result);
?>