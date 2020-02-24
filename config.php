<?php
# MVC
define('CONTROLLER', 'index.php');
define('CONTEXT', true);

# Session control
if (@session_id() == "") {
	@session_start();
	}
$current_user = $_SESSION['user'];
if ($current_user == "") {
	$current_user = $_POST['user'];
}
//echo "<pre>" . var_dump($_SESSION) . "</pre>";
//echo "<pre>" . $current_user . "</pre>";

# DB settings
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'barman');
define('DBSERV', 'localhost');
define('BEV_TBL', 'Beverages');
define('FRUIT_TBL', 'Fruit_Veg');
define('GAR_TBL', 'Garnish');
define('SUP_TBL', 'Suppliers');
define('COCK_TBL', 'Cocktails');
define('BEVT_TBL', 'Bev_Type');
define('GLS_TBL', 'Glassware');
define('INV_TBL', 'Inventory');
define('TECH_TBL', 'Techniques');
define('REQ_TBL', 'Requisition');
define('WASTE_TBL', 'Wastage');
//date_default_timezone_set('Hungary/Budapest');

# User settings
// % of alcoholic discount for Raiker
define('RAIKER_ALC', 8);
// % of non-alcoholic discount for Raiker
define('RAIKER_NONALC', 12);
define('CURRENCY', "HUF");
define('VOL_MET', "L");
define('VOL_MET_TOT', "mL");
?>
