<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/07_Session/inc/subHead.php');
	include "../conn/conn.php";
?>
<?	
	$selectSQL		= "SELECT session_type, language, COUNT(*) as count from statistics group by session_type, language order by stat_date , time, session_type, LANGUAGE asc ";
	$res			= mysql_query($selectSQL);
	
?>
<div class="board-list-wrap">
<span class="bd-line"></span>

<table>
	<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
	<colgroup>
		<col scope="col" width="10%">
		<col scope="col" width="10%">
		<col scope="col" width="10%">
	</colgroup>
	<thead>
		<tr>
			<th>세션종류</th>
			<th>언어</th>
			<th>클릭수</th>
		 </tr>
	 </thead>
	 <tbody>
		<?
			//if($Result['listNum']==0) echo(" <tr><td colspan=\"10\">세션정보가 존재하지 않습니다.</td></tr>");
		while($row = mysql_fetch_array($res)){
			switch($row["language"]){
				case 1:
					$lang_convert = "국문";
					break;
				case 2:
					$lang_convert = "영문";
					break;
				case 3:
					$lang_convert = "일문";
					break;
				case 4:
					$lang_convert = "중문";
					break;
			}	
		?>
			<tr>
				<td><?=$row["session_type"]?></td>
				<td><?=$lang_convert?></td>
				<td><?=$row["count"]?></td>			
			</tr>
		<?
		}
		?>
	</tbody>
</table>
<div class="ssgap"></div>
<div class="fr">
	<button class="bpc-btn" onclick="location.href='export.php'" ><span>엑셀 다운로드</span></button>
</div>
<div class="ssgap"></div>

<!-- <div style = "width:100px; height:100px; > </div>
<div class="fr">
	<button class="bpc-btn" onclick="location.href='export.php'" style="margin-right:20"><span>댓글 추출</span></button>
</div> -->

<!-- paging 현재 주석, 필요시 구현

<ul class="paging-wrap">
<? //../_Img/Content/paging-first.jpg
	$nowPage = 0;
	//맨 앞 페이지
	$first_page = "<a href=$_SERVER[PHP_SELF]?admin_type=Stats&start=0><img src='../_Img/Content/paging-first.jpg' style='border:none;' text-decoration: none; align='absmiddle'></a>";
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
	$pre_page = "<a href=$_SERVER[PHP_SELF]?admin_type=Stats&start=$prev><img src='../_Img/Content/paging-prev.jpg' style='border:none;' text-decoration: none; align='absmiddle'></a>";
	//다음 페이지
	$next_page = "<a href=$_SERVER[PHP_SELF]?admin_type=Stats&start=$next><img src='../_Img/Content/paging-next.jpg' style='border:none;' text-decoration: none; align='absmiddle'></a>";
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
      echo "<li><a href=$_SERVER[PHP_SELF]?admin_type=Stats&start=$nextPage>$plus</a></li>";
    }
?>
	<li> <?=$next_page?></li>
	<? 
	//마지막 페이지
	echo "<li><a href=$_SERVER[PHP_SELF]?admin_type=Stats&start=$nextPage style='border-right:1px solid #e2e2e2;'><img src='../_Img/Content/paging-last.jpg' style='border:none;' align='absmiddle'></a></li>"
	?>
</ul>
<div class="ssgap"></div>

<div class="ssgap"></div>
 e : 게시판 페이징 -->

<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>