<?php
# Settings
require 'config.php';
require 'functions.php';
?>
<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title> Inventory Entry </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<h1>Inventory Entry</h1></br>
<form name=logout method=POST action="<?php echo CONTROLLER; ?>">
<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>
<form action="" method="POST">
<input type="date" name="inv_date" autofocus ><br /><br />
<?php
# Constructing the query.
$bev_table = "Beverages";
$bev_query = "SELECT ID , Name, Vol FROM " . $bev_table . " WHERE Stock_Need=1";
# Fetch results.
$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $bev_query);
# Constructing a query to get date of latest inventory.
$inv_table = "Inventory";
$inv_date_query = "SELECT MAX(`ID`) AS `ID`, MAX(`Inv_Date`) AS `Latest` FROM " . $inv_table . " WHERE 1=1";
# Fetch results.
$inv_date_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_date_query);
while($row = mysql_fetch_array($inv_date_result)) {
	$latest_date=substr($row['Latest'],0,10);
	$id=$row['ID'];
}
# Constructing a query to get the latest inventory.
$inv_table = "Inventory";
$inv_latest_query = "SELECT Inventory FROM " . $inv_table . " WHERE ID=" . $id;
# Fetch results.
$inv_latest_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_latest_query);
while($row = mysql_fetch_array($inv_latest_result)) {
	$latest_inv=$row['Inventory'];
}
# Draw results table.
$table_cols = array("name", "volume","previous</br>inventory</br>$latest_date","current amount");
print_table_headers($table_cols);
print_inv_table($query_result,$latest_inv);
# Max ID in Beverage table.
$max_query = "SELECT MAX(ID) AS MAX_ID FROM Beverages";
$max_result = db_connect($db_service, $db_name, $db_user, $db_pass, $max_query);
while($row = mysql_fetch_array($max_result)) {
	$max=$row['MAX_ID'];
}
# Frees up memory that is allocated for the query.
mysql_free_result($query_result);
?>
<br /><br /><input type="submit" value="Send" /> 
<input type="reset" value="Clear" />
</form>
<?php
echo "</br></br>";
echo "<form name=logout method=POST action=" . CONTROLLER . ">";
echo "<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>";
if (isset($_POST['inv_date']) && ($_POST['inv_date'] <> "")) {
# Set query parameters.
$inv_date = $_POST['inv_date'];
$inv = "";
for ($i=1;$i<=$max;$i++) {
	if ($_POST["amount$i"]<>"") {
		$inv = $inv . "$i-" . $_POST["amount$i"] . ",";
		
	}
}
$inv = substr($inv, 0, -1);
$stamp = date('Y-m-d h:i:s', time());
$by = $current_user;
$inv_table = "Inventory";
$ins_query = "INSERT INTO $inv_table (Inventory, Inv_Date, Stamp, By_User) VALUES ('$inv', '$inv_date', '$stamp', '$by')";
$ins_result = db_connect($db_service, $db_name, $db_user, $db_pass, $ins_query);
if ($ins_result) {
	echo "Inventory sheet was submitted successfully!";
}
else {
	echo "Something went wrong with the insert, error: " . mysql_error($ins_result);
	}
} else {
	$inv_date = "";
}
?>
</body>
</html>