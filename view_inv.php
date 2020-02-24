<?php 
# Settings & functions
require 'config.php';
require 'functions.php';

# Set query parameters to find the desired beverage item to be edited.
$id = $_GET["inv"];
# Constructing a query to get date of inventory.
$inv_table = "Inventory";
$inv_query = "SELECT Inv_Date FROM " . $inv_table . " WHERE ID=" . $id;
# Fetch results.
$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_query);
while($row = mysql_fetch_array($query_result)) {
	$date=$row['Inv_Date'];
}
?>
<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title> Inventory Sheet View </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<h1>Viewing Inventory Sheet from <?php echo substr($date,0,10); ?></h1></br>
<form name=logout method=POST action="<?php echo CONTROLLER; ?>">
<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>
<?php
# Constructing the query.
$inv_table = "Inventory";
$inv_query = "SELECT Inventory FROM " . $inv_table . " WHERE ID=" . $id;
# Fetch results.
$inv_query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_query);
# Draw results table.
$table_cols = array("name", "volume","amount");
print_table_headers($table_cols);
print_inv_view_table($inv_query_result,$db_name,$db_service,$db_user,$db_pass);
# Frees up memory that is allocated for the query.
mysql_free_result($inv_query_result);
?>