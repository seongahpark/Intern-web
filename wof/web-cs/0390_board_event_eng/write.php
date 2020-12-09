<?php
$pagenum		= $_REQUEST['pagenum'];
$search_select	= $_REQUEST['search_select'];//내용검색
$keyword		= $_REQUEST['keyword'];//검색어
$enc_keyword	= urlencode($_REQUEST['keyword']);//검색어
$tab			= $_REQUEST['tab'];
$idx			= $_REQUEST['idx'];//기본키
$modes			= $_REQUEST['modes'];//동작 구분

$onoff			= $_REQUEST['onoff'];

//넘어오는 값은 항상 고정, 없거나 write, modify... 그 이외의 것은 기본 글 쓰기로 취급
if($mode=='' || ($mode!='write' && $mode!='modify'))
{
	$mode='write';
}

if($mode=='write')
{
	$modes='write';
}
else//쓰기가 아닐경우 수정, 쓰기/수정 이외의 것은 process에서....
{
	$modes='modify';

	$sql="select * from ".$DB_TABLE." where isdel='0' and idx='".$idx."'";

	@$rs_board = $conn->Execute($sql);

	if(!$rs_board)
	{
		error_msg('DB 질의가 실패했습니다.\\n에러코드['.$menu.':001]');
		exit;
	}
	if($rs_board->_numOfRows)
	{
		foreach($rs_board->fields as $key => $value)
		{
			$value=stripslashes($value);
			//input type value="" 형식으로 들어가는 것은 " 치환
			if($key=='title')
			{
				$value=str_replace('"', '&quot;', $value);
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
}

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
?>