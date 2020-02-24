<?php
require 'config.php';

?>
<!DOCTYPE html PUBLIC
"-//W3C/DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<body>
<head>
<title> BARMAN </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
body {
    background-image: url("barmaaan.jpg");
    background-repeat: no-repeat;
	-webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
</style>
</head>
<h1><font color="white"><b>Welcome to</b></font></h1>
<br><br><br><br><br><table border=0><tr><td>
<form name=login method=POST action="<?php echo CONTROLLER; ?>">
<input type=hidden name=command value='login' />
<font color="white">Login:</font></td><td><input type=text name=login autofocus size='15' /></td><td></td></tr><tr><td>
<font color="white">Pass:</font></td><td><input type=password name=passwd size='15' /></td></tr><tr><td>
<input type=submit value=GO></td><td>
<?php 
if ($_SESSION['attempts']>=1)
	{
	if ($_SESSION['attempts']>4) 
		{
			echo "<font color=\"white\">No more attempts left, check back later...</font>";
		}
	else
	{
		echo "<font color=\"white\">" . (4-$_SESSION['attempts']) . " login attempt(s) left.</font>";
	}
}
?></td></tr>
</form>
</table>
</br></br></br></br></br></br>
<label><i><center>Web by Xero</br>Copyright 2015</center></i></label>
</body>
</html>
