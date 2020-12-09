<?php
	include "../conn/conn.php";
	include "../cmmInc/sessionTop.php";
	include "../cmmInc/queryInfo.php";
	include "../cmmInc/function.php";
//	include "../cmmInc/lib_image.php";
	include "../cmmInc/msgScript.php";
	include "../cmmInc/saveClass.php";

//$saveDir = $_SERVER["DOCUMENT_ROOT"]."/data/".$_POST["bid"]."/";
//echo $$saveDir;
//일반게시판
if($_GET["btype"]=="Board"){
	if($_GET['bid'] == 'qna'){
	$tnm	 = "multiboard";							##테이블이름##################
	$saveDir = "../../data/qna/";			##파일저장경로################
	$idx	 = $_GET['idx'];							##게시판 IDX##################
								
	###게시판정보###########################
	$boardInfoWhere= "where bid='".$bid."'";
	$boardInfo     = @Result_Query("boardinfo","*","mysql_fetch_array",$boardInfoWhere);

	$insertField = new writeValue;
	$insertField -> postVal       = $_POST;	##포스트로 받은값#############
	$insertField -> ex            = "-";				##필드명이 배열일경우 구분자##
	$insertField -> delVal        = "x,y,minus,cnt,writedate";	##필드제외####################
	$insertField -> saveDir		  = $saveDir;
	$insertField -> returnName	  = "Ext";				##리턴파일명 확장
	$insertField -> fileFieldName = "up_file";			#####파일필드#################
	$insertField -> dataTnm		  = "fileboard";		#####파일테이블###############
	$insertField -> idx			  = $idx;							
	$insertField -> bid           = $_POST["bid"];		##게시판 아이디###############
	$insertField -> conn		  = $conn;				##DB연결######################

	$insertField -> smpX		  = 160;				##샘플가로####################
	$insertField -> smpY		  = 120;				##샘플세로####################

	$writeDate   = Explode("-",$_POST['writedate']);
	$writeDate   = mkTime(0,0,0,$writeDate[1],$writeDate[2],$writeDate[0]);			##작성일
	$userIp      = $_SERVER["REMOTE_ADDR"];				##아이피
	$retrunStr   = $insertField -> updateValue();		##업데이트쿼리문리턴..........
	$Step		 = $insertField -> BoardStep();			##게시판 스탭정보.............

	$insertSQL   = "update $tnm set ".$retrunStr.$NoticeChk.$SecretChk.",writedate=".$writeDate;
	$insertSQL  .= " where idx=".$idx;

	$resultConn  = mysql_query($insertSQL,$conn);
			
	IF($resultConn==true){								##데이터저장성공시  파일저장
		$insertField -> insertIdx  = $idx;				##인설트 IDX..................
		$insertField -> MultiFile();					##파일업로드..................

		###게시판 타이틀 이미지ㅡㅡ;###################################################
		IF($boardInfo['titleimg']=='O'){						
			$insertField -> imgDis = "OLD";
			$insertField -> fileFieldName = "up_old";		#####타이틀필드################
			$insertField -> ExistSingleFile();				##타이틀이미지업로드###########

			$insertField -> imgDis = "NEW";
			$insertField -> fileFieldName = "up_new";		#####타이틀필드################
			$insertField -> ExistSingleFile();				##타이틀이미지업로드###########
		}
		###############################################################################

		Alert_Msg("저장하였습니다.");
	}else{
		Alert_Msg("정보입력오류입니다.");
	}

	mysql_close($conn);
	$parameter = $_GET["parameter"];

	Replace("./BoardList.php?page=&sw=".$_GET['sw']."&sv=".$_GET['sv']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype']."&attribute=".$_GET['attribute']);	

	}else if($_GET['bid'] == 'notice'){
	$tnm	 = "multiboard";							##테이블이름##################
	$saveDir = "../../data/".$_POST["bid"]."/";			##파일저장경로################
	$idx	 = $_GET['idx'];							##게시판 IDX##################
	
	###게시판정보###########################
	$boardInfoWhere= "where bid='".$_POST['bid']."'";
	$boardInfo     = @Result_Query("boardinfo","*","mysql_fetch_array",$boardInfoWhere);

	$insertField = new writeValue;
	$insertField -> postVal       = $_POST;	##포스트로 받은값#############
	$insertField -> ex            = "-";				##필드명이 배열일경우 구분자##
	$insertField -> delVal        = "x,y,minus,cnt,writedate";	##필드제외####################
	$insertField -> saveDir		  = $saveDir;
	$insertField -> returnName	  = "Ext";				##리턴파일명 확장
	$insertField -> fileFieldName = "up_file";			#####파일필드#################
	$insertField -> dataTnm		  = "fileboard";		#####파일테이블###############
	$insertField -> idx			  = $idx;							
	$insertField -> bid           = $_POST["bid"];		##게시판 아이디###############
	$insertField -> conn		  = $conn;				##DB연결######################

	$insertField -> smpX		  = 160;				##샘플가로####################
	$insertField -> smpY		  = 120;				##샘플세로####################
	

	$writeDate   = Explode("-",$_POST['writedate']);
	$writeDate   = mkTime(0,0,0,$writeDate[1],$writeDate[2],$writeDate[0]);		##작성일
	$userIp      = $_SERVER["REMOTE_ADDR"];				##아이피
	$returnStr   = $insertField -> insertValue();		##인설트쿼리문리턴############
	$Step		 = $insertField -> BoardStep();			##게시판 스탭정보#############
	$attribute	 = $_POST["attribute"];					##게시판 말머리 구분##########

	$insertSQL   = "insert into $tnm (idx,".$returnStr[0].",writedate,ref,re_level,re_step,userip,delnum) ";
	$insertSQL  .= "values('',".$returnStr[1].",".$writeDate.",".$Step[0].",".$Step[1].",".$Step[2].",'".$userIp."','0')";
	

	$resultConn  = mysql_query($insertSQL,$conn);
	$insertIdx   = mysql_insert_id();			

//	echo "<br/>".$resultConn;
	IF($resultConn==true){								##데이터저장성공시  파일저장
		$insertField -> insertIdx  = $insertIdx;		##인설트 IDX###################
		$insertField -> MultiFile();					##파일업로드###################
	/*
		$insertField = new writeValue;
		$insertField -> postVal       = $_POST;			##포스트로 받은값#############
		$insertField -> ex            = "-";			##필드명이 배열일경우 구분자##
		$insertField -> saveDir		  = $saveDir;
		$insertField -> returnName	  = "Ext";			##리턴파일명 확장
		$insertField -> imgDis		  = "img";
		$insertField -> fileFieldName = "up_file";	#####타이틀필드################
		$insertField -> dataTnm		  = "fileboard";	#####파일테이블###############
		$insertField -> idx			  = $idx;							
		$insertField -> bid           = $_POST["bid"];	##게시판 아이디###############
		$insertField -> conn		  = $conn;			##DB연결######################
		$insertField -> insertIdx	  = $insertIdx;		##인설트 IDX###################
		$insertField -> MultiFile();					##파일업로드###################	
	*/
		//print_r($_FILES);
		//exit;
		Alert_Msg("저장하였습니다.");
	}else{
		Alert_Msg("정보입력오류입니다.1");
	}



	mysql_close($conn);
	//$listGet = "bid=".$_GET['bid']."&page=".$_POST['page']."&gid=".$_GET['gid']."&btype=Board";
	$parameter = $_GET["parameter"];

	Replace("./BoardList.php?page=&sw=".$_GET['sw']."&sv=".$_GET['sv']."&bid=".$_GET['bid']."&btype=".$_GET['btype']."&attribute=".$_GET['attribute']);
	}
}

//사진게시판
else if($_GET["btype"]=="Gallery"){
	$tnm	 = "multiboard";							##테이블이름##################
	$saveDir = "../../data/".$_POST["bid"]."/";			##파일저장경로################
	$idx	 = $_GET['idx'];							##게시판 IDX##################

	###게시판정보###########################
	$boardInfoWhere= "where bid='".$_POST['bid']."'";
	$boardInfo     = @Result_Query("boardinfo","*","mysql_fetch_array",$boardInfoWhere);

	$insertField = new writeValue;
	$insertField -> postVal       = $_POST;	##포스트로 받은값#############
	$insertField -> ex            = "-";				##필드명이 배열일경우 구분자##
	$insertField -> delVal        = "x,y,minus,cnt,writedate";	##필드제외####################
	$insertField -> saveDir		  = $saveDir;
	$insertField -> returnName	  = "Ext";				##리턴파일명 확장
	$insertField -> fileFieldName = "up_file";			#####파일필드#################
	$insertField -> dataTnm		  = "fileboard";		#####파일테이블###############
	$insertField -> idx			  = $idx;							
	$insertField -> bid           = $_POST["bid"];		##게시판 아이디###############
	$insertField -> conn		  = $conn;				##DB연결######################

	$insertField -> smpX		  = 160;				##샘플가로####################
	$insertField -> smpY		  = 120;				##샘플세로####################


	$writeDate   = Explode("-",$_POST['writedate']);
	$writeDate   = mkTime(0,0,0,$writeDate[1],$writeDate[2],$writeDate[0]);			##작성일
	$userIp      = $_SERVER["REMOTE_ADDR"];				##아이피
	$returnStr   = $insertField -> insertValue();		##인설트쿼리문리턴############
	$Step		 = $insertField -> BoardStep();			##게시판 스탭정보#############
	$attribute	 = $_POST["attribute"];					##게시판구분##############

	$insertSQL   = "insert into $tnm (idx,".$returnStr[0].",writedate,ref,re_level,re_step,userip,delnum) ";
	$insertSQL  .= "values('',".$returnStr[1].",".$writeDate.",".$Step[0].",".$Step[1].",".$Step[2].",'".$userIp."','0')";
//	echo $insertSQL; exit;
	

	$resultConn  = mysql_query($insertSQL,$conn);
	$insertIdx   = mysql_insert_id();			


	IF($resultConn==true){								##데이터저장성공시  파일저장
		$insertField -> insertIdx  = $insertIdx;		##인설트 IDX###################
		$insertField -> MultiFile();					##파일업로드###################	
		
		$insertField = new writeValue;
		$insertField -> postVal       = $_POST;			##포스트로 받은값#############
		$insertField -> ex            = "-";			##필드명이 배열일경우 구분자##
		$insertField -> saveDir		  = $saveDir;
		$insertField -> returnName	  = "Ext";			##리턴파일명 확장
		$insertField -> imgDis = "list";
		$insertField -> fileFieldName = "list_file";	#####타이틀필드################
		$insertField -> dataTnm		  = "fileboard";	#####파일테이블###############
		$insertField -> idx			  = $idx;							
		$insertField -> bid           = $_POST["bid"];	##게시판 아이디###############
		$insertField -> conn		  = $conn;			##DB연결######################
		$insertField -> insertIdx  = $insertIdx;		##인설트 IDX###################
		$insertField -> MultiFile();					##파일업로드###################	
		
	/*
		$insertField = new writeValue;
		$insertField -> postVal       = $_POST;			##포스트로 받은값#############
		$insertField -> ex            = "-";			##필드명이 배열일경우 구분자##
		$insertField -> saveDir		  = $saveDir;
		$insertField -> returnName	  = "Ext";			##리턴파일명 확장
		$insertField -> imgDis = "top";
		$insertField -> fileFieldName = "top_file";		#####타이틀필드################
		$insertField -> dataTnm		  = "fileboard";	#####파일테이블###############
		$insertField -> idx			  = $idx;							
		$insertField -> bid           = $_POST["bid"];	##게시판 아이디###############
		$insertField -> conn		  = $conn;			##DB연결######################
		$insertField -> insertIdx  = $insertIdx;		##인설트 IDX###################
		$insertField -> MultiFile();					##파일업로드###################	
	*/
		Alert_Msg("저장하였습니다.");
	}else{
		Alert_Msg("정보입력오류입니다.2");
	}



	mysql_close($conn);
	//$listGet = "bid=".$_GET['bid']."&page=".$_POST['page']."&gid=".$_GET['gid']."&btype=Board";
	$parameter = $_GET["parameter"];

	Replace("./BoardList.php?page=&sw=".$_GET['sw']."&sv=".$_GET['sv']."&bid=".$_GET['bid']."&btype=".$_GET['btype']."&attribute=".$_GET['attribute']);


}


?>