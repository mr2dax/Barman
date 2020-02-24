<?php
ini_set('session.save_path',getcwd(). '/sessions');
if (@session_id() == "") @session_start();

if (!$_SESSION['status'] || $_SESSION['status'] == 'failed') {
  $parameter['command']='login';
}

define('DEFAULTPAGE', 'welcome.php');
define('USERS', 'etc/passwd.txt');
$parameter = array_merge($_GET, $_POST);

function clearing_input($input_array) {
  foreach ($input_array as $key=>$value) {
    $value = strip_tags($value, '<b><i><u>');
    $value = preg_replace('/\r\n|\r|\n/', '<br>', $value);
    $value = str_replace('|', '&#124;', $value);
    $input_array[$key] = $value;
  }
  return $input_array;
}

$parameter = clearing_input($parameter);

switch($parameter['command']) {
  case 'login':
    $_SESSION['status'] = 'failed';
    $users = file(USERS);
    foreach($users as $line) {
      list ($user, $pass) = explode(':', chop($line));
      if ($user==$parameter['login'] && $pass==md5($parameter['passwd'])) {
        $_SESSION['status'] = 'ok';
        $_SESSION['user'] = $user;
        $_SESSION['attempts'] = 1;
        break;
      }
    }
    if ($_SESSION['status']=='ok') {
      require 'start.php';
    } else {
      $_SESSION['attempts']++;
      if ($_SESSION['attempts'] > 3) {
        sleep(10);
      }
      require DEFAULTPAGE;
    }
    break;
  case 'logout':
	session_unset(); 
    session_destroy();
	$cookieParams = session_get_cookie_params();
	setcookie(session_name(), '', 0, $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']);
	$_SESSION = array();
    require DEFAULTPAGE;
    break;
  case 'back':
    require 'start.php';
    break;
  case 'bev_lookup':
    require 'bev_lookup.php';
	break;
  case 'gar_lookup':
    require 'gar_lookup.php';
	break;
  case 'fruit_lookup':
    require 'fruit_lookup.php';
	break;
  case 'cock_lookup':
    require 'cock_lookup.php';
	break;
  case 'new_cock':
    require 'new_cock.php';
	break;
  case 'new_bev':
    require 'new_bev.php';
	break;
  case 'new_gar':
    require 'new_gar.php';
	break;
  case 'new_fruit':
    require 'new_fruit.php';
	break;
  case 'ent_inv':
    require 'ent_inv.php';
	break;
  case 'ent_req':
    require 'ent_req.php';
	break;
  case 'ent_waste':
    require 'ent_waste.php';
	break;
  case 'rep_cons':
    require 'rep_cons.php';
    break;
  case 'rep_stock':
    require 'rep_stock.php';
    break;
  case 'rep_inv':
    require 'rep_inv.php';
    break;
  case 'edit_bev':
    require 'edit_bev.php';
    break;
  case 'edit_cock':
    require 'edit_cock.php';
    break;
  case 'back_2_bev_lookup':
    require 'bev_lookup.php';
	break;
  case 'back_2_cock_lookup':
    require 'cock_lookup.php';
	break;
  default:
    require DEFAULTPAGE;
}
?>
