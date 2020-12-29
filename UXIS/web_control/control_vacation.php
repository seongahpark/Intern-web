<?php
require_once "../common/config_www.php";
require_once "../web_process/process_write_common.php";
require_once "../web_process/process_apllyVacation.php";
require_once "../common/class_email.php";

if(!LOGIN_ID) location_href("../");

$isAjax  = isAjax();

$Write	 = new Write($process);
$Write->saveDir = "../../data/myWork/";
/*
$_POST['process'] = "addwork";
$_POST["workName"] = "업무내용";
$_POST["issueTitle"] = Array(
	"이슈1","이슈2","이슈3"
);
*/

$toMail = "test@test.com";
$toName = "테스트";
$proc	 = $_POST['process'];
$proc	 = !$_GET['process']   ? $proc   : $_GET['process'];	//대표님 메일에서 넘어올경우 (GET으로 넘어옴) 해당값을 넣고 아닐경우 위에서 받은 POST값을 그대로 가져감

if($proc=="apply"):
  $Write->addVacation($_POST);
  $vid = mysql_insert_id();
  
  $contents = "<div style='width:100%;text-align:left;'>휴가신청(".$_POST["type"].")<br>";
  $contents .= "신청자:".$_POST["name"]." ".$_POST["grade"]."<br>";
  $contents .= "신청기간:".$_POST["sdate"]." ~ ".$_POST["edate"]."<br>";
  $contents .= "업무대행자:".$_POST["agent"]."<br>";
  $contents .= "사유:".$_POST["reason"]."</div><br>";
  $contents .= "<a href='http://uxis.co.kr/boss/web_control/control_vacation.php?vidx=".$vid."&process=confirm'><img src='http://uxis2.dever-host.com/boss/images/email/confirm.png' /></a>";
 
  $Write->sendMailForVacationInfo($_POST["name"]." ".$_POST["grade"]." 휴가신청 접수 ",$toMail,$toName,"uxis@uxis.co.kr","유시스",$contents);
elseif($proc=="modi"):
  $Write->modiVacation($_POST);
  $contents = "<div style='width:100%;text-align:left;'>휴가신청(".$_POST["type"].") 정보가 아래와 같이 변경 되었습니다.<br>";
  $contents .= "신청자:".$_POST["name"]." ".$_POST["grade"]."<br>";
  $contents .= "신청기간:".$_POST["sdate"]." ~ ".$_POST["edate"]."<br>";
  $contents .= "업무대행자:".$_POST["agent"]."<br>";
  $contents .= "사유:".$_POST["reason"]."</div><br>";
  $contents .= "<a href='http://uxis.co.kr/boss/web_control/control_vacation.php?vidx=".$vid."&process=confirm'><img src='http://uxis2.dever-host.com/boss/images/email/confirm.png' /></a>";

  $Write->sendMailForVacationInfo($_POST["name"]." ".$_POST["grade"]." 휴가신청정보가 변경되었습니다.",$toMail,$toName,"uxis@uxis.co.kr","유시스",$contents);
elseif($proc=="confirm"):
  $ret = $Write->confirmVacation($_GET);
  //메세지를 띄우고 창을 닫음
  if($ret == '1'){
	alert("승인되었습니다.");
  }else if($ret == '2'){
	alert("이미 승인된 신청서입니다.");
  }else{
	alert("글이 없거나 삭제되었습니다.");
  }
  echo "<script> self.close(); </script>";
elseif($proc=="del"):
  $ret = $Write->deleteVacation($_POST["idxs"]);
  if($ret):
    $temp["result"]="success";
    $ret = json_encode($temp);
  endif;
else:
	die('error process');
endif;




if($isAjax):
	echo $ret;
else:
	$_params  = $_POST['params'] ? $_POST['params'] : "";
	location_href("../12_incom/applyVacation.php?view=".$_params);
endif;
