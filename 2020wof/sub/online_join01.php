<? include "../inc/inc_headinfo.php"; ?>
<? include "../inc/inc_language.php"; ?>
<?
	include "../Mngt/conn/conn.php";
	include "../Mngt/cmmInc/queryInfo.php";
	ini_set("display_errors", '0'); //에러메시지 안나오도록 설정
	session_start();
	if($_SESSION) $id = $_SESSION['user_id'];
	else $id = "empty";

	$session_date	= "2020-10-27";			  //세션 날짜 정보
	$tn1			= "session_kor";
	$tn2			= "session_eng";
	$tn3			= "session_jpn";
	$tn4			= "session_chi";
	
	$session_name   = "2020 대한민국 해양인의 밤";

	//해당 Session idx 가져오기
	$getQuery = "SELECT idx FROM session WHERE del='N' AND date='".$session_date."' ORDER BY idx LIMIT 1";
	$res = mysql_query($getQuery, $conn);
	$res = mysql_result($res, 0);

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn1;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_kor = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_kor = mysql_result($result, 0, "title");			//세션 명

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn2;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_eng = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_eng = mysql_result($result, 0, "title");			//세션 명

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn3;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_jpn = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_jpn = mysql_result($result, 0, "title");			//세션 명

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn4;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_chi = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_chi = mysql_result($result, 0, "title");			//세션 명

	//2020 대한민국 해양인의 밤
	$getQuery = "SELECT idx FROM session WHERE del='N' AND kind='".$session_name."' ORDER BY idx LIMIT 1";
	$res = mysql_query($getQuery, $conn);
	$res = mysql_result($res, 0);

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn1;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_kor1 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_kor1 = mysql_result($result, 0, "title");			//세션 명

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn2;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_eng1 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_eng1 = mysql_result($result, 0, "title");			//세션 명
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
<!--온라인 참가 페이지-->
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
				<a href="#n">온라인 포럼 참가<span class="btn_over"><img src="../img/menu_btn.png" /></span></a>
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


	<!--cont tit/tab/cont S-->
	<div class="cont cont_all">
		<h1>온라인 포럼 참가</h1>
		<div class="cont_tab">
			<ul>
				<li class="on_tab">
					<a href="online_join01.php">
						10.27(화)
					</a>
				</li>
				<li>
					<a href="online_join02.php">
						10.28(수)
					</a>
				</li>
				<li>
					<a href="online_join03.php">
						10.29(목)
					</a>
				</li>
			</ul>
		</div>

		<!--cont S-->
		<div class="rspvn_box tb-ty">
			<div class="rspvn_tb">
				<div class="cont03">
					<p class="t_txt">* 실시간 중계 페이지로 이동합니다.</p>
					<table class="table_wrap">
						<colgroup>
							<col width="1%">
							<col width="18%">
							<col width="18%">
							<col width="18%">
							<col width="18%">
						</colgroup>
						<tbody>
							<!-- 1 -->
							<tr>
								<th>15:30 ~ 17:30</th>
								<td>
									<a href="live_forum01.php?lang=kor&kind=open">
										<p><?=$getKind_kor?></p>
										<p class="s_tit pdt100"><?=$getTitle_kor?></p>		
									</a>
								</td>
								<td>
									<a href="live_forum01.php?lang=eng&kind=open">
										<p class="b_tit"><?=$getKind_eng?></p>
										<p class="s_tit"><?=$getTitle_eng?></p>
									</a>
								</td>
								<td>
									<a href="live_forum01.php?lang=jpn&kind=open">
										<p><?=$getKind_jpn?></p>
										<p class="s_tit pdt100"><?=$getTitle_jpn?></p>
									</a>
								</td>
								<td>
									<a href="live_forum01.php?lang=chi&kind=open">
										<p><?=$getKind_chi?></p>
										<p class="s_tit pdt100"><?=$getTitle_chi?></p>
									</a>
								</td>								
							</tr>

							<!-- 2 -->
							<tr>
								<th>17:30 ~ 18:30</th>
								<td>
									<a href="live_forum01.php?lang=kor&kind=2020">
										<p class="b_tit"><?=$getKind_kor1?></p>
										<p class="s_tit"><?=$getTitle_kor1?></p>
									</a>
								</td>
								<td>
									<a href="live_forum01.php?lang=eng&kind=2020">
										<p class="b_tit"><?=$getKind_eng1?></p>
										<p class="s_tit"><?=$getTitle_eng1?></p>
									</a>
								</td>
								<td class="n_hover">&nbsp;</td>
								<td class="n_hover">&nbsp;</td>								
							</tr>
									
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--cont E-->
		<div class="gap100"></div>

	</div>
	<!--cont tit/tab E-->
</div>

<? include "../inc/inc_footer.php"; ?>