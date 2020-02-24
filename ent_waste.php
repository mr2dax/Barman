<?php 
require 'config.php';
?>
<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title> Wastage Entry </title>
<script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
var next_item = 0;
var item_count = 0;
function deleteLine(id) {
	var del_id = "#" + id;
	$(del_id).remove();
	item_count--;
	if (item_count==0) {
		$('.post').hide();
	}
}
function appendLine() {
	next_item = next_item + 1;
	var id = next_item;
	var currentDate = new Date();
    var day = currentDate.getDate();
	if (day.length < 10) {
		day = "0" + day;
	}
    var month = currentDate.getMonth() + 1;
	if (month < 10) {
		month = "0" + month;
	}
    var year = currentDate.getFullYear();
    currentDate = year + "-" + month + "-" + day;
	var txtfield = "<table border='0' id='" + id + "'>" + 
	"<tr><td>Name: </label></td><td><select required name='name" + id + "'>" + "<?php
		$mysqli = new mysqli("127.0.0.1", $db_user, $db_pass, $db_name);
		$result = $mysqli->query("SELECT ID, Name FROM Beverages");
		while ($row = $result->fetch_assoc()) {
			echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
		}
	?>" + "</select></td></tr><tr><td><label>Volume: </label></td><td><input type='text' required name='vol" + id + "'>" + 
	"</input></td></tr><tr><td><label>Date: </label></td><td><input type='datetime' format='YYYY-MM-DD HH:mm' required value='" + currentDate + "' name='date" + id + "'></input></td></tr><tr><td>" + 
	"<label>Type: </label></td><td><select name='type" + id + "'><option value='0'>Spillage</option><option value='1'>Spoilage</option><option value='2'>Transfer</option><option value='3'>Return</option></td></tr><tr>" +
	"<td>Comment: </label></td><td><input type='text' required name='reason" + id + "'></input><input type='hidden' name='user' value='<?php echo $current_user; ?>'>&nbsp;&nbsp;&nbsp;<button onClick='deleteLine(" + id + ")'>Delete</button></td></tr>&nbsp;<tr></tr></table>";
	$("#fields").append(txtfield);
	$('.post').show();
	item_count++;
}
$( document ).ready(function() {
// Variable to hold request
var request;
// Hide the submit button by default as there are no entry fields present at page load.
$('.post').hide();
// Bind to the submit event of our form
$("#wastage").submit(function(event){
    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var form = $(this);
	var max_item = $(this).find('table:last').attr('id');

    // Let's select and cache all the fields
    var $inputs = form.find("input,select");

    // Serialize the data in the form
    var serializedData = form.serialize() + "&max=" + max_item;

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // Fire off the request to /proc_waste.php
    request = $.ajax({
        url: "/proc_waste.php",
        type: "post",
        data: serializedData,
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        alert("Posted successfully!");
		$('#fields').empty();
		$('.post').hide();
		item_count = 0;
		next_item = 0;
		
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

    // Prevent default posting of form
    event.preventDefault();
});
});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<h1>Wastage Entry</h1></br>
<p id='button'><button onClick="appendLine()">New Entry</button></p>
<form id="wastage" action="proc_waste.php" title="" method="post">
<p id='fields'></p>
</br></br><div>
	<input type="submit" class="post" value="Submit">
</div>
</form>
<?php
	echo "</br></br><form name=logout method=POST action=\"" . CONTROLLER . "\">";
	echo "<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>";
?>
</body>
</html>