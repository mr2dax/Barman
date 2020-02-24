<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title> Cocktail Lookup </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
// After the document has finished loading.
$(document).ready(function() {
// Variable to hold request.
var cock_request;
// Bind to the submit event of the query form.
$("#cock_query").submit(function(event) {
    // Abort any pending requests.
    if (cock_request) {
        cock_request.abort();
    }
    // Get the query form.
    var form = $(this);
    // Select and cache all the input fields of the form.
    var $inputs = form.find("input","checkbox");
    // Serialize all the data in the form.
    var serializedData = form.serialize();
	// Set type of lookup to beverage.
	var type = "&lookup_type=cock";
	
    // Disable the inputs for the duration of the Ajax request.
    // Note: disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);
	
    // Fire off the request to the processing php script.
    cock_request = $.ajax({
        url: "/proc_lookup.php",
        type: "post",
        data: serializedData + type,
		dataType: "html"
    });
	
    // Callback handler that will be called on success.
    cock_request.done(function (cock_response, textStatus, jqXHR){
		// Refresh the result pane with the new data.
		$('#result').empty();
		$('#result').append(cock_response);
    });

    // Callback handler that will be called on failure.
    cock_request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console.
        console.error("The following error occurred: " + textStatus, errorThrown);
    });

    // Callback handler that will be called regardless if the request failed or succeeded.
    cock_request.always(function () {
        // Re-enable the inputs.
        $inputs.prop("disabled", false);
    });

    // Prevent default posting of form.
    event.preventDefault();
});

resetForm();

var cock_name = "<?php echo $_POST['lookup_name']; ?>"
var cock_type = "<?php echo $_POST['lookup_type']; ?>"
var alc = "<?php echo $_POST['lookup_alc']; ?>"
var shot = "<?php echo $_POST['lookup_shot']; ?>"
var menu = "<?php echo $_POST['lookup_in_menu']; ?>"

if (cock_name != "") {
	$('#cock_name').val(cock_name);
}
if (cock_type != "") {
	$('#cock_type'+cock_type).attr('checked',true);
}
if (alc != "") {
	if (alc==1) { alc = true; } else { alc = false; }
	$('#alc').prop('checked',alc);
}
if (shot != "") {
	if (shot==1) { shot = true; } else { shot = false; }
	$('#shot').prop('checked',shot);
}
if (menu != "") {
	if (menu==1) { menu = true; } else { menu = false; }
	$('#menu').prop('checked',menu);
}
$("#cock_query").submit();
});

// Delete row when corresponding button is clicked and hide the row from the list.
function delCock(del_id){
	// Formulate the id of the cocktail to delete from the database and the id of the table row to hide.
	var hide_row = "#" + del_id.substr(4);
	var info = "id=" + del_id.substr(4) + "&del_type=cock";
	if (confirm ("Do you really want to delete this cocktail? It cannot be undone!")) {
		$.ajax({
			type: "POST",
			url: "/proc_del.php",
			data: info,
			success: function(){
				$(hide_row).hide();
				if ($('#result tr:visible').length == 1) {
					$('#result').empty();
				}
			}
		});
	}
	return false;
}

// Reset the form back to default.
function resetForm() {
	document.getElementById('cock_query').reset();
	$("#cock_name").val("");
	document.getElementById("cock_type0").checked = true;
	document.getElementById("shot").checked = false;
	document.getElementById("alc").checked = true;
	document.getElementById("menu").checked = true;
}
</script>
</head>
<body>
<h1>Cocktail Lookup</h1>
<p id="query">
<form id="cock_query"><table border='0'><tr><td>
<input type="radio" id="cock_type0" name="cock_type" value="0" checked /> Classic<br /><input type="radio" name="cock_type" id="cock_type1" value="1" /> Signature<br /><input type="radio" name="cock_type" id="cock_type2" value="2" /> Twisted Classic</td><td>
<input type="checkbox" name="shot" id="shot" value="1">Shot
<input type="checkbox" name="alc" id="alc" value="1">Alcoholic</td></tr><tr><td>
Search by Name:</td><td><input type="text" name="cock_name" id="cock_name" pattern="[a-zA-Z0-9! ,.?\/'#~$£%&*()-+:@]*" title="Invalid input." size="15" maxlength="30" autofocus /></td></tr>
<tr><td><input type="checkbox" name="menu" id="menu" value="1">In Menu</td><td></td></tr>
<tr><td><input type="submit" value="Query" /> 
<input type="button" onclick="resetForm()" value="Reset"> 
</form></td></table><br />
<form method="POST" action="index.php">
<input type="hidden" name="command" value="back"/><input type="submit" value="Back"></form>
</p>
<p id="result"></p>
</body>
</html>