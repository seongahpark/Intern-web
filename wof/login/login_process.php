<?php
//include "./session.inc.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/web-cs/config_init.php';

$mode		= $_REQUEST['mode'];
$ip			= $_SERVER['REMOTE_ADDR'];

extract($_POST);

switch($mode)
{
	case 'login':
		$DB_TABLE='member';

		$ref		= $_REQUEST['ref'];

		$ref		= urldecode($ref);

		if(preg_match('/\/kor\/html\/03_online\/online_02.php/', $ref) || preg_match('/\/kor\/html\/03_online\/speaker_01.php/', $ref) || preg_match('/\/kor\/html\/03_online\/speaker_02.php/', $ref) || preg_match('/\/kor\/html\/06_member\/*/', $ref))
		{
			$ref= '/kor/';
		}

		$sql="select a.* ";
		$sql=$sql." from `".$DB_TABLE."` a where `user_id`='".$userid."'";

		$rs=$conn->Execute($sql);
		if($rs->_numOfRows)
		{
			$password1=$rs->fields['password1'];
			
			$password=sha1($rs->fields['user_id'].'/'.$rs->fields['reg_ip'].'/'.$userpwd.'/'.$rs->fields['reg_date']);

			$sql="select a.* ";
			$sql=$sql." from `".$DB_TABLE."` a where `idx`='".$rs->fields['idx']."' and `password`='".$password."'";

			$rs2=$conn->Execute($sql);
			if($rs2->_numOfRows)
			{
				$sql="insert into `".$DB_TABLE."_login` (`user_idx`, `user_id`, `user_name`, `login_date`, `login_ip`) values ('".$rs->fields['idx']."', '".stripslashes($rs->fields['user_id'])."', '".stripslashes($rs->fields['user_name1'].$rs->fields['user_name2'])."', now(), '".$ip."');";
				@$rs_insert=$conn->Execute($sql);

				$_SESSION['_USER_IDX']			= $rs->fields['idx'];
				$_SESSION['_PASSWORD1']			= $rs->fields['password1'];
				$_SESSION['_USER_ID']			= $rs->fields['user_id'];
				$_SESSION['_USER_NAME']			= $rs->fields['user_name1'].$rs->fields['user_name2'];
				$_SESSION['_USER_NAME1']		= $rs->fields['user_name1'];
				$_SESSION['_USER_NAME2']		= $rs->fields['user_name2'];
				$_SESSION['_USER_ENG_NAME']		= $rs->fields['eng_user_name1'].$rs->fields['eng_user_name2'];
				$_SESSION['_USER_ENG_NAME1']	= $rs->fields['eng_user_name1'];
				$_SESSION['_USER_ENG_NAME2']	= $rs->fields['eng_user_name2'];
				$_SESSION['_USER_TYPE']			= $rs->fields['user_type'];
				$_SESSION['_USER_DETAIL_TYPE']	= $rs->fields['user_detail_type'];
				$_SESSION['_USER_BELONG']		= $rs->fields['belong'];
				$_SESSION['_USER_ENG_BELONG']	= $rs->fields['eng_belong'];
				$_SESSION['_USER_POSITION']		= $rs->fields['position'];
				$_SESSION['_USER_POSITION_ENG']	= $rs->fields['eng_position'];
				$_SESSION['_NATIONALITY']		= $rs->fields['nationality'];
				$_SESSION['_APPELLATION']		= $rs->fields['appellation'];
				$_SESSION['_TEL']				= $rs->fields['tel'];
				$_SESSION['_MOBILE']			= $rs->fields['mobile'];

				//200915 sso 구현 완료
				//login_process -> login_sso.php 로 이동하여 sso 기능 동작

			}
			else
			{
				script_alert_replace('등록되지 않은 계정이거나 잘못된 비밀번호입니다.', '/kor/html/06_member/login.php?ref='.urlencode($ref));
				exit;
			}
		}
		else
		{
			script_alert_replace('등록되지 않은 계정이거나 잘못된 비밀번호입니다.', '/kor/html/06_member/login.php?ref='.urlencode($ref));
			exit;
		}

		//201020 online wof에서 넘어와서 로그인시 바로 onlinewof 페이지로 넘어가도록 설정 -- 박성아
		$check = $_GET['check'];
		if($check == "onlinewof"){
			script_mov('/kor/login/login_sso.php');
		}
/*
		if($ref)
		{
			script_mov($ref);
			exit;
		}
		else
		{
			script_mov('/kor/');
			exit;
		}
*/

		// 20140902 : 로그인후 프로그램등록으로 바로 이동
		// 2017-08-25 : 마이페이지로 이동하게 수정
		if($_SESSION['_USER_TYPE'] == 10) {
			if($password1==""){
				script_alert_replace("비밀번호를 기간이 지나 변경해 주세요.",'/kor/html/06_member/mypage_modify.php');
			}else{
				if($_GET['check'] == "onlinewof"){
					script_mov('http://2020.wof.kr/main/main.php');
				}
				//script_mov('/kor/html/02_forum/forum_04.php');
				script_mov('/kor/html/06_member/mypage.php');
			}
		} else {
			script_mov('/kor/html/06_member/presenter_mypage_session.php');
		}

		break;
	case 'logout':
	default :
		session_destroy();
		session_unset();
		script_mov('/kor/');
		break;
}
?>