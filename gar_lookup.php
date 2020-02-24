<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title> Garnish Lookup </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
// After the document has finished loading.
$(document).ready(function() {
// Variable to hold request.
var gar_request;
// Bind to the submit event of the query form.
$("#gar_query").submit(function(event){
    // Abort any pending requests.
    if (gar_request) {
        gar_request.abort();
    }
    // Get the query form.
    var form = $(this);
    // Select and cache all the input fields of the form.
    var $inputs = form.find("input");
    // Serialize all the data in the form.
    var serializedData = form.serialize();
	// Set type of lookup to beverage.
	var type = "&lookup_type=gar";
	
    // Disable the inputs for the duration of the Ajax request.
    // Note: disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);
	
    // Fire off the request to the processing php script.
    gar_request = $.ajax({
        url: "/proc_lookup.php",
        type: "post",
        data: serializedData + type,
		dataType: "html"
    });

    // Callback handler that will be called on success.
    gar_request.done(function (gar_response, textStatus, jqXHR){
		// Refresh the result pane with the new data.
		$('#result').empty();
		$('#result').append(gar_response);
    });

    // Callback handler that will be called on failure.
    gar_request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console.
        console.error("The following error occurred: " + textStatus, errorThrown);
    });

    // Callback handler that will be called regardless if the request failed or succeeded.
    gar_request.always(function () {
        // Re-enable the inputs.
        $inputs.prop("disabled", false);
    });

    // Prevent default posting of form.
    event.preventDefault();
});

});

// Delete row when corresponding button is clicked and hide the row from the list.
function delGar(del_id){
	// Formulate the id of the garnish to delete from the database and the id of the table row to hide.
	var hide_row = "#" + del_id.substr(4);
	var info = "id=" + del_id.substr(4) + "&del_type=gar";
	if (confirm ("Do you really want to delete this garnish? It cannot be undone!")) {
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
	document.getElementById('gar_query').reset();
	$("#gar_name").val("");
    document.getElementById("gar_type").selectedIndex = "all";
	document.getElementById("avail1").checked = true;
}
</script>
</head>
<body>
<h1>Garnish Lookup</h1>
<p id="query">
<form id="gar_query">
<input type="radio" id="avail1" name="avail" value="1" checked /> Available<input type="radio" name="avail" id="avail0" value="0" /> Not Available<input type="radio" name="avail" id="avail2" value="2" />Doesn't Matter<br />
Search by Name: <input type='text' id='gar_name' name='gar_name' size='20' pattern="[a-zA-Z0-9! ,.?\/'#~$£%&*()-+:@]*" title="Invalid input." maxlength='40' autofocus />
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