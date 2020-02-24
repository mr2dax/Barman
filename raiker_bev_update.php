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
<title> Raiker Price Changes </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<h1>Beverage Price Change Report</h1></br>
<object type="text/html" data="http://www.raiker.hu/user/validate" style="width:50%; height:50%">

<form name=logout method=POST action="<?php echo CONTROLLER; ?>">
<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>
</body>
</html>
<?php
# Constructing the query.
$bev_table = "Beverages";
$bev_query = "SELECT `ID`, `Name`, `Vol`, `Price` FROM `" . $bev_table . "` WHERE `Supplier_ID` = 1";
# Fetch results.
$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $bev_query);
# Draw results table.
$table_cols = array("name", "volume","old bottle price", "new bottle price");
print_table_headers($table_cols);
//print_raiker_update_table($query_result);	
# Frees up memory that is allocated for the query.
mysql_free_result($query_result);
?>