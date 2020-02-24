<?php
// Process lookup requests.

# Settings & functions
require "config.php";
require "functions.php";

# Grab search parameters from POST form and constructing the query.
$result_table="";
switch ($_POST['lookup_type']) {
	case 'bev':
		$avail = $_POST['avail'];
		$sup_table = SUP_TBL;
		$table = BEV_TBL;
		$bev_name = $_POST['bev_name'];
		$bev_type = $_POST['bev_type'];
		$query = "SELECT `B`.`ID` AS `ID`, `B`.`Name` AS `Name`, `B`.`Vol` AS `Vol`, `B`.`Price` AS `Price`, `B`.`Alc` AS `Alc`, `S`.`Name` AS `Supplier`, `B`.`Sell_Price` AS `Sell_Price`, `B`.`Tot_Price` AS `Tot_Price` FROM `$table` AS `B` JOIN `$sup_table` AS `S` ON `B`.`Supplier_ID`=`S`.`ID` WHERE 1=1";
		$conditions = " AND `B`.`Name` LIKE '%$bev_name%'";
		if ($avail=="1" || $avail=="0") {
			$conditions .= " AND `Avail`='$avail'";
		}
		if ($bev_type<>"all") {
			$conditions .= " AND `Type_ID`='$bev_type'";
		}
		$query .= $conditions . " ORDER BY `B`.`House_Pouring` DESC";
		# Generate results: table headers and rows.
		$result = db_connect($query);
		if (($result->num_rows) > 0) {
			$table_cols = array("name", "volume","bottle</br>retail price", "10ml</br>price", "40ml</br>price","bottle</br>sell price","40ml</br>price","current</br>stock");
			$result_table = print_table_headers($table_cols) . print_bev_table($result,$bev_name,$bev_type,$avail);
		} else {
			$result_table = "<b>No beverages to list for the above search criteria.</b>";
		}
		break;
	case 'fruit':
		$table = FRUIT_TBL;
		break;
	case 'gar':
		$table = GAR_TBL;
		$avail = $_POST['avail'];
		$sup_table = SUP_TBL;
		$table = GAR_TBL;
		$gar_name = $_POST['gar_name'];
		$query = "SELECT `G`.`ID` AS `ID`, `G`.`Name` AS `Name`, `G`.`Metric` AS `Metric`, `G`.`Amount` AS `Amount`, `G`.`Price` AS `Price`, `G`.`Quantity` AS `Quantity`, `S`.`Name` AS `Supplier` FROM `$table` AS `G` JOIN `$sup_table` AS `S` ON `G`.`Supplier_ID`=`S`.`ID` WHERE 1=1";
		$conditions = " AND `G`.`Name` LIKE '%$gar_name%'";
		if ($avail=="1" || $avail=="0") {
			$conditions .= " AND `Avail`='$avail'";
		}
		$query .= $conditions . " ORDER BY `G`.`Name`";
		# Generate results: table headers and rows.
		$result = db_connect($query);
		if (($result->num_rows) > 0) {
			$table_cols = array("name", "bundle","bundle price","price <br />per price","stock");
			$result_table = print_table_headers($table_cols) . print_gar_table($result);
		} else {
			$result_table = "<b>No garnishes to list for the above search criteria.</b>";
		}
		break;
	case 'cock':
		// Set query parameters.
		$cock_name = $_POST["cock_name"];
		$cock_type = $_POST["cock_type"];
		$alc = $_POST["alc"];
		$shot = $_POST["shot"];
		$in_menu = $_POST["menu"];
		$cock_table = COCK_TBL;
		$tech_table = TECH_TBL;
		$glass_table = GLS_TBL;
		$cock_query = "SELECT `C`.`ID` AS `ID`, `C`.`Name` AS `Name`, `C`.`Ingredients` AS `Ingredients`, `C`.`Garnish` AS `Garnish`, `G`.`Name` AS `Glass`, `T`.`Name` AS `Tech`, `C`.`Comment` AS `Comment`, `C`.`Price` AS `Price` FROM `$cock_table` AS `C` JOIN `$tech_table` AS `T` ON `C`.`Tech`=`T`.`ID` JOIN `$glass_table` AS `G` ON `C`.`Glass`=`G`.`ID` WHERE 1=1 AND `C`.`In_Menu`='$in_menu' AND `C`.`Name` LIKE '%$cock_name%' AND `C`.`Type`='$cock_type' AND `C`.`Alc`='$alc' AND `C`.`Shot`='$shot'";
		// Fetch results of constructed query.
		$result = db_connect($cock_query);
		if (($result->num_rows) > 0) {
			$result_table = print_cock_table($result,$cock_name,$cock_type,$alc,$shot,$in_menu);
		} else {
			$result_table = "<b>No cocktails to list for the above search criteria.</b>";
		}
		break;
}

# Return html code as string to the view.
echo utf8_encode($result_table);
?>