<?
	session_start();
	header('Content-Type: text/html; charset=utf-8');
	//ID 부분 @ 앞까지 끊는거 구현
	$belong = $_SESSION['_USER_BELONG'];
	$mobile = $_SESSION['_MOBILE'];
	$email = $_SESSION['_USER_ID'];
	$name = $_SESSION['_USER_NAME1'].$_SESSION['_USER_NAME2'];

	if(!$email){
		$id = "empty";
?>
<script>
	alert('로그인 후 이용가능합니다');
	document.location.href = 'http://wof.kr/kor/html/06_member/login.php?check=onlinewof&ref=%2Fkor%2Fhtml%2F00_main%2Findex.php';
</script>
<?
	}else{
		$id = explode('@', $email);
		$id = $id[0];
	}
?>

<form name="login" method="POST" action="http://2020.wof.kr/main/login.php?lang=kor">
<input type="hidden" name="user_id" value="<?=$id?>">
<input type="hidden" name="belong" value="<?=$belong?>">
<input type="hidden" name="mobile" value="<?=$mobile?>">
<input type="hidden" name="email" value="<?=$email?>">
<input type="hidden" name="name" value="<?=$name?>">
<input type="submit" value="">
<script>document.login.submit();</script>
</form>