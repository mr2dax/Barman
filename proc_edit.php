<?php
// Process edit requests.

# Settings & functions
require 'config.php';
require 'functions.php';

# Initialize variables for update query.
switch ($_POST['edit_type']) {
	case 'bev':
		$bev_id=$_POST['id'];
		$table = BEV_TBL;
		$avail = $_POST["avail"];
		$bev_name = $_POST["bev_name"];
		$bev_type = $_POST["bev_type"];
		$alc = $_POST["alc"];
		$bev_vol = $_POST["bev_vol"];
		$bev_price = $_POST["bev_price"];
		$bev_sellprice = $_POST["bev_sellprice"];
		$supplier = $_POST["supplier"];
		$stock_need = $_POST["stock_need"];
		$house_pouring = $_POST["house_pouring"];
		$tot_price = $_POST["tot_price"];
		$mod_query = "UPDATE `$table` SET `Name`='$bev_name', `Type_ID`='$bev_type', `Alc`='$alc', `Vol`='$bev_vol', `Price`='$bev_price', `Sell_Price`='$bev_sellprice', `Tot_Price`='$tot_price', `Supplier_ID`='$supplier', `Avail`='$avail', `Stock_Need`='$stock_need', `House_Pouring`='$house_pouring' WHERE ID='$bev_id'";
		break;
	case 'fruit':
		$table = FRUIT_TBL;
		break;
	case 'gar':
		$table = GAR_TBL;
		break;
	case 'cock':
		# Get the maximum number of ingredients of the cocktail.
		$max = $_POST["max"];
		# Start building the ingredients and garnishes strings for storage.
		$ings = "";
		$gars = "";
		for ($j=1;$j<=$max;$j++) {
			if ($_POST["name_b$j"]<>"") {
				$ings .= "b-" . $_POST["name_b$j"] . "-" . $_POST["vol_b$j"] . ",";
			}
			if ($_POST["name_f$j"]<>"") {
				$ings .= "f-" . $_POST["name_f$j"] . "-" . $_POST["vol_f$j"] . ",";
			}
			if ($_POST["name_g$j"]<>"") {
				$gars .= $_POST["name_g$j"] . "-" . $_POST["vol_g$j"] . ",";
			}
		}
		$ings = substr($ings, 0, -1);
		$gars = substr($gars, 0, -1);
		# Cocktail attributes for the insert statement.
		$table = COCK_TBL;
		$cock_id = $_POST["cock_id"];
		$cock_name = $_POST["cock_name"];
		$cock_type = $_POST["cock_type"];
		$shot = $_POST["shot"];
		$alc = $_POST["alc"];
		$glass = $_POST["glass"];
		$tech = $_POST["tech"];
		$comment = $_POST["comment"];
		$price = $_POST["price"];
		$in_menu = $_POST["menu"];
		$mod_query ="UPDATE `$table` SET `Name`='$cock_name', `Ingredients`='$ings', `Alc`='$alc', `Type`='$cock_type', `Shot`='$shot', `Garnish`='$gars', `Glass`='$glass', `Tech`='$tech', `Comment`='$comment', `Price`='$price', `In_Menu`='$in_menu' WHERE `ID` = '$cock_id'";
		break;
}
db_connect($mod_query);
?>