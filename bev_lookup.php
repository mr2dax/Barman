<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title> Beverage Lookup </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
// After the document has finished loading.
$(document).ready(function() {
// Variable to hold request.
var bev_request;
// Bind to the submit event of the query form.
$("#bev_query").submit(function(event){
    // Abort any pending requests.
    if (bev_request) {
        bev_request.abort();
    }
    // Get the query form.
    var form = $(this);
    // Select and cache all the input fields of the form.
    var $inputs = form.find("input");
    // Serialize all the data in the form.
    var serializedData = form.serialize();
	// Set type of lookup to beverage.
	var type = "&lookup_type=bev";
	
    // Disable the inputs for the duration of the Ajax request.
    // Note: disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);
	$('#bev_type').prop("disabled",true);
	
    // Fire off the request to the processing php script.
    bev_request = $.ajax({
        url: "/proc_lookup.php",
        type: "post",
        data: serializedData + type,
		dataType: "html"
    });

    // Callback handler that will be called on success.
    bev_request.done(function (bev_response, textStatus, jqXHR){
		// Refresh the result pane with the new data.
		$('#result').empty();
		$('#result').append(bev_response);
    });

    // Callback handler that will be called on failure.
    bev_request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console.
        console.error("The following error occurred: " + textStatus, errorThrown);
    });

    // Callback handler that will be called regardless if the request failed or succeeded.
    bev_request.always(function () {
        // Re-enable the inputs.
        $inputs.prop("disabled", false);
		$('#bev_type').prop("disabled",false);
    });

    // Prevent default posting of form.
    event.preventDefault();
});

resetForm();

var bev_name = "<?php echo $_POST['lookup_name']; ?>"
var avail = "<?php echo $_POST['lookup_avail']; ?>"

if (bev_name != "") {
	$('#bev_name').val(bev_name);
}
if (avail != "") {
	$('#avail'+avail).attr('checked',true);
}

});

// Delete row when corresponding button is clicked and hide the row from the list.
function delBev(del_id){
	// Formulate the id of the beverage to delete from the database and the id of the table row to hide.
	var hide_row = "#" + del_id.substr(4);
	var info = "id=" + del_id.substr(4) + "&del_type=bev";
	if (confirm ("Do you really want to delete this beverage? It cannot be undone!")) {
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
	document.getElementById('bev_query').reset();
	$("#bev_name").val("");
    document.getElementById("bev_type").selectedIndex = "all";
	document.getElementById("avail1").checked = true;
}

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
		$("#bev_query").submit();
	});

	// Callback handler that will be called on failure
	bev_type_request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: " + textStatus, errorThrown);
	});
}
var bev_type = "<?php echo $_POST['lookup_type']; ?>"
// Get beverage type.
getBevTypes(bev_type);
</script>
</head>
<body>
<h1>Beverage Lookup</h1>
<p id="query">
<form id="bev_query">
<input type="radio" id="avail1" name="avail" value="1"/> Available<input type="radio" name="avail" id="avail0" value="0" /> Not Available<input type="radio" name="avail" id="avail2" value="2" /> Doesn't Matter<br />
Search by Name: <input type='text' id='bev_name' name='bev_name' size='20' pattern="[a-zA-Z0-9! ,.?\/'#~$£%&*()-+:@]*" title="Invalid input." maxlength='40' autofocus />
Search by Type: <select name="bev_type" id='bev_type'>
<option value="all">All</option>
</select>
<br /><br />
<input type="submit" value="Query" />
<input type="button" onclick="resetForm()" value="Clear"> 
</form>
<br />
<form method="POST" action="index.php">
<input type="hidden" name="command" value="back"/><input type="submit" value="Back"/>
</form>
</p>
<p id="result"></p>
</body>
</html>