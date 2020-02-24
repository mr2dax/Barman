<?php
# Settings & functions
require 'config.php';
require 'functions.php';

# Get the maximum number of ingredients of the cocktail.
$max = substr($_POST["max"],1,strlen($_POST["max"]));
# Start building the ingredients and garnishes strings for storage.
$ings = "";
$gars = "";
for ($j=1;$j<=$max;$j++) {
	if ($_POST["name_b$j"]<>"") {
		$ings .= "b-" . $_POST["name_b$j"] . "-" . $_POST["vol_b$j"] . ",";
		continue;
	}
	if ($_POST["name_f$j"]<>"") {
		$ings .= "f-" . $_POST["name_f$j"] . "-" . $_POST["vol_f$j"] . ",";
		continue;
	}
	if ($_POST["name_g$j"]<>"") {
		$gars .= $_POST["name_g$j"] . "-" . $_POST["vol_g$j"] . ",";
		continue;
	}
}
$ings = substr($ings, 0, -1);
$gars = substr($gars, 0, -1);
# Cocktail attributes for the insert statement.
$name = $_POST["cock_name"];
$cock_type = $_POST["cock_type"];
$shot = $_POST["shot"];
$alc = $_POST["alc"];
$tech = $_POST["tech"];
$glass = $_POST["glass"];
$comment = $_POST["comment"];
$price = $_POST["price"];
$in_menu = $_POST["menu"];
$table = COCK_TBL;
$ins_query = "INSERT INTO `$table` (`Name`, `Ingredients`, `Alc`, `Type`, `Shot`, `Garnish`, `Glass`, `Tech`, `Comment`, `Price`, `In_Menu`) VALUES ('$name','$ings','$alc','$cock_type','$shot','$gars','$glass','$tech','$comment','$price','$in_menu')";

$ins_result = db_connect($ins_query);
?>