<? include "../inc/inc_headinfo.php"; ?>
<? include "../inc/inc_language.php"; ?>
<?
	include "../Mngt/conn/conn.php";
	include "../Mngt/cmmInc/queryInfo.php";
	ini_set("display_errors", '0'); //에러메시지 안나오도록 설정

	$tnm = "event";
	if($_POST){
	$idx = $_POST['o_idx'];
	$event_title = $_POST['o_title'];
	$event_contents = $_POST['o_contents'];
	if($idx){
		$insertSQL  = "insert into $tnm (idx, title, content) ";
		$insertSQL .= "values('".$idx."','".$event_title."','".$event_contents."') ";
		$insertSQL .= "on duplicate key update title = '".$event_title."', content = '".$event_contents."'";
		$resultConn  = mysql_query($insertSQL,$conn);
	}else{
		$insertSQL   = "insert into $tnm (title, content) ";
		$insertSQL  .= "values('".$event_title."','".$event_contents."')";
		$resultConn  = mysql_query($insertSQL,$conn);
	}
	}

	$getQuery = "SELECT * FROM event ORDER BY idx, date";
	$result = mysql_query($getQuery, $conn);

	$getIdx1 = mysql_result($result, 0, "idx");				//링크를 위한 idx
	$getTitle1 = mysql_result($result, 0, "title");			//이벤트명
	$getContent1 = mysql_result($result, 0, "content");		//내용
	$getDate1 = mysql_result($result, 0, "date");			//날짜

	$getIdx2 = mysql_result($result, 1, "idx");				//링크를 위한 idx
	$getTitle2 = mysql_result($result, 1, "title");			//이벤트명
	$getContent2 = mysql_result($result, 1, "content");		//내용
	$getDate2 = mysql_result($result, 1, "date");			//날짜

	$getIdx3 = mysql_result($result, 2, "idx");				//링크를 위한 idx
	$getTitle3 = mysql_result($result, 2, "title");			//이벤트명
	$getContent3 = mysql_result($result, 2, "content");		//내용
	$getDate3 = mysql_result($result, 2, "date");			//날짜

	$getIdx4 = mysql_result($result, 3, "idx");				//링크를 위한 idx
	$getTitle4 = mysql_result($result, 3, "title");			//이벤트명
	$getContent4 = mysql_result($result, 3, "content");		//내용
	$getDate4 = mysql_result($result, 3, "date");			//날짜

	$url1 = "http://wof.kr/kor/html/05_community/community_07.php?mode=read&idx=$getIdx1&pagenum=0&search_select=&keyword=";
	$url2 = "http://wof.kr/kor/html/05_community/community_07.php?mode=read&idx=$getIdx2&pagenum=0&search_select=&keyword=";
	$url3 = "http://wof.kr/kor/html/05_community/community_07.php?mode=read&idx=$getIdx3&pagenum=0&search_select=&keyword=";
	$url4 = "http://wof.kr/kor/html/05_community/community_07.php?mode=read&idx=$getIdx4&pagenum=0&search_select=&keyword=";
?>
<!--발표자료확인하기-->
<div class="sub">
	<div class="s_visual"></div>

	<!--sub nav S-->
	<div class="nav">
		<ul>
			<li>
				<a href="online_join01.php">온라인 포럼 참가</a>
			</li>
			<li>
				<a href="present.php">발표자료집</a>
			</li>
			<li>
				<a href="content_exhibi.php">콘텐츠 전시관</a>
			</li>
			<li>
				<a href="event.php">이벤트 안내</a>
			</li>
		</ul>
	</div>

	<div class="m_nav">
		<ul>
			<li class="nav_onoff">
				<a href="#n">이벤트 안내<span class="btn_over"><img src="../img/menu_btn.png" /></span></a>
			</li>
		</ul>
		<ul class="view">
			<li>
				<a href="online_join01.php">온라인 포럼 참가</a>
			</li>
			<li>
				<a href="present.php">발표자료집</a>
			</li>
			<li>
				<a href="content_exhibi.php">콘텐츠 전시관</a>
			</li>
			<li>
				<a href="event.php">이벤트 안내</a>
			</li>
		</ul>
	</div>
	<!--sub nav E-->

	<!--cont  S-->
		<div class="cont event">
			<h1>이벤트 안내</h1>		
		</div>
		<div class="cont05">
			<ul class="event_wrap">
				<li>
					<a href="http://wof.kr/kor/html/05_community/community_07.php?mode=read&idx=7&pagenum=0&search_select=&keyword=" target="_blank" title="새창으로열기">
						<div class="over">
							<div class="img_all img_box05"></div>
						</div>
						<div class="txt_box">							
							<h4>실시간 댓글달기<br/>이벤트</h4>
						</div>
					</a>					
				</li>

				<li>
					<a href="http://wof.kr/kor/html/05_community/community_07.php?mode=read&idx=8&pagenum=0&search_select=&keyword=" target="_blank" title="새창으로열기">
						<div class="over">
							<div class="img_all img_box06"></div>
						</div>
						<div class="txt_box">							
							<h4>도전 퀴즈왕~!<br/>QUIZ EVENT</h4>
						</div>
					</a>						
				</li>

				<li>
					<a href="http://wof.kr/kor/html/05_community/community_07.php?mode=read&idx=9&pagenum=0&search_select=&keyword=" target="_blank" title="새창으로열기">
						<div class="over">
							<div class="img_all img_box07"></div>
						</div>
						<div class="txt_box">							
							<h4>만족도 조사<br/>참여 이벤트</h4>
						</div>
					</a>	
				</li>

				<li>
					<a href="http://wof.kr/kor/html/05_community/community_07.php?mode=read&idx=10&pagenum=0&search_select=&keyword=" target="_blank" title="새창으로열기">
						<div class="over">
							<div class="img_all img_box08"></div>
						</div>
						<div class="txt_box">							
							<h4>BLUE<br/>한 줄 감상평 이벤트</h4>
						</div>
					</a>	
				</li>
			</ul>
		</div>
	</div>
	<!--cont  E-->

	<div class="gap100"></div>

</div>
<? include "../inc/inc_footer.php"; ?>