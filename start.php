<?php
require 'config.php';

?>
<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title> BarMan - A Bar Management App </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<h1><center><b>BarMan - A Bar Management App<br>Logged in as <?php echo $current_user; ?>! 
<form name=logout method=POST action="<?php echo CONTROLLER; ?>">
<input type=hidden name=command value='logout'/><input type=submit value=Logout></form></b></center></h1>
</br></br>
<p>
<table id="menu"><tr>
<?php
	$sites = array("Beverages"=>"bev_lookup.php","Garnishes"=>"gar_lookup.php","Fruits & Vegetables"=>"fruit_lookup.php","Cocktails"=>"cock_lookup.php",
	"New Beverage"=>"new_bev.php","New Garnish"=>"new_gar.php","New Fruit / Vegetable"=>"new_fruit.php","New Cocktail"=>"new_cock.php",
	"Inventory Entry"=>"ent_inv.php","Requisition Entry"=>"ent_req.php","Wastage Entry"=>"ent_waste.php",
	"Inventory Report"=>"rep_inv.php","Stock Report"=>"rep_stock.php","Consumption Report"=>"rep_cons.php");
	foreach($sites as $site_name => $site_url) {
		$site_command = explode(".",$site_url);
		echo "<td><form name=\"" . $site_command[0] . "\" method=\"POST\" action=\"" . 
		CONTROLLER . "\"><input type='hidden' name='command' value='" . $site_command[0] . "'/><input type=\"submit\" value=\"" . $site_name . "\"></form></td>";
	}
?>
</tr></table>
</p>
</br>
<i><center>Web by Xero</br>Copyright 2015</center></i>
</body>
</html>