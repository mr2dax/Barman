<?php
// Process delete requests.

# Settings & functions
require "config.php";
require "functions.php";

# Initialize variables for delete query.
$id=$_POST['id'];
switch ($_POST['del_type']) {
	case 'bev':
		$table = BEV_TBL;
		break;
	case 'fruit':
		$table = FRUIT_TBL;
		break;
	case 'gar':
		$table = GAR_TBL;
		break;
	case 'cock':
		$table = COCK_TBL;
		break;
}
$del_query = "DELETE FROM `$table` WHERE `ID`='$id'";
$del_result = db_connect($del_query);
?>