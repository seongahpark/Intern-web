<?php
$modes	= $_REQUEST['modes'];
$idx	= $_REQUEST['idx'];
$tab	= $_REQUEST['tab'];
$ip		= $_SERVER['REMOTE_ADDR'];
$pagenum		= $_REQUEST['pagenum'];
$search_select	= $_REQUEST['search_select'];//내용검색
$keyword		= $_REQUEST['keyword'];//검색어
$enc_keyword	= urlencode($_REQUEST['keyword']);//검색어

if($FILE_SKIN=='_a')
{
	$user_idx	=$_SESSION['_ADMIN_IDX'];
	$user_id	=$_SESSION['_ADMIN_ID'];
	$user_name	=$_SESSION['_ADMIN_NAME'];
}

//성공/실패 시 이동 경로
if($modes=='write')
{
	$error_link='?mode=write&menu='.$menu.'&tn='.$tn.'&tab='.$tab.'&search_select='.$search_select.'&keyword='.$keyword.'&pagenum='.$pagenum;//실패 후 이동 경로
	$success_link='?menu='.$menu.'&tn='.$tn.'&tab='.$tab.'&mode=list';//성공 후 이동 경로
}
else if($modes=='modify')
{
	$error_link='?menu='.$menu.'&tn='.$tn.'&tab='.$tab.'&mode=read&idx='.$idx.'&search_select='.$search_select.'&keyword='.$keyword.'&pagenum='.$pagenum;//실패 후 이동 경로
	$success_link='?menu='.$menu.'&tn='.$tn.'&tab='.$tab.'&mode=read&idx='.$idx.'&search_select='.$search_select.'&keyword='.$keyword.'&pagenum='.$pagenum;//성공 후 이동 경로
}
else if($modes=='delete')
{
	$error_link='?menu='.$menu.'&tn='.$tn.'&tab='.$tab.'&mode=read&idx='.$idx.'&search_select='.$search_select.'&keyword='.$keyword.'&pagenum='.$pagenum;//실패 후 이동 경로
	$success_link='?menu='.$menu.'&tn='.$tn.'&tab='.$tab.'&mode=list&search_select='.$search_select.'&keyword='.$keyword.'&pagenum='.$pagenum;//성공 후 이동 경로
}
else if($modes=='alldel')
{
	$error_link='?menu='.$menu.'&tn='.$tn.'&tab='.$tab.'&mode=list&search_select='.$search_select.'&keyword='.$keyword.'&pagenum='.$pagenum;//실패 후 이동 경로
	$success_link='?menu='.$menu.'&tn='.$tn.'&tab='.$tab.'&mode=list&search_select='.$search_select.'&keyword='.$keyword.'&pagenum='.$pagenum;//성공 후 이동 경로
}
else
{
	$error_link='?mode=list&menu='.$menu.'&tn='.$tn.'&tab='.$tab.'&search_select='.$search_select.'&keyword='.$keyword.'&pagenum='.$pagenum;//실패 후 이동 경로
}

$savedir	= $_SERVER['DOCUMENT_ROOT'].'/UploadFolder/'.$menu.'/'.$tn.'/';

if(!is_dir($savedir))
{
	script_alert_replace('첨부파일 경로가 존재하지 않습니다.\\n에러코드['.$menu.':001]', $error_link);
	exit;
}

$util		= new Util();
$file_count = count($_FILES);

if($modes=='modify')
{
	$sql = "select * from `".$DB_TABLE."` where `idx` = '".$idx."'";
	@$rs = $conn->Execute($sql);

	if(!$rs)
	{
		script_alert_replace('DB 질의가 실패했습니다.\\n에러코드['.$menu.':002]', $error_link);
		$rs->close();
		exit;
	}
	for($i=1;$i<=$file_count;$i++)
	{
		if($_REQUEST['delcheck'.$i]=='Y' || $_FILES['file'.$i]['tmp_name']!="")
		{
			if(file_exists($savedir.$rs->fields['filename'.$i]) && $rs->fields['filename'.$i]!='')
			{
				@unlink($savedir.$rs->fields['filename'.$i]);
			}
			$sql = "update `".$DB_TABLE."` set `filename".$i."` = '', `filename_real".$i."` = '' where `idx` = '".$idx."'";
			@$rs_update = $conn->Execute($sql);

			if(!$rs_update)
			{
				script_alert_replace('첨부파일 삭제 업데이트가 실패했습니다.\\n에러코드['.$menu.':003]', $error_link);
				$rs_update->close();
				exit;
			}
			$rs_update->close();
		}
	}
	$rs->close();
}

for($i=1;$i<=$file_count;$i++)
{
	if( $_FILES['file'.$i]['tmp_name'] )
	{
		$tmp_ext[$i]=explode(".", $_FILES['file'.$i]['name']);
		$ext=$tmp_ext[$i][count($tmp_ext[$i])-1];
		$savename[$i]			= '';
		$file_type[$i]			= '';
		$file[$i]				= $_FILES['file'.$i]['tmp_name'];
		$file_name[$i]			= date('YmdHis').'_'.rand(0, 1000);
		$file_name_ext[$i]		= $file_name[$i].'.'.$ext;
		$file_realname[$i]		= $_FILES['file'.$i]['name'];
		$file_size[$i]			= $_FILES['file'.$i]['size'];
		$file_type[$i]			= $_FILES['file'.$i]['type'];
		if ($file_name[$i])
		{
			$savename[$i]	= $util->upload($file[$i], $file_name_ext[$i], $savedir);
		}
	}
}

switch($modes)
{
	//		if($_POST['mode']=='' || $_POST['modes']=='' || $_POST['title']=='' || $_POST['contents']=='')
	case 'write':
		if($_POST['mode']=='' || $_POST['modes']=='' || $_POST['title']=='' || $_POST['contents']=='')
		{
			script_alert_replace('필수 입력값이 없습니다.\\n에러코드['.$menu.':004]', $error_link);
			exit;
		}

		extract($_POST);

		$sql="select * from `".$DB_TABLE."` where `idx`='-1'";
		@$rs_sql=$conn->Execute($sql);

		if(!$rs_sql)
		{
			script_alert_replace('DB 질의가 실패했습니다.\\n에러코드['.$menu.':005]', $error_link);
			$rs_sql->close();
			exit;
		}

		$val					= array();

		$sql="desc `".$DB_TABLE."`";
		$rs_desc=$conn->Execute($sql);
		if(!$rs_desc)
		{
			script_alert_replace('DB 질의가 실패했습니다.\\n에러코드['.$menu.':006]', $error_link);
			$rs_sql->close();
			exit;
		}

		$val_esc=array('idx');

		while(!$rs_desc->EOF)
		{
			if(isset(${$rs_desc->fields['Field']}))
			{
				if(!in_array($rs_desc->fields['Field'], $val_esc))
				{
					$val[$rs_desc->fields['Field']]=${$rs_desc->fields['Field']}!='' ? ${$rs_desc->fields['Field']} : '';
				}
			}
			$rs_desc->MoveNext();
		}
		$rs_desc->close();

		if($_SERVER['HTTPS'])
		{
			$hosts='https://'.$_SERVER['HTTP_HOST'];
		}
		else
		{
			$hosts='http://'.$_SERVER['HTTP_HOST'];
		}

		$val['contents']		=  str_replace('src="'.$hosts, 'src="', stripslashes($val['contents']));

		$val['reg_date']		= date('Y-m-d H:i:s');
		$val['reg_ip']			= $ip;
		for($i=1;$i<=$file_count;$i++)
		{
			if($savename[$i])
			{
				$val['filename'.$i]			=$savename[$i];
				$val['filename_real'.$i]	=$file_realname[$i];
			}
		}

		$sql=$conn->GetInsertSQL($rs_sql, $val);
		$rs_sql->close();

		@$rs=$conn->Execute($sql);

		if(!$rs)
		{
			script_alert_replace('등록이 실패했습니다.\\n에러코드['.$menu.':007]', $error_link);
			$rs->close();
			exit;
		}
		else
		{
			script_replace($success_link);
			$rs->close();
			exit;
		}
		exit;
		break;
	case 'modify':
		if($_POST['mode']=='' || $_POST['modes']=='' || $_POST['title']=='' || $_POST['contents']=='')
		{
			script_alert_replace('필수 입력값이 없습니다.\\n에러코드['.$menu.':008]', $error_link);
			exit;
		}

		extract($_POST);

		$sql="select * from `".$DB_TABLE."` where `idx`='".$idx."'";
		@$rs_sql=$conn->Execute($sql);

		if(!$rs_sql)
		{
			script_alert_replace('DB 질의가 실패했습니다.\\n에러코드['.$menu.':009]', $error_link);
			$rs_sql->close();
			exit;
		}

		$val						= array();

		$sql="desc `".$DB_TABLE."`";
		$rs_desc=$conn->Execute($sql);
		if(!$rs_desc)
		{
			script_alert_replace('DB 질의가 실패했습니다.\\n에러코드['.$menu.':010]', $error_link);
			$rs_sql->close();
			exit;
		}

		$val_esc=array('user_idx', 'user_id', 'user_name');

		while(!$rs_desc->EOF)
		{
			if(isset(${$rs_desc->fields['Field']}))
			{
				if(!in_array($rs_desc->fields['Field'], $val_esc))
				{
					$val[$rs_desc->fields['Field']]=${$rs_desc->fields['Field']}!='' ? ${$rs_desc->fields['Field']} : '';
				}
			}
			$rs_desc->MoveNext();
		}
		$rs_desc->close();

		if($_SERVER['HTTPS'])
		{
			$hosts='https://'.$_SERVER['HTTP_HOST'];
		}
		else
		{
			$hosts='http://'.$_SERVER['HTTP_HOST'];
		}

		$val['contents']		=  str_replace('src="'.$hosts, 'src="', stripslashes($val['contents']));

		$val['update_user_idx']		= $user_idx;
		$val['update_user_id']		= $user_id;
		$val['update_user_name']	= $user_name;
		$val['update_date']			= date('Y-m-d H:i:s');
		$val['update_ip']			= $ip;
		for($i=1;$i<=$file_count;$i++)
		{
			if ( $savename[$i] != "" )
			{
				$val['filename'.$i]			=$savename[$i];
				$val['filename_real'.$i]	=$file_realname[$i];
			}
		}

		$sql=$conn->GetUpdateSQL($rs_sql, $val);

		$rs_sql->close();

		if($sql)
		{
			@$rs=$conn->Execute($sql);

			if(!$rs)
			{
				script_alert_replace('수정이 실패했습니다.\\n에러코드['.$menu.':011]', $error_link);
				$rs->close();
				exit;
			}
			else
			{
				script_replace($success_link);
				$rs->close();
				exit;
			}
		}
		else
		{
			script_replace($success_link);
			exit;
		}
		exit;
		break;
	case 'delete':
		if($_REQUEST['mode']=='' || $_REQUEST['modes']=='' || $_REQUEST['idx']=='')
		{
			script_alert_replace('필수 입력값이 없습니다.\\n에러코드['.$menu.':012]', $error_link);
			exit;
		}

		extract($_POST);

		$sql="select * from `".$DB_TABLE."` where `idx`='".$idx."'";
		@$rs_chk=$conn->Execute($sql);
		if(!$rs_chk)
		{
			script_alert_replace('DB 질의가 실패했습니다.\\n에러코드['.$menu.':013]', $error_link);
			$rs_chk->close();
			exit;
		}

		$val					= array();
		$val['isdel']			= '1';
		$val['isdel_user_idx']	= $user_idx;
		$val['isdel_user_id']	= $user_id;
		$val['isdel_user_name']	= $user_name;
		$val['isdel_date']		= date('Y-m-d H:i:s');
		$val['isdel_ip']		= $ip;

		$sql=$conn->GetUpdateSQL($rs_chk, $val);

		@$rs=$conn->Execute($sql);

		if(!$rs)
		{
			script_alert_replace('글 삭제가 실패했습니다.\\n에러코드['.$menu.':014]', $error_link);
			$rs->close();
			exit;
		}

		script_replace($success_link);
		$rs->close();
		exit;
		break;
	case 'alldel':
		for( $i = 0; $i < sizeof( $_POST['isDel']); $i++ )
		{
			$TmoCode[]	= " `idx` = '" . $_POST['isDel'][$i] . "'";
		}

		if ( is_array($TmoCode) )
		{
			$DeleCode	= implode( ' or ', $TmoCode );

			$sql = "select * from `".$DB_TABLE."` where " . $DeleCode;
			@$rs_sql = $conn->Execute($sql);

			if(!$rs_sql)
			{
				script_alert_replace('DB 질의가 실패했습니다.\\n에러코드['.$menu.':015]', $error_link);
				exit;
			}
			$val					= array();
			$val['isdel']			= '1';
			$val['isdel_user_idx']	= $user_idx;
			$val['isdel_user_id']	= $user_id;
			$val['isdel_user_name']	= $user_name;
			$val['isdel_date']		= date('Y-m-d H:i:s');
			$val['isdel_ip']		= $ip;

			$sql=$conn->GetUpdateSQL($rs_sql, $val);
			$rs_sql->close();

			@$rs=$conn->Execute($sql);

			if(!$rs)
			{
				script_alert_replace('삭제가 실패했습니다.\\n에러코드['.$menu.':016]', $error_link);
				$rs->close();
				exit;
			}
			script_replace($success_link);
			$rs->close();
			exit;
		}
		else
		{
			script_alert_replace('삭제 대상이 없습니다.\\n에러코드['.$menu.':017]', $error_link);
			exit;
		}
		exit;
		break;
	default:
		script_alert_replace('잘못된 접근입니다.', $error_link);
		exit;
		break;
}
?>