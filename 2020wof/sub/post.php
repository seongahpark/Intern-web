<?//post.php
	include "../inc/inc_headinfo.php";
	include "../Mngt/conn/conn.php";
	include "../Mngt/cmmInc/queryInfo.php";
	header("Cache-Control:no-cache");
	header("Pragma:no-cache");

	if($_POST['message'] != ""){ //메시지 입력 값이 있을때만 나오도록
	$insertSQL   = "insert into chat_message (session, lang, name, message, chatDate)";
	$insertSQL  .= "values('".$_POST["session"]."', '".$_POST["lang"]."', '".$_POST["name"]."', '".$_POST["message"]."', NOW())";
	$resultConn  = mysql_query($insertSQL, $conn);
    mysql_close($conn);
	}
?>