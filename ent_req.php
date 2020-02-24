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
<title> Requisition Entry </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<h1>Requisition Entry</h1></br>
<form name=logout method=POST action="<?php echo CONTROLLER; ?>">
<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>
<form action="" method="POST">
<input type="date" name="req_date" autofocus ><br /><br />
<?php
# Constructing the query.
$bev_table = "Beverages";
$bev_query = "SELECT ID , Name, Vol FROM " . $bev_table . " WHERE Stock_Need=1";
# Fetch results.
$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $bev_query);
# Draw results table.
$table_cols = array("name", "volume","amount");
print_table_headers($table_cols);
print_inv_req_table($query_result);
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
if (isset($_POST['req_date']) && ($_POST['req_date'] <> "")) {
# Set query parameters.
$req_date = $_POST['req_date'];
$req = "";
for ($i=1;$i<=$max;$i++) {
	if ($_POST["amount$i"]<>"") {
		$req = $req . "$i-" . $_POST["amount$i"] . ",";
		
	}
}
$req = substr($req, 0, -1);
$stamp = date('Y-m-d h:i:s', time());
$by = "barman";
$req_table = "Requisition";
$ins_query = "INSERT INTO $req_table (Requisition, Req_Date, Stamp, By_User) VALUES ('$req', '$req_date', '$stamp', '$by')";
$ins_result = db_connect($db_service, $db_name, $db_user, $db_pass, $ins_query);
if ($ins_result) {
	echo "Requisition sheet was submitted successfully!";
}
else {
	echo "Something went wrong with the insert, error: " . mysql_error($ins_result);
	}
} else {
	$req_date = "";
}
?>
</body>
</html>