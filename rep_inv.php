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
<title> Inventory Reports </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<h1>Inventory Reports</h1></br>
<form name=logout method=POST action="<?php echo CONTROLLER; ?>">
<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>
</body>
</html>
<?php
# Constructing the query.
$inv_table = "Inventory";
$inv_query = "SELECT `ID`, `Inv_Date`, `Stamp`, `By_User` FROM `" . $inv_table . "` WHERE 1=1";
# Fetch results.
$inv_result = db_connect($db_service, $db_name, $db_user, $db_pass, $inv_query);
# Draw results table.
$table_cols = array("inventory date", "entered at", " entered by");
print_table_headers($table_cols);
list_invs($inv_result);	
# Frees up memory that is allocated for the query.
mysql_free_result($inv_result);
?>