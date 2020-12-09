<?php
	include "../conn/conn.php";
	include "../cmmInc/sessionTop.php";
	include "../cmmInc/queryInfo.php";
	include "../cmmInc/saveClass.php";
	include "../cmmInc/msgScript.php";
if($_GET["btype"] == "Board"){
	if($_POST['admin_id']){
	$i = 1;
	$i--; //0부터 시작할라니깐 안돼서 -- 한번 해줘서 0으로 만들어 줌
	$cnt = count($_POST['admin_id']); // array 개수
	while($i <= $cnt){
		$updateSQL   = "update multiboard ";
		$updateSQL	.= "set del='Y'";
		$updateSQL  .= " where idx='".$_POST["admin_id"][$i]."'";

		$resultConn  = mysql_query($updateSQL,$conn);
		$i++;
		echo $i;
	}

	}else if($_POST['idx'][0]){
		$updateSQL   = "update multiboard ";
		$updateSQL	.= "set del='Y'";
		$updateSQL  .= " where idx='".$_POST["idx"][0]."'";

		$resultConn  = mysql_query($updateSQL,$conn);		
	}
	IF($resultConn==true){								
		Alert_Msg("삭제에 성공하였습니다.");
	}else{
		Alert_Msg("삭제에 실패하였습니다.");
	}
	mysql_close($conn);

	Replace("./BoardList.php?page=".$_GET['page']."&sw=".$_GET['sw']."&sv=".$_GET['sv']."&corp=".$_GET['corp']."&rd=".$_GET['rd']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype']);
}
/*
else if($_GET["bid"]=="qna"){
	$i = 1;
	$i--; //0부터 시작할라니깐 안돼서 -- 한번 해줘서 0으로 만들어 줌
	$cnt = count($_POST['admin_id']); // array 개수
	while($i <= $cnt){
		$updateSQL   = "update multiboard ";
		$updateSQL	.= "set del='Y'";
		$updateSQL  .= " where num='".$_POST["admin_id"][$i]."'";

		$resultConn  = mysql_query($updateSQL,$conn);
		$i++;
	}

	IF($resultConn==true){								
		Alert_Msg("삭제에 성공하였습니다.");
	}else{
		Alert_Msg("삭제에 실패하였습니다.");
		exit();
	}

	mysql_close($conn);
	

	Replace("./BoardList.php?page=".$_GET['page']."&sw=".$_GET['sw']."&sv=".$_GET['sv']."&corp=".$_GET['corp']."&rd=".$_GET['rd']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype']);
}
*/

?>