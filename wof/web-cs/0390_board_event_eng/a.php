<script type="text/javascript">
	function del_comment() {
		if ( confirm('정말 삭제하시겠습니까?') ) {
			form2.submit();
		}
	}
</script>

<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/web-cs/config_init.php';

	switch($tn)
	{
		case 'board_event_eng':
		default :
			$mode = $_REQUEST['mode'] ? $_REQUEST['mode'] : 'list';

			$DB_TABLE		= $tn;
			$FILE_FOLDER	= $menu;
			$FILE_SKIN		= '_a';
			$FILE_NAME		= '';
			$board_title	= '이벤트(영문)';

			switch($mode)
			{
				case '':
				case 'list':
					include CLASS_PATH.$FILE_FOLDER.'/'.$FILE_NAME.'list.php';
					break;
				case 'read':
					include CLASS_PATH.$FILE_FOLDER.'/'.$FILE_NAME.'read.php';
					break;
				case 'write':
				case 'modify':
					include CLASS_PATH.$FILE_FOLDER.'/'.$FILE_NAME.'write.php';
					break;
				case 'process':
					include CLASS_PATH.$FILE_FOLDER.'/'.$FILE_NAME.'process.php';
					break;
				default:
					include CLASS_PATH.'Error_404.html';
					break;
			}
			break;
	}
?>

<?
$DB_TABLE_COMMENT='board_event_comment_eng';

$mode = $_GET['mode'];
$pagenum = $_GET['pagenum'];
$search_select = $_GET['search_select'];
$keyword = $_GET['keyword'];
$user_id = $_SESSION['_ADMIN_ID'];
$idx = $_GET['idx'];

$url = "http://wof.kr/eng/html/05_community/community_07.php?mode=list&idx=$idx&pagenum=$pagenum&search_select=$search_select&keyword=$keyword";
$comment_url = "http://wof.kr/eng/html/05_community/comment.php?mode=read&idx=$idx&pagenum=$pagenum&search_select=$search_select&keyword=$keyword";

//댓글 페이징 기능
    $pageNum = 10; //한 페이지에 채울 목록 개수
    $sql = "select * from `".$DB_TABLE_COMMENT."` where `idx`='".$idx."'";
	$res = Mysql_query($sql);
    $pageTotal = mysql_num_rows($res);
    $start = $_GET['start']; //START 변수로 페이지 구분

    if(!$start) $start=0;
	//연도 -> 일자 오름차순 기준으로 정렬되도록 변경
    $sql = "SELECT * FROM `".$DB_TABLE_COMMENT."` WHERE `idx`='".$idx."' order by `comment_date` asc limit $start, $pageNum";
	$res = Mysql_query($sql);

//////////////일단 다른 작업 먼저 진행 미완성/////////////
if($mode == "read"){
//댓글 불러오기를 위한 내용 추가
$sql="select *";
$sql=$sql." from `".$DB_TABLE_COMMENT."` where `idx`='".$idx."' order by `comment_date` asc";


$result = Mysql_query($sql);
$comment = Mysql_num_rows($result);
if($comment == "") $comment = "0";
?>
<p style='margin-top: 20px; margin-bottom: 20px;'>총 <?=$comment?>개의 댓글이 있습니다</p>
<table frame=void style='table-layout: fixed; width: 100%;'>
		  <colgroup>
			 <col scope="col" width="20%" style="background: #efefef">
			 <col scope="col" width="60%" style="background: #efefef">
			 <col scope="col" width="20%" style="background: #efefef">
			 <col scope="col" width="20%" style="background: #efefef">
		  </colgroup>
<?
while($row = Mysql_fetch_array($result)){
	echo "<tr>";
	echo "<td width:20% align='center'>".$row['comment_id']."</td>";
	echo "<td >".$row['comment']."</td>";
	echo "<td align='center'>".$row['comment_date']."</td>";
	echo "<td align='center'>
	<form method='POST' id='form2' name='form2' action='del_comment.php?lang=eng'>
	<input type='hidden' name='idx' value='".$row['idx_comment']."'>
	<span>
		<input type='submit' value='삭제' onclick='del_comment()' class='btnGray hand' />
	</span>
	</form>
	</td>";
	echo "</tr>";
}
echo "</table>";
}


if($_GET['mode'] == 'read'){
?>
<div id="contents"></div>
<div style="margin-bottom: 80px; width:100%;">
    <form name="commentform" action="<?=$comment_url?>" method="POST" enctype="multipart/form-data">
		<div style="float: left; width: 100%; margin-top: 20px;">
			<div style="float: left; height: 23px; width: 10%; text-align: center; padding: 10px; background-color: #efefef;">댓글</div>
			<input type="hidden" name="comment_id" id="comment_id" size="10" placeholder="아이디" style="float: left; height: 30px;" value="<?=$user_id?>" readonly="readonly"/>
            <textarea name="comment" class="comment" id="text" style="resize:none; float: left; width: 70%; margin-left:10px; height: 30px; padding: 5px; "></textarea>
			<!--<input type="submit" class="btn_on b0" value="등록" style="float: right; margin-left: 10px; height: 43px;"/>-->
			<button class="btn_on b0" id="btn" value="등록" style="float: right; margin-left: 10px; height: 43px;"><span>등록</span></button>
        </div>
    </form>
</div>

<? } ?>