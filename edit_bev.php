<?php
// Edit beverage attributes.

# Settings & functions
require 'config.php';
require 'functions.php';

# Set query parameters to find the desired beverage item to be edited.
$id = $_POST["edit_id"];
$lookup_name = $_POST["lookup_name"];
$lookup_type = $_POST["lookup_type"];
$lookup_avail = $_POST["lookup_avail"];
$bev_table = BEV_TBL;
$get_query = "SELECT * FROM `$bev_table` WHERE `ID` = '$id'";
# Fetch result.
if ($get_result = db_connect($get_query)) {
	$row = $get_result->fetch_assoc();
	$alc = $row["Alc"];
	$avail = $row["Avail"];
	$bev_name = $row["Name"];
	$bev_type = $row["Type_ID"];
	$bev_vol = round($row["Vol"],2);
	$bev_price = $row["Price"];
	$bev_sellprice = $row["Sell_Price"];
	$tot_price = $row["Tot_Price"];
	$supplier = $row["Supplier_ID"];
	$stock_need = $row["Stock_Need"];
	$house_pouring = $row["House_Pouring"];
}
# Frees up memory that is allocated for the query.
$get_result->free();
?>
<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title> Edit Beverage </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
// After the document has finished loading.
$(document).ready(function() {
// Variable to hold request.
var update_request;
// Bind to the submit event of the query form.
$("#edit_bev").submit(function(event){
    // Abort any pending requests.
    if (update_request) {
        update_request.abort();
    }
    // Get the query form.
    var form = $(this);
    // Select and cache all the input fields of the form.
    var $inputs = form.find("input");
    // Serialize all the data in the form.
    var serializedData = form.serialize();

    // Disable the inputs for the duration of the Ajax request.
    // Note: disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);
	$('#bev_type').prop("disabled",true);
	$('#supplier').prop("disabled",true);
	
    // Fire off the request to the processing php script.
    update_request = $.ajax({
        url: "/proc_edit.php",
        type: "post",
        data: serializedData
    });
	
    // Callback handler that will be called on success.
    update_request.done(function (response, textStatus, jqXHR){
		// Refresh the result pane with the new data.
		//alert("Update successful!");
		alert("Update successful!");
    });

    // Callback handler that will be called on failure.
    update_request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console.
        console.error("The following error occurred: " + textStatus, errorThrown);
    });

    // Callback handler that will be called regardless if the request failed or succeeded.
    update_request.always(function () {
        // Re-enable the inputs.
        $inputs.prop("disabled", false);
		$('#bev_type').prop("disabled",false);
		$('#supplier').prop("disabled",false);
    });

    // Prevent default posting of form.
    event.preventDefault();
});

});

// Fetch the beverage types for the query form.
function getBevTypes(selected) {
	bev_type_request = $.ajax({
		url: "/get_types.php",
		type: "post",
		data: { type : "bev", selected_id : selected },
		dataType: "html"
	});

	// Callback handler that will be called on success
	bev_type_request.done(function (response, textStatus, jqXHR){
		$('#bev_type').append(response);
	});

	// Callback handler that will be called on failure
	bev_type_request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+textStatus, errorThrown);
	});
}

// Fetch the supplier types for the query form.
function getSup(selected) {
	sup_request = $.ajax({
		url: "/get_types.php",
		type: "post",
		data: { type : "sup", selected_id : selected },
		dataType: "html"
	});

	// Callback handler that will be called on success
	sup_request.done(function (response, textStatus, jqXHR){
		$('#supplier').append(response);
	});

	// Callback handler that will be called on failure
	sup_request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error("The following error occurred: " + textStatus, errorThrown);
	});
}

// Get beverage type and suppliers.
getBevTypes("<?php echo $bev_type; ?>");
getSup("<?php echo $supplier; ?>");
</script>
</head>
<body>
<h1>Edit Beverage</h1>
<?php
# Populate the form.
echo "<form id='edit_bev'><table border='0'><tr><td>Availability:</td><td>";
# Get the correct availability radio button selected. 
if($avail==1) { 
	echo '<input type="radio" name="avail" value="1" id="avail1" checked /> Available</br><input type="radio" name="avail" value="0" id="avail0" /> Not Available';
	}
	else {
		echo '<input type="radio" name="avail" value="1" id="avail1" /> Available</br><input type="radio" name="avail" value="0" id="avail0" checked /> Not Available';
	}
echo "</td></tr><tr><td>Name:</td><td><input type='text' name='bev_name' id='bev_name' size='20' pattern=\"[a-zA-Z0-9! ,.?\/'#~$£%&*()-+:@]*\" title=\"Invalid input.\" maxlength='40' value='$bev_name' /></td></tr>";
echo "<tr><td>Type:</td><td><select name='bev_type' id='bev_type'>";
echo "</select></td></tr>";
echo "<tr><td>Volume:</td><td><input type='text' id='bev_vol' name='bev_vol' pattern=\"[0-9]{1,2}[.]{1}[0-9]{1,3}*\" title=\"Pattern: xx.yyy\" name='bev_vol' size='6' maxlength='6' value='$bev_vol' /> " . VOL_MET . "</td></tr>";
echo "<tr><td>Price /wo disc.:</td><td><input type='text' pattern=\"[0-9.]{1,7}\" title=\"1 to 7-digit whole number\" name='bev_price' id='bev_price' size='7' maxlength='7' value='$bev_price' /> " . CURRENCY . "</td></tr>";
echo "<tr><td>Sell Price:</td><td><input type='text' pattern=\"[0-9.]{1,7}\" title=\"1 to 7-digit whole number\" name='bev_sellprice' id='bev_sellprice' size='7' maxlength='7' value='$bev_sellprice' /> " . CURRENCY . "</td></tr>";
echo "<tr><td>Tot Price:</td><td><input type='text' pattern=\"[0-9.]{1,7}\" title=\"1 to 7-digit whole number\" name='tot_price' id='tot_price' size='7' maxlength='7' value='$tot_price' /> " . CURRENCY . "</td></tr>";
# Get the correct alcoholic radio button selected. 
echo "<tr><td>Alcoholic?</td><td>";
if($alc==1) { 
	echo '<input type="radio" name="alc" id="alc1" value="1" checked /> Alcoholic</br><input type="radio" name="alc" id="alc0" value="0" /> Non Alcoholic';
	}
	else {
		echo '<input type="radio" name="alc" id="alc1" value="1" /> Alcoholic</br><input type="radio" name="alc" id="alc0" value="0" checked /> Non Alcoholic';
	}
echo "</td></tr>";
echo "<tr><td>Supplier:</td><td><select name='supplier' id='supplier'>";
echo "</select></td></tr>";
echo "<tr><td>Need to supervise in </br>Stock Management?</td><td>";
if($stock_need==1) {
	echo '<input type="radio" name="stock_need" id="stock_need1" value="1" checked /> Needed</br><input type="radio" name="stock_need" id="stock_need0" value="0" /> Not Needed';
	}
	else {
		echo '<input type="radio" name="stock_need" id="stock_need1" value="1" /> Needed</br><input type="radio" name="stock_need" id="stock_need0" value="0" checked /> Not Needed';
	}
echo "</td></tr><tr><td>House Pouring?</td><td>";
if($house_pouring==1) { 
	echo '<input type="radio" name="house_pouring" id="house_pouring1" value="1" checked /> Yes</br><input type="radio" name="house_pouring" id="house_pouring0" value="0" /> No';
	}
	else {
		echo '<input type="radio" name="house_pouring" id="house_pouring1" value="1" /> Yes</br><input type="radio" name="house_pouring" id="house_pouring0" value="0" checked /> No';
	}
echo "</td></tr>";
?>
<tr><td><input type="submit" value="Save" /></td></tr></table>
<input type="hidden" name="id" value="<?php echo $id; ?>" ><input type="hidden" name="edit_type" value="bev"></form><br />
<form method=POST action="index.php">
<input type="hidden" name="command" value='back_2_bev_lookup'/><input type='hidden' name='lookup_name' value='<?php echo $lookup_name; ?>'/><input type='hidden' name='lookup_type' value='<?php echo $lookup_type; ?>'/><input type='hidden' name='lookup_avail' value='<?php echo $lookup_avail; ?>'/><input type='submit' value='Back'/></form>
</body>
</html>