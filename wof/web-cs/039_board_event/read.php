<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/web-cs/config_init.php';

$pagenum		= $_REQUEST['pagenum'];
$search_select	= $_REQUEST['search_select'];
$keyword		= $_REQUEST['keyword'];
$enc_keyword	= urlencode($_REQUEST['keyword']);
$tab			= $_REQUEST['tab'];

$idx			= $_REQUEST['idx'];

//공지 제외
$append2=$append2." and `notice`=0";

//공지만
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

$sql="select ";
$sql=$sql." a.* ";
$sql=$sql." from `".$DB_TABLE."` a ";
$sql=$sql." where a.`isdel`='0' and a.`idx`='".$idx."'";

@$rs_board = $conn->Execute($sql);

if(!$rs_board)
{
	error_msg('DB 정보 질의가 실패했습니다.\\n에러코드['.$menu.':001]');
	$rs_board->close();
	exit;
}

if($rs_board->_numOfRows)
{
	if($FILE_SKIN=='_c')
	{
		$sql="update `".$DB_TABLE."` set `hits`=`hits`+1 where `idx`='".$idx."'";
		@$rs_hit=$conn->Execute($sql);
		$rs_hit->close();
	}

	foreach($rs_board->fields as $key => $value)
	{
		$value=stripslashes($value);

		if($key=='hits' && $FILE_SKIN=='_c')
		{
			$value=$value+1;
		}
		$fix_rows[$key]=$value;
	}
}
else
{
	error_msg('존재하지 않은 자료입니다.');
	exit;
}
$rs_board->close();

$sql="select ";
$sql=$sql." a.* ";
$sql=$sql." from `".$DB_TABLE."` a ";
$sql=$sql." where `isdel`='0' and `idx` > '" .$idx. "'".$append;
if($fix_rows['notice'])
{
	$sql=$sql.$append3;
}
else
{
	$sql=$sql.$append2;
}
$sql=$sql." order by `idx` asc";
$sql=$sql." limit 0, 1";
$pre = $conn->Execute($sql);
if(!$pre)
{
	error_msg('DB 정보 질의가 실패했습니다.\\n에러코드['.$menu.':002]');
	exit;
}
$p_idx = $pre->fields['idx'];
$p_title = stripslashes($pre->fields['title']);

if ( $p_idx )
{
	if($FILE_SKIN=='_a')
	{
		$pre_s		= "<a href=\"?menu=".$menu."&tn=".$tn."&tab=".$tab."&mode=".$mode."&idx=".$p_idx."&search_select=".$search_select."&keyword=".$enc_keyword."&pagenum=".$pagenum."&onoff=".$onoff."\">".$p_title."</a>";
	}
	else
	{
		$pre_s		= "<a href=\"?mode=".$mode."&idx=".$p_idx."&search_select=".$search_select."&keyword=".$enc_keyword."&pagenum=".$pagenum."\">".$p_title."</a>";
	}
}
else
{
	$pre_s		= '<a href="#none" onclick="return false;">없음.</a>';
}
$pre->close();

$sql="select ";
$sql=$sql." a.* ";
$sql=$sql." from `".$DB_TABLE."` a ";
$sql=$sql." where `isdel`='0' and `idx` < '" .$idx. "'".$append;
if($fix_rows['notice'])
{
	$sql=$sql.$append3;
}
else
{
	$sql=$sql.$append2;
}
$sql=$sql." order by `idx` desc";
$sql=$sql." limit 0, 1";
$next = $conn->Execute($sql);
if(!$next)
{
	error_msg('DB 정보 질의가 실패했습니다.\\n에러코드['.$menu.':003]');
	exit;
}
$n_idx = $next->fields['idx'];
$n_title = stripslashes($next->fields['title']);
if ( $n_idx )
{
	if($FILE_SKIN=='_a')
	{
		$next_s		= "<a href=\"?menu=".$menu."&tn=".$tn."&tab=".$tab."&mode=".$mode."&idx=".$n_idx."&search_select=".$search_select."&keyword=".$enc_keyword."&pagenum=".$pagenum."&onoff=".$onoff."\">".$n_title."</a>";
	}
	else
	{
		$next_s		= "<a href=\"?mode=".$mode."&idx=".$n_idx."&search_select=".$search_select."&keyword=".$enc_keyword."&pagenum=".$pagenum."\">".$n_title."</a>";
	}
}
else
{
	$next_s		= '<a href="#none" onclick="return false;">없음.</a>';
}
$next->close();

$etc['Admin_Login_Path']	= $Admin_Login_Path;
$etc['Admin_Master_Path']	= $Admin_Master_Path;
$etc['Admin_First_Path']	= $Admin_First_Path;

$etc['board_title']		= $board_title;
$etc['menu']			= $menu;
$etc['tn']				= $tn;
$etc['tab']				= $tab;

$etc['search_select']	= $search_select;
$etc['keyword']			= $keyword;
$etc['enc_keyword']		= $enc_keyword;
$etc['pagenum']			= $pagenum;
$etc['pageclick']		= $pageclick;

$etc['pre_s']			= $pre_s;
$etc['next_s']			= $next_s;

$etc['comment'] = $_POST['comment'];
$etc['comment_id'] = $_POST['comment_id'];
$etc['comment_date'] = $_POST['comment_date'];

/////////////////////////////////////////////////
$smarty = new Smarty;
$smarty->compile_check	= true;
$smarty->compile_dir	= Compile_PATH;
$smarty->template_dir	= Template_PATH.$FILE_FOLDER;
$smarty->debugging		= 0;

$smarty->assign("L", $fix_rows);

$smarty->assign("etc", $etc);
$main_contents = $FILE_SKIN."read.tpl.htm";
$smarty->clear_compiled_tpl();
$smarty->display($main_contents, '', $FILE_FOLDER);
?>