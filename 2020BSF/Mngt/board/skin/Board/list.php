<? require_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/conn/conn.php') ?>
<? require_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/queryInfo.php') ?>
<?	
	//페이징을 위한 함수 추가 << 이 함수로 페이징 구동
    $pageNum = 10; //한 페이지에 채울 목록 개수
	if($_GET['bid'] == "notice"){
		$writerName = '작성자';
		if(!strcmp($sw,''))
			$sql = "SELECT * FROM multiboard WHERE bid='notice' AND del='N' ORDER BY regdate desc, idx desc";
		else{
			if(!strcmp($sv,'title')){
				$sql = "SELECT * FROM multiboard WHERE bid='notice' AND del='N' AND title like '%$sw%' ORDER BY regdate desc, idx desc";
			}
			else if(!strcmp($sv,'writer')){
				$sql = "SELECT * FROM multiboard WHERE bid='notice' AND del='N' AND writer like '%$sw%' ORDER BY regdate desc, idx desc";
			}
			else{
				$sql = "SELECT * FROM multiboard WHERE bid='notice' AND del='N' AND (writer like '%$sw%' OR title like '%$sw%') ORDER BY regdate desc, idx desc";
			}

		}
	}else if($_GET['bid'] == "qna"){
		$writerName = '문의자';
		if(!strcmp($sw,''))
			$sql = "SELECT * FROM multiboard WHERE bid='qna' AND del='N' ORDER BY regdate desc, idx desc";
		else{
			if(!strcmp($sv,'title')){
				$sql = "SELECT * FROM multiboard WHERE bid='qna' AND del='N' AND title like '%$sw%' ORDER BY regdate desc, idx desc";
			}
			else if(!strcmp($sv,'writer')){
				$sql = "SELECT * FROM multiboard WHERE bid='qna' AND del='N' AND writer like '%$sw%' ORDER BY regdate desc, idx desc";
			}
			else{
				$sql = "SELECT * FROM multiboard WHERE bid='qna' AND del='N' AND (writer like '%$sw%' OR title like '%$sw%') ORDER BY regdate desc, idx desc";
			}
		}
	}
		
	$res = mysql_query($sql, $conn);
    $pageTotal = mysql_num_rows($res);
    $start = $_GET['start']; //START 변수로 페이지 구분

    if(!$start) $start=0;
	if($_GET['bid'] == "notice"){
		if(!strcmp($sw,''))
			$sql = "SELECT * FROM multiboard WHERE bid='notice' AND del='N' ORDER BY regdate desc, idx desc limit $start, $pageNum";
		else{
			if(!strcmp($sv,'title')){
				$sql = "SELECT * FROM multiboard WHERE bid='notice' AND del='N' AND title like '%$sw%' ORDER BY regdate desc, idx desc limit $start, $pageNum";
			}
			else if(!strcmp($sv,'writer')){
				$sql = "SELECT * FROM multiboard WHERE bid='notice' AND del='N' AND writer like '%$sw%' ORDER BY regdate desc, idx desc limit $start, $pageNum";
			}
			else{
				$sql = "SELECT * FROM multiboard WHERE bid='notice' AND del='N' AND (writer like '%$sw%' OR title like '%$sw%') ORDER BY regdate desc, idx desc limit $start, $pageNum";
			}
		}
	}else if($_GET['bid'] == "qna"){
		if(!strcmp($sw,''))
			$sql = "SELECT * FROM multiboard WHERE bid='qna' AND del='N' ORDER BY regdate desc, idx desc limit $start, $pageNum";
		else{
			if(!strcmp($sv,'title')){
				$sql = "SELECT * FROM multiboard WHERE bid='qna' AND del='N' AND title like '%$sw%' ORDER BY regdate desc, idx desc limit $start, $pageNum";
			}
			else if(!strcmp($sv,'writer')){
				$sql = "SELECT * FROM multiboard WHERE bid='qna' AND del='N' AND writer like '%$sw%' ORDER BY regdate desc, idx desc limit $start, $pageNum";
			}
			else{
				$sql = "SELECT * FROM multiboard WHERE bid='qna' AND del='N' AND (writer like '%$sw%' OR title like '%$sw%') ORDER BY regdate desc, idx desc limit $start, $pageNum";
			}
		}
	}
	$res = mysql_query($sql, $conn);
	//연도 -> 일자 오름차순 기준으로 정렬되도록 변경
    //$sql = "SELECT * FROM program WHERE del = 'N' ORDER BY year asc, date asc, time asc, end_time asc limit $start, $pageNum";
	//$res = mysql_query($sql, $conn);

	//상세페이지 url
	$modi_url = "./BoardModi.php?admin_type=notice";
	$write_url = "./BoardWrite.php?admin_type=notice";
	$del_url = "./del.php?admin_type=notice";
	$new_date = date(Y-m-d);
	
	if($_GET['bid'] == "") $_GET['bid'] = "notice";
	if($_GET['btype'] == "") $_GET['btype'] = "Board";
$parameter = "page=".$page."&sw=".$_GET['sw']."&sv=".$_GET['sv']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype']."&attribute=".$_GET['attribute'];

//상세페이지 url
$modi_url = "./BoardModi.php?admin_type=notice&".$parameter;
$view_url = "./BoardView.php?".$parameter."&admin_type=board_notice";
$write_url = "./BoardWrite.php?".$parameter."&admin_type=board_notice";
$del_url = "./del.php?".$parameter;
?>
<script>
	function del_chk(){
		var form = document.list_form;
		if(!All_Check_Num(form,'admin_id[]',1,'관리자')) return;
		var msg = confirm('정말 삭제하겠습니까?');
		if(msg==true){
			form.submit();
		}
	}
</script>

<script>
//검색어 미입력시 alert
function search(value) {
	if(value == "") alert("검색어를 입력해주세요.");
	else form.submit();
}
</script>

<div class="board-search">
	<div class="total"><span>Total : <strong><?=$pageTotal+$notice_data_result["num"]?></strong></span></div>
	<form name="search_form" action="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>">
		<input type="hidden" name="bid" value="<?=$_GET["bid"]?>"  />
		<input type="hidden" name="btype" value="<?=$_GET["btype"]?>" />
		
		<p class="search">
			<select name="sv" title="검색내용을 선택해주세요">
				<option value="" <?if($sv==""){?>selected<?}?> >전체</option>
				<option value="writer" <?if($sv=="writer"){?>selected<?}?> ><?echo $writerName?></option>
				<option value="title" <?if($sv=="title"){?>selected<?}?> >제목</option>
			</select>

			<input type="text" name="sw" value="<?=$sw?>" title="검색 내용을 입력해주세요">
			<button type='submit' onclick="search(sw.value);"><span>검색</span></button>
		</p>
	</form>
</div>


<div class="board-list-wrap">

	<span class="bd-line"></span>
<? if($_GET['bid'] == "notice"){ ?>	
<form name="list_form" action="<?=$del_url?>" method="post">	
	<table>
		  <caption><span class="blind">번호, 제목, 첨부, 작성자, 작성일 관리 테이블 입니다.</span></caption>
		  <colgroup>
			 <col scope="col" width="2%">
			 <col scope="col" width="2%">
			 <col scope="col" width="15%">
			 <col scope="col" width="10%">
			 <col scope="col" width="5%">
			 <col scope="col" width="7%">
			 <col scope="col" width="2%">
		  </colgroup>
		  <thead>
			 <tr>
				  <th><input type="checkbox" name="check_all" onclick="javascript:All_Check('list_form','admin_id[]',this)"></th>
				  <th>번호</th>
				  <th>제목</th>
				  <th>작성자</th>
				  <th>조회수</th>
				  <th>등록일</th>
				  <th>수정</th>
			  </tr>
		  </thead>
		  <tbody>
			 <?
				if($pageTotal==0) echo(" <tr><td colspan=\"10\">게시물이 없습니다.</td></tr>");
				$index = $pageTotal + 1 - $_GET['start'];
				while($row = mysql_fetch_array($res)){
					$index = $index - 1;
			 ?>
			  <tr>
				  <td>
					<input type='checkbox' name='admin_id[]' value="<?=$row['idx']?>">
				  </td>
				  <td class="num"><?=$index?></td>
				  <td><a href="<?=$view_url?>&idx=<?=$row["idx"]?>" class="f14"><?=$re_img?><?=$row["title"]?></a></td>
				  <!-- GET 형식으로 IDX 넘겨주기 -->
				  <td><?=$row["writer"]?></td>
				  <td><?=$row["visited"]?></td>
				  <td><?=substr($row["regdate"],0,10)?></td>
				  <td>
				  	<!--
					 <a href="<?=$modi_url?>&admin_id=<?=$row["admin_id"]?>" class="sp-btn"><span>수정/삭제</span></a> -->
					 <a href="<?=$modi_url?>&idx=<?=$row["idx"]?>" class="sdp-btn"><span>수정</span></a>
				  </td>
			  </tr>
			 <?
					$num++;
				}
			 ?>
		</tbody>
	</table>
	</form>
<? }else if($_GET['bid'] == 'qna'){ ?>
<form name="list_form" action="<?=$del_url?>" method="post">	
	<table>
		  <caption><span class="blind">번호, 제목, 첨부, 작성자, 작성일 관리 테이블 입니다.</span></caption>
		  <colgroup>
			 <col scope="col" width="2%">
			 <col scope="col" width="2%">
			 <col scope="col" width="15%">
			 <col scope="col" width="5%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="5%">
			 <col scope="col" width="10%">
			 <col scope="col" width="5%">
		  </colgroup>
		  <thead>
			 <tr>
				  <th><input type="checkbox" name="check_all" onclick="javascript:All_Check('list_form','admin_id[]',this)"></th>
				  <th>번호</th>
				  <th>제목</th>
				  <th>답변</th>
				  <th>문의자</th>
				  <th>답변자</th>
				  <th>조회수</th>
				  <th>등록일</th>
				  <th>답변및수정</th>
			  </tr>
		  </thead>
		  <tbody>
			 <?
				if($pageTotal==0) echo(" <tr><td colspan=\"10\">게시물이 없습니다.</td></tr>");
				$index = $pageTotal + 1 - $_GET['start'];
				while($row = mysql_fetch_array($res)){
					$index = $index - 1;
			 ?>
			  <input type="hidden" name="idx" value="<?=$row['idx']?>">
			  <tr>
				  <td>
					<input type='checkbox' name='admin_id[]' value="<?=$row['idx']?>">
				  </td>
				  <td class="num"><?=$index?></td>
				  <td><a href="<?=$view_url?>&idx=<?=$row["idx"]?>" class="f14"><?=$re_img?><?=$row["title"]?></a></td>
				  <!-- GET 형식으로 IDX 넘겨주기 -->
				  <td>
					  <?
					  if($row["answerer"] != "") echo "O";
					  else echo "X";
					  ?></td>
				  <td><?=$row["writer"]?></td>
				  <td><?=$row["answerer"]?></td>
				  <td><?=$row["visited"]?></td>
				  <td><?=substr($row["regdate"],0,10)?></td>
				  <td>
				  	<!--
					 <a href="<?=$modi_url?>&admin_id=<?=$row["admin_id"]?>" class="sp-btn"><span>수정/삭제</span></a> -->
					 <a href="<?=$write_url?>&idx=<?=$row["idx"]?>" class="sdp-btn"><span>답변</span></a>
				  </td>
			  </tr>
			 <?
					$num++;
				}
			 ?>
		</tbody>
	</table>
	</form>
<? } ?>
</div>
	<div class="gap"></div>

<!-- s : 게시판 페이징 -->

<ul class="paging-wrap">
<? //../_Img/Content/paging-first.jpg
	$nowPage = 0;
	//맨 앞 페이지
	$first_page = "<a href=$_SERVER[PHP_SELF]?start=0&".$parameter."><img src='../_Img/Content/paging-first.jpg' style='border:none;' text-decoration: none; align='absmiddle'></a>";
	if($_GET['start']-$pageNum <= 0){
		$prev = 0;
	}else{
		$prev = $_GET['start']-$pageNum;
	}
	$next = $_GET['start']+$pageNum;
	if($next >= $pageTotal){
		$next = $_GET['start'];
	}
	//이전 페이지
	$pre_page = "<a href=$_SERVER[PHP_SELF]?start=$prev&".$parameter."><img src='../_Img/Content/paging-prev.jpg' style='border:none;' text-decoration: none; align='absmiddle'></a>";
	//다음 페이지
	$next_page = "<a href=$_SERVER[PHP_SELF]?start=$next&".$parameter."><img src='../_Img/Content/paging-next.jpg' style='border:none;' text-decoration: none; align='absmiddle'></a>";
?>
	<li><?=$first_page?></li>
	<li><?=$pre_page?></li>
<?
	//현재 페이지
    $pages = $pageTotal / $pageNum;
    for($i=0; $i<$pages; $i++){
	  $nowPage = $nextPage;
      $nextPage = $pageNum * $i;
	  $plus = $i + 1;
      echo "<li><a href=$_SERVER[PHP_SELF]?start=$nextPage&".$parameter.">$plus</a></li>";
    }
?>
	<li> <?=$next_page?></li>
	<? 
	//마지막 페이지
	echo "<li><a href=$_SERVER[PHP_SELF]?start=$nextPage&".$parameter." style='border-right:1px solid #e2e2e2;'><img src='../_Img/Content/paging-last.jpg' style='border:none;' align='absmiddle'></a></li>"
	?>
</ul>
<div class="ssgap"></div>

<!-- 기존 페이징 함수
<ul class="paging-wrap">
	<li><?=$Result['firstPage']?></li>
	<li><?=$Result['pageBack']?></li>
	<?=$Result['nowPage']?>
	<li> <?=$Result['nextPage']?></li>
	<li><?=$Result['lastPage']?></li>
</ul>
-->
<div class="ssgap"></div>
<!-- e : 게시판 페이징 -->
	<div class="fr">
		<? if($_GET['bid'] != 'qna') { ?>
		<button class="bpc-btn" onclick="location.href='<?=$write_url?>'"><span>등록</span></button>
		<? } ?>
	</div>
	<div class="fl">
		<button class="bdp-btn" onclick="javascript:del_chk();"><span>삭제</span></button>
	</div>
	<div class="gap"></div>
<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>
