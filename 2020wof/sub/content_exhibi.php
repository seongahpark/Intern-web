<? include "../inc/inc_headinfo.php"; ?>
<? include "../inc/inc_language.php"; ?>
<?
	ini_set("display_errors", '0'); //에러메시지 안나오도록 설정
	session_start();
	if($_SESSION) $id = $_SESSION['user_id'];
	else $id = "empty";
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script>
var user_id = '<?= $id ?>';
$(document).ready(function(){
	if(user_id == "empty"){ //wof 로그인시에만 이용 가능하도록 설정
		alert('로그인 후 이용 가능합니다');
		location.replace("http://wof.kr/kor/html/06_member/login.php?check=onlinewof&ref=%2Fkor%2Fhtml%2F00_main%2Findex.php");
	}		
});

</script>
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
				<a href="#n">콘텐츠 전시관<span class="btn_over"><img src="../img/menu_btn.png" /></span></a>
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
			<h1>콘텐츠 전시관</h1>		
		</div>
		<div class="cont05">
			<ul class="event_wrap">
				<li>
					<a href="https://m.post.naver.com/viewer/postView.nhn?volumeNo=28429739&memberNo=45270291" target="_blank" title="새창으로열기">
						<div class="over">
							<div class="img_all img_box01"></div>
						</div>
						<div class="txt_box">							
							<h4>2020 해양콘텐츠 공모전</h4>
						</div>
					</a>
				</li>

				<li>
					<a href="http://hkplus.pknu.ac.kr/bbs/board.php?bo_table=notice&wr_id=42&sfl=" target="_blank" title="새창으로열기">
						<div class="over">
							<div class="img_all img_box02"></div>
						</div>
						<div class="txt_box">							
							<h4>아시아의 표해록<br/> - 바닷길, 아시아를 잇다</h4>
						</div>
					</a>
				</li>

				<li>
					<a href="http://wof.kr/kor/html/05_community/community_0201.php" target="_blank" title="새창으로열기">
						<div class="over">
							<div class="img_all img_box03"></div>
						</div>
						<div class="txt_box">
							<h4>WOF 2020 미디어존</h4>
						</div>
					</a>
				</li>

				<li>
					<a href="https://youtu.be/to80hx1OBQo" target="_blank" title="새창으로열기">
						<div class="over">
							<div class="img_all img_box04"></div>
						</div>
						<div class="txt_box">
							<h4>해양환경 시네마 'Blue'</h4>
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