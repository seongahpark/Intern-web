  <head>
    <meta charset="utf-8">
    <title>2020 BSF - 부산과학축전 :: 로그인</title>
  </head>

<?php
	//세션을 사용하기 위해 선언하는 부분
	session_cache_limiter('');
	session_start();
	if(isset($_POST['userid'])){
		//POST 값이 새로 들어왔을때 SESSION을 만들도록 한다.

		$id = $_POST['userid'];
		$name = $_POST['name'];

		$_SESSION['userid']= $id;
		$_SESSION['name'] = $name;

		$sess_key    = session_id(); 
		$sess_expiry = time(); 
		$sess_value  = $_SESSION['user_id'];
		$_SESSION['session_key'] = $sess_key; //토큰 등록
	}
	echo "<script>location.replace('http://www.busansf.or.kr/main/index.php');</script>";
   ?>