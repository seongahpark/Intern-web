<?php
$pagenum		= $_REQUEST['pagenum'];
$search_select	= $_REQUEST['search_select'];//내용검색
$keyword		= $_REQUEST['keyword'];//검색어
$enc_keyword	= urlencode($_REQUEST['keyword']);//검색어
$tab			= $_REQUEST['tab'];
$idx			= $_REQUEST['idx'];//기본키
//$modes			= $_REQUEST['modes'];//동작 구분

//$onoff			= $_REQUEST['onoff'];

$comment = $_GET['idx'];
$comment = $_POST['comment'];
$comment_id = $_POST['comment_id'];
$comment_date = date("Y-m-d");

$sql="insert into";
$sql=$sql." board_event_comment (comment, comment_id, comment_date) ";
$sql=$sql." values('".$comment."', '".$comment_id."', '".$comment_date."')";
$sql=$sql." where `idx` = '" .$idx. "'";


//스마티 변수 할당
$etc['Board_Tmp_Save_Time']	= $Board_Tmp_Save_Time;//config_init.php 에 있음
$etc['board_title']		= $board_title;
$etc['menu']			= $menu;
$etc['tn']				= $tn;
$etc['tab']				= $tab;
$etc['mode']			= $mode;
$etc['modes']			= $modes;

$etc['search_select']	= $search_select;
$etc['keyword']			= $keyword;
$etc['enc_keyword']		= $enc_keyword;
$etc['pagenum']			= $pagenum;
$etc['pageclick']		= $pageclick;

$etc['onoff']		= $onoff;


/*
##스마티에 변수 담기#################
$smarty = new Smarty;
$smarty->compile_check	= true;
$smarty->compile_dir	= Compile_PATH;
$smarty->template_dir	= Template_PATH.$FILE_FOLDER;
$smarty->debugging		= 0;

$smarty->assign("L", $fix_rows);
$smarty->assign("etc", $etc);//기타

##템플릿 페이지 연결#################
$main_contents = $FILE_SKIN."write.tpl.htm";
$smarty->clear_compiled_tpl();
$smarty->display($main_contents, '', $FILE_FOLDER);
*/
?>