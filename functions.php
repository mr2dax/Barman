<?php
# Settings
require 'config.php';

# Custom functions

# Establish connection to database.
# Input: query
# Output: query result rows as 2D array
function db_connect($query ) {
	$db = new mysqli(DBSERV, DBUSER, DBPASS, DBNAME);
	# Connect to the database and handle errors, if any.
	if($db->connect_errno > 0){
		die('Unable to connect to database [' . $db->connect_error . ']');
	}
	# Run the query.
	$sql = $query;
	if(!$result = $db->query($sql)) {
		die('There was an error running the query [' . $db->error . ']');
	}
	# Closes connection to database service.
	$db->close();
	
	return $result;
}

# Get all types of the beverages and set selected one if applicable.
# Input: result of a query, selected option
# Output: none
function print_bev_types($result,$selected_id) {
	# Get each row of data and print it out.
	while($row = $result->fetch_assoc()) {
		$type_id = $row['ID'];
		$type_name = $row['Type'];
		echo "<option value='$type_id'";
		if ($selected_id==$type_id) {
			echo " selected";
		}
		echo ">$type_name</option>";
	}
}

# Get beverages according to condition.
# Input: result of a query, selected option
# Output: none
function print_selected($result) {
	# Get each row of data and print it out.
	while($row = $result->fetch_assoc()) {
		$id = $row['ID'];
		$name = $row['Name'];
		echo "<option value='$id'>$name</option>";
	}
}

# Get all suppliers and set selected one if applicable.
# Input: result of a query, selected option
# Output: none
function print_sup_types($result, $selected_id) {
	# Get each row of data and print it out.
	while($row = $result->fetch_assoc()) {
		$sup_id = $row['ID'];
		$sup_name = $row['Name'];
		echo "<option value='$sup_id'";
		if ($selected_id==$sup_id) {
			echo " selected";
		}
		echo ">$sup_name</option>";
	}
}

# Get all glass types and set selected one if applicable.
# Input: result of a query, selected option
# Output: none
function print_gls_types($result, $selected_id) {
	# Get each row of data and print it out.
	while($row = $result->fetch_assoc()) {
		$gls_id = $row['ID'];
		$gls_name = $row['Name'];
		echo "<option value='$gls_id'";
		if ($selected_id==$gls_id) {
			echo " selected";
		}
		echo ">$gls_name</option>";
	}
}

# Get all technique types and set selected one if applicable.
# Input: result of a query, selected option
# Output: none
function print_tech_types($result, $selected_id) {
	# Get each row of data and print it out.
	while($row = $result->fetch_assoc()) {
		$tech_id = $row['ID'];
		$tech_name = $row['Name'];
		echo "<option value='$tech_id'";
		if ($selected_id==$tech_id) {
			echo " selected";
		}
		echo ">$tech_name</option>";
	}
}

# Get all types of the inventories and set selected one if applicable.
# Input: result of a query, selected option
# Output: none
function print_inv_dates($result, $selected_id) {
	# Get each row of data and print it out.
	while($row = $result->fetch_assoc()) {
		$inv_id = $row['ID'];
		$inv_date = $row['Inv_Date'];
		echo "<option value='$inv_id'";
		if ($selected_id==$inv_id) {
			echo " selected";
		}
		echo ">" . substr($inv_date,0,10) . "</option>";
	}
}

# Get all ids and names of beverages for javascript.
# Input: result of a query
# Output: id and names of beverages (str)
function get_bev($result) {
	$bev_array = "";
	# Get each row of data and print it out.
	while($row = $result->fetch_assoc()) {
		$bev_id = $row['ID'];
		$bev_name = $row['Name'];
		$bev_array = $bev_array . $bev_id . ": '" . $bev_name . "', ";
	}
	$bev_array = substr($bev_array, 0, -2);
	return $bev_array;
}

# Generate html code of table headers.
# Input: table header fields
# Output: string of the html table headers
function print_table_headers($headers) {
	$table_header = "<table border='1'><tr>";
	for ($i=0;$i<count($headers);$i++) {
		$table_header .= "<th>" . strtoupper($headers[$i]) . "</th>";
	}
	$table_header .= "</tr>";
	
	return $table_header;
}

# Generate html code of beverages formatted as table rows.
# Input: result of a query
# Output: string of the html table rows
function print_bev_table($result,$bev_name,$bev_type,$avail) {
	$table_rows = "";
	# Constructing a query to get data of latest inventory.
	$inv_table = INV_TBL;
	$inv_query = "SELECT `Inventory`,`Inv_Date` FROM `$inv_table` WHERE 1=1 AND `Type`='1' ORDER BY `Inv_Date` DESC LIMIT 1";
	$inv_query_result = db_connect($inv_query);
	$row = $inv_query_result->fetch_assoc();
	$inv = $row['Inventory'];
	$latest_inv = $row['Inv_Date'];
	$inv_query_result->free();
	# Constructing a query to get requisitions since latest inventory.
	$req_table = REQ_TBL;
	$req_query = "SELECT `Requisition` FROM `$req_table` WHERE `Type`='1' AND `Req_Date`>=\"" . $latest_inv . "\"";
	$req_query_result = db_connect($req_query);
	$reqs = "";
	while($row = $req_query_result->fetch_assoc()) {
		$reqs .= $row['Requisition'] . ",";
	}
	$reqs = substr($reqs,0,strlen($reqs)-1);
	$req_query_result->free();
	#Constructing a query to get wastages since latest inventory.
	$waste_table = WASTE_TBL;
	$waste_query = "SELECT `Name`, `Vol` FROM `$waste_table` WHERE `Prod_Type`='1' AND `Date`>=\"" . $latest_inv . "\"";
	$waste_query_result = db_connect($waste_query);
	$wastes = "";
	while($row = $waste_query_result->fetch_assoc()) {
		$wastes .= $row['Name'] . "-" . (string)$row['Vol'] . ",";
	}
	$wastes = substr($wastes,0,strlen($wastes)-1);
	$waste_query_result->free();
	$inv_arr = explode(",",$inv);
	$req_arr = explode(",",$reqs);
	$waste_arr = explode(",",$wastes);
	# Print each row of result.
	while($row = $result->fetch_assoc()) {
		$id = $row['ID'];
		# Calculate and indicate discounts, if any.
		if ($row['Alc']==1 && $row['Supplier']=="Raiker") {
			$price = round($row['Price']*((100-RAIKER_ALC)/100));
			$disc=1;
		} elseif ($row['Alc']==0 && $row['Supplier']=="Raiker") {
			$price = round($row['Price']*((100-RAIKER_NONALC)/100));
			$disc=1;
		} else {
			$price = $row['Price'];
			$disc=0;
		}
		$table_rows .= "<tr id=\"" . $id . "\"><td align='left'>" . $row['Name'] . "</td><td align='center'>" . (float)$row['Vol'] . " " . VOL_MET . "</td><td align='right'>" . $price . " ". CURRENCY;
		if ($disc==1) {
			$table_rows .= "<b> (d.)</b></td>";
		} else {
			$table_rows .= "</td>";
		}
		$table_rows .= "<td align='right'>" . round($price/$row['Vol']/100) . " " . CURRENCY . "</td><td align='right'>" . round($price/$row['Vol']/100*4) . " " . CURRENCY . "</td><td align='right'>" . $row['Sell_Price'] . " " . CURRENCY . "</td><td align='right'>" . $row['Tot_Price'] . " " . CURRENCY . "</td>";
		# Calculate current stock.
		$stock = 0;
		foreach ($inv_arr as $inv) {
			$inv_item = explode("-",$inv);
			if ($inv_item[0] == $id) {
				$stock += $inv_item[1];
			}
		}
		foreach ($req_arr as $req) {
			$req_item = explode("-",$req);
			if ($req_item[0] == $id) {
				$stock += $req_item[1];
			}
		}
		foreach ($waste_arr as $waste) {
			$waste_item = explode("-",$waste);
			if ($waste_item[0] == $id) {
				$stock -= round($waste_item[1]/$row['Vol'],2);
			}
		}
		$table_rows .= "<td align='center'>" . $stock . "</td>";
		# Print edit and delete buttons.
		$table_rows .= "<td align='center'><form action='" . CONTROLLER . "' method='POST' name='edit_" . $id . "' id='edit_" . $id . "'><input type='hidden' name='command' value='edit_bev'><input type='hidden' name='edit_id' value='" . $id . "'><input type='hidden' name='lookup_name' value='$bev_name'><input type='hidden' name='lookup_type' value='$bev_type'><input type='hidden' name='lookup_avail' value='$avail'><input type='submit' value='Edit'></form></td><td align='center'><button type='button' id='del_" . 
		$id . "' onClick=\"delBev('del_" . $id . "')\">Delete</button></td></tr>";
		}
	
	$result->free();
	return $table_rows .= "</table></br></br><form name=logout method=POST action=" . CONTROLLER . "><input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>";
}

# Generate html code of garnishes formatted as table rows.
# Input: result of a query
# Output: string of the html table rows
function print_gar_table($result) {
	$table_rows = "";
	# Constructing a query to get data of latest inventory.
	$inv_table = INV_TBL;
	$inv_query = "SELECT `Inventory`,`Inv_Date` FROM `$inv_table` WHERE 1=1 AND `Type`='3' ORDER BY `Inv_Date` DESC LIMIT 1";
	$inv_query_result = db_connect($inv_query);
	$row = $inv_query_result->fetch_assoc();
	$inv = $row['Inventory'];
	$latest_inv = $row['Inv_Date'];
	$inv_query_result->free();
	# Constructing a query to get requisitions since latest inventory.
	$req_table = REQ_TBL;
	$req_query = "SELECT `Requisition` FROM `$req_table` WHERE `Type`='3' AND `Req_Date`>=\"" . $latest_inv . "\"";
	$req_query_result = db_connect($req_query);
	$reqs = "";
	while($row = $req_query_result->fetch_assoc()) {
		$reqs .= $row['Requisition'] . ",";
	}
	$reqs = substr($reqs,0,strlen($reqs)-1);
	$req_query_result->free();
	#Constructing a query to get wastages since latest inventory.
	$waste_table = WASTE_TBL;
	$waste_query = "SELECT `Name`, `Vol` FROM `$waste_table` WHERE `Prod_Type`='3' AND `Date`>=\"" . $latest_inv . "\"";
	$waste_query_result = db_connect($waste_query);
	$wastes = "";
	while($row = $waste_query_result->fetch_assoc()) {
		$wastes .= $row['Name'] . "-" . (string)$row['Vol'] . ",";
	}
	$wastes = substr($wastes,0,strlen($wastes)-1);
	$waste_query_result->free();
	$inv_arr = explode(",",$inv);
	$req_arr = explode(",",$reqs);
	$waste_arr = explode(",",$wastes);
	# Print each row of result.
	while($row = $result->fetch_assoc()) {
		$id = $row['ID'];
		$price = $row['Price'];
		$price_per_piece = $price/$row['Quantity'];
		# Discount calculation.
		$disc=0;
		$table_rows .= "<tr id=\"" . $id . "\"><td align='left'>" . $row['Name'] . "</td><td align='center'>" . $row['Amount'] . " " . $row['Metric'] . " - " . $price . "</td><td align='center'>" . $price_per_piece . " " . CURRENCY;
		if ($disc==1) {
			$table_rows .= "<b> (d.)</b></td>";
		} else {
			$table_rows .= "</td>";
		}
		# Calculate current stock.
		$stock = 0;
		foreach ($inv_arr as $inv) {
			$inv_item = explode("-",$inv);
			if ($inv_item[0] == $id) {
				$stock += $inv_item[1];
			}
		}
		foreach ($req_arr as $req) {
			$req_item = explode("-",$req);
			if ($req_item[0] == $id) {
				$stock += $req_item[1];
			}
		}
		foreach ($waste_arr as $waste) {
			$waste_item = explode("-",$waste);
			if ($waste_item[0] == $id) {
				$stock -= round($waste_item[1],2);
			}
		}
		$table_rows .= "<td align='center'>" . $stock . "</td>";
		# Print edit and delete buttons.
		$table_rows .= "<td align='center'><form action='" . CONTROLLER . "' method='POST' name='edit_" . $id . "' id='edit_" . $id . "'><input type='hidden' name='command' value='edit_gar'><input type='hidden' name='edit_id' value='" . $id . "'><input type='submit' value='Edit'></form></td><td align='center'><button type='button' id='del_" . 
		$id . "' onClick=\"delGar('del_" . $id . "')\">Delete</button></td></tr>";
		}
	
	$result->free();
	return $table_rows .= "</table></br></br><form name=logout method=POST action=" . CONTROLLER . "><input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>";
}

# Print cocktail list.
#Input: result of a query
# Output: html code of cocktails and their ingredients in table format
function print_cock_table($result,$cock_name,$cock_type,$alc,$shot,$in_menu) {
// Build results table.
if ($result) {
	$result_table .= "<table border='1'><tr><th>NAME</th><th>INGREDIENTS</th><th>PRICE PER <br />INGREDIENT</th><th>GARNISHING</th><th>PRICE PER <br />GARNISH</th><th>INFORMATION</th><th>TOTAL PRICE</th><th>SELL PRICE</th></tr>";
	while($row = $result->fetch_assoc()) {
		$id = $row['ID'];
		$comment = $row['Comment'];
		$tech = $row['Tech'];
		$glass = $row['Glass'];
		$sell_price = $row['Price'];
		$result_table .= "<tr id='$id'>";
		$result_table .= " <td>" . $row['Name'] . "</td>";
		$ings = explode(",", $row['Ingredients']);
		$gars = explode(",", $row['Garnish']);
		$ing_count = count($ings);
		$gar_count = count($gars);
		$price = 0;
		$ingredients = "";
		$ings_price = "";
		$garnishes = "";
		$gars_price = "";
		for($k=0;$k<$ing_count;$k++) {
			$ing = explode("-", $ings[$k]);
			switch ($ing[0]) {
			case "b":
				$ltable = BEV_TBL;
				$columns = "`Name`, `Price`, `Vol`";
				break;
			case "f":
				$ltable = FRUIT_TBL;
				$columns = "`Name`, `Price`, `Amount`, `Weight`, `Metric`";
				break;
			}
			$lquery = "SELECT $columns FROM `$ltable` WHERE 1=1 AND `ID` ='" . $ing[1] . "'";
			$lresult = db_connect($lquery);
			while($lrow = $lresult->fetch_assoc()) {
				switch ($ing[0]) {
				case "b":
					$price += $lrow['Price']/$lrow['Vol']/100*$ing[2]/10;
					$ingredients .= $lrow['Name'] . " - " . $ing[2] . VOL_MET_TOT . "<br />";
					$ings_price .= round($lrow['Price']/$lrow['Vol']/100*$ing[2]/10) . " " . CURRENCY . "<br />";
					break;
				case "f":
					if ($lrow['Metric']=="KG") {
						$price += round(($lrow['Price']/(($lrow['Amount']*1000)/$lrow['Weight']))*$ing[2]);
						$ingredients .= $lrow['Name'] . " - " . $ing[2] . " pc<br />";
						$ings_price .= round(($lrow['Price']/(($lrow['Amount']*1000)/$lrow['Weight']))*$ing[2]) . " " . CURRENCY . "<br />";
					}
					else if ($lrow['Metric']=="PL") {
						$price += round(($lrow['Price']/(($lrow['Amount']*1000)/$lrow['Weight']))*$ing[2]);
						$ingredients .= $lrow['Name'] . "<br />";
						$ings_price .= round($lrow['Price']*$ing[2]) . " " . CURRENCY . "<br />";
					}
					else {
						$price += round(($lrow['Price']/$lrow['Weight'])*$ing[2]);
						$ingredients .= $lrow['Name'] . " - " . $ing[2] . " pc<br />";
						$ings_price .= round(($lrow['Price']/$lrow['Weight'])*$ing[2]) . " " . CURRENCY . "<br />";
					}
					break;
				}
			}
			$lresult->free;
		}
		for($l=0;$l<$gar_count;$l++) {
			$gar = explode("-", $gars[$l]);
			$ltable = GAR_TBL;
			$columns = "`Name`, `Price`, `Amount`, `Quantity`";
			$lquery = "SELECT $columns FROM `$ltable` WHERE 1=1 AND `ID` ='" . $gar[0] . "'";
			$lresult = db_connect($lquery);
			while($lrow = $lresult->fetch_assoc()) {
				$price += ($lrow['Price']*$lrow['Amount']/$lrow['Quantity']*$gar[1]);
				$garnishes .= $lrow['Name'] . " - " . $gar[1] . " pc<br />";
				$gars_price .= round($lrow['Price']*$lrow['Amount']/$lrow['Quantity']*$gar[1]) . " " . CURRENCY . "<br />";
			}
			$lresult->free;
		}
		$result_table .= " <td>$ingredients</td><td>$ings_price</td><td>$garnishes</td><td>$gars_price</td><td>Glassware: $glass<br />Technique: $tech<br /><br />Comments: $comment</td><td>" . round($price) . " " . CURRENCY . "</td><td>$sell_price" . " " . CURRENCY . "</td><td><form action='" . CONTROLLER . "' method='POST' name='edit_" . $id . 
		"' id='edit_" . $id . "'><input type='hidden' name='command' value='edit_cock'><input type='hidden' name='edit_id' value='" . $id . 
		"'><input type='submit' value='Edit'><input type='hidden' name='lookup_name' value='$cock_name'><input type='hidden' name='lookup_type' value='$cock_type'><input type='hidden' name='lookup_alc' value='$alc'><input type='hidden' name='lookup_shot' value='$shot'><input type='hidden' name='lookup_in_menu' value='$in_menu'></form></td><td align='center'><button type='button' id='del_" . $id . "' onClick=\"delCock('del_" . $id . "')\">Delete</button></td></tr>";
	}
	$result->free;
	$result_table .= "</table></br></br><form method='POST' action='" . CONTROLLER . "'><input type='hidden' name='command' value='back'/><input type='submit' value='Back'></form>";
	} else {
		$result_table .= "<br/>Query unsuccessful!";
	}
	return $result_table;
}

# Get list of inventory sheets.
# Input: result of a query
# Output: none
function list_invs($result) {
	# Print each row of result.
	while($row = $result->fetch_assoc()) {
		$id = $row['ID'];
		$user = $row['By_User'];
		$when = $row['Stamp'];
		$date = substr($row['Inv_Date'],0,10);
		echo "<tr id=\"" . $id . "\">";
		echo " <td>" . $date . "</td>";
		echo " <td>" . $when . "</td>";
		echo " <td>" . $user . "</td>";
		# Print edit and delete buttons.
		echo "<td><form action='view_inv.php' method='get'><input type='hidden' name='inv' value=$id>";
		echo "<button type='submit'>View</button></form></td>";
		echo " <td><form action='edit_inv.php' method='get'><input type='hidden' name='inved' value=$id>";
		echo "<button type='submit'>Edit</button></form></td>";
		echo "<form method='post' action='del_inv.php'>";
		echo "<td><input type='button' value='Delete' name='invdel' value=$id></td></tr>";
		echo "</form>";
		}
	echo "</table>";
	echo "</br></br>";
	echo "<form name=logout method=POST action=" . CONTROLLER . ">";
	echo "<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>";
}

# Get list of beverages according to inventory.
# Input: result of a query
# Output: none
function print_inv_table($result,$pre_inv) {
	# Print each row of result.
	while($row = $result->fetch_assoc()) {
		$id = $row['ID'];
		echo "<tr id=\"" . $id . "\">";
		echo "<td id='name'>" . $row['Name'] . "</td>";
		echo "<td id='vol'>" . (float)$row['Vol'] . " " . VOL_MET . "</td>";
		echo "<td id='amount'><input type='text' name='amount$id' pattern=\"[0-9]{1,2}[.]{1}[0-9]{1,3}*\" title=\"Pattern: xx.yyy\" size='5' maxlength='5' value='0' /></td>";
		echo "</form>";
		}
	echo "</table>";
}

# Get list of beverages according to inventory for requisition.
# Input: result of a query
# Output: none
function print_inv_req_table($result) {
	# Print each row of result.
	while($row = $result->fetch_assoc()) {
		$id = $row['ID'];
		echo "<tr id=\"" . $id . "\">";
		echo "<td id='name'>" . $row['Name'] . "</td>";
		echo "<td id='vol'>" . (float)$row['Vol'] . " " . VOL_MET . "</td>";
		echo "<td id='amount'><input type='text' name='amount$id' pattern=\"[0-9]{1,2}[.]{1}[0-9]{1,3}*\" title=\"Pattern: xx.yyy\" size='5' maxlength='5' value='0' /></td>";
		echo "</form>";
		}
	echo "</table>";
}

# Get list of beverages according to the search criteria for Raiker price update.
# Input: result of a query
# Output: none
function print_raiker_update_table($result) {
	# Print each row of result.
	while($row = $result->fetch_assoc()) {
		$id = $row['ID'];
		$price = $row['Price'];
		$vol = $row['Vol'];
		$name = $row['Name'];
		$match = 0;
		# Set site search string
		$site = "http://www.raiker.hu/arlista?searchtext=" . str_replace(" ", "+", $name);
		# Get content of the whole site
		$content = file_get_contents($site);
		# Search for the first occurrence of the name and check if it's the right one
		while($match<>1) {
			# The beverage name to find
			$search_text = 'Szeszesitalok';
			//$name_len = strlen($name);
			# Get the position
			$pos = strpos($content,$search_text);
			# Adjust the position past the '<td>' tag
			$pos = $pos + 7;
			echo "<pre>" . var_dump($pos) . "</pre>";
			# Cache the found beverage name for perfect comparison
			//$found_name = substr($content,$pos,$name_len);
			# Cut the crap from the start of the content string
			$content = substr($content,$pos);
			echo "<pre>" . $content . "</pre>";
			/*
			# Get the volume next to the name
			$search_text = '<td>';
			$vol_len = strlen($vol);
			$vol = (float)$vol;
			$vol = str_replace(".",",",$vol . " l");
			$pos = strpos($content,$search_text);
			# Adjust the position past the '<td>' tag
			$pos = $pos + 4;
			# Cut the crap from the start of the content string
			$content = substr($content,$pos);
			# Find the end of the table cell that contains the volume
			$search_text = '</td>';
			$pos_vol_end = strpos($content,$search_text);
			$found_vol = substr($content, $pos, $pos_vol_end-$pos);
			$found_vol = str_replace(' ','',$found_vol);
			$pos = $pos_vol_end + 4;
			# Cut the crap up until the volume cell's '</td>' end tag
			$content = substr($content,$pos);
			if (($found_name == $name) && ($found_vol == $vol)){
				# Get the price in line with the appropriate name and value
				$search_text = '<td class="price">';
				$pos = strpos($content,$search_text);
				# Adjust the position past the '<td class="price">' tag
				$pos = $pos + 18;
				# Cut the crap from the start of the content string
				$content = substr($content,$pos);
				# Find the end of the price value
				$search_text = ',- Ft</td>';
				$pos_price_end = strpos($content,$search_text);
				$pos_price_end = $pos_price_end - 10;
				$found_price = substr($content, $pos, $pos_price_end-$pos);
				$found_price = str_replace(' ','',$found_price);
				$match = 1;
			} else {
				# Find the start of the next table row
				$search_text = '<tr>';
				$pos = strpos($content,$search_text);
				$pos = $pos + 4;
				}
			}
			if (($match==1) && ($price<>$found_price)) {
			echo "<tr id=\"" . $id . "\">";
			echo "<td>" . $name . "</td>";
			echo "<td>" . (float)$vol . " " . VOL_MET . "</td>";
			echo "<td>" . $price . " " . CURRENCY . "</td>";
			echo "<td>" . $found_price . " " . CURRENCY . "</td>";
			echo "</tr>";
	*/}}
		echo "</table>";
	}

# Get list of beverages and their amounts for stock.
# Input: result of a query
# Output: none
function print_inv_view_table($inv_result,$db_name,$db_service,$db_user,$db_pass) {
	# Print each row of result.
	$row = mysql_fetch_array($inv_result);
	$inventory = $row['Inventory'];
	$inv = explode(",",$inventory);
	$count = count($inv);
	for($i=0;$i<$count;$i++){
		$element = $inv[$i];
		$item = explode("-",$element);
		# Constructing the query.
		$bev_table = "Beverages";
		$bev_query = "SELECT Name, Vol FROM " . $bev_table . " WHERE ID=" . $item[0];
		# Fetch results.
		$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $bev_query);
		$bev = mysql_fetch_array($query_result);
		echo "<tr id=\"" . $item[0] . "\">";
		echo "<td id='name'>" . $bev['Name'] . "</td>";
		echo "<td id='vol'>" . (float)$bev['Vol'] . " " . VOL_MET . "</td>";
		echo "<td id='amount'>" . $item[1] . "</td>";
		echo "</tr>";
		mysql_free_result($query_result);
	}
	echo "</table>";
	echo "</br></br>";
	echo "<form name=logout method=POST action=" . CONTROLLER . ">";
	echo "<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>";
}

# Get list of beverages and their amounts for consumption.
# Input: result of a query
# Output: none
function print_cons_rep_table($inv_result,$db_name,$db_service,$db_user,$db_pass,$req,$waste,$prev_inv_result) {
	# Print each row of result.
	$row = mysql_fetch_array($inv_result);
	$pre_row = mysql_fetch_array($prev_inv_result);
	$inventory = $row['Inventory'];
	$pre_inventory = $pre_row['Inventory'];
	$inv = explode(",",$inventory);
	$pre_inv = explode(",",$pre_inventory);
	# Requisitions summary
	$reqs = explode(",",$req);
	$count = count($inv);
	$pre_count = count($pre_inv);
	$req_count = count($reqs);
	$total_cons=0;
	# Wastage summary
	$wastes = explode(",",$waste);
	$waste_count = count($wastes);
	for($i=0;$i<$count;$i++){
		$element = $inv[$i];
		$pre_element = $pre_inv[$i];
		$item = explode("-",$element);
		$pre_item = explode("-",$pre_element);
		# Constructing the query.
		$bev_table = "Beverages";
		$bev_query = "SELECT Name, Vol, Price, Sell_Price FROM " . $bev_table . " WHERE ID=" . $item[0];
		# Fetch results.
		$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $bev_query);
		$bev = mysql_fetch_array($query_result);
		echo "<tr id=\"" . $item[0] . "\">";
		echo "<td id='name'>" . $bev['Name'] . "</td>";
		echo "<td id='vol'>" . (float)$bev['Vol'] . " " . VOL_MET . "</td>";
		if($pre_item[0]==$item[0]) {
			echo "<td id='pre_inv' align='center'>" . $pre_item[1] . "</td>";
		} else {
			echo "<td id='pre_inv' align='center'>No data.</td>";
		}
		echo "<td id='req' align='center'>";
		$sumreq = 0;
		for($j=0;$j<$req_count;$j++){
			$req_item=explode("-",$reqs[$j]);
			if($req_item[0]==$item[0]){
				$sumreq = $sumreq + $req_item[1];
			}
		}
		echo $sumreq;
		echo "</td>";
		echo "<td id='waste' align='center'>";
		$sumwaste = 0;
		for($k=0;$k<$waste_count;$k++){
			$waste_item=explode("-",$wastes[$k]);
			if($waste_item[0]==$item[0]){
				$sumwaste = $sumwaste + $waste_item[1];
			}
		}
		echo $sumwaste;
		echo " " . VOL_MET . "</td>";
		echo "<td id='inv' align='center'>" . $item[1] . "</td>";
		echo "<td id='cons' align='center'>" . round(($pre_item[1]-$item[1]+$sumreq-($sumwaste/(float)$bev['Vol'])),2) . " (" . ((($pre_item[1]-$item[1]+$sumreq)*(float)$bev['Vol'])-$sumwaste) . " " . VOL_MET . ")</td>";
		$total_cons=$total_cons + (($pre_item[1]-$item[1]+$sumreq+$sumwaste)*$bev['Price']);
		echo "<td id='retprice' align='center'>" . (($pre_item[1]-$item[1]+$sumreq+$sumwaste)*$bev['Price']) . "</td>";
		$total_sold=$total_sold + (($pre_item[1]-$item[1]+$sumreq)*$bev['Sell_Price']);
		echo "<td id='sellprice' align='center'>" . (($pre_item[1]-$item[1]+$sumreq)*$bev['Sell_Price']) . "</td>";
		echo "</tr>";
		mysql_free_result($query_result);
	}
	echo "Total Retail Cost: " . $total_cons . "</br></br>";
	echo "Total Sold: " . $total_sold . "</br></br>";
	echo "Total Revenue: " . ($total_sold-$total_cons) . "</br></br>";
	echo "</table>";
	echo "</br></br>";
	echo "<form name=logout method=POST action=" . CONTROLLER . ">";
	echo "<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>";
}

# Get list of beverages and their amounts for consumption.
# Input: result of a query
# Output: none
function print_stock_table($inv_result,$db_name,$db_service,$db_user,$db_pass,$req) {
	# Print each row of result.
	$row = mysql_fetch_array($inv_result);
	$inventory = $row['Inventory'];
	$inv = explode(",",$inventory);
	$count = count($inv);
	# Requisitions summary
	$reqs = explode(",",$req);
	$req_count = count($reqs);
	for($i=0;$i<$count;$i++){
		$element = $inv[$i];
		$item = explode("-",$element);
		# Constructing the query.
		$bev_table = "Beverages";
		$bev_query = "SELECT Name, Vol FROM " . $bev_table . " WHERE ID=" . $item[0];
		# Fetch results.
		$query_result = db_connect($db_service, $db_name, $db_user, $db_pass, $bev_query);
		$bev = mysql_fetch_array($query_result);
		echo "<tr id=\"" . $item[0] . "\">";
		echo "<td id='name'>" . $bev['Name'] . "</td>";
		echo "<td id='vol'>" . (float)$bev['Vol'] . " " . VOL_MET . "</td>";
		echo "<td id='stock' align='center'>";
		$sumreq = 0;
		for($j=0;$j<$req_count;$j++){
			$req_item=explode("-",$reqs[$j]);
			if($req_item[0]==$item[0]){
				$sumreq = $sumreq + $req_item[1];
			}
		}
		$amount = $sumreq + $item[1];
		echo $amount . " btls (" . round((((float)$bev['Vol'])*1000)*(float)$amount/1000,2) . " " . VOL_MET . ")";
		echo "</td>";
		echo "</tr>";
		mysql_free_result($query_result);
	}
	echo "</table>";
	echo "</br></br>";
	echo "<form name=logout method=POST action=" . CONTROLLER . ">";
	echo "<input type=hidden name=command value='back'/><input type=submit value=Back><br /><br /></form>";
}
?>