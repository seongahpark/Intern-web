<div class="board-search">
	<div class="total"><span>Total : <strong><?=$result[5]?>건</strong></span></div>
	<div class="search">
		<form name="searchForm" method="get" action="<?=$_SERVER["PHP_SELF"]?>">
		<div class="select_box">
			<select class="sc_category" name="sc">
				<option value>전체</option>
				<option value="title">제목</option>
				<option value="subject">분류</option>
				<option value="contents">내용</option>
			</select>
		</div>
		<input type="text"  name="sw" id="sw" title="검색 내용을 입력해주세요" value="<?=$sw?>"/>
		<button type='submit' onclick="document.searchForm.submit();"><span>검색</span></button>
		</form>
	</div>
</div>
<div class="photo-default">
	<span class="u-line-dpoint1"></span>
	<ul>
	    <!-- 첫번째 first class 꼭 넣어주세요 (5개씩 반복시)-->
		<?if((($result[5]+$noticeResult['num']))==0){?>
			<div style="text-align: center"><span class="c-dgray" ><br>등록된 글이 없습니다.<br><br></span></div>
			<?}else{?>
			<?PHP
			//--
					$cc=0;
					$num		= ($result[5]-($page*$vrecord));//글번호
					while($row=mysql_Fetch_array($result[0])){
						$regdate    = $row['regdate'];
						$subject	= $row['subject'];
						$getVideo	= $row['video'];
						$getVideo	= substr($getVideo, 17); 
						$thumbnail	= 'https://img.youtube.com/vi/'.$getVideo.'/mqdefault.jpg';			 #썸네일 이미지
						$ReplyIcon  = ReplyIcon($row["re_level"],$BoardIcon["Reply"]);				     #답글아이콘
						$FileIcon   = FileIcon($row['idx'],$BoardIcon["File"]);						     #파일아이콘
						$NewIcon    = NewIcon($boardInfo["newicon"],$row["writedate"],$BoardIcon["New"]);	 #뉴  아이콘 << 원래는 regdate대신 writedate가 들어감
						$NoticeIcon = BoardIcon($boardInfo["notice"],$BoardIcon["Notice"]);			     #공지아이콘
						$SecretIcon = BoardIcon($row["secret"],$BoardIcon["Secret"]);		             #비밀아이콘
						$title      = strcut_utf8($row["title"],30,true,'...');
						$deep       = ($row["re_level"]*10);										     #답변뎁스
						$_valGET	= "idx=".$row['idx']."&pg_mode=View&".$getPage;
						$contents  = han_cut($row["contents"],150,'...');
						$memoSQL="select idx from memoboard where bid='".$bid."' and idx=".$row['idx'];
						$memoRs=mysql_query($memoSQL,$conn);
						$memoCnt=mysql_num_rows($memoRs);

						$fileSQL="select * from fileboard where bid='".$bid."' and idx=".$row['idx']." and type like 'image%' order by fileidx asc limit 1";
						$fileRs=mysql_query($fileSQL,$conn);
						$fileRow=mysql_fetch_array($fileRs);
						$fileType=$fileRow['type'];
						
						//파일 확장자 체크
						if(strpos($fileType, "image") !== false) $fileChk = true;
						else $fileChk = false;

						//if($getVideo){	//youtube 영상 썸네일을 사용할 시 해당 주석 해제
						//	$imgURL="<img src='$thumbnail' width='284px' height='163px'>";
						//}else if($fileChk){
						if($fileChk){
							$imgURL="<img src='".$saveDir.$fileRow['sname']."' alt='".$fileRow['rname']."' style='width:284px;height:120.04px;'>";
						}else{
							$imgURL="<img src='/cmmImg/Board/no-img01.jpg' alt='NO images' style='width:284px;height:120.04px;'/>";
						}

				IF($_SESSION['sess_auth']<=$boardInfo['reader']){
					   $returnTitle   = $_SERVER['PHP_SELF']."?".$_valGET;
					   $returnScript   = "";
				}else{
					   $returnTitle   = "#";
					   $returnScript   = " onclick='javascript:alert(\"회원 이상의 권한이 필요합니다.\");return false;'";
				
				}
?>
		<li <?if($cc%4==0){?>class="first"<?}?>>
			<a href="<?=$returnTitle?>" <?=$returnScript?>>
			<span class="img">
				<?=$imgURL?>
				<span class="over"></span>
			</span>
			<span class="title ellipsis"><?=$title?><?=$SecretIcon?><?if(date("Y-m-d")==$regdate) echo $NewIcon;?></span><br>
			<span class="date">등록일 : <?=$regdate?></span><br>
			<span class="subject">분류명 : <?=$subject?></span>
			</a>
		</li>
			<?PHP 
			$cc++;
			$num--;}}?>
	</ul>

</div>


<div class="ssgap"></div>

<ul class="paging-wrap">
	<li><?=$result[6]?></li>
	<li><?=$result[2]?></li>
	<?=$result[3]?>
	<li><?=$result[4]?></li>
	<li><?=$result[7]?></li>
</ul>