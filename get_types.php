<?php
// Get certain types from db.

# Settings & functions
require "config.php";
require "functions.php";

# Decide which type dependent on posted value.
$selected_id = $_POST['selected_id'];
switch ($_POST['type']) {
	case "bev":
	# Get beverage types for drop-down menu.
	$type_table = BEVT_TBL;
	$type_query = "SELECT `ID`, `Type` FROM `$type_table` WHERE 1=1";
	# Construct drop-down list.
	$result = print_bev_types(db_connect($type_query),$selected_id);
	break;
	case "glass":
	# Get glass types for drop-down menu.
	$glass_table = GLS_TBL;
	$glass_query = "SELECT `ID`, `Name` FROM `$glass_table` WHERE 1=1";
	# Construct drop-down list.
	$result = print_gls_types(db_connect($glass_query),$selected_id);
	break;
	case "tech":
	# Get technique types for drop-down menu.
	$tech_table = TECH_TBL;
	$tech_query = "SELECT `ID`, `Name` FROM `$tech_table` WHERE 1=1";
	# Construct drop-down list.
	$result = print_tech_types(db_connect($tech_query),$selected_id);
	break;
	case "sup":
	# Get suppliers for drop-down menu.
	$sup_table = SUP_TBL;
	$sup_query = "SELECT `ID`, `Name` FROM `$sup_table` WHERE 1=1";
	# Construct drop-down list.
	$result = print_sup_types(db_connect($sup_query),$selected_id);
	break;
	case "b_select":
	$group = $_POST['selected_option'];
	# Get selected group of beverage for drop-down menu.
	$bev_table = BEV_TBL;
	$query = "SELECT `ID`, `Name` FROM `$bev_table` WHERE 1=1 AND `Type_ID`='$group'";
	# Construct drop-down list.
	$result = print_selected(db_connect($query));
	break;
	case "b_adjust":
	$selected = $_POST['selected_option'];
	# Get group of selected beverage for drop-down menu.
	$bev_table = BEV_TBL;
	$query = "SELECT `Type_ID` FROM `$bev_table` WHERE 1=1 AND `ID`='$selected'";
	# Construct drop-down list.
	$result = db_connect($query);
	$row = $result->fetch_assoc();
	$result = $row['Type_ID'];
	break;
}

# Send type list back to view.
echo $result;
?>