<?
	//$_incBoardList = Array("B"=>"B","P"=>"P","PB"=>"PB");
	//$_incBoardName = Array("B"=>"일반게시판","P"=>"사진게시판","PB"=>"리스트_사진게시판");
	include ROOT_PATH."/pSys/admin_lib/lib_paging2.php";
	$boardInfo['tbl']="multiboard";
	$nowPageClass="c_blueskyb";
	$linkClass="start";
	

	//요청 (정희정 <hj9797@fobst.org>) 에 의해 일부게시물 숨김처리 (2020.07.06 ,심재성)
	if($boardInfo['bid']== "edu_notice1" ){//교육프로그램 > 생활과학교실 > 공지사항
		$tmpHideWhere = " and idx not in('13398','13288') ";		
	}else if($boardInfo['bid']== "edu_notice4"){//교육프로그램 > 생활과학교실 코딩반 > 공지사항
		$tmpHideWhere = " and idx not in('12449') ";
	}else if($boardInfo['bid']== "edu_notice3"){//교육프로그램 > 찾아가는 생활과학교실 > 공지사항
		$tmpHideWhere = " and idx not in('13399','12376','11896') ";
	}else if($boardInfo['bid']== "join_notice"){//참여마당 > 공지사항	
		$tmpHideWhere = " and idx not in('13361','13290','13289','13203','12658','12657','12377','11901','11520','11519') ";
	}
	$where .= $tmpHideWhere;
	$noticeWhere .= $tmpHideWhere;
	

	//edu_notice1: 생활과학교실_생활과학교실_공지사항  : 현상태 유지
	if($boardInfo['bid']== "edu_notice1" ){
		// start --- 20190307요청 		
		$where .= " and writedate >= UNIX_TIMESTAMP('2019-01-01') " ;  
		$noticeWhere .= " and writedate >= UNIX_TIMESTAMP('2019-01-01') " ;  
		// end --- 20190307요청
	}
	
	//edu_notice3 : 생활과학교실_찾아가는생활과학교실_공지사항 : 2018년 이후 게시물 살리기
	if($boardInfo['bid']== "edu_notice3" || $boardInfo['bid']=="join_notice"){
		$where .= "and writedate >= UNIX_TIMESTAMP('2018-01-01') " ;  
		$noticeWhere .= "and writedate >= UNIX_TIMESTAMP('2018-01-01') " ;  
	}
	
	//join_notice : 참여마당_공지사항 : 2018년 이후 게시물 살리기
	if($boardInfo['bid']== "join_notice"){
		$where .= "and writedate >= UNIX_TIMESTAMP('2018-01-01') " ;  
		$noticeWhere .= "and writedate >= UNIX_TIMESTAMP('2018-01-01') " ;  
	}
	
	
	$noticeResult = SelectAndNum($boardInfo['tbl'],"*",$noticeWhere.$orderby);
	$result = Page_Result($boardInfo['tbl'],"idx","*",$vrecord,$vpage,$page,$sv,$sw,$where,$list_img,$get,$orderby,$nowPageClass,$linkClass,$pageLine,$sc);

	//201201 박성아 BSC 메뉴 추가
	if($boardInfo['btype']=="B" && $boardInfo['bid'] != "BSC"){
		include(ROOT_PATH.'/Skin/Board/default/list.php');
	}elseif($boardInfo['btype']=="P"){
		include(ROOT_PATH.'/Skin/Gallery/default/list.php');
	}elseif($boardInfo['btype']=="BY"){
		include(ROOT_PATH.'/Skin/Board/fobst/list.php');
	}elseif($boardInfo['btype']=="BC"){
		include(ROOT_PATH.'/Skin/Board/lecture/list.php');
	}elseif($boardInfo['btype']=="PC"){
		include(ROOT_PATH.'/Skin/Board/book/default/list.php');
	}elseif($boardInfo['btype']=="PB"){
		include(ROOT_PATH.'/Skin/hallFame/default/list.php');
	}elseif($boardInfo['bid'] == "BSC"){
		include(ROOT_PATH.'/Skin/Board/bsc/list.php');
	}
?>
