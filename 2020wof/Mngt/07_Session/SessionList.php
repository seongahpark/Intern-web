<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/07_Session/inc/subHead.php');?>
<!--// page start -->
<?	
	$process = new pagingClass;
	$sv		   = $_GET['sv'];
	$sw		   = $_GET['sw'];

	$searchFlag= false;
	$searchFlag= issetCheck($sv,$svTitle01);
	$sv        = $_GET['sv'];
	$vrecord   = 10;
	$process -> pageSQL     = "select * from session";
	$process -> viewPage	= 5;
	$process -> scale       = $vrecord;
	$process -> page		= $page;
	$process -> sv			= $sv;
	$process -> sw			= $sw;
//	$process -> where		= "where admin_id != 'uxis'";
	$process -> bid			= $bid;
	//s$process -> view		= $view;
	$process -> get			= "";
	$process -> orderBy	    = " order by date asc";
	$process -> groupBy	    = "";
	$process -> npageStyle  = "";
	$process -> pageStyle   = '';
	$process -> btype		= $_GET["btype"];
	$listImgIcon            = array("../board/img/btn/arrow_01.gif","../board/img/btn/arrow_02.gif","../board/img/btn/arrow_03.gif","../board/img/btn/arrow_04.gif");
	$process -> listImg     = $listImgIcon;
	$process -> svTitle01	= $svTitle01;
	$Result    = $process   -> pagingView();

	//기본 파라미터
	$parameter = "admin_type=".$_GET["admin_type"];
	//$parameter = "admin_type=".$_GET["admin_type"]."&page=".$_GET['page']."&sw=".$_GET['sw']."&sv=".$_GET['sv']."&corp=".$_GET['corp']."&rd=".$_GET['rd']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype'];

	//페이징을 위한 함수 추가 << 이 함수로 페이징 구동
    $pageNum = 10; //한 페이지에 채울 목록 개수
    $sql = "SELECT * FROM session WHERE del = 'N' ORDER BY date ASC";
	$res = mysql_query($sql, $conn);
    $pageTotal = mysql_num_rows($res);
    $start = $_GET['start']; //START 변수로 페이지 구분

    if(!$start) $start=0;
	//연도 -> 일자 오름차순 기준으로 정렬되도록 변경
    $sql = "SELECT * FROM session WHERE del = 'N' ORDER BY year asc, date asc, time asc, end_time asc limit $start, $pageNum";
	$res = mysql_query($sql, $conn);

	//상세페이지 url
	$modi_url = "./SessionModi.php?admin_type=SessionList";
	$write_url = "./SessionWrite.php?admin_type=SessionList";

	$new_date = date(Y-m-d);
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
<div class="board-list-wrap">

	<span class="bd-line"></span>
	
<form name="list_form" action="del.php?<?=$parameter?>" method="post">	
	<table>
		  <caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		  <colgroup>
			 <col scope="col" width="2%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
		  </colgroup>
		  <thead>
			 <tr>
				  <th>년도</th>
				  <th>세션종류</th>
				  <th>일자</th>
				  <th>시간</th>
				  <th>국문</th>
				  <th>영문</th>
				  <th>일문</th>
				  <th>중문</th>
				  <th>관리</th>
			  </tr>
		  </thead>
		  <tbody>
			 <?
				if($Result['listNum']==0) echo(" <tr><td colspan=\"10\">세션정보가 존재하지 않습니다.</td></tr>");
				while($row = mysql_fetch_array($res)){
			 ?>
			  <tr>
				  <td><?=$row["year"]?></td>
				  <td><?=$row["kind"]?></td>
				  <td><?=$row["date"]?></td>
				  <td><?=substr($row["time"],0,-3)?></td>
				  <!-- GET 형식으로 IDX 넘겨주기 -->
				  <td><a href="kor.php?admin_type=SessionList&idx=<?=$row["idx"]?>" class="sp-btn"><span>국문</span></a></td>
				  <td><a href="eng.php?admin_type=SessionList&idx=<?=$row["idx"]?>" class="sp-btn"><span>영문</span></a></td>
				  <td><a href="jpn.php?admin_type=SessionList&idx=<?=$row["idx"]?>" class="sp-btn"><span>일문</span></a></td>
				  <td><a href="chi.php?admin_type=SessionList&idx=<?=$row["idx"]?>" class="sp-btn"><span>중문</span></a></td>
				  <td>
				  	<!--
					 <a href="<?=$modi_url?>&admin_id=<?=$row["admin_id"]?>" class="sp-btn"><span>수정/삭제</span></a> -->
					 <a href="<?=$modi_url?>&idx=<?=$row["idx"]?>" class="sdp-btn"><span>수정/삭제</span></a>
				  </td>
			  </tr>
			 <?
				}
			 ?>
		</tbody>
	</table>
	</form>
</div>
	<div class="gap"></div>

<!-- s : 게시판 페이징 -->

<ul class="paging-wrap">
<? //../_Img/Content/paging-first.jpg
	$nowPage = 0;
	//맨 앞 페이지
	$first_page = "<a href=$_SERVER[PHP_SELF]?admin_type=SessionList&start=0><img src='../_Img/Content/paging-first.jpg' style='border:none;' text-decoration: none; align='absmiddle'></a>";
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
	$pre_page = "<a href=$_SERVER[PHP_SELF]?admin_type=SessionList&start=$prev><img src='../_Img/Content/paging-prev.jpg' style='border:none;' text-decoration: none; align='absmiddle'></a>";
	//다음 페이지
	$next_page = "<a href=$_SERVER[PHP_SELF]?admin_type=SessionList&start=$next><img src='../_Img/Content/paging-next.jpg' style='border:none;' text-decoration: none; align='absmiddle'></a>";
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
      echo "<li><a href=$_SERVER[PHP_SELF]?admin_type=SessionList&start=$nextPage>$plus</a></li>";
    }
?>
	<li> <?=$next_page?></li>
	<? 
	//마지막 페이지
	echo "<li><a href=$_SERVER[PHP_SELF]?admin_type=SessionList&start=$nextPage style='border-right:1px solid #e2e2e2;'><img src='../_Img/Content/paging-last.jpg' style='border:none;' align='absmiddle'></a></li>"
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
		<button class="bpc-btn" onclick="location.href='<?=$write_url?>'"><span>등록</span></button>
	</div>
	<div class="gap"></div>
<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>
