<?php
include "../conn/conn.php";
include "../cmmInc/sessionTop.php";
include "../cmmInc/queryInfo.php";
include "../cmmInc/msgScript.php";
include "../cmmInc/delClass.php";

$fidx = $_GET['fidx'];										#----파일IDX---#
$idx  = $_GET['idx'];										#--해당글 IDX--#
$bid  = $_GET['bid'];										#---게시판ID---#

$deleteClass = new deleteValue;								#-클래스 선언--#
$deleteClass -> saveFieldName = "sname";					#-필드명-------#
$deleteClass -> saveDir = "../../data/".$bid."/";			#-저장경로-----#
$deleteClass -> fileWhere = "where fileidx=".$fidx;			#-해당레코드---#
$deleteClass -> fileTable = "fileboard";					#-자료테이블---#
$deleteClass -> conn = $conn;								#-DB연결-------#
$deleteReturn = $deleteClass -> deleteOnlyFile();			#-메서드 호출--#
mysql_close($conn);
if ($deleteReturn==true){									#성공...........
	History_back(-1,"삭제되었습니다.");
}else{														#실패...........
	History_back(-1,"실패되었습니다.");
}
?>