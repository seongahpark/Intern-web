<?php
require_once "../boss/common/config_www.php";
require_once "../boss/web_process/process_write_common.php";
require_once "../boss/web_process/process_consult.php";
require_once "../boss/common/class_email.php";
//if(!LOGIN_ID) location_href("../");

//201110 박성아 첨부파일 저장 추가
$saveDir = $_SERVER["DOCUMENT_ROOT"]."/data/consult/";

function returnFileName1($fileName,$saveDir){
	 $fileExt		   = strrchr($fileName,".");
	 $fileName		   = md5($fileName);
		list($tm1,$tm2)= Explode(" ",Microtime());
		$save_name = substr($fileName.$tm2,-20).$fileExt;
		while(File_Exists($saveDir.$save_name)):
			list($tm1,$tm2)=Explode(" ",Microtime());
			$save_name = substr($fileName.$tm2,-20).$fileExt;
		endwhile;
	 return $save_name;
}

function fileUploadProcess1($fileFieldName,$saveDir){
			$rname  = $_FILES[$fileFieldName][name]; //rname은 원본 이름
			$sname  = returnFileName1($rname,$saveDir); //sname은 임시 이름
			$fsize  = $_FILES[$fileFieldName][size];
			$ftype  = $_FILES[$fileFieldName][type];
			move_uploaded_file($_FILES[$fileFieldName][tmp_name],$saveDir.$sname);
			clearstatcache();
			return array("rname"=>$rname,"sname"=>$sname,"fsize"=>$fsize,"ftype"=>$ftype);
}

$isAjax  = isAjax();

$Write	 = new Write($process);
$Write->saveDir = "../data/consult/";

$toName = "유시스";

$toMailArray = Array(
	"test@uxis.co.kr",
	"test1@uxis.co.kr",
	"test2@uxis.co.kr" //개인정보라 메일 수정
);

$proc	 = $_POST['process'];
$page_url = $_POST['page_url'];

if($proc=="insert"):
	$ret = $Write -> insertConsult();

	if($_FILES){ //첨부파일 있을때 저장
	$fileFieldName = "up_file";
	$file = fileUploadProcess1($fileFieldName,$saveDir);
	
	$idxSQL = "SELECT idx FROM consult ORDER BY regdate desc LIMIT 1"; 
	$idxres = mysql_query($idxSQL);
	$idx	= mysql_result($idxres, 0);
	//내용 먼저 저장하고 해당 idx를 받아와서 fileboard에 저장
	$fileSQL = "INSERT INTO fileboard (idx, sname, rname, size)";
	$fileSQL .= " VALUES ('".$idx."', '".$file[sname]."','".$file[rname]."','".$file[fsize]."')";
	$res	= mysql_query($fileSQL);
	}

	//상담신청정보를 담당자 메일로 발송  (2017.03.14 심재성)
  $contents = "<div style='width:100%;text-align:left;'>----상담신청----<br/>";
  $contents .= "회사명:".$_POST["cp_name"]."( ".$_POST["cp_addr"]." )<br/>";
  $contents .= "담당자명:".$_POST["dam_name"]." <br/>";  
  $contents .= "이메일:".$_POST["dam_email"]."<br/></div>";

  foreach($toMailArray as $mail ){
	$Write->sendMailForConsult(" 새로운 상담이 접수되었습니다. (".$_POST["cp_name"].") ",$mail,$toName,"uxis@uxis.co.kr","유시스",$contents);
  }
  //$Write->sendMailForConsult(" 새로운 상담이 접수되었습니다. (".$_POST["cp_name"].") ",$toMail1,$toName,"uxis@uxis.co.kr","유시스",$contents);
  //$Write->sendMailForConsult(" 새로운 상담이 접수되었습니다.(".$_POST["cp_name"].") ",$toMail2,$toName,"uxis@uxis.co.kr","유시스",$contents);
  //$Write->sendMailForConsult(" 새로운 상담이 접수되었습니다.(".$_POST["cp_name"].") ",$toMail3,$toName,"uxis@uxis.co.kr","유시스",$contents);
 // $Write->sendMailForConsult(" 새로운 상담이 접수되었습니다.(".$_POST["cp_name"].") ",$toMail4,$toName,"uxis@uxis.co.kr","유시스",$contents);
  //$Write->sendMailForConsult(" 새로운 상담이 접수되었습니다.(".$_POST["cp_name"].") ",$toMail5,$toName,"uxis@uxis.co.kr","유시스",$contents);

elseif($proc=="update"):
	$ret = $Write -> updateConsult();
elseif($proc=="delete"):
	$ret = $Write -> deleteConsult();
elseif($proc=="fileDelete"):
	$ret = $Write -> deleteFile();
else:
	die('error process');
endif;
 
if($isAjax):
	echo $ret;
else:
	$_params  = $_POST['params'] ? "?".$_POST['params'] : "";
	location_href("http://uxis.co.kr".$page_url);
	//location_href("../04_Contact/Request_com.php");
	//location_href("../04_Contact/Request.php".$_params);	
endif;