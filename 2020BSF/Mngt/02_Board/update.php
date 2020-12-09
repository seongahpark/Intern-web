<?php
	include "../conn/conn.php";
	include "../cmmInc/sessionTop.php";
	include "../cmmInc/queryInfo.php";
	include "../cmmInc/lib_image.php";
	include "../cmmInc/msgScript.php";
	include "../cmmInc/saveClass.php";


if($_GET["btype"]=="Board"){

	$tnm	 = "multiboard";							##테이블이름##################
	$saveDir = "../../data/".$_POST["bid"]."/";			##파일저장경로################
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

	!$_POST['notice'] ? $NoticeChk = ",notice='N'" : $NoticeChk = "";	#공지
	!$_POST['secret'] ? $SecretChk = ",secret='N'" : $SecretChk = "";	#비밀

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


}else if($_GET["btype"]=="Gallery"){


	$tnm	 = "multiboard";							##테이블이름##################
	$saveDir = "../../data/".$_POST["bid"]."/";			##파일저장경로################
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


	!$_POST['notice'] ? $NoticeChk = ",notice='N'" : $NoticeChk = "";	#공지
	!$_POST['secret'] ? $SecretChk = ",secret='N'" : $SecretChk = "";	#비밀

	$insertSQL   = "update $tnm set ".$retrunStr.$NoticeChk.$SecretChk.",writedate=".$writeDate;
	$insertSQL  .= " where idx=".$idx;

	$resultConn  = mysql_query($insertSQL,$conn);
			
	IF($resultConn==true){								##데이터저장성공시  파일저장
		$insertField -> insertIdx  = $idx;				##인설트 IDX..................
		$insertField -> MultiFile();					##파일업로드..................

		$insertField = new writeValue;
		$insertField -> postVal       = $_POST;	##포스트로 받은값#############
		$insertField -> ex            = "-";				##필드명이 배열일경우 구분자##
		$insertField -> saveDir		  = $saveDir;
		$insertField -> returnName	  = "Ext";				##리턴파일명 확장
		$insertField -> imgDis = "list";
		$insertField -> fileFieldName = "list_file";		#####타이틀필드################
		$insertField -> dataTnm		  = "fileboard";		#####파일테이블###############
		$insertField -> idx			  = $idx;							
		$insertField -> bid           = $_POST["bid"];		##게시판 아이디###############
		$insertField -> conn		  = $conn;				##DB연결######################
		$insertField -> insertIdx  = $idx;		##인설트 IDX###################
		$insertField -> MultiFile();					##파일업로드###################	
		
	/*
		$insertField = new writeValue;
		$insertField -> postVal       = $_POST;	##포스트로 받은값#############
		$insertField -> ex            = "-";				##필드명이 배열일경우 구분자##
		$insertField -> saveDir		  = $saveDir;
		$insertField -> returnName	  = "Ext";				##리턴파일명 확장
		$insertField -> imgDis = "top";
		$insertField -> fileFieldName = "top_file";		#####타이틀필드################
		$insertField -> dataTnm		  = "fileboard";		#####파일테이블###############
		$insertField -> idx			  = $idx;							
		$insertField -> bid           = $_POST["bid"];		##게시판 아이디###############
		$insertField -> conn		  = $conn;				##DB연결######################
		$insertField -> insertIdx  = $idx;		##인설트 IDX###################
		$insertField -> MultiFile();					##파일업로드###################	
	*/
		Alert_Msg("저장하였습니다.");
	}else{
		Alert_Msg("정보입력오류입니다.");
	}

	mysql_close($conn);
	$parameter = $_GET["parameter"];

	Replace("./BoardList.php?page=&sw=".$_GET['sw']."&sv=".$_GET['sv']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype']."&attribute=".$_GET['attribute']);


}else if($_GET["btype"]=="Movie"){

	$tnm	 = "multiboard";							##테이블이름##################
	$saveDir = "../../data/".$_POST["bid"]."/";			##파일저장경로################
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
	$insertField -> imgDis = "sub";
	$insertField -> fileFieldName = "sub_file";			#####파일필드#################
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


	!$_POST['notice'] ? $NoticeChk = ",notice='N'" : $NoticeChk = "";	#공지
	!$_POST['secret'] ? $SecretChk = ",secret='N'" : $SecretChk = "";	#비밀

	$insertSQL   = "update $tnm set ".$retrunStr.$NoticeChk.$SecretChk.",writedate=".$writeDate;
	$insertSQL  .= " where idx=".$idx;

	$resultConn  = mysql_query($insertSQL,$conn);
			
	IF($resultConn==true){								##데이터저장성공시  파일저장
		$insertField -> insertIdx  = $idx;				##인설트 IDX..................
		$insertField -> MultiFile();					##파일업로드..................
/*
		$insertField = new writeValue;
		$insertField -> postVal       = $_POST;	##포스트로 받은값#############
		$insertField -> ex            = "-";				##필드명이 배열일경우 구분자##
		$insertField -> saveDir		  = $saveDir;
		$insertField -> returnName	  = "Ext";				##리턴파일명 확장
		$insertField -> imgDis = "sub";
		$insertField -> fileFieldName = "sub_file";		#####타이틀필드################
		$insertField -> dataTnm		  = "fileboard";		#####파일테이블###############
		$insertField -> idx			  = $idx;							
		$insertField -> bid           = $_POST["bid"];		##게시판 아이디###############
		$insertField -> conn		  = $conn;				##DB연결######################
		$insertIdx   = mysql_insert_id();			
		$insertField -> insertIdx  = $insertIdx;		##인설트 IDX###################
		$insertField -> MultiFile();					##파일업로드###################	
		*/
	
		$insertField = new writeValue;
		$insertField -> postVal       = $_POST;	##포스트로 받은값#############
		$insertField -> ex            = "-";				##필드명이 배열일경우 구분자##
		$insertField -> saveDir		  = $saveDir;
		$insertField -> returnName	  = "Ext";				##리턴파일명 확장
		$insertField -> imgDis = "movie";
		$insertField -> fileFieldName = "movie_file";		#####타이틀필드################
		$insertField -> dataTnm		  = "fileboard";		#####파일테이블###############
		$insertField -> idx			  = $idx;							
		$insertField -> bid           = $_POST["bid"];		##게시판 아이디###############
		$insertField -> conn		  = $conn;				##DB연결######################
		//$insertIdx   = mysql_insert_id();			
		$insertField -> insertIdx  = $idx;		##인설트 IDX###################
		$insertField -> MultiFile();					##파일업로드###################	

		Alert_Msg("저장하였습니다.");
	}else{
		Alert_Msg("정보입력오류입니다.");
	}

	mysql_close($conn);
	$parameter = $_GET["parameter"];

	Replace("./BoardList.php?page=&sw=".$_GET['sw']."&sv=".$_GET['sv']."&corp=".$_GET['corp']."&rd=".$_GET['rd']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype']);

}else if($_GET["btype"]=="eBootda"){

	$tnm	 = "multiboard";							##테이블이름##################
	$saveDir = "../../data/".$_POST["bid"]."/";			##파일저장경로################
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
	$insertField -> imgDis = "sub";
	$insertField -> fileFieldName = "sub_file";			#####파일필드#################
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


	!$_POST['notice'] ? $NoticeChk = ",notice='N'" : $NoticeChk = "";	#공지
	!$_POST['secret'] ? $SecretChk = ",secret='N'" : $SecretChk = "";	#비밀

	$insertSQL   = "update $tnm set ".$retrunStr.$NoticeChk.$SecretChk.",writedate=".$writeDate;
	$insertSQL  .= " where idx=".$idx;

	$resultConn  = mysql_query($insertSQL,$conn);
			
	IF($resultConn==true){								##데이터저장성공시  파일저장
		$insertField -> insertIdx  = $idx;				##인설트 IDX..................
		$insertField -> MultiFile();					##파일업로드..................
/*
		$insertField = new writeValue;
		$insertField -> postVal       = $_POST;	##포스트로 받은값#############
		$insertField -> ex            = "-";				##필드명이 배열일경우 구분자##
		$insertField -> saveDir		  = $saveDir;
		$insertField -> returnName	  = "Ext";				##리턴파일명 확장
		$insertField -> imgDis = "sub";
		$insertField -> fileFieldName = "sub_file";		#####타이틀필드################
		$insertField -> dataTnm		  = "fileboard";		#####파일테이블###############
		$insertField -> idx			  = $idx;							
		$insertField -> bid           = $_POST["bid"];		##게시판 아이디###############
		$insertField -> conn		  = $conn;				##DB연결######################
		$insertIdx   = mysql_insert_id();			
		$insertField -> insertIdx  = $insertIdx;		##인설트 IDX###################
		$insertField -> MultiFile();					##파일업로드###################	
		*/
	
		$insertField = new writeValue;
		$insertField -> postVal       = $_POST;	##포스트로 받은값#############
		$insertField -> ex            = "-";				##필드명이 배열일경우 구분자##
		$insertField -> saveDir		  = $saveDir;
		$insertField -> returnName	  = "Ext";				##리턴파일명 확장
		$insertField -> imgDis = "movie";
		$insertField -> fileFieldName = "movie_file";		#####타이틀필드################
		$insertField -> dataTnm		  = "fileboard";		#####파일테이블###############
		$insertField -> idx			  = $idx;							
		$insertField -> bid           = $_POST["bid"];		##게시판 아이디###############
		$insertField -> conn		  = $conn;				##DB연결######################
		//$insertIdx   = mysql_insert_id();			
		$insertField -> insertIdx  = $idx;		##인설트 IDX###################
		$insertField -> MultiFile();					##파일업로드###################	

		Alert_Msg("저장하였습니다.");
	}else{
		Alert_Msg("정보입력오류입니다.");
	}

	mysql_close($conn);
	$parameter = $_GET["parameter"];

	Replace("./BoardList.php?page=&sw=".$_GET['sw']."&sv=".$_GET['sv']."&corp=".$_GET['corp']."&rd=".$_GET['rd']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype']);

}

?>