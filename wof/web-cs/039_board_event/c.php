<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/web-cs/config_init.php';

	switch($tn)
	{
		case 'board_event':
		default :
			$mode = $_REQUEST['mode'] ? $_REQUEST['mode'] : 'list';

			$DB_TABLE		= $tn;
			$FILE_FOLDER	= $menu;
			$FILE_SKIN		= '_c';
			$FILE_NAME		= '';
			$board_title	= '이벤트';

			switch($mode)
			{
				case '':
				case 'list':
					include CLASS_PATH.$FILE_FOLDER.'/'.$FILE_NAME.'list.php';
					break;
				case 'read':
					include CLASS_PATH.$FILE_FOLDER.'/'.$FILE_NAME.'read.php';
					break;
				default:
					include CLASS_PATH.'Error_404.html';
					break;
			}
			break;
	}
?>
<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
//반응형게시판 데이터복제
$(function(){
    var list = $('table tbody tr')
    for(var i=0; i<list.length; i++){
        var writer = $('table tbody tr').eq(i).find('.writer').html();
        var date = $('table tbody tr').eq(i).find('.date').html();
        var view = $('table tbody tr').eq(i).find('.view').html();
        
        $('table tbody tr').eq(i).find('.list_tit a .meta .m_writer').html(writer)
        $('table tbody tr').eq(i).find('.list_tit a .meta .m_date').html(date)
        $('table tbody tr').eq(i).find('.list_tit a .meta .m_view').html(view)
    }
});
 
$(document).ready(function(){
	//로그인 했을 시에만 이용가능하도록 설정
	$("#text").click(function(){
		if ("<?=$_SESSION['_USER_ID']?>" == "")
		{
		alert("로그인 후 이용가능합니다");
		document.location.replace("http://wof.kr/kor/html/06_member/login.php?ref=%2Fkor%2Fhtml%2F00_main%2Findex.php");
		}
	});

	//댓글 내용 미입력시 입력하도록 설정
	$("#btn").click(function(){
		if($("#text").val() ==''){
			alert("댓글 내용을 입력해주세요");
			return false;
		}else{
			form.submit();
		}
	});
});


</script>

<?
$DB_TABLE_COMMENT='board_event_comment';

$mode = $_GET['mode'];
$pagenum = $_GET['pagenum'];
$search_select = $_GET['search_select'];
$keyword = $_GET['keyword'];
$user_id = $_SESSION['_USER_ID'];
$idx = $_GET['idx'];

$url = "http://wof.kr/kor/html/05_community/community_07.php?mode=list&idx=$idx&pagenum=$pagenum&search_select=$search_select&keyword=$keyword";
$comment_url = "http://wof.kr/kor/html/05_community/comment.php?mode=read&idx=$idx&pagenum=$pagenum&search_select=$search_select&keyword=$keyword";

//댓글 페이징 기능
    $pageNum = 10; //한 페이지에 채울 목록 개수
    $sql = "select * from `".$DB_TABLE_COMMENT."` where `idx`='".$idx."'";
	$res = Mysql_query($sql);
    $pageTotal = mysql_num_rows($res);
    $start = $_GET['start']; //START 변수로 페이지 구분

    if(!$start) $start=0;
	//연도 -> 일자 오름차순 기준으로 정렬되도록 변경
    $sql = "SELECT * FROM `".$DB_TABLE_COMMENT."` WHERE `idx`='".$idx."' order by `comment_date` asc limit $start, $pageNum";
	$res = Mysql_query($sql);;

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
<div frame=void class='re_chbox'>
<?
while($row = Mysql_fetch_array($result)){
	echo "<div>";
	echo "<div class='re_chat'><p>".$row['comment_id']."</p><div class='re_chatCont'>".$row['comment']."</div><span>".$row['comment_date']."</span></div>";
	echo "</div>";
}	
?>
</div>

<div id="contents"></div>
<div class="chbox">
    <form name="commentform" action="<?=$comment_url?>" method="POST" enctype="multipart/form-data">
		<div class="chbox_txt">
			<div>댓글 작성</div>
			<input type="hidden" name="comment_id" id="comment_id" size="10" placeholder="아이디" value="<?=$user_id?>" readonly="readonly"/>
            <textarea name="comment" class="comment" id="text"></textarea>
			<!--<input type="submit" class="btn_on b0" value="등록" style="float: right; margin-left: 10px; height: 43px;"/>-->
			<button class="btn_on b0" id="btn" value="등록"><span>등록</span></button>
        </div>
    </form>
</div>

<div class="right pt_20">
	<a href="<?=$url?>" class="btn_on" title="목록">목록</a>
</div>

<div class="clear_div"></div>

<?
}
?>