<? 
	session_start();	
	include "../inc/inc_headinfo.php";
	include "../Mngt/conn/conn.php";
	include "../Mngt/cmmInc/queryInfo.php";
	header("Cache-Control:no-cache");
	header("Pragma:no-cache");
	
	ini_set("display_errors", '0'); //에러메시지 안나오도록 설정
	//header('Content-Type: text/html; charset=utf-8');			//인코딩 깨지면 주석해제

	if(!$_SESSION) $_SESSION['user_id'] = "empty";
	$user_id = $_SESSION['user_id'];
	$user_email = $_SESSION['email'];

	$session_date	= "2020-10-29";			  //세션 날짜 정보
	if($_GET) $lang	= $_GET['lang'];		  //세션 언어 정보
	else	  $lang = "kor";				  //default kor
	$tn				= "session_".$lang;

	if($_GET['kind'] == "MS3") $name = "정규세션 3"; //세션 종류 정보
	else if($_GET['kind'] == "MS4") $name = "정규세션 4";
	else if($_GET['kind'] == "SS3") $name = "특별세션 3";
	else if($_GET['kind'] == "SS4") $name = "특별세션 4";
	else if($_GET['kind'] == "EP") $name = "에필로그 세션";

	//해당 Session idx 가져오기 
	$getQuery = "SELECT idx FROM session WHERE del='N' AND date='".$session_date."' AND kind='".$name."' ORDER BY idx LIMIT 1";
	$res = mysql_query($getQuery, $conn);
	$res = mysql_result($res, 0);

	//Main Data
	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle = mysql_result($result, 0, "title");			//세션 명
	$getVideo = mysql_result($result, 0, "video");			//유튜브 주소
	$getText = mysql_result($result, 0, "text");			//세션 소개글
	$getPlace = mysql_result($result, 0, "place");			//좌장
	$getSpeech = mysql_result($result, 0, "speech");		//기조연설
	$getKeynote = mysql_result($result, 0, "keynote");		//세션기조
	$getPresent = mysql_result($result, 0, "present");		//발제자
	$getPanel = mysql_result($result, 0, "panel");			//토론좌장
	$getPanelist = mysql_result($result, 0, "panelist");	//토론자
	
	//Video 정보 가공
	$getVideo = substr($getVideo, 17); 
	//url을 https://www.youtube.com/embed/+해당링크 형식으로 만들어주기위해 url 가공
	$uploadVideo = 'https://www.youtube.com/embed/'.$getVideo;
	$video = '<iframe width="560" height="315" src="'.$uploadVideo.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

/*
	//통계
	//$sessiondate	= "2020-10-29";
	$selectSQL		= "SELECT kind FROM session WHERE idx = '".$res."'";			//공통 인덱스를 통하여 제목을 가져온다
	$result_title	= mysql_query($selectSQL);	
	$real_title		= mysql_result($result_title, 0);
	if(!strcmp("kor" , $lang))
		$lang_convert = 1;
	else if(!strcmp("eng" , $lang))
		$lang_convert = 2;
	else if(!strcmp("jpn" , $lang))
		$lang_convert = 3;
	else if(!strcmp("chi" , $lang))
		$lang_convert = 4;
	
	if($user_id != "empty"){
	$member_ID	= $_SESSION['user_id'];			//ID를 wof.kr에서 받아옴
	$belong		= $_SESSION['belong'];			//소속
	$number		= $_SESSION['mobile'];			//연락처
	$email		= $_SESSION['email'];			//이메일
	$name		= $_SESSION['name'];			//성명

	$selectDate		= "SELECT stat_date from statistics where ID = '".$member_ID."' ";		//날짜 가져오기
	$resultDate		= mysql_query($selectDate);
	$dbDate			= mysql_fetch_array($resultDate);
	$subdbDate		= substr($dbDate[0], 2, 8);

	$selectSQL	= "SELECT * from statistics where ID = '".$member_ID."' AND session_type = '".$real_title."' AND language = '".$lang_convert."' AND stat_date = '".$subdbDate."' ";			//해당하는 
	$result		= mysql_query($selectSQL);				
	$count = mysql_num_rows($result);

	if($result == false){
		echo "sql error! <br>";
	}
	$selectTime		= "SELECT time FROM session WHERE idx = '".$res."'";					//시간 가져오기
	$result_Time	= mysql_query($selectTime);	
	$real_Time		= mysql_result($result_Time, 0);

	$curdate		= date('y-m-d');					//현재 날짜
	//$curdate		= '20-10-29';						///테스트용 날짜 설정
	$sessionDate	= new DateTime($session_date);		//세션 날짜

	if(date_diff(new DateTime($curdate) , $sessionDate)->format("%R%a") < 0){					//세션 일자 보다 이후일 경우
		echo
		'<script>
			alert("지난 세션입니다");
			history.back();
		</script>';
	}
	else 

	if(date_diff(new DateTime($curdate), $sessionDate)->format("%R%a") > 0){
		if($_SERVER['REMOTE_ADDR'] == "106.242.167.93" || $_SERVER['REMOTE_ADDR'] ==  "61.32.164.99" || $_SERVER['REMOTE_ADDR'] ==  "222.97.89.32"){
		}else{
			echo
			'<script>
			alert("준비중입니다");
			history.back();
			</script>';		
		}
	}else{
		if($count == 0){		//처음 들어온 사람일 시
			$insertSQL   = "insert into statistics (session_type , language, ID, belong, number, email, name, stat_date, time) ";
			$insertSQL  .= "values( '".$real_title."' , '".$lang_convert."' , '".$member_ID."' , '".$belong."' , '".$number."' , '".$email."' , '".$name."' , '".$curdate."' , '".$real_Time."' )";
			$resultConn  = mysql_query($insertSQL,$conn);
			$insertIdx   = mysql_insert_id();		
		}	
	}
	}
*/
	// Session 3 가져오기
	$name			= "정규세션 3";

	$getQuery = "SELECT idx FROM session WHERE del='N' AND date='".$session_date."' AND kind='".$name."' ORDER BY idx LIMIT 1";
	$res = mysql_query($getQuery, $conn);
	$res = mysql_result($res, 0);

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind1 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle1 = mysql_result($result, 0, "title");			//세션 명
	$getVideo1 = mysql_result($result, 0, "video");			//유튜브 주소
	$getText1 = mysql_result($result, 0, "text");			//세션 소개글
	$getPlace1 = mysql_result($result, 0, "place");			//좌장
	$getSpeech1 = mysql_result($result, 0, "speech");		//기조연설
	$getKeynote1 = mysql_result($result, 0, "keynote");		//세션기조
	$getPresent1 = mysql_result($result, 0, "present");		//발제자
	$getPanel1 = mysql_result($result, 0, "panel");			//토론좌장
	$getPanelist1 = mysql_result($result, 0, "panelist");	//토론자

	//해당 Session 4 가져오기
	$name			= "정규세션 4";

	$getQuery = "SELECT idx FROM session WHERE del='N' AND date='".$session_date."' AND kind='".$name."' ORDER BY idx LIMIT 1";
	$res = mysql_query($getQuery, $conn);
	$res = mysql_result($res, 0);

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind2 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle2 = mysql_result($result, 0, "title");			//세션 명
	$getVideo2 = mysql_result($result, 0, "video");			//유튜브 주소
	$getText2 = mysql_result($result, 0, "text");			//세션 소개글
	$getPlace2 = mysql_result($result, 0, "place");			//좌장
	$getSpeech2 = mysql_result($result, 0, "speech");		//기조연설
	$getKeynote2 = mysql_result($result, 0, "keynote");		//세션기조
	$getPresent2 = mysql_result($result, 0, "present");		//발제자
	$getPanel2 = mysql_result($result, 0, "panel");			//토론좌장
	$getPanelist2 = mysql_result($result, 0, "panelist");	//토론자

	//특별세션 3
	$name			= "특별세션 3";

	$getQuery = "SELECT idx FROM session WHERE del='N' AND date='".$session_date."' AND kind='".$name."' ORDER BY idx LIMIT 1";
	$res = mysql_query($getQuery, $conn);
	$res = mysql_result($res, 0);

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind3 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle3 = mysql_result($result, 0, "title");			//세션 명
	$getVideo3 = mysql_result($result, 0, "video");			//유튜브 주소
	$getText3 = mysql_result($result, 0, "text");			//세션 소개글
	$getPlace3 = mysql_result($result, 0, "place");			//좌장
	$getSpeech3 = mysql_result($result, 0, "speech");		//기조연설
	$getKeynote3 = mysql_result($result, 0, "keynote");		//세션기조
	$getPresent3 = mysql_result($result, 0, "present");		//발제자
	$getPanel3 = mysql_result($result, 0, "panel");			//토론좌장
	$getPanelist3 = mysql_result($result, 0, "panelist");	//토론자

	//특별세션 4
	$name			= "특별세션 4";

	$getQuery = "SELECT idx FROM session WHERE del='N' AND date='".$session_date."' AND kind='".$name."' ORDER BY idx LIMIT 1";
	$res = mysql_query($getQuery, $conn);
	$res = mysql_result($res, 0);

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind4 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle4 = mysql_result($result, 0, "title");			//세션 명
	$getVideo4 = mysql_result($result, 0, "video");			//유튜브 주소
	$getText4 = mysql_result($result, 0, "text");			//세션 소개글
	$getPlace4 = mysql_result($result, 0, "place");			//좌장
	$getSpeech4 = mysql_result($result, 0, "speech");		//기조연설
	$getKeynote4 = mysql_result($result, 0, "keynote");		//세션기조
	$getPresent4 = mysql_result($result, 0, "present");		//발제자
	$getPanel4 = mysql_result($result, 0, "panel");			//토론좌장
	$getPanelist4 = mysql_result($result, 0, "panelist");	//토론자

	//에필로그
	$name			= "에필로그 세션";

	$getQuery = "SELECT idx FROM session WHERE del='N' AND date='".$session_date."' AND kind='".$name."' ORDER BY idx LIMIT 1";
	$res = mysql_query($getQuery, $conn);
	$res = mysql_result($res, 0);

	$getQuery = "SELECT * FROM ";
	$getQuery .= $tn;
	$getQuery .= " WHERE idx='".$res."' LIMIT 1";
	$result = mysql_query($getQuery, $conn);
	$getKind5 = mysql_result($result, 0, "kind");			//세선 종류
	$getTitle5 = mysql_result($result, 0, "title");			//세션 명
	$getVideo5 = mysql_result($result, 0, "video");			//유튜브 주소
	$getText5 = mysql_result($result, 0, "text");			//세션 소개글
	$getPlace5 = mysql_result($result, 0, "place");			//좌장
	$getSpeech5 = mysql_result($result, 0, "speech");		//기조연설
	$getKeynote5 = mysql_result($result, 0, "keynote");		//세션기조
	$getPresent5 = mysql_result($result, 0, "present");		//발제자
	$getPanel5 = mysql_result($result, 0, "panel");			//토론좌장
	$getPanelist5 = mysql_result($result, 0, "panelist");	//토론자

?>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
var today = new Date(); //채팅방 접속 시간 가져오기 위해 사용
var hour = today.getHours();
var min = today.getMinutes();
var sec = today.getSeconds();
var getDate = " "+ hour + ":" + min + ":" + sec;
var user_id = '<?= $user_id ?>';
var id = '<?= $user_email ?>';
var session = '<?= $getKind ?>';
var lang = '<?= $lang ?>';
var didScroll; //스크롤 이벤트를 위해 사용

$(document).ready(function() { //이 HTML도큐먼트가 로드되면 실행되는 함수
	$("#name").val(id);
    $("#send").click(function() { //#send 의 클릭 이벤트 발생시
	  $("#chatLog").scrollTop($("#chatLog")[0].scrollHeight);
      var form_data = { //POST로 보낼 formdata를 ajax형태로 생성해줌.
		 session: session,
		 lang: lang,
         name: $("#name").val(),
         message: $("#message").val(),
         is_ajax: 1
      };
      $.ajax({ //Jquery에서 지원하는 AJAX
         type: "POST",
         url: "post.php",
         data: form_data
      });
		$("#message").val(''); //전송 후 내용 비우기
      return false;
   });
   
   $("#message").click(function() {
	   //로그인 했을 시에만 채팅 사용 되도록
		check();
   });	
});	
function ajax_request(url) //이 함수는 Jquery를 사용하지 않은 AJAX
{
	var sessionEn = encodeURIComponent(session);
   var xhr = new XMLHttpRequest();
   //xhr.open("GET", url, true);
   xhr.open("GET", "log.php?date="+getDate+"&id="+id+"&session="+sessionEn+"&lang="+lang, true); //GET으로 시간만 전송
	xhr.onreadystatechange = function(){
		if (xhr.readyState === 4 && xhr.status === 200){
			$("#chatLog").html(xhr.responseText);
			$("#chatLog").scroll(function(event){
				didScroll = true;
			});
		}else{
			//alert("error");
		}
	}
	xhr.send(null)
}

var timer = setInterval(function () { //인터벌 500인 타이머 생성후 코드 반복 실행
   ajax_request("log.php"); //0.5초마다 log.php의 내용을 불러온다.
   if(didScroll){
	   	//console.log("scroll");
		didScroll = false;
   }else{
		$("#chatLog").scrollTop($("#chatLog")[0].scrollHeight);
   }
   }, 1000); //1초로 수정

function check(){
	if(user_id == "empty"){
		alert('로그인 후 이용 가능합니다');
		location.replace("http://wof.kr/kor/html/06_member/login.php?check=onlinewof&ref=%2Fkor%2Fhtml%2F00_main%2Findex.php");
	}		
}
</script>
<div class="sub">
	<div class="cont">
		<div class="sec01"><h1>LIVE 온라인 포럼 중계</h1></div>
		<div class="sec02">
			<div class="youtube">
				<div class="youtube_m">
					<?php echo $video;?>
				</div>
			</div>
			<div class="chat">
				<div class="chat_wrap">
					<div class="gray_view" id="chatLog">
						<div class="ch_txtbox">
							<p>UXIS</p>
							<div class="">
								<p>세계해양포럼입니다. 현재는 온라인 실시간 입니다.</p>
							</div>
						</div>
						<div class="ch_txtbox me_chat">
							<p class="id_tit">UXIS</p>
							<div class="">
								<p>세계해양포럼입니다. 현재는 온라인 실시간 입니다.</p>
							</div>
						</div>
					</div>
					<div class="white_write">
						<div class="w_w_inner">
							<form id="form1" name="form1" method="POST">
							<input type="hidden" id="name" name="user_id" value="<?=$user_id?>">
							<div class="chat_areabox">
								<textarea id="message"></textarea>
							</div>
							<div class="chat_btnbox">
								<a href="#n" id="send"><span>등록</span></a>
							</div>
							</form>
						</div>						
					</div>
				</div>
			</div>
		</div>
		<div  class="sec03">
			<ul class="">
				<li>
					<a href="present.php">
						<div>
							<h4 class="txt_ch">발표자료집 확인하기</h4>
							<p class="arrow"></p>
						</div>
						<p class="icon_01"><img src="../img/btn_icon01_s50.png"></p>
					</a>	
				</li>
				<li>
					<a href="event.php">
						<div>
							<h4 class="txt_ch">이벤트 안내</h4>
							<p class="arrow"></p>
						</div>
						<p class="icon_01"><img src="../img/btn_icon03_s50.png"></p>
					</a>	
				</li>
				<li>
					<a href="content_exhibi.php">
						<div>
							<h4 class="txt_ch">콘텐츠 전시관</h4>
							<p class="arrow"></p>
						</div>
						<p class="icon_01"><img src="../img/btn_icon02_s50.png"></p>
					</a>	
				</li>
			</ul>
		</div>

<?	if($_GET['kind'] == "MS3" || $_GET['kind'] == "MS4" || $_GET['kind'] == "EP") { ?>
		<!--1-->
		<div class="sec04">
			<div class="pg_all pg_tit">
				<p>( 10:00 ~ 12:00 ) <?= $getKind1?></p>
				<h3><?= $getTitle1?></h3>
				<div class="tab_btn"></div>
			</div>
			<div class="cont_onoff">
				<div class="pg_cont ">
					<div><p>세션소개</p></div>
					<p class="pg_info"><?=nl2br($getText1)?></p>
				</div>
				<div class="pg_speaker">
					<table>
						<colgroup>
							<col width="20%">
							<col width="80%">
						</colgroup>
			<? if($getPlace1 != ""){ ?>
						<tr>
							<th class="first">좌장</th>
							<td>
								<ul>
									<li><?=nl2br($getPlace1)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getSpeech1 != ""){ ?>
						<tr>
							<th>기조연설</th>
							<td>
								<ul>
									<li><?=nl2br($getSpeech1)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getKeynote1 != ""){ ?>
						<tr>
							<th>세션기조</th>
							<td>
								<ul>
									<li><?=nl2br($getKeynote1)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPresent1 != ""){ ?>
						<tr>
							<th>발제자</th>
							<td>
								<ul>
									<li><?=nl2br($getPresent1)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPanel1 != ""){ ?>
						<tr>
							<th>토론좌장</th>
							<td>
								<ul>
									<li><?=nl2br($getPanel1)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPanelist1 != ""){ ?>
						<tr>
							<th class="bb_n">토론자</th>
							<td class="bb_n">
								<ul>
									<li><?=nl2br($getPanelist1)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
					</table>
				</div>
			</div>
		</div>

		<!--2-->
		<div class="sec04">
			<div class="pg_all pg_tit01">
				<p>( 13:30 ~ 15:30 ) <?= $getKind2?></p>
				<h3><?= $getTitle2?></h3>
				<div class="tab_btn01"></div>
			</div>
			<div class="cont_onoff01">
				<div class="pg_cont ">
					<div><p>세션소개</p></div>
					<p class="pg_info"><?=nl2br($getText2)?></p>
				</div>
				<div class="pg_speaker">
					<table>
						<colgroup>
							<col width="20%">
							<col width="80%">
						</colgroup>
			<? if($getPlace2 != ""){ ?>
						<tr>
							<th class="first">좌장</th>
							<td>
								<ul>
									<li><?=nl2br($getPlace2)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getSpeech2 != ""){ ?>
						<tr>
							<th>기조연설</th>
							<td>
								<ul>
									<li><?=nl2br($getSpeech2)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getKeynote2 != ""){ ?>
						<tr>
							<th>세션기조</th>
							<td>
								<ul>
									<li><?=nl2br($getKeynote2)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPresent2 != ""){ ?>
						<tr>
							<th>발제자</th>
							<td>
								<ul>
									<li><?=nl2br($getPresent2)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPanel2 != ""){ ?>
						<tr>
							<th>토론좌장</th>
							<td>
								<ul>
									<li><?=nl2br($getPanel2)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPanelist2 != ""){ ?>
						<tr>
							<th class="bb_n">토론자</th>
							<td class="bb_n">
								<ul>
									<li><?=nl2br($getPanelist2)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
					</table>
				</div>
			</div>
		</div>
		<!--3-->
		<div class="sec04">
			<div class="pg_all pg_tit02">
				<p>( 16:00 ~ 17:00 ) <?= $getKind5?></p>
				<h3><?= $getTitle5?></h3>
				<div class="tab_btn02"></div>
			</div>
			<div class="cont_onoff02">
				<div class="pg_cont ">
					<div><p>세션소개</p></div>
					<p class="pg_info"><?=nl2br($getText5)?></p>
				</div>
				<div class="pg_speaker">
					<table>
						<colgroup>
							<col width="20%">
							<col width="80%">
						</colgroup>
			<? if($getPlace5 != ""){ ?>
						<tr>
							<th class="first">좌장</th>
							<td>
								<ul>
									<li><?=nl2br($getPlace5)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getSpeech5 != ""){ ?>
						<tr>
							<th>기조연설</th>
							<td>
								<ul>
									<li><?=nl2br($getSpeech5)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getKeynote5 != ""){ ?>
						<tr>
							<th>세션기조</th>
							<td>
								<ul>
									<li><?=nl2br($getKeynote5)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPresent5 != ""){ ?>
						<tr>
							<th>발제자</th>
							<td>
								<ul>
									<li><?=nl2br($getPresent5)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPanel5 != ""){ ?>
						<tr>
							<th>토론좌장</th>
							<td>
								<ul>
									<li><?=nl2br($getPanel5)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPanelist5 != ""){ ?>
						<tr>
							<th class="bb_n">토론자</th>
							<td class="bb_n">
								<ul>
									<li><?=nl2br($getPanelist5)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
					</table>
				</div>
			</div>
		</div>
	<? }else{ ?>
		<!--1-->
		<div class="sec04">
			<div class="pg_all pg_tit">
				<p>( 10:00 ~ 12:00 ) <?= $getKind3?></p>
				<h3><?= $getTitle3?></h3>
				<div class="tab_btn"></div>
			</div>
			<div class="cont_onoff">
				<div class="pg_cont ">
					<div><p>세션소개</p></div>
					<p class="pg_info"><?=nl2br($getText3)?></p>
				</div>
				<div class="pg_speaker">
					<table>
						<colgroup>
							<col width="20%">
							<col width="80%">
						</colgroup>
			<? if($getPlace3 != ""){ ?>
						<tr>
							<th class="first">좌장</th>
							<td>
								<ul>
									<li><?=nl2br($getPlace3)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getSpeech3 != ""){ ?>
						<tr>
							<th>기조연설</th>
							<td>
								<ul>
									<li><?=nl2br($getSpeech3)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getKeynote3 != ""){ ?>
						<tr>
							<th>세션기조</th>
							<td>
								<ul>
									<li><?=nl2br($getKeynote3)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPresent3 != ""){ ?>
						<tr>
							<th>발제자</th>
							<td>
								<ul>
									<li><?=nl2br($getPresent3)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPanel3 != ""){ ?>
						<tr>
							<th>토론좌장</th>
							<td>
								<ul>
									<li><?=nl2br($getPanel3)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPanelist3 != ""){ ?>
						<tr>
							<th class="bb_n">토론자</th>
							<td class="bb_n">
								<ul>
									<li><?=nl2br($getPanelist3)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
					</table>
				</div>
			</div>
		</div>

		<!--2-->
		<div class="sec04">
			<div class="pg_all pg_tit01">
				<p>( 13:30 ~ 16:30 ) <?= $getKind4?></p>
				<h3><?= $getTitle4?></h3>
				<div class="tab_btn01"></div>
			</div>
			<div class="cont_onoff01">
				<div class="pg_cont ">
					<div><p>세션소개</p></div>
					<p class="pg_info"><?=nl2br($getText4)?></p>
				</div>
				<div class="pg_speaker">
					<table>
						<colgroup>
							<col width="20%">
							<col width="80%">
						</colgroup>
			<? if($getPlace4 != ""){ ?>
						<tr>
							<th class="first">좌장</th>
							<td>
								<ul>
									<li><?=nl2br($getPlace4)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getSpeech4 != ""){ ?>
						<tr>
							<th>기조연설</th>
							<td>
								<ul>
									<li><?=nl2br($getSpeech4)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getKeynote4 != ""){ ?>
						<tr>
							<th>세션기조</th>
							<td>
								<ul>
									<li><?=nl2br($getKeynote4)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPresent4 != ""){ ?>
						<tr>
							<th>발제자</th>
							<td>
								<ul>
									<li><?=nl2br($getPresent4)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPanel4 != ""){ ?>
						<tr>
							<th>토론좌장</th>
							<td>
								<ul>
									<li><?=nl2br($getPanel4)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
			<? if($getPanelist4 != ""){ ?>
						<tr>
							<th class="bb_n">토론자</th>
							<td class="bb_n">
								<ul>
									<li><?=nl2br($getPanelist4)?></li>
								</ul>
							</td>
						</tr>
			<? } ?>
					</table>
				</div>
			</div>
		</div>
	<? } ?>
		<!--end-->
		<div class="gap100"></div>
	</div>
</div>

<?
	//세션3 : 2020-10-29 09:30:00' && $curr < '2020-10-29 12:30:00
	//세션4 : 2020-10-29 13:00:00' && $curr < '2020-10-29 16:30:00
	//에필로그 : 2020-10-29 16:30:00' && $curr < '2020-10-29 18:00:00
	//10-14 세션 정보 일정 시간 내에서만 열리게 변경
	$curr = date( 'Y-m-d H:i:s' );
	if( $curr > '2020-10-29 09:30:00' && $curr < '2020-10-29 12:30:00'){ ?>
		<!-- <div class="tab_btn.on"></div> -->
		<script>
		var openDiv = $(".cont_onoff");
		openDiv.slideDown();
		$(this).addClass('on');	
		
		</script>

	<?}else if($curr > '2020-10-29 13:00:00' && $curr < '2020-10-29 16:00:00'){ ?>
		<script>
		var openDiv = $(".cont_onoff01");
		openDiv.slideDown();
		$(this).addClass('on');	
		
		</script>	
	<?}else if($curr >= '2020-10-29 16:00:00' && $curr < '2020-10-29 18:00:00'){ ?>
		<script>
		var openDiv = $(".cont_onoff02");
		openDiv.slideDown();
		$(this).addClass('on');	
		
		</script>	
	<?}
?>

<? include "../inc/inc_footer.php"; ?>