<?php
	include "../conn/conn.php";
	include "../cmmInc/sessionTop.php";
	include "../cmmInc/queryInfo.php";
	include "../cmmInc/saveClass.php";
	include "../cmmInc/msgScript.php";

	$idx = is_numeric($_POST['idx']) ? $_POST['idx'] : die('error idx 관리자에게 문의 주세요!');

    $ret = mysql_query("select count(*) from session where idx='".$idx."'", $conn) or die('세션 정보오류 관리자에게 문의 주세요!');
	if(is_resource($ret)):
		$row = mysql_fetch_array($ret);
		if($row[0] != '1'):
			die('error session 관리자에게 문의 주세요!');
		endif;
	else:
		die('error resource 관리자에게 문의 주세요!');
	endif;
 
	$updateSQL   = "update session ";
	$updateSQL	.= "set year='".$_POST["session_year"]."', kind='".addslashes($_POST["kind_kor"])."', date='".$_POST["session_date"]."', time='".$_POST["session_time"]."', end_time='".$_POST["session_end_time"]."'";
	$updateSQL  .= " where idx='".$_POST["idx"]."'";
	
	$resultConn  = mysql_query($updateSQL,$conn) or die('1. 세션정보 업데이트 실패 관리자에게 문의 주세요!');		
	
	$updateKorSQL   = "update session_kor ";
	$updateKorSQL	.= "set kind='".addslashes($_POST["kind_kor"])."', title='".addslashes($_POST["title_kor"])."', video='".addslashes($_POST["video_kor"])."', text='".addslashes($_POST["explain_kor"])."', place='".addslashes($_POST["place_kor"])."', speech='".addslashes($_POST["speech_kor"])."', keynote='".addslashes($_POST["keynote_kor"])."', present='".addslashes($_POST["present_kor"])."', panel='".addslashes($_POST["panel_kor"])."', panelist='".addslashes($_POST["panelist_kor"])."'";
	$updateKorSQL  .= " where idx='".$_POST["idx"]."'";
	
	$resultKorConn  = mysql_query($updateKorSQL,$conn)  or die('2. 국문 업데이트 실패 관리자에게 문의 주세요!');		

	$updateEngSQL   = "update session_eng ";
	$updateEngSQL	.= "set kind='".addslashes($_POST["kind_eng"])."', title='".addslashes($_POST["title_eng"])."', video='".addslashes($_POST["video_eng"])."', text='".addslashes($_POST["explain_eng"])."', place='".addslashes($_POST["place_eng"])."', speech='".addslashes($_POST["speech_eng"])."', keynote='".addslashes($_POST["keynote_eng"])."', present='".addslashes($_POST["present_eng"])."', panel='".addslashes($_POST["panel_eng"])."', panelist='".addslashes($_POST["panelist_eng"])."'";
	$updateEngSQL  .= " where idx='".$_POST["idx"]."'";
	
	$resultEngConn  = mysql_query($updateEngSQL,$conn)  or die('3. 영문 업데이트 실패 관리자에게 문의 주세요!');		

	$updateJpnSQL   = "update session_jpn ";
	$updateJpnSQL	.= "set kind='".addslashes($_POST["kind_jpn"])."', title='".addslashes($_POST["title_jpn"])."', video='".addslashes($_POST["video_jpn"])."', text='".addslashes($_POST["explain_jpn"])."', place='".addslashes($_POST["place_jpn"])."', speech='".addslashes($_POST["speech_jpn"])."', keynote='".addslashes($_POST["keynote_jpn"])."', present='".addslashes($_POST["present_jpn"])."', panel='".addslashes($_POST["panel_jpn"])."', panelist='".addslashes($_POST["panelist_jpn"])."'";
	$updateJpnSQL  .= " where idx='".$_POST["idx"]."'";
	
	$resultJpnConn  = mysql_query($updateJpnSQL,$conn)   or die('4. 일문 업데이트 실패 관리자에게 문의 주세요!');		

	$updateChiSQL   = "update session_chi ";
	$updateChiSQL	.= "set kind='".addslashes($_POST["kind_chi"])."', title='".addslashes($_POST["title_chi"])."', video='".addslashes($_POST["video_chi"])."', text='".addslashes($_POST["explain_chi"])."', place='".addslashes($_POST["place_chi"])."', speech='".addslashes($_POST["speech_chi"])."', keynote='".addslashes($_POST["keynote_chi"])."', present='".addslashes($_POST["present_chi"])."', panel='".addslashes($_POST["panel_chi"])."', panelist='".addslashes($_POST["panelist_chi"])."'";
	$updateChiSQL  .= " where idx='".$_POST["idx"]."'";
	
	$resultChiConn  = mysql_query($updateChiSQL,$conn)   or die('5. 중문 업데이트 실패 관리자에게 문의 주세요!');			

	IF($resultConn==true && $resultKorConn==true && $resultEngConn==true && $resultJpnConn==true && $resultChiConn==true){								
		Alert_Msg("수정하였습니다.");
		mysql_close($conn);
		Replace("./SessionList.php?admin_type=SessionList");
	}else{
		Alert_Msg("정보입력오류입니다.");
		echo "<script>history.go(-1);</script>";
	}


?>