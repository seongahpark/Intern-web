<?
	include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/conn/conn.php');
	session_start();
	header('Content-Type: text/html; charset=utf-8');

	//방문자수 통계를 위한 코드
	if (!isset($_SESSION['today'])) {
		$_SESSION['today']='0';
	}
	$todayc = date('Y-m-d');
		
	$sql = "SELECT * FROM statistics WHERE date = '".$todayc."'";
	$result = mysql_query($sql, $conn);
	$cnt = mysql_num_rows($result);
	if($cnt == 0){
		$_SESSION['today'] = '1';
		$sql = "INSERT INTO `statistics` (`date`, `count`) VALUES('".$todayc."','1')";
		$res = mysql_query($sql, $conn);
	}else if($cnt == 1 && $_SESSION['today'] != '1'){
		$_SESSION['today'] = '1';
		$sql = "UPDATE `statistics` SET `count`=`count`+1 WHERE `date`='".$todayc."'";
		$res = mysql_query($sql, $conn);
	}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>2020 BSF - 부산과학축전</title>
    <meta name="title" content="2020년 제19회 부산과학축전">
    <meta name="description" content="2020년 제19회 부산과학축전 홈페이지입니다.">    
	<meta property="og:type" content="website">
	<meta property="og:url" content="http://busansf.or.kr">
	<meta property="og:title" content="2020년 제19회 부산과학축전">
	<meta property="og:description" content="2020년 제19회 부산과학축전 홈페이지입니다.">
	<meta property="og:image" content="/share/img/og_img.png" />
	<meta name="naver-site-verification" content="a29bc0e8f264386f1af1943853893217ecc6b7b5" />
	<meta name="msvalidate.01" content="A0A950B6E0570A56D97BC3B0FA1B7E56" />
	<link rel="canonical" href="http://busansf.or.kr">
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">

    <script src="../share/js/vendor/webfontloader.js"></script>
	<script>
		WebFont.load ({
			custom: {
			  families: ['Noto Sans'],
			  urls: ['/share/css/fonts.css'],
			}
		 });
	</script>

    
    <link rel="stylesheet" href="../share/css/reset.css">    
    <link rel="stylesheet" href="../share/css/slick.css">    
    <link rel="stylesheet" href="../share/css/ui.css">
    <link rel="stylesheet" href="../share/css/layout.css?ver=2">
    <link rel="stylesheet" href="../share/css/main.css?ver=1.8">
    <link rel="stylesheet" href="../share/css/board.css?ver=1.7">    
    <link rel="stylesheet" href="../share/css/sub.css?ver=1.8">    
    <link rel="stylesheet" href="../share/css/landing.css?ver=1.7">    
</head>
<body>
	<div class="wrap">
        <header class="header_wrapper">
            <div class="header">
                <div class="top">
                    <div class="inner">
                        <div class="left">
                            <a href="http://www.fobst.org/" class="item out_link" target="_blank">
                                <i class="icon icon_link">로고</i>
                                <span>부산과학문화 거점센터</span>
                            </a>
							<a href="http://www.goongle.org/intro/intro.php" class="item out_link" target="_blank">
                                <i class="icon icon_link goong">로고</i>
                                <span>부산과학기술 콘텐츠플랫폼</span>
                            </a>
                        </div>
                        <div class="right">
						<?
							if(!$_SESSION || $_SESSION['name'] == ""){
						?>
                            <a href="http://www.fobst.org/kor/Member/Login.php?check=bsf" class="item login">
                                <i class="icon icon_login">로그인아이콘</i>
                                <span>로그인</span>
                            </a>
                            <a href="http://www.fobst.org/kor/Member/Join0102.php" class="item signup">
                                <i class="icon icon_signup">회원가입아이콘</i>
                                <span>회원가입</span>
                            </a>
							<?}else{?>
							<div class="item user_info">
								<i class="icon icon_user">유저아이콘</i>
								<span><?=$_SESSION['name']?>님 안녕하세요</span>								
							</div>
							<a href="http://www.fobst.org/kor/Member/logOut.php?check=bsf" class="item logout">
                                <i class="icon icon_logout">로그아웃아이콘</i>
                                <span>로그아웃</span>
                            </a>
							<?}?>
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="inner">
                        <h1 class="logo"><a href="../main/index.php">부산과학축천</a></h1>
                        <nav class="gnb_wrapper">
                            <div class="mobile_login_wrapper">
                                <?
									if(!$_SESSION || $_SESSION['name'] == ""){
								?>
								<a href="http://www.fobst.org/kor/Member/Login.php?check=bsf" class="item login">
									<span>로그인</span>
								</a>
								<a href="http://www.fobst.org/kor/Member/Join0102.php" class="item signup">
									<span>회원가입</span>
								</a>
								<?}else{?>
								<div class="item user_info">
									<span><?=$_SESSION['name']?>님</span>								
								</div>
								<a href="http://www.fobst.org/kor/Member/logOut.php?check=bsf" class="item logout">
									<span>로그아웃</span>
								</a>
								<?}?>
                            </div>
                            <ul>
                                <li class="menu_l1"><a class="menu_a1" href="../about/festival.php">행사소개</a>
                                    <ul class="menu_d2">
                                        <li class="menu_l2"><a class="menu_a2" href="../about/festival.php">행사개요</a></li>
                                        <li class="menu_l2"><a class="menu_a2" href="../about/greet.php">인사말</a></li>
                                    </ul>
                                </li>
                                <li class="menu_l1"><a class="menu_a1" href="../science/top7.php">과학 in 부산</a>
                                    <ul class="menu_d2">
                                        <li class="menu_l2"><a class="menu_a2" href="../science/top7.php">전통과학발명품 TOP7</a></li>
                                        <li class="menu_l2"><a class="menu_a2" href="../science/tour.php">과학관 여행</a></li>
                                        <li class="menu_l2"><a class="menu_a2" href="../science/party.php">스타파티</a></li>
                                        <li class="menu_l2"><a class="menu_a2" href="../science/overcome.php">위기극복 부산</a></li>
                                        <li class="menu_l2"><a class="menu_a2" href="../science/scientist.php">부산의 과학자</a></li>
                                    </ul>
                                </li>
                                <li class="menu_l1"><a class="menu_a1" href="../concert/meeting.php">과학 on 라이브</a>
                                    <ul class="menu_d2">
                                        <li class="menu_l2"><a class="menu_a2" href="../concert/meeting.php">유튜버 팬미팅</a></li>
                                        <li class="menu_l2"><a class="menu_a2" href="../concert/drama.php">사이언스 드라마</a></li>
                                        <li class="menu_l2"><a class="menu_a2" href="../concert/story.php">스토리 마마</a></li>
                                        <li class="menu_l2"><a class="menu_a2" href="../concert/showme.php">쇼미더사이언스</a></li>
                                    </ul>
                                </li>
                                <li class="menu_l1"><a class="menu_a1" href="../playground/laboratory_01.php">과학 & 펀</a>
                                    <ul class="menu_d2">
                                        <li class="menu_l2">
                                            <a class="menu_a2" href="../playground/laboratory_01.php">어디나 실험실</a>
                                            <ul class="menu_d3">
                                                <li class="menu_l3"><a class="menu_a3" href="../playground/laboratory_01.php">기관 및 과학관</a></li>
                                                <li class="menu_l3"><a class="menu_a3" href="../playground/laboratory_02.php">학교</a></li>
                                                <li class="menu_l3"><a class="menu_a3" href="../playground/laboratory_03.php">우리집</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu_l2"><a class="menu_a2" href="../playground/anyone.php">누구나 실험왕</a></li>
                                        <li class="menu_l2"><a class="menu_a2" href="../playground/challenge.php">과학댄스 챌린지</a></li>
                                    </ul>
                                </li>
                                <li class="menu_l1"><a class="menu_a1" href="../community/notice.php?bid=notice&&start=0">소통마당</a>
                                    <ul class="menu_d2">
                                        <li class="menu_l2"><a class="menu_a2" href="../community/notice.php?bid=notice&&start=0">공지사항</a></li>
                                        <li class="menu_l2"><a class="menu_a2" href="../community/qna.php?bid=qna&&start=0">Q&A</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <a href="#" class="mobile_close">닫기</a>
                        </nav>
                        <div class="utill">
                            <!-- <a href="#" class="search item">
                                <i class="icon icon_search">검색아이콘</i>
                                <span>검색</span>
                            </a> -->
                            <a href="../etc/sitemap.php" class="sitemap item">
                                <i class="icon icon_sitemap">사이트맵아이콘</i>
                                <span>사이트맵</span>
                            </a>
                        </div>
						<div class="mobile_dim"></div>
                    </div>
                </div>
            </div>
        </header>
			<div id="barba-wrapper">