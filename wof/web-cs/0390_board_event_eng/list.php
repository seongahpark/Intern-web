<?php
$pagenum			= $_REQUEST['pagenum'];
$search_select		= $_REQUEST['search_select'];
$keyword			= $_REQUEST['keyword'];
$enc_keyword		= urlencode($_REQUEST['keyword']);
$tab				= $_REQUEST['tab'];

if(empty($pagenum) || $pagenum=='' || $pagenum<'0')
{
	$pagenum = 0;
}

$page		= 10;
$limit		= 10;

$append=" `isdel`='0'";

$append2=$append2." and `notice`=0";

$append3=$append3." and `notice`=1";

if($keyword)
{
	if($search_select=='all')
	{
		$append=$append." and (`title` like '%".$keyword."%' or `contents` like '%".$keyword."%') ";
	}
	else
	{
		$append=$append." and `".$search_select."` like '%".$keyword."%'";
	}
}

$sql="select count(`idx`) as `cnt` from `".$DB_TABLE."` where ".$append.$append2;
@$rs=$conn->Execute($sql);
if(!$rs)
{
	//error_msg('DB 질의가 실패했습니다.\\n에러코드['.$menu.':001]');
	error_msg('Error['.$menu.':001]');
	exit;
}

$total_count=$rs->fields['cnt'];
$pagesu		= ceil($total_count/$page);

$listnum	= $total_count - $pagenum * $page;

if($pagenum>($pagesu-1) && $pagesu!=0)
{
	$pagenum=$pagesu-1;
}

$offset=$limit*$pagenum;

if($offset<0)
{
	$offset = 0;
}

$rs->close();

$sql="select ";
$sql=$sql." a.* ";
$sql=$sql." from `".$DB_TABLE."` ";
$sql=$sql." a where ".$append;
$sql=$sql.$append2;
$sql=$sql." order by a.`idx` desc ";
$sql=$sql." limit ".$offset.", ".$limit;

@$rs_board = $conn->Execute($sql);

if(!$rs_board)
{
	//error_msg('DB 질의가 실패했습니다.\\n에러코드['.$menu.':002]');
	error_msg('Error['.$menu.':002]');
	exit;
}

while(!$rs_board->EOF)
{
	foreach($rs_board->fields as $key => $value)
	{
		$value=stripslashes($value);
		if($key=='reg_date')
		{
			$value=explode(' ', $value);
		}
		if($key=='title')
		{
			$value=cut_str($value, 32);
		}
		$fix_rows[$rs_board->_currentRow][$key]=$value;
	}
	$fix_rows[$rs_board->_currentRow]['no']=$listnum--;
	$rs_board->MoveNext();
}

$rs_board->close();

$sql="select ";
$sql=$sql." a.* ";
$sql=$sql." from `".$DB_TABLE."` ";
$sql=$sql." a where ".$append;
$sql=$sql.$append3;
$sql=$sql." order by a.`idx` desc ";

@$rs_board = $conn->Execute($sql);

if(!$rs_board)
{
	//error_msg('DB 질의가 실패했습니다.\\n에러코드['.$menu.':003]');
	error_msg('Error['.$menu.':003]');
	exit;
}

while(!$rs_board->EOF)
{
	foreach($rs_board->fields as $key => $value)
	{
		$value=stripslashes($value);
		if($key=='reg_date')
		{
			$value=explode(' ', $value);
		}
		if($key=='title')
		{
			$value=cut_str($value, 32);
		}
		$fix_rows2[$rs_board->_currentRow][$key]=$value;
	}
	$fix_rows2[$rs_board->_currentRow]['no']=$listnum--;
	$rs_board->MoveNext();
}

$rs_board->close();

if($FILE_SKIN=='_a')
{
	$opt='&tab='.$tab;
	$pageclick = PageModule($total_count, $pagenum, $search_select, $keyword, $DB_TABLE, $menu, $page, $opt, 1);
}
else
{
	$opt='';
	$pageclick = cPageModule($total_count, $pagenum, $search_select, $keyword, $DB_TABLE, $menu, $page, $opt, 0);
}

$etc['Admin_Login_Path']	= $Admin_Login_Path;
$etc['Admin_Master_Path']	= $Admin_Master_Path;
$etc['Admin_First_Path']	= $Admin_First_Path;

$etc['board_title']			= $board_title;
$etc['menu']				= $menu;
$etc['tn']					= $tn;
$etc['tab']					= $tab;

$etc['search_select']		= $search_select;
$etc['keyword']				= $keyword;
$etc['enc_keyword']			= $enc_keyword;
$etc['pagenum']				= $pagenum;
$etc['pageclick']			= $pageclick;

$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->compile_dir = Compile_PATH;
$smarty->template_dir = Template_PATH.$FILE_FOLDER;
$smarty->debugging = 0;

$smarty->assign("L", $fix_rows);
$smarty->assign("L2", $fix_rows2);

$smarty->assign("etc", $etc);

$main_contents = $FILE_SKIN."list.tpl.htm";
$smarty->clear_compiled_tpl();
$smarty->display($main_contents, '', $FILE_FOLDER);
?>