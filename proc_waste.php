<?php
# Settings
require 'config.php';
require 'functions.php';

$max = $_POST['max'];
for ($i=1;$i<=$max;$i++) {
	if ($_POST['name' . $i] <> "") {
		$name = $_POST['name' . $i];
		$vol = $_POST['vol' . $i];
		$type = $_POST['type' . $i];
		$date = $_POST['date' . $i];
		$reason = $_POST['reason' . $i];
		$stamp = date('Y-m-d h:i:s', time());
		$by = $_POST['user'];
		$waste_table = "Wastage";
		$ins_query = "INSERT INTO $waste_table (Name, Vol, Date, Type, Reason, Stamp, By_User) VALUES ('$name', '$vol', '$date', '$type', '$reason', '$stamp', '$by')";
		$ins_result = db_connect($db_service, $db_name, $db_user, $db_pass, $ins_query);
	}
}
?>