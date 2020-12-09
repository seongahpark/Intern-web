<?php

	include "../conn/conn.php";
	include "../cmmInc/sessionTop.php";
	include "../cmmInc/queryInfo.php";
	include "../cmmInc/saveClass.php";
	include "../cmmInc/msgScript.php";


//DELETE FROM `member_admin` WHERE 1
	$idx_cnt = 5;
	$idx_kor_cnt = 9;
	$idx_eng_cnt = 9;
	$idx_jpn_cnt = 9;
	$idx_chi_cnt = 9;
	/*
	for($i=0;$i<$idx_cnt;$i++){
		$deleteSQL   = "delete from session ";
		$deleteSQL  .= "where idx='".$_GET["idx"][$i]."'";
		
		$resultConn  = mysql_query($deleteSQL,$conn);			
	}

	for($i=0;$i<$idx_kor_cnt;$i++){
		$deleteSQL   = "delete from session_kor ";
		$deleteSQL  .= "where idx='".$_GET["idx"][$i]."'";
		
		$resultConn  = mysql_query($deleteSQL,$conn);			
	}

	for($i=0;$i<$idx_eng_cnt;$i++){
		$deleteSQL   = "delete from session_eng ";
		$deleteSQL  .= "where idx='".$_GET["idx"][$i]."'";
		
		$resultConn  = mysql_query($deleteSQL,$conn);			
	}

	for($i=0;$i<$idx_jpn_cnt;$i++){
		$deleteSQL   = "delete from session_jpn ";
		$deleteSQL  .= "where idx='".$_GET["idx"][$i]."'";
		
		$resultConn  = mysql_query($deleteSQL,$conn);			
	}

	for($i=0;$i<$idx_chi_cnt;$i++){
		$deleteSQL   = "delete from session_chi ";
		$deleteSQL  .= "where idx='".$_GET["idx"][$i]."'";
		
		$resultConn  = mysql_query($deleteSQL,$conn);			
	}
	*/
	//원래 delete로 전체 삭제를 했으나 삭제여부 Y/N 으로 변경하여
	//실수로 삭제했을 경우에 다시 복원할 수 있도록 함
	$updateSQL   = "update session ";
	$updateSQL	.= "set del='Y'";
	$updateSQL  .= " where idx='".$_GET["idx"]."'";
	
	$resultConn  = mysql_query($updateSQL,$conn);	

	IF($resultConn==true){								
		Alert_Msg("삭제에 성공하였습니다.");
	}else{
		Alert_Msg("삭제에 실패하였습니다.");
	}

	mysql_close($conn);
	

	Replace("./SessionList.php?admin_type=SessionList");


?>