<?php
//공통모듈
require_once "../common/config_www.php";

if(!LOGIN_ID) location_href("../");
if($_SESSION['login_auth']==1) location_href("../");

$_incFile['vacList']	= 'inc_vacationList_new.php';
$_incFile['vacWrite']	= 'inc_vacationWrite_new.php';
$_incFile['vacModi']	= 'inc_vacationModi_new.php';
//$_incFile['carview']	= 'inc_carView.php';
//$_incFile['view']	= 'view.php';
//$_incFile['write']	= 'write.php';
//$_incFile['modi']	= 'modi.php';

$defaultFile		= 'carlist';

$sv				  = !$_GET['sv']   ? 'cp_name'	    : $_GET['sv'];
$sw				  = !$_GET['sw']   ? ''				: urldecode($_GET['sw']);
$sw				  = removeScript($sw);
$idx			  = !is_numeric($_GET['idx'])	?	0	: $_GET['idx'];
$page			  = !is_numeric($_GET['page'])	?	0	: $_GET['page'];
$id				  = !$_GET['id']				?	""	: $_GET['id'];

$view			  = !$_GET['view'] ? $defaultFile   : $_GET['view'];
$viewflag		  = in_array($view,array_keys($_incFile));
$view			  = $viewflag==true ? $view : $defaultFile;
$contentsPath	  = $_incFile[$view];


$_params['now']	  = "view=".$view."&id=".$id;
$_params['list']  = "view=list&page=".$page."&sv=".$sv."&sw=".$sw;
$_params['modi']  = "view=modi&id=".$id."&page=".$page."&sv=".$sv."&sw=".$sw;

$depth01		  = "휴가신청";
$depth02		  = $dis;



//메뉴위치
$t_menu12="_on";
$s_menu1="abt";$s_menu2="abt";$s_menu3="abt";$s_menu9="abt";$s_menu4="abt";$s_menu5="abt";$s_menu6="";$s_menu7="abt";$s_menu8="abt";$s_menu10="abt";



require_once DESIGN_LAYOUT;
?>
