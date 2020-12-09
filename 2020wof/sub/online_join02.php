<? include "../inc/inc_headinfo.php"; ?>
<? include "../inc/inc_language.php"; ?>
<?
	include "../Mngt/conn/conn.php";
	include "../Mngt/cmmInc/queryInfo.php";
	ini_set("display_errors", '0'); //에러메시지 안나오도록 설정	
	session_start();
	if($_SESSION) $id = $_SESSION['user_id'];
	else $id = "empty";

	$tn1			= "session_kor";
	$tn2			= "session_eng";
	$tn3			= "session_jpn";
	$tn4			= "session_chi";

	//정규세션 1
	$getQuery = "SELECT idx FROM session WHERE del='N' AND kind='정규세션 1' ORDER BY idx LIMIT 1";
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

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn3;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_jpn1 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_jpn1 = mysql_result($result, 0, "title");			//세션 명

	//정규세션 2
	$getQuery = "SELECT idx FROM session WHERE del='N' AND kind='정규세션 2' ORDER BY idx LIMIT 1";
	$res = mysql_query($getQuery, $conn);
	$res = mysql_result($res, 0);

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn1;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_kor2 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_kor2 = mysql_result($result, 0, "title");			//세션 명

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn2;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_eng2 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_eng2 = mysql_result($result, 0, "title");			//세션 명

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn3;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_jpn2 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_jpn2 = mysql_result($result, 0, "title");			//세션 명

	//특별세션 1
	$getQuery = "SELECT idx FROM session WHERE del='N' AND kind='특별세션 1' ORDER BY idx LIMIT 1";
	$res = mysql_query($getQuery, $conn);
	$res = mysql_result($res, 0);

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn1;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_kor3 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_kor3 = mysql_result($result, 0, "title");			//세션 명

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn2;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_eng3 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_eng3 = mysql_result($result, 0, "title");			//세션 명

	//특별세션 2
	$getQuery = "SELECT idx FROM session WHERE del='N' AND kind='특별세션 2' ORDER BY idx LIMIT 1";
	$res = mysql_query($getQuery, $conn);
	$res = mysql_result($res, 0);

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn1;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_kor4 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_kor4 = mysql_result($result, 0, "title");			//세션 명

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn2;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind_eng4 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle_eng4 = mysql_result($result, 0, "title");			//세션 명

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
				<a href="#n">온라인 포럼 참가</a>
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

	<script type="text/javascript">
		
	</script>

	<!--cont tit/tab S-->
	<div class="cont cont_all">
		<h1>온라인 포럼 참가</h1>
		<div class="cont_tab">
			<ul>
				<li>
					<a href="online_join01.php">
						10.27(화)
					</a>
				</li>
				<li class="on_tab">
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
							<col width="10%">
							<col width="18%">
							<col width="18%">
							<col width="18%">
							<col width="18%">
							<col width="18%">
						</colgroup>
						<thead>
							<tr>
								<th colspan="4">정규세션</th>
								<th colspan="3" class="sp_th">특별세션</th>
							</tr>
						</thead>
						<tbody>
							<!-- 1 -->
							<tr>
								<th>10:00 ~ 12:00</th>
								<td>
									<a href="live_forum02.php?lang=kor&kind=MS1">
										<p class="b_tit"><?=$getKind_kor1?></p>
										<p class="s_tit"><?=$getTitle_kor1?></p>
									</a>
								</td>
								<td>
									<a href="live_forum02.php?lang=eng&kind=MS1">
										<p class="b_tit"><?=$getKind_eng1?></p>
										<p class="s_tit"><?=$getTitle_eng1?></p>
									</a>
								</td>
								<td>
									<a href="live_forum02.php?lang=jpn&kind=MS1">
										<p class="b_tit"><?=$getKind_jpn1?></p>
										<p class="s_tit"><?=$getTitle_jpn1?></p>
									</a>
								</td>
								<td class="sp_td">
									<a href="live_forum02.php?lang=kor&kind=SS1">
										<p class="b_tit"><?=$getKind_kor3?></p>
										<p class="s_tit"><?=$getTitle_kor3?></p>
									</a>
								</td>
								<td class="sp_td">
									<a href="live_forum02.php?lang=eng&kind=SS1">
										<p class="b_tit"><?=$getKind_eng3?></p>
										<p class="s_tit"><?=$getTitle_eng3?></p>
									</a>
								</td>
							</tr>

							<!-- 2 -->
							<tr>
								<th>13:30 ~ 15:30</th>
								<td rowspan="2">
									<a href="live_forum02.php?lang=kor&kind=MS2">
										<p class="b_tit"><?=$getKind_kor2?></p>
										<p class="s_tit"><?=$getTitle_kor2?></p>
									</a>
								</td>
								<td rowspan="2">
									<a href="live_forum02.php?lang=eng&kind=MS2">
										<p class="b_tit"><?=$getKind_eng2?></p>
										<p class="s_tit"><?=$getTitle_eng2?></p>
									</a>
								</td>
								<td rowspan="2">
									<a href="live_forum02.php?lang=jpn&kind=MS2">
										<p class="b_tit"><?=$getKind_jpn2?></p>
										<p class="s_tit"><?=$getTitle_jpn2?></p>
									</a>
								</td>
								<td class="sp_td">
									<a href="live_forum02.php?lang=kor&kind=SS2">
										<p class="b_tit"><?=$getKind_kor4?></p>
										<p class="s_tit"><?=$getTitle_kor4?></p>
									</a>
								</td>
								<td class="sp_td">
									<a href="live_forum02.php?lang=eng&kind=SS2">
										<p class="b_tit"><?=$getKind_eng4?></p>
										<p class="s_tit"><?=$getTitle_eng4?></p>
									</a>
								</td>
							</tr>
							<tr>
								<th>15:30 ~ 16:00</th>
								<td class="n_hover" colspan="2">&nbsp;</td>
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