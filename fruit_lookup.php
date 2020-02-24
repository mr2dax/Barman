<?php 
require 'config.php';
include "conf.php";
?>
<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title> Fruit/Vegetable Lookup </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<h1>Fruit/Vegetable Lookup</h1></br>
<form action="" method="POST">
Availability:&nbsp;&nbsp;<input type="radio" name="avail" value="1" checked /> Available
<input type="radio" name="avail" value="0" /> Not Available
<input type="radio" name="avail" value="2" /> Doesn't Matter<br />
Search by Name: <input type="text" name="fruit_name" size="15" maxlength="30" />
<br /><br />
<input type="submit" value="Query" /> 
<input type="reset" value="Reset" />
</form><br />
<form name=logout method=POST action="<?php echo CONTROLLER; ?>">
<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>
</body>
</html>
<?php
if ((isset($_POST["avail"])) && (isset($_POST["fruit_name"])))
            {
	// Set query parameters.
        $avail = $_POST["avail"];
		$bev_name = $_POST["fruit_name"];
            }
    else    {
        $avail = "";
		$bev_name = "";
            }
	$table = "Fruit_Veg";
	$con = mysql_connect( "127.0.0.1", $db_user, $db_pass );
	if ( ! $con )
		die( "No connection with the database." );
	mysql_select_db( $db_name, $con )
		or die ( "Cannot open database called $db_name ".mysql_error() );
	// Get everything.
	$query = "SELECT ID, Name, Amount, Metric, Price, Weight FROM " . $table . " WHERE 1=1";
	// Set query conditions accordingly.
	$conditions = " AND Name LIKE '%" . $fruit_name . "%'";
	if ($avail=="1" || $avail=="0")
		{
			$conditions = $conditions .  " AND Avail=" . $avail;
		}
	// Fetch results of constructed query.
	$result = mysql_query( $query . $conditions );
	// Draw results table.
	if ($result) {
			echo "<table border='1'>
			<tr>
			<th>NAME</th>
			<th>AMOUNT</th>
			<th>PRICE</th>
			<th>1 PIECE PRICE</th>
			</tr>";
			while($row = mysql_fetch_array($result)) {
				$id = $row['ID'];
				echo "<tr id=\"" . $id . "\">";
				echo " <td>" . $row['Name'] . "</td>";
				echo " <td>" . $row['Amount'] . " " . $row['Metric'] . "</td>";
				echo " <td>" . $row['Price'] . " HUF</td>";
				echo " <td>" . round($row['Price']/(($row['Amount']*1000)/$row['Weight'])) . " HUF</td>";
				echo "<td><input type='button' value='Edit' name='fruited_$id'></td>";
				echo "<td><input type='button' value='Delete' name='fruitdel_$id'></td></tr>";
				}
			mysql_free_result($result);
			echo "</table>";
			}
	else { echo "<br/>" . "Query unsuccessful!";}
	mysql_close( $con );
?>