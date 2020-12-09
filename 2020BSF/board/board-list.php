<?	require_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/conn/conn.php');
	//error_reporting(E_ALL);
	//ini_set("display_errors", 1);
	$bid = $_GET['bid'];
	$chkKind = !strcmp($bid,'notice');				//공지사항인지 QNA인지 구별하는 bool, true면 notice
	//검색 내용
	if($chkKind){
		if(!strcmp($sw,''))
			$sql = "SELECT * FROM multiboard where del = 'N' AND bid = 'notice'";
		else{
			if(!strcmp($sv,'title')){
				$sql = "SELECT * FROM multiboard where del = 'N' AND title like '%$sw%' AND bid = 'notice'";
			}
			else if(!strcmp($sv,'name')){
				$sql = "SELECT * FROM multiboard where del = 'N' AND writer like '%$sw%' AND bid = 'notice'";
			}
			else{
				$sql = "SELECT * FROM multiboard where del = 'N' AND contents like '%$sw%' AND bid = 'notice'";
			}
		}
	}
	else{
		if(!strcmp($sw,''))
			$sql = "SELECT * FROM multiboard where del = 'N' AND bid = 'qna'";
		else{
			if(!strcmp($sv,'title')){
				$sql = "SELECT * FROM multiboard where del = 'N' AND title like '%$sw%' AND bid = 'qna'";
			}
			else if(!strcmp($sv,'name')){
				$sql = "SELECT * FROM multiboard where del = 'N' AND writer like '%$sw%' AND bid = 'qna'";
			}
			else{
				$sql = "SELECT * FROM multiboard where del = 'N' AND contents like '%$sw%' AND bid = 'qna'";
			}
		}
	}
	
	//echo $sql;
	$res = mysql_query($sql, $conn);
	$pageTotal = mysql_num_rows($res);				//총 게시글 수를 센다.

	//20201105 김찬기 추가
	$board_name = $chkKind ? "notice" : "qna";
?>
<div class="board <?=$board_name ?>">
    <div class="b_top">
            <div class="total">
                <img src="../share/img/description.svg" alt="total">전체 : <?=$pageTotal?>
            </div>

            <form name="search_form" action="./<?=$bid?>.php?bid=<?=$bid?>&&start=0" method="post">
                <div class="search_box">
                    <div class="select_box">
                        <select name="sv" class="sc_category">
                            <option value="title">제목</option>
                            <option value="name">작성자</option>
                            <option value="contents">내용</option>
                        </select>
                    </div>
                    <div class="input_box">
                        <input type="text" name="sw" placeholder="검색어를 입력해주세요">
                    </div>
                    <button onclick="javascript:add_form_check();" class="board_btn search"><i class="icon-search"><span class="hidden">돋보기 아이콘</span></i>검색</button>
                </div>
            </form>
            
    </div>
    <table class="board_frame">
        <caption>게시판입니다.</caption>
        <colgroup>
			<? if($chkKind){ ?>
                <col width="120" class="mo_hidden">
				<col width="*">
				<col width="100">
				<col width="120">
				<col width="120">
				<col width="120" class="mo_hidden">
				<? }else{ ?>
				<col width="120" class="mo_hidden">
				<col width="*">
				<col width="100">
				<col width="120">
				<col width="120">
				<col width="120"  class="mo_hidden">
			<?} ?>
           
        </colgroup>
        <thead>
            <tr>
                <th class="num">번호</th>
                <th class="title">제목</th>
                <th class="file">첨부</th>
                <th class="writer">작성자</th>
                <th class="date">작성일</th>
				<? if($chkKind){ ?>
                <th class="view">조회</th>
				<? }else{ ?>
				<th class="status">상태</th>
				<?} ?>
            </tr>
        </thead>
        <tbody>
            <?	
				$pageNum = 10; //한 페이지에 채울 목록 개수
				//if($Result['listNum']==0) echo(" <tr><td colspan=\"10\">세션정보가 존재하지 않습니다.</td></tr>");
				if($pageTotal == 0){
					echo(" <tr><td class='empty' colspan=\"6\">게시물이 없습니다.</td></tr>");
				}
				if($chkKind){
					if(!strcmp($sw,''))
						$sql = "SELECT * FROM multiboard where del = 'N' AND bid = 'notice' order by idx desc limit $start, $pageNum ";
					else{
						if(!strcmp($sv,'title')){
							$sql = "SELECT * FROM multiboard where del = 'N' AND bid = 'notice' AND title like '%$sw%' order by idx desc limit $start, $pageNum";
						}
						else if(!strcmp($sv,'name')){
							$sql = "SELECT * FROM multiboard where del = 'N' AND bid = 'notice' AND writer like '%$sw%' order by idx desc limit $start, $pageNum";
						}
						else{
							$sql = "SELECT * FROM multiboard where del = 'N' AND bid = 'notice' AND contents like '%$sw%' order by idx desc limit $start, $pageNum";
						}
					}
				}
				else{
					if(!strcmp($sw,''))
						$sql = "SELECT * FROM multiboard where del = 'N' AND bid = 'qna' order by idx desc limit $start, $pageNum ";
					else{
						if(!strcmp($sv,'title')){
							$sql = "SELECT * FROM multiboard where del = 'N' AND bid = 'qna' AND title like '%$sw%' order by idx desc limit $start, $pageNum ";
						}
						else if(!strcmp($sv,'name')){
							$sql = "SELECT * FROM multiboard where del = 'N' AND bid = 'qna' AND writer like '%$sw%' order by idx desc limit $start, $pageNum ";
						}
						else{
							$sql = "SELECT * FROM multiboard where del = 'N' AND bid = 'qna' AND contents like '%$sw%' order by idx desc limit $start, $pageNum";
						}
					}
				}
				$res = mysql_query($sql, $conn);
				$start = $_GET['start']; //START 변수로 페이지 구분
				$index = $pageTotal + 1 - $_GET['start'];
				while($row = mysql_fetch_array($res)){
					$index = $index - 1;
					//첨부파일 있는지 없는지 확인
					$filesql = "SELECT * FROM fileboard where idx='".$row['idx']."'";
					$fileres = mysql_query($filesql, $conn);
					$filerow = mysql_fetch_array($fileres);
			 ?>
					<tr>
						<td class="num"><?=$index?></td>
						<td class="title">
						<? if(substr($row["regdate"],0,10) == date("Y-m-d")){ ?> 
							<i class="board_n_icon"><span class="hidden">새글</span></i>
						<? } ?>
						<?if($row["secret"] == 'Y') echo "<i class='board_secret_icon'><span class='hidden'>비밀글</span></i>";
							?>
							<a href="<?echo $bid?>_view.php?bid=<?=$bid?>&&idx=<?=$row["idx"]?>" class="f14">
							<?=$row["title"]?></a>
						</td>
						<td class="file">
						<? if($filerow['sname'] != "") { ?>
						<img src="../share/img/attachment.svg" alt="첨부파일">
						<? } ?>
						</td>
						<td class="writer"><?=$row["writer"]?></td>
						<td class="date"><?=substr($row["regdate"],0,10)?></td>
						<? if($chkKind){ ?>
						<td class="view"><?=$row["visited"]?></td>
						<? }else {
							if($row['answerer'] == "") $state = "<i class='progress'>진행중</i>";
							else $state = "<i class='done'>답변완료</i>";
						?>
						<td class="status"><?=$state?></td>
						<? } ?>
					</tr>
			<?
				}
			?>
        </tbody>        
    </table>

	<?
		if(!$chkKind){				//QNA이면 하단 글쓰기 버튼 생성
	?>
    <div class="action cl">
        <button class="board_btn b_write" onclick="location.href='./qna_write.php?idx=<?=$pageTotal + 1; ?>'"><i class="icon-write" onclick="href"></i>질문 작성</button>
    </div>
	<?
			}
	?>

    <div class="pager">
        <ul class="pager_num cl">
			<?
				$nowPage = $_GET['start'] / $pageNum;
				$first_page = "<a href=$_SERVER[PHP_SELF]?bid=$bid&&start=0 class='first'><i class='icon-ar_left_d'><span class='hidden'>처음으로</span></i></a>";

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
				$pre_page = "<a href=$_SERVER[PHP_SELF]?bid=$bid&&start=$prev class='prev'><i class='icon-ar_left'><span class='hidden'>이전</span></i></a>";
				//다음 페이지
				$next_page = "<a href=$_SERVER[PHP_SELF]?bid=$bid&&start=$next class='next'><i class='icon-ar_right'><span class='hidden'>다음</span></i></a>";
			?>
			<li><?=$first_page?></li>
			<li><?=$pre_page?></li>
			<?
				//현재 페이지
				$pages = $pageTotal / $pageNum;
				for($i=0; $i<$pages; $i++){
				  
				  $nextPage = $pageNum * $i;
				  $plus = $i + 1;
				  if($i == $nowPage){
						//echo "<li class='active'>$plus</li>";
						echo "<li><a href='javascript:void(0)' class='active'>$plus</a></li>";
				  }
				  else{
						echo "<li><a href=$_SERVER[PHP_SELF]?bid=$bid&&start=$nextPage>$plus</a></li>";
				  }
				}
				if($pages == 0)	{	//모바일 페이징 상황에서 게시물이 없을 때, 0으로 표시 되는것 수정
					$pages = 1;	
					echo "<li><a href='javascript:void(0)' class='active'>1</a></li>";
				}
			?>
			<li><?=$next_page?></li>
			<? 
				//마지막 페이지
				echo "<li><a href=$_SERVER[PHP_SELF]?bid=$bid&&start=$nextPage class='last'><i class='icon-ar_right_d'><span class='hidden'>마지막으로</span></i></a></li>"
			?>
			
        </ul>
    </div>
	<div class="mobile_pager">
		<ul>
			<li><?=$pre_page?></li>
			<li class="fraction"><span><?=$nowPage+1?></span><span>/</span><span><?echo ceil($pages)?></span></li>
			<li><?=$next_page?></li>
		</ul>
	</div>
</div>


<!-- 글 작성 시, 빈 칸 확인여부 -->
<script type="text/javascript" src="../Mngt/cmmJs/formCheck.js"></script>
<script type="text/javascript">
	function add_form_check(){
		var form = document.search_form;
		
		if(!Admin_Pass_Chk(form.sw,'내용')) return false;

			form.submit();
	}
</script>