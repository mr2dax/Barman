<?php 
# Settings & functions
require 'config.php';
require 'functions.php';
?>
<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title> Add Beverage </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<h1>Add New Beverage</h1></br>
<form action="" method="POST">
Availability:&nbsp;&nbsp;<input type="radio" name="avail" value="1" checked /> Available
<input type="radio" name="avail" value="0" /> Not Available</br>
<?php
echo "Name: <input type='text' name='bev_name' pattern=\"[a-zA-Z0-9! ,.?\/'#~$£%&*()-+:@]*\" title=\"Invalid input.\" size='15' maxlength='30' autofocus />";
echo "  Type: <select name='bev_type'>";
# Get beverage types for drop-down menu.
$type_table = BEVT_TBL;
$type_query = "SELECT ID, Type FROM $type_table WHERE 1=1";
# Fetch results.
$type_result = db_connect($type_query);
# Draw drop-down list.
$selected = 0;
print_bev_types($type_result, $selected);
# Frees up memory that is allocated for the query.
mysql_free_result($type_result);
echo "</select></br>";
echo "Volume: <input type='text' name='bev_vol' pattern=\"[0-9]{1,2}[.]{1}[0-9]{1,3}*\" title=\"Pattern: xx.yyy\" size='6' maxlength='6' value='$bev_vol' />";
echo "  Price /wo disc.: <input type='text' name='bev_price' pattern=\"[0-9.]{1,7}\" title=\"1 to 7-digit whole number\" size='7' maxlength='7' value='$bev_price' />";
echo "Alcoholic?  ";
if($alc==1) { 
	echo '<input type="radio" name="alc" value="1" checked /> Alcoholic<input type="radio" name="alc" value="0" /> Non Alcoholic';
	}
	else {
		echo '<input type="radio" name="alc" value="1" /> Alcoholic<input type="radio" name="alc" value="0" checked /> Non Alcoholic';
	}
echo "</br></br>";
echo "  Supplier: <select name='supplier'>";
# Get suppliers for drop-down menu.
$sup_table = SUP_TBL;
$sup_query = "SELECT ID, Name FROM $sup_table WHERE 1=1";
# Fetch results.
$sup_result = db_connect($sup_query);
# Draw drop-down list.
print_sup_types($sup_result, $supplier);
# Frees up memory that is allocated for the query.
mysql_free_result($sup_result);
echo "</select>";
echo "  Need to supervise in Stock Management?  ";
if($stock_need==1) { 
	echo '<input type="radio" name="stock_need" value="1" checked /> Needed<input type="radio" name="stock_need" value="0" /> Not Needed';
	}
	else {
		echo '<input type="radio" name="stock_need" value="1" /> Needed<input type="radio" name="stock_need" value="0" checked /> Not Needed';
	}
echo "</br>House Pouring?  ";
if($house_pouring==1) { 
	echo '<input type="radio" name="house_pouring" value="1" checked /> Yes<input type="radio" name="house_pouring" value="0" /> No';
	}
	else {
		echo '<input type="radio" name="house_pouring" value="1" /> Yes<input type="radio" name="house_pouring" value="0" checked /> No';
	}
echo "</br></br>";
?>
<input type="submit" value="Save" /> 
<input type="reset" value="Clear" />
</form><br />
<form name=logout method=POST action="<?php echo CONTROLLER; ?>">
<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>
</body>
</html>
<?php
if ($_POST[bev_name]<>"") {
	// Set query parameters.
	$alc = $_POST["alc"];
	$avail = $_POST["avail"];
	$bev_name = $_POST["bev_name"];
	$bev_type = $_POST["bev_type"];
	$bev_vol = $_POST["bev_vol"];
	$bev_price = $_POST["bev_price"];
	$supplier = $_POST["supplier"];
	$stock_need = $_POST["stock_need"];
	$tot_price = $_POST["tot_price"];
	$sell_price = $_POST["sell_price"];
	$house_pouring = $_POST["house_pouring"];
	$bev_table = BEV_TBL;
	$ins_query = "INSERT INTO `$bev_table` (`Name`, `Type_ID`, `Alc`, `Vol`, `Price`, `Sell_Price`, `Tot_Price`, `Supplier_ID`, `Avail`, `House_Pouring`) VALUES ('$bev_name', '$bev_type', '$alc' , '$bev_vol', '$bev_price', '$sell_price', '$tot_price', '$supplier', '$avail', '$house_pouring')";
	$ins_result = db_connect($ins_query);
	if ($ins_result) {
		echo "$bev_name was added successfully!";
		
	}
	else {
		echo "Something went wrong with the insert, error: " . mysql_error($ins_result);
	}
}
	else {
		$alc = "";
		$avail = "";
		$bev_name = "";
		$bev_type = "";
		$bev_price = "";
		$bev_vol = "";
		$supplier = "";
}
?>