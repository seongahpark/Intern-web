<script type="text/javascript" src="/Seditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<?
	!$_GET["pg_mode"]? $pg_mode="List":$pg_mode=$_GET['pg_mode'];
	include ROOT_PATH."/02_board/boardTop.php";
	$_board = array("List"=>"boardList.php","View"=>"boardView.php","Write"=>"boardWrite.php","Modi"=>"boardModi.php","Del"=>"boardDel.php");
	if(file_exists(ROOT_PATH."/02_board/".$_board[$pg_mode])):
		//echo "../02_board/".$_board[$pg_mode];
		if($_SERVER["REMOTE_ADDR"]=="61.32.164.99" || $_SERVER["REMOTE_ADDR"]=="106.242.167.93"){
			echo " 유시스 에서만 보이는 메시지 ".ROOT_PATH."/02_board/".$_board[$pg_mode];
		}
		require_once(ROOT_PATH."/02_board/".$_board[$pg_mode]);
	else:
		echo "등록된 형식이 없습니다.";
	endif;
?>
