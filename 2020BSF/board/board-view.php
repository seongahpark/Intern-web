<?	include ($_SERVER["DOCUMENT_ROOT"].'/Mngt/conn/conn.php');  
	include ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/function.php');  
	include ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/queryInfo.php');  

	$idx = $_GET['idx'];
	$bid = $_GET['bid'];
	$chkKind = !strcmp($bid,'notice');				//공지사항인지 QNA인지 구별하는 bool, true면 notice
	if($chkKind){
		$sql = "SELECT * FROM multiboard where idx = $idx";
	}
	else{
		$sql = "SELECT * FROM multiboard where idx = $idx";
	}

	$res = mysql_query($sql, $conn);
	$row = mysql_fetch_array($res);

	//비밀글 기능
	if($row['secret'] == 'Y' && $_SESSION['name'] != $row['writer']){
		echo "<script>alert('비밀글입니다.');</script>";
		echo "<script>history.go(-1);</script>";
	}else{

	//조회수 증가
	$viewcnt = $row["visited"] + 1;
	if($chkKind)
		$updatesql = "UPDATE `multiboard` SET visited = $viewcnt where idx = $idx";
	else
		$updatesql = "UPDATE multiboard SET visited = $viewcnt where idx = $idx";
	$resultConn  = mysql_query($updatesql,$conn);	

	$saveDir = '/data/'.$bid.'/';

	//파일 첨부
	$saveDir  =  $_SERVER["DOCUMENT_ROOT"]."/data/";
	$FileSQL = "SELECT * FROM fileboard where idx = $idx";

	$result = mysql_query($FileSQL, $conn);
	$fileNum = mysql_num_rows($result);

	//이전글, 다음글 (비밀글 제외)
	$prev_data = mysql_fetch_array(mysql_query("SELECT * FROM multiboard WHERE bid='".$bid."' AND del = 'N' AND secret='N' AND idx < ".$idx." ORDER BY idx DESC LIMIT 0,1"));
	$next_data = mysql_fetch_array(mysql_query("SELECT * FROM multiboard WHERE bid='".$bid."' AND del = 'N' AND secret='N' AND idx > ".$idx." ORDER BY idx ASC LIMIT 0,1"));

	$prev_url = str_replace("idx=".$idx, "idx=".$prev_data['idx'], $_SERVER['REQUEST_URI']);
	$next_url = str_replace("idx=".$idx, "idx=".$next_data['idx'], $_SERVER['REQUEST_URI']);

	//20201105 김찬기 추가
	$board_name = $chkKind ? "notice" : "qna";
?>
<div class="board <?=$board_name ?>">
    <div class="board_view_frame">
        <div class="question_wrapper">			
			<div class="title_box">
				<h5 class="title"><?=$row["title"]?></h5>
				<div class="meta">
					<span class="date"><?=$row["regdate"]?></span>               
					<div class="writer">작성자: <span><?=$row["writer"]?></span></div>
				</div>
            </div>
			<div class="attachment">
			<? if($_GET['bid'] == 'notice') { ?>
				<div class="list_box">
					<div class="label"><img class="lazy" data-src="../share/img/inbox.svg" alt="attachment icon"><span>첨부파일</span></div>
					<ul class="file_list">
						<!--
						<li><a href="#">첨부파일명.jpg</a></li>
						<li><a href="#">첨부파일명.jpg</a></li>
						-->
						<? 
						while($fileRow = mysql_fetch_array($result)){
							echo "<li><a href='fileDown.php?idx=".$fileRow['fileidx']."'>".$fileRow['rname']."</a></li>";
						}
						?>
					</ul>
				</div>
				<a href="#" class="toggle_btn"><span>더보기</span></a>
			<? } ?>
			</div>
			<div class="board_content">
				<div class="photo_box">      
				<?
				if($_GET['bid'] == 'notice') {
					$sql = "SELECT * FROM fileboard where idx = $idx order by fileidx asc";
					$view_file_data_result = mysql_query($sql,$conn);
					//$view_file_data_result = Select_Query("fileboard","*","where idx='".$_GET["idx"]."'  and dis='' order by fileidx asc");
					while($view_file_data_row = mysql_fetch_array($view_file_data_result)){
						$url = "http://www.busansf.or.kr/data/".$bid."/".$view_file_data_row["sname"];
						$index = strpos($view_file_data_row["sname"],'.');
						$ext = substr($view_file_data_row["sname"],$index+1, strlen($view_file_data_row["sname"]));
								 
						if($ext=="pjpeg"||$ext=="gif"||$ext=="bmp"||$ext=="png"||$ext=="jpg"||$ext=="JPG"||$ext=="JPEG"||$ext=="jpeg"){
				?>
							<img src="<?=$url?>"><br/>
				<?
									 }
							}
				}
				?>
				</div>
				
				<div class="content_box">            
						<?=nl2br($row["contents"])?>
				</div>
			</div>
        </div>

		<? 
			////////////////////////// QnA 내용 //////////////////////////////
			/////////////////////////////////////////////////////////////////
				if($_GET['bid'] == 'qna' && $row['answerer'] != "") { ?>
			<div class="answer_wrapper">
				<div class="title_box">
					<div class="meta">
						<div class="writer">답변자: <span><?=$row["answerer"]?></span></div>
					</div>
				</div>	

				<? if($fileNum > 0 ){ ?>
				<div class="attachment">
					<div class="list_box">
						<div class="label"><img class="lazy" data-src="../share/img/inbox.svg" alt="attachment icon"><span>첨부파일</span></div>
						<ul class="file_list">
							<?
								while($fileRow = mysql_fetch_array($result)){
									echo "<li><a href='fileDown.php?idx=".$fileRow['fileidx']."'>".$fileRow['rname']."</a></li>";
								}
							?>
						</ul>
					</div>
					<a href="#" class="toggle_btn"><span>더보기</span></a>
				</div>
				<? } ?>
				<div class="board_content">
					<div class="photo_box">      
					<?	
						$sql = "SELECT * FROM fileboard where idx = $idx order by fileidx asc";
						$view_file_data_result = mysql_query($sql,$conn);
						while($view_file_data_row = mysql_fetch_array($view_file_data_result)){
							$url = "http://www.busansf.or.kr/data/".$bid."/".$view_file_data_row["sname"];
							$index = strpos($view_file_data_row["sname"],'.');
							$ext = substr($view_file_data_row["sname"],$index+1, strlen($view_file_data_row["sname"]));
									 
							if($ext=="pjpeg"||$ext=="gif"||$ext=="bmp"||$ext=="png"||$ext=="jpg"||$ext=="JPG"||$ext=="JPEG"||$ext=="jpeg"){
					?>
								<img src="<?=$url?>"><br/>
					<?
										 }
								}
					?>
					</div>
						<div class="content_box">            
							<p>
								<?=nl2br($row["content_answer"])?>
							</p>
						</div>
				</div>
			</div>
		<? } ?>    
			     
        <div class="control">
            <div class="row prev">
                <div class="head">이전글</div>
                <div class="title">      
					<? if($prev_data){ ?>
						<a href="<?=$prev_url?>"><span class="list"><?=$prev_data['title']?></span></a>
					<? } else { ?>
						<span class="no_list">이전글이 없습니다.</span>  
					<? } ?>
                </div>
            </div>
            <div class="row next">
                <div class="head">다음글</div>
                 <div class="title">      
					<? if($next_data){ ?>
						<a href="<?=$next_url?>"><span class="list"><?=$next_data['title']?></span></a>
					<? } else { ?>
						<span class="no_list">다음글이 없습니다.</span>  
					<? } ?>
                </div>
            </div>
        </div>            
        <div class="btn_wrapper ">
			<?if(!$chkKind){?>
	            <button type="button" onclick="location.href='../community/qna_modi.php?idx=<?=$idx?>' "class="board_btn modify">수정</button>
			<?}?>
            <button type="button" onclick="location.href='../community/<?echo $bid?>.php?bid=<?echo $bid?>&&start=0' " class="board_btn list">목록</button>
            <?if(!$chkKind){?>
				<button id="dynamic-dialog" type="button"  onclick="location.href='../community/qna_passChk.php?idx=<?=$idx?>' " class="board_btn cancel">삭제</button>
			<?}?>
        </div>   
    </div> 
</div>
<script>
	//20201105 이미지 없을경우 noImg클래스 추가 - 김찬기
	var photo_box = document.querySelectorAll('.photo_box');
	for(var i = 0; i < photo_box.length; i++){
			var img_content = photo_box[i].querySelectorAll('img');
			if(img_content.length === 0) photo_box[i].classList.add('noImg');
	}

	//20201105 첨부 없을때 첨부란 삭제 (qna게시판으로 두개이상생겨서 추가)
	var file_frame = document.querySelectorAll('.attachment')
	for(var i = 0; i < file_frame.length; i++){
		var file_list = file_frame[i].querySelectorAll('.list_box .file_list li');
		if(file_list.length <= 0){
			file_frame[i].style.display = "none";
		}
	}
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
	$(document).ready(function() {
		// 버튼의 이벤트 핸들러를 붙입니다.
		$("#dynamic-dialog").on("click", function () {
			// 다이얼로그 내용을 가져올 URL입니다.
			var url = "./dialog_content.html";
			// 다이얼로그를 생성합니다.
			$('<div id="DialogDiv">').dialog({
				// 커스텀 스타일을 줍니다.
				dialogClass: 'custom-dialog-style',
				// 모달 다이얼로그로 생성합니다.
				modal: true,
				// 다이얼로그 열기 콜백
				open: function () {
					// 모달 오버레이 설정
					$(".ui-widget-overlay").css({
						opacity: 0.5,
						filter: "Alpha(Opacity=50)",
						backgroundColor: "black"
					});
					// 내용을 불러 옵니다.
					$(this).load(url);
				},
				// 닫기 콜백
				close: function (e) {
					$(this).empty();
					$(this).dialog('destroy');
				},
				height: 350,
				width: 400,
				title: '동적 다이얼로그'
			});
		});
	});
</script>


<? } ?>