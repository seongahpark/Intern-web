<head>
    <meta charset="utf-8">
    <title>SSO 2020WOF 로그인 페이지</title>
  </head>

<?php
	//세션을 사용하기 위해 선언하는 부분
	session_cache_limiter('');
	session_start();
	//db 접근
	include "../Mngt/conn/conn.php";
	if(isset($_POST['user_id'])){
		//POST 값이 새로 들어왔을때 SESSION을 만들도록 한다.

		$id = $_POST['user_id'];
		$belong = $_POST['belong'];
		$mobile = $_POST['mobile'];
		$email = $_POST['email'];
		$name = $_POST['name'];

		$_SESSION['user_id']= $id;
		$_SESSION['belong'] = $belong;
		$_SESSION['mobile'] = $mobile;
		$_SESSION['email'] = $email;
		$_SESSION['name'] = $name;

		$sess_key    = session_id(); 
		$sess_expiry = time(); 
		$sess_value  = $_SESSION['user_id'];
		$_SESSION['session_key'] = $sess_key; //토큰 등록

		//db에 세션저장
		$mergeSQL = "insert into member_sso (session_key, session_expiry, session_value)";
		$mergeSQL .= "values('".$sess_key."', '".$sess_expiry."','".$sess_value."'";
		$mergeSQL .= "on duplicate key update session_key='".$sess_key."', session_expiry='".$sess_expiry."', session_value='".$sess_value."'";
		$resultConn = mysql_query($mergeSQL, $conn);
		$insertSQL   = "insert into member_sso (session_key, session_expiry, session_value)";
		$insertSQL  .= "values('".$sess_key."', '".$sess_expiry."','".$sess_value."')";
		$resultConn  = mysql_query($insertSQL,$conn);		
		if(!$resultConn){
			//unique key 적용 전의 코드, 문제 생긴다면 코드 확인하고 수정할 것
			$updateSQL = "update member_sso set session_key='".$sess_key."', session_expiry='".$sess_expiry."' where session_value='".$sess_value."'";
			$resultConn = mysql_query($updateSQL, $conn);
		}
	}	 
	$getSessionKey = $_SESSION['session_key'];
	$user_id = $_SESSION['user_id'];
	$getQuery = "SELECT session_key FROM member_sso WHERE session_value='".$user_id."'";
	$res = mysql_query($getQuery, $conn);
	$getDBSessionKey = mysql_result($res, 0, 0);
	if($getDBSessionKey == $getSessionKey && $getSessionKey){
		$login_state = TRUE;
		//로그인 상태가 true일 때 확인
		//echo '<h1> 안녕하세요 "'.$user_id.'"님</h1>';
	}else{
		$login_state = FALSE;
	}
	
	if($_GET['lang'] == "eng"){
	echo "<script>alert('Login completed successfully.');</script>";
	echo "<script>location.replace('http://2020.wof.kr/eng/main/main.php');</script>";
	}else{
	//header( 'Location: http://2020.wof.kr/sub/live_forum_test.php' ); //채팅때문에 바로테스트 페이지로 이동
	echo "<script>alert('로그인이 완료되었습니다.');</script>";
	echo "<script>location.replace('http://2020.wof.kr/sub/online_join01.php');</script>";
	//header( 'Location: http://2020.wof.kr/sub/online_join01.php');
	}
   ?>