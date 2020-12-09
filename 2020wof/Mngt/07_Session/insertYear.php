<?php
	include "../conn/conn.php";
	include "../cmmInc/sessionTop.php";
	include "../cmmInc/queryInfo.php";
	include "../cmmInc/function.php";
	include "../cmmInc/msgScript.php";
	include "../cmmInc/saveClass.php";
	//이미 있는 경우 update 시키는 기능 필요
	$tnm	 = "session_year";

	$session_title = $_POST["session_title"];
	$session_year = $_POST["session_year"];
	$session_validate = $_POST["session_validate"];

	$insertSQL   = "insert into $tnm (title , year, validate) ";
	$insertSQL  .= "values('".$session_title."','".$session_year."','".$session_validate."')";
	$insertSQL	.= " ON DUPLICATE KEY ";
	$insertSQL	.= "UPDATE title = '".$session_title."', validate = '".$session_validate."'";
	$resultConn  = mysql_query($insertSQL,$conn);		

	IF($resultConn==true){
		Alert_Msg("저장하였습니다.");
	}else{
		Alert_Msg("등록에 실패하였습니다.");
	}

	mysql_close($conn);
	Replace("./sessionYear.php?admin_type=".$_POST["admin_type"]);
?>