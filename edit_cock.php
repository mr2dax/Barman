<?php
// Edit cocktail attributes.

# Settings & functions
require 'config.php';
require 'functions.php';

# Set query parameters to find the desired cocktail item to be edited.
$id = $_POST["edit_id"];
$lookup_name = $_POST["lookup_name"];
$lookup_type = $_POST["lookup_type"];
if ($_POST["lookup_alc"]=="") {$lookup_alc=0;} else {$lookup_alc=$_POST["lookup_alc"];};
if ($_POST["lookup_shot"]=="") {$lookup_shot=0;} else {$lookup_shot=$_POST["lookup_shot"];};
if ($_POST["lookup_in_menu"]=="") {$lookup_in_menu=0;} else {$lookup_in_menu=$_POST["lookup_in_menu"];};
$cock_table = COCK_TBL;
$get_query = "SELECT * FROM `$cock_table` WHERE `ID` = '$id'";
# Fetch result.
if ($get_result = db_connect($get_query)) {
	$row = $get_result->fetch_assoc();
	$alc = $row["Alc"];
	$tech = $row["Tech"];
	$cock_name = $row["Name"];
	$cock_type = $row["Type"];
	$cock_price = $row["Price"];
	$ingredients = $row["Ingredients"];
	$garnishes = $row["Garnish"];
	$glass = $row["Glass"];
	$shot = $row["Shot"];
	$comment = $row["Comment"];
	$in_menu = $row["In_Menu"];
	if ($ingredients<>"") {
		$count_ings = count(explode(",",$ingredients));
		$ings = explode(",",$ingredients);
	} else {
		$count_ings = 0;
	}
	if ($garnishes<>"") {
		$count_gars = count(explode(",",$garnishes));
		$gars = explode(",",$garnishes);
	} else {
		$count_gars = 0;
	}
	$count = $count_gars + $count_ings;
}
# Frees up memory that is allocated for the query.
$get_result->free();
?>
<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title> Edit Cocktail </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
var next_item = <?php echo $count; ?>;
var item_count = <?php echo $count; ?>;

function setIngs() {
	var count_ings = <?php echo $count_ings; ?>;
	var count_gars = <?php echo $count_gars; ?>;
	var ings = [<?php if (count($ings)>0) {foreach ($ings as $ing) { echo "\"" . $ing . "\","; }} ?>];
	var gars = [<?php if (count($gars)>0) {foreach ($gars as $gar) { echo "\"" . $gar . "\","; }} ?>];
	var shot = <?php echo $shot; ?>;
	var alc = <?php echo $alc; ?>;
	var cock_type = <?php echo $cock_type; ?>;
	var in_menu = <?php echo $in_menu; ?>;

	for (j=1;j<=count_ings;j++) {
		addIng(j,ings);
	}
	for (k=1;k<=count_gars;k++) {
		addGar(k,gars);
	}
	$('#shot' + shot).prop('checked',true);
	$('#cock_type' + cock_type).prop('checked',true);
	$('#alc' + alc).prop('checked',true);
	$('#menu' + in_menu).prop('checked',true);
}

function incVol(id,type,event) {
	var vol_id = "#vol_" + type + id;
	var vol_inc_id = "#vol_" + type + "_s" + id;
	var vol_val = parseFloat($(vol_id).val());
	var vol_inc = parseFloat($(vol_inc_id).val());
	$(vol_id).val(vol_val+vol_inc);
	event.preventDefault();
}

function decVol(id,type,event) {
	var vol_id = "#vol_" + type + id;
	var vol_dec_id = "#vol_" + type + "_s" + id;
	var vol_val = parseFloat($(vol_id).val());
	var vol_dec = parseFloat($(vol_dec_id).val());
	if (vol_val-vol_dec >= 0) {
		$(vol_id).val(vol_val-vol_dec);
	}
	event.preventDefault();
}

function deleteLine(id) {
	var del_id = "#" + id;
	$(del_id).remove();
	item_count--;
}

function addIng(ing_ind,ing_arr) {
	id = ing_ind;
	id_arr = ing_ind-1;
	ing_data = ing_arr[id_arr].split("-");
	type = ing_data[0];
	ing = ing_data[1];
	vol = ing_data[2];
	switch(type) {
    case "b":
		var txtfield = "<table border='0' id='b" + id + "'><tr><td><select onChange='changeList(this.selectedIndex," + id + ",\"b\")' id='type_b" + id + "' style='width: 65px'>";
        txtfield = txtfield + "<?php
		$result = db_connect("SELECT `ID`, `Type` FROM `" . BEVT_TBL . "`");
		while ($row = $result->fetch_assoc()) {
			echo "<option value='".$row['ID']."'>".$row['Type']."</option>";
		}
	?>";		
		txtfield = txtfield + "</select></td><td><select required id='name_b" + id + "' name='name_b" + id + "' style='width: 150px'>";
        txtfield = txtfield + "<?php
		$result = db_connect("SELECT `ID`, `Name` FROM `" . BEV_TBL . "`");
		while ($row = $result->fetch_assoc()) {
			echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
		}
	?>";
		txtfield = txtfield + "</select></td><td><input type='text' value='10' style='width: 40px' id='vol_b" + id + "' name='vol_b" + id + "' required></input>" +
		"</input><button onClick='incVol(\"" + id + "\",\"b\",event)'>+</button><button onClick='decVol(\"" + id + "\",\"b\",event)'>-</button>" +
		"<select id='vol_b_s" + id + "'><option value='5'>5</option><option value='10'>10</option><option value='20'>20</option></select></td><td>" + "<?php echo VOL_MET_TOT; ?>" + "</td>";
        txtfield = txtfield + "<td><button onClick='deleteLine(\"b" + id + "\")'>Delete</button></td>";
		break;
    case "f":
		var txtfield = "<table border='0' id='" + type + id + "'><tr><td><select required name='name_" + type + id + "' id='name_" + type + id + "' style='width: 150px'>";
        txtfield = txtfield + "<?php
		$result = db_connect("SELECT `ID`, `Name` FROM `" . FRUIT_TBL . "`");
		while ($row = $result->fetch_assoc()) {
			echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
		}
	?>";
		txtfield = txtfield + "</select></td><td><input type='text' style='width: 40px' required id='vol_" + type + id + "' name='vol_" + type + id + "' value='" + vol + "'></input>" + 
		"</input><button onClick='incVol(\"" + id + "\",\"f\",event)'>+</button><button onClick='decVol(\"" + id + "\",\"f\",event)'>-</button>" +
		"<select id='vol_f_s" + id + "'><option value='1'>1</option><option value='0.5'>1/2</option><option value='0.25'>1/4</option><option value='0.125'>1/8</option></select></td><td>pc</td>";
        txtfield = txtfield + "<td><button onClick='deleteLine(\"" + type + id + "\")'>Delete</button></td>";
		break;
}
	txtfield = txtfield + "</tr></table>";
	$("#fields").append(txtfield);
	var select_option_id = "#name_" + type + id;
	$(select_option_id).val(ing);
	if (type=="b") {
		adjustList(ing,id,type);
	}
	$('.post').show();
}

function addGar(gar_ind,gar_arr) {
	id = gar_ind;
	id_arr = gar_ind-1;
	gar_data = gar_arr[id_arr].split("-");
	gar = gar_data[0];
	vol = gar_data[1];
	var txtfield = "<table border='0' id='g" + id + "'><tr><td><select required name='name_g" + id + "' id='name_g" + id + "' style='width: 150px'>";
	txtfield = txtfield + "<?php
	$result = db_connect("SELECT `ID`, `Name`, `Metric` FROM `" . GAR_TBL . "`");
	while ($row = $result->fetch_assoc()) {
		$metric = strtolower($row['Metric']);
		echo "<option value='".$row['ID']."'>".$row['Name']." (" . $metric . ")</option>";
	}
	?>";
	txtfield = txtfield + "</select></td><td><input type='text' style='width: 40px' required id='vol_g" + id + "' name='vol_g" + id + "' value='" + vol + "'></input>" + 
	"</input><button onClick='incVol(\"" + id + "\",\"g\",event)'>+</button><button onClick='decVol(\"" + id + "\",\"g\",event)'>-</button>" +
		"<select id='vol_g_s" + id + "'><option value='1'>1</option><option value='0.5'>1/2</option></td><td></td>";
    txtfield = txtfield + "<td><button onClick='deleteLine(\"g" + id + "\")'>Delete</button></td>";

	txtfield = txtfield + "</tr></table>";
	$("#fields").append(txtfield);
	var select_option_id = "#name_g" + id;
	$(select_option_id).val(gar);
	$('.post').show();
}

function appendLine(type) {
	next_item = next_item + 1;
	var id = next_item;
	switch(type) {
    case "bev":
		var txtfield = "<table border='0' id='b" + id + "'><tr><td><select onChange='changeList(this.selectedIndex," + id + ",\"b\")' id='type_b" + id + "' style='width: 65px'>";
        txtfield = txtfield + "<?php
		$result = db_connect("SELECT `ID`, `Type` FROM `" . BEVT_TBL . "`");
		while ($row = $result->fetch_assoc()) {
			echo "<option value='".$row['ID']."'>".$row['Type']."</option>";
		}
	?>";		
		txtfield = txtfield + "</select></td><td><select required id='name_b" + id + "' name='name_b" + id + "' style='width: 150px'>";
        txtfield = txtfield + "<?php
		$result = db_connect("SELECT `ID`, `Name` FROM `" . BEV_TBL . "`");
		while ($row = $result->fetch_assoc()) {
			echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
		}
	?>";
		txtfield = txtfield + "</select></td><td><input type='text' value='10' style='width: 40px' id='vol_b" + id + "' name='vol_b" + id + "' required></input>" +
		"</input><button onClick='incVol(\"" + id + "\",\"b\",event)'>+</button><button onClick='decVol(\"" + id + "\",\"b\",event)'>-</button>" +
		"<select id='vol_b_s" + id + "'><option value='5'>5</option><option value='10'>10</option><option value='20'>20</option></select></td><td>" + "<?php echo VOL_MET_TOT; ?>" + "</td>";
        txtfield = txtfield + "<td><button onClick='deleteLine(\"b" + id + "\")'>Delete</button></td>";
		break;
    case "fruit":
		var txtfield = "<table border='0' id='f" + id + "'><tr><td><select required name='name_f" + id + "' style='width: 150px'>";
        txtfield = txtfield + "<?php
		$result = db_connect("SELECT `ID`, `Name` FROM `" . FRUIT_TBL . "`");
		while ($row = $result->fetch_assoc()) {
			echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
		}
	?>";
		txtfield = txtfield + "</select></td><td><input type='text' value='1' style='width: 40px' id='vol_f" + id + "' name='vol_f" + id + "' required>" +
		"</input><button onClick='incVol(\"" + id + "\",\"f\",event)'>+</button><button onClick='decVol(\"" + id + "\",\"f\",event)'>-</button>" +
		"<select id='vol_f_s" + id + "'><option value='1'>1</option><option value='0.5'>1/2</option><option value='0.25'>1/4</option><option value='0.125'>1/8</option></select></td><td>pc</td>";
        txtfield = txtfield + "<td><button onClick='deleteLine(\"f" + id + "\")'>Delete</button></td>";
		break;
    case "gar":
		var txtfield = "<table border='0' id='g" + id + "'><tr><td><select required name='name_g" + id + "' style='width: 150px'>";
        txtfield = txtfield + "<?php
		$result = db_connect("SELECT `ID`, `Name`, `Metric` FROM `" . GAR_TBL . "`");
		while ($row = $result->fetch_assoc()) {
			$metric = strtolower($row['Metric']);
			echo "<option value='".$row['ID']."'>".$row['Name']." (" . $metric . ")</option>";
		}
	?>";
		txtfield = txtfield + "</select></td><td><input type='text' value='1' style='width: 40px' required id='vol_g" + id + "' name='vol_g" + id + "'>" +
		"</input><button onClick='incVol(\"" + id + "\",\"g\",event)'>+</button><button onClick='decVol(\"" + id + "\",\"g\",event)'>-</button>" +
		"<select id='vol_g_s" + id + "'><option value='1'>1</option><option value='0.5'>1/2</option></td><td></td>";
		txtfield = txtfield + "<td><button onClick='deleteLine(\"g" + id + "\")'>Delete</button></td>";
		break;
}
	txtfield = txtfield + "</tr></table>";
	$("#fields").append(txtfield);
	$('.post').show();
	item_count++;
}

// Change content of second drop-down list according to what was selected in the first drop-down list.
function changeList(selected_option_id,element_id,type) {
	select_request = $.ajax({
		url: "/get_types.php",
		type: "post",
		data: { type : type + "_select", selected_option : selected_option_id+1 },
		dataType: "html"
	});

	// Callback handler that will be called on success
	select_request.done(function (response, textStatus, jqXHR){
		$('#name_' + type + element_id).find('option').remove();
		$('#name_' + type + element_id).append(response);
	});

	// Callback handler that will be called on failure
	select_request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error("The following error occurred: " + textStatus, errorThrown);
	});
}

// Adjust content of first drop-down list according to what was set in the second drop-down list.
function adjustList(selected_option_id,element_id,type) {
	adjust_request = $.ajax({
		url: "/get_types.php",
		type: "post",
		data: { type : type + "_adjust", selected_option : selected_option_id },
		dataType: "html"
	});

	// Callback handler that will be called on success
	adjust_request.done(function (response, textStatus, jqXHR){
		$('#type_' + type + element_id).val(response);
	});

	// Callback handler that will be called on failure
	adjust_request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error("The following error occurred: " + textStatus, errorThrown);
	});
}

// Fetch the glass types.
function getGlassTypes(selected) {
	glass_type_request = $.ajax({
		url: "/get_types.php",
		type: "post",
		data: { type : "glass", selected_id : selected },
		dataType: "html"
	});

	// Callback handler that will be called on success
	glass_type_request.done(function (response, textStatus, jqXHR){
		$('#glass').append(response);
	});

	// Callback handler that will be called on failure
	glass_type_request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error("The following error occurred: " + textStatus, errorThrown);
	});
}

// Fetch the glass types.
function getTechTypes(selected) {
	tech_type_request = $.ajax({
		url: "/get_types.php",
		type: "post",
		data: { type : "tech", selected_id : selected },
		dataType: "html"
	});

	// Callback handler that will be called on success
	tech_type_request.done(function (response, textStatus, jqXHR){
		$('#tech').append(response);
	});

	// Callback handler that will be called on failure
	tech_type_request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error("The following error occurred: " + textStatus, errorThrown);
	});
}

$( document ).ready(function() {
// Set data for editing.
glass_selected = <?php echo $glass; ?>;
tech_selected = <?php echo $tech; ?>;
// Set glass type.
getGlassTypes(glass_selected);
// Set tech type.
getTechTypes(tech_selected);
// Set ingredients and garnishes.
setIngs();

// Variable to hold request
var request;
// Bind to the submit event of our form
$("#cock_update").submit(function(event){
    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var form = $(this);
	var max_item = item_count;
    // Let's select and cache all the fields
    var $inputs = form.find("input");

    // Serialize the data in the form
    var serializedData = form.serialize() + "&max=" + max_item + "&edit_type=cock";

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
	var cock_name = $('#cock_name').val();
    $inputs.prop("disabled", true);
	$('select').prop("disabled",true);
	$('#comment').prop("disabled",true);

    // Fire off the request to /proc_edit.php
    request = $.ajax({
        url: "/proc_edit.php",
        type: "post",
        data: serializedData,
    });
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        alert(cock_name + " has been updated!");
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error("The following error occurred: " + textStatus, errorThrown);
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Re-enable the inputs
		$('select').prop("disabled",false);
        $inputs.prop("disabled", false);
		$('#comment').prop("disabled",false);
    });

    // Prevent default posting of form
    event.preventDefault();
});
});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<h1>Edit <?php echo $cock_name; ?> Cocktail</h1></br>
<p id='button'><button onClick="appendLine('bev')">Beverage</button><button onClick="appendLine('fruit')">Fruit/Veg</button><button onClick="appendLine('gar')">Garnish</button></p>
<form id="cock_update" >
<div id='name' class="post">
	<input type='text' id='cock_name' name='cock_name' autofocus required size='15' maxlenght='30' value='<?php echo $cock_name; ?>'><input type="hidden" name="cock_id" value="<?php echo $id; ?>">
</div>
<p id='fields'></p>
<div class="post"><table border='0'>
	<tr><td>Type?</td><td><input type="radio" name="cock_type" id="cock_type1" value="1" /> Signature<br />
	<input type="radio" name="cock_type" id="cock_type0" value="0" checked /> Classic<br />
	<input type="radio" name="cock_type" id="cock_type2" value="2" /> Twisted Classic</td></tr>
	<tr><td>Shot?</td><td><input type="radio" name="shot" id="shot1" value="1" /> Yes<br />
	<input type="radio" name="shot" id="shot0" value="0" checked /> No</td></tr>
	<tr><td>Alcoholic?</td><td><input type="radio" name="alc" id="alc1" value="1" checked /> Yes<br />
	<input type="radio" name="alc" id="alc0" value="0" /> No</td></tr>
	<tr><td>Glassware</td><td><select id='glass' name='glass'></select></td></tr>
	<tr><td>Technique</td><td><select id='tech' name='tech'></select></td></tr>
	<tr><td>Comments</td><td><textarea required id='comment' name='comment' rows='3' cols='50'><?php echo $comment; ?></textarea></td></tr>
	<tr><td>Sell Price</td><td><input type='text' id='price' name='price' required size='15' maxlenght='30' value='<?php echo $cock_price; ?>'></input></td></tr>
	<tr><td>Currently in menu?</td><td><input type="radio" name="menu" id="menu1" value="1" /> Yes<br />
	<input type="radio" name="menu" id="menu0" value="0" checked /> No</td></tr>
	<tr><td><input type="submit" class="post" id="cock_add" value="Save"></td></tr>
	</table>
</div>
</form>
<?php
	echo "</br></br><form name=logout method=POST action=\"" . CONTROLLER . "\">";
	echo "<input type='hidden' name='command' value='back_2_cock_lookup'/><input type='hidden' name='lookup_name' value='$lookup_name'/><input type='hidden' name='lookup_type' value='$lookup_type'/><input type='hidden' name='lookup_alc' value='$lookup_alc'/><input type='hidden' name='lookup_shot' value='$lookup_shot'/><input type='hidden' name='lookup_in_menu' value='$lookup_in_menu'/><input type='submit' value='Back'><br /><br /></form>";
?>
</body>
</html>