<? require_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/conn/conn.php') ?>
<? require_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/queryInfo.php') ?>
<?php
	//header("location:/Mngt/02_Board_test/BoardList.php?");
	$default_result = SelectAndNum("boardinfo","*","order by seq asc limit 0,1");
	while($default_result_row = mysql_fetch_Array($default_result["result"])){
	header("location:/Mngt/02_Board/BoardList.php?admin_type=board_notice&btype=".$default_result_row["btype"]."&bid=".$default_result_row["bid"]."");
	}
?>