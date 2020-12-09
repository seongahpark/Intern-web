<?php
	include "../conn/conn.php";
	include "../cmmInc/sessionTop.php";
	include "../cmmInc/queryInfo.php";
	include "../cmmInc/function.php";
	include "../cmmInc/msgScript.php";
	include "../cmmInc/saveClass.php";
	//이미 있는 경우 update 시키는 기능 필요
	$tnm	 = "session";

	$session_year = $_POST["session_year"];
	$session_kind = $_POST["session_kind"];
	$session_date = $_POST["session_date"];
	$session_time = $_POST["session_time"];
	$session_end_time = $_POST["session_end_time"];
	$insertSQL   = "insert into $tnm (year , kind, date, time, end_time) ";
	$insertSQL  .= "values('".$session_year."','".$session_kind."','".$session_date."','".$session_time."','".$session_end_time."')";
	$resultConn  = mysql_query($insertSQL,$conn);		
	
	$lang = $_POST["lang"];

	$tnm_kor = "session_kor";
	$title_kor = $_POST["title_kor"];
	$video_kor = $_POST["video_kor"];
	$explain_kor = $_POST["explain_kor"];
	$place_kor = $_POST["place_kor"];
	$speech_kor = $_POST["speech_kor"];
	$keynote_kor = $_POST["keynote_kor"];
	$present_kor = $_POST["present_kor"];
	$panel_kor = $_POST["panel_kor"];
	$panelist_kor = $_POST["panelist_kor"];

	$insertKorSQL = "insert into $tnm_kor (title, video, text, place, speech, keynote, present, panel, panelist)";
	$insertKorSQL .= "values('".$title_kor."','".$video_kor."','".$explain_kor."','".$place_kor."','".$speech_kor."','".$keynote_kor."','".$present_kor."','".$panel_kor."','".$panelist_kor."')";
	$resultKorConn = mysql_query($insertKorSQL, $conn);

	$tnm_eng = "session_eng";
	$title_eng = $_POST["title_eng"];
	$video_eng = $_POST["video_eng"];
	$explain_eng = $_POST["explain_eng"];
	$place_eng = $_POST["place_eng"];
	$speech_eng = $_POST["speech_eng"];
	$keynote_eng = $_POST["keynote_eng"];
	$present_eng = $_POST["present_eng"];
	$panel_eng = $_POST["panel_eng"];
	$panelist_eng = $_POST["panelist_eng"];

	$insertEngSQL = "insert into $tnm_eng (title, video, text, place, speech, keynote, present, panel, panelist)";
	$insertEngSQL .= "values('".$title_eng."','".$video_eng."','".$explain_eng."','".$place_eng."','".$speech_eng."','".$keynote_eng."','".$present_eng."','".$panel_eng."','".$panelist_eng."')";
	$resultEngConn = mysql_query($insertEngSQL, $conn);

	$tnm_jpn = "session_jpn";
	$title_jpn = $_POST["title_jpn"];
	$video_jpn = $_POST["video_jpn"];
	$explain_jpn = $_POST["explain_jpn"];
	$place_jpn = $_POST["place_jpn"];
	$speech_jpn = $_POST["speech_jpn"];
	$keynote_jpn = $_POST["keynote_jpn"];
	$present_jpn = $_POST["present_jpn"];
	$panel_jpn = $_POST["panel_jpn"];
	$panelist_jpn = $_POST["panelist_jpn"];

	$insertJpnSQL = "insert into $tnm_jpn (title, video, text, place, speech, keynote, present, panel, panelist)";
	$insertJpnSQL .= "values('".$title_jpn."','".$video_jpn."','".$explain_jpn."','".$place_jpn."','".$speech_jpn."','".$keynote_jpn."','".$present_jpn."','".$panel_jpn."','".$panelist_jpn."')";
	$resultJpnConn = mysql_query($insertJpnSQL, $conn);

	$tnm_chi = "session_chi";
	$title_chi = $_POST["title_chi"];
	$video_chi = $_POST["video_chi"];
	$explain_chi = $_POST["explain_chi"];
	$place_chi = $_POST["place_chi"];
	$speech_chi = $_POST["speech_chi"];
	$keynote_chi = $_POST["keynote_chi"];
	$present_chi = $_POST["present_chi"];
	$panel_chi = $_POST["panel_chi"];
	$panelist_chi = $_POST["panelist_chi"];

	$insertChiSQL = "insert into $tnm_chi (title, video, text, place, speech, keynote, present, panel, panelist)";
	$insertChiSQL .= "values('".$title_chi."','".$video_chi."','".$explain_chi."','".$place_chi."','".$speech_chi."','".$keynote_chi."','".$present_chi."','".$panel_chi."','".$panelist_chi."')";
	$resultChiConn = mysql_query($insertChiSQL, $conn);


	IF($resultConn==true && $resultKorConn==true && $resultEngConn==true && $resultJpnConn==true && $resultChiConn==true) {
		Alert_Msg("저장하였습니다.");
	}else{
		Alert_Msg("등록에 실패하였습니다.");
	}

	mysql_close($conn);
	Replace("./sessionYear.php?admin_type=".$_POST["admin_type"]);
?>