<?php
//log.php
	ini_set("display_errors", '0'); //에러메시지 안나오도록 설정
	header("Cache-Control:no-cache");
	header("Pragma:no-cache");
	include "../Mngt/conn/conn.php";
	include "../Mngt/cmmInc/queryInfo.php";

	$name = $_GET['id'];
	$session = $_GET['session'];
	$lang = $_GET['lang'];
	$date = date('Y-m-d');
	$getDate = $_GET['date'];
	$total = $date;
	$total .= $getDate;
	//echo "접속시간 : ".$total."</br>";
	//echo "접속 아이디 : ".$name;
	//echo "</br>위의 정보는 test용으로 출력한 임시 정보창입니다</br>";
   $data = mysql_query("select * from chat_message where session = '".$session."' and lang = '".$lang."' and chatDate > '".$total."'");
   while ($row = mysql_fetch_array($data))
   {
	  if($row['name'] == $name){ //본인이 입력했을 때 보이는 채팅 css 적용
?>
		<div class="ch_txtbox me_chat">
			<p class="id_tit"><?=$row['name']?></p>
			<div class="">
			<p><?=$row['message']?></p>
			</div>
		</div>
<?
	  }else{ //상대방이 입력한 채팅 css 적용
?>
	  <div class="ch_txtbox">
		<p><?=$row['name']?></p>
		<div class="">
		<p><?=$row['message']?></p>
		</div>
	  </div>
<?
	  }
   }

?>
