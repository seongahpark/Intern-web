<?php
	$view_data_result = Select_Query("multiboard","*","where idx='".$_GET["idx"]."'");
	$view_data_row = mysql_fetch_array($view_data_result);
	$saveDir = '/data';
	$FileList = new_ADFileListAll3($idx,$saveDir,$bid);		  #파일
		
	$parameter = "page=".$_GET['page']."&sw=".$_GET['sw']."&sv=".$_GET['sv']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype']."&attribute=".$_GET['attribute'];
		
	//이전글, 다음글
	$prev_data = mysql_fetch_array(mysql_query("SELECT * FROM multiboard WHERE bid='".$_GET['bid']."' AND del='N' AND idx < ".$idx." ORDER BY idx DESC LIMIT 0,1"));
	$next_data = mysql_fetch_array(mysql_query("SELECT * FROM multiboard WHERE bid='".$_GET['bid']."' AND del='N' AND idx > ".$idx." ORDER BY idx ASC LIMIT 0,1"));

	$prev_url = str_replace("idx=".$idx, "idx=".$prev_data['idx'], $_SERVER['REQUEST_URI']);
	$next_url = str_replace("idx=".$idx, "idx=".$next_data['idx'], $_SERVER['REQUEST_URI']);
?>
<div class="board-view-wrap">
		<!-- <span class="u-line-dpoint1"></span> -->
		<span class="bd-line"></span>
			
		<table>
			  <caption><span class="blind"><?=$view_data_row["title"]?></span></caption>
			  <thead>
				  <tr>
					  <th>
						<p class="btxt">
							<?=$attributeStr?>
							<?=$view_data_row["title"]?>
							<? if($view_data_row["regdate"] == date("Y-m-d")){ ?> 
								<img src="../cmmImg/Board/bnew_icon.jpg" alt="새글" class="pad5l" /> 
							<? } ?>
						</p>											

						<span><strong>작성자</strong> : <?=$view_data_row["writer"]?></span>
						<span><strong>작성일자</strong> : <?=$view_data_row["regdate"]?></span>

						<?if($_GET['bid']=='question'){?>
						<span><strong>e-mail</strong> : <?=$view_data_row["email"]?></span>
						<?}?>
						<!--모바일사이즈시 조회수는 사라집니다-->
						<p class="hit">
							<span>조회수</span>
							<span><?=$view_data_row["visited"]?></span>
						</p>
					  </th>
				  </tr>
			  </thead>
			  <tbody>
				  <?if($_GET['bid']=='notice'){?>
				  <tr>
					  <td>
						 <strong class="file-btxt">첨부파일 : </strong>
						 <? if($FileList["link"] == "등록된 파일이 없습니다.") $non_click = 'style="pointer-events: none;" disabled'; else $non_click = ''; ?>
						 <a href="#" class="file-add" <?=$non_click?>><span><?=$FileList["link"]?></span></a>
					  </td>
				  </tr>
				  <?}?>
				  <tr>
					  <td colspan="2" class="editor-data-box">
					  <?
					  if($_GET['bid'] == 'notice'){
						$view_file_data_result = Select_Query("fileboard","*","where idx='".$_GET["idx"]."'  and dis='' order by fileidx asc");
						while($view_file_data_row = mysql_fetch_array($view_file_data_result)){
							 $index = strpos($view_file_data_row["sname"],'.');
							 $ext = substr($view_file_data_row["sname"],$index+1, strlen($view_file_data_row["sname"]));
							 
							 if($ext=="pjpeg"||$ext=="gif"||$ext=="bmp"||$ext=="png"||$ext=="jpg"||$ext=="JPG"||$ext=="JPEG"||$ext=="jpeg"){
						?>
							<img src="<?=$saveDir?>/<?=$_GET["bid"]?>/<?=$view_file_data_row["sname"]?>"/>
							<br/>
						<?
								 }
						}
						}
						?>
						<?=$view_data_row["contents"]?>
					  </td>
				  </tr>
	<? if($_GET['bid'] == 'qna') { ?>
				  <tr>
					  <th>
						<span><strong>답변자</strong> : <?=$view_data_row["answerer"]?></span>
					  </th>
				  </tr>
				  <?if($_GET['bid']!='question'){?>	
				  <tr>
					  <td>
						 <strong class="file-btxt">첨부파일 : </strong>
						 <? if($FileList["link"] == "등록된 파일이 없습니다.") $non_click = 'style="pointer-events: none;" disabled'; else $non_click = ''; ?>
						 <a href="#" class="file-add" <?=$non_click?>><span><?=$FileList["link"]?></span></a>
					  </td>
				  </tr>
				  <?}?>
				  <tr>
					  <td colspan="2" class="editor-data-box">
					  <?
						$view_file_data_result = Select_Query("fileboard","*","where idx='".$_GET["idx"]."'  and dis='' order by fileidx asc");
						while($view_file_data_row = mysql_fetch_array($view_file_data_result)){
							 $index = strpos($view_file_data_row["sname"],'.');
							 $ext = substr($view_file_data_row["sname"],$index+1, strlen($view_file_data_row["sname"]));
							 
							 if($ext=="pjpeg"||$ext=="gif"||$ext=="bmp"||$ext=="png"||$ext=="jpg"||$ext=="JPG"||$ext=="JPEG"||$ext=="jpeg"){
						?>
							<img src="<?=$saveDir?>/<?=$_GET["bid"]?>/<?=$view_file_data_row["sname"]?>"/>
							<br/>
						<?
								 }
						}
						?>
						<?=$view_data_row["content_answer"]?>
					  </td>
				  </tr>
	<? } ?>
			  </tbody>
		</table>

		<!-- 이전글 다음글 -->
		<div class="ssgap"></div>
		<ul class="np-page">
			<li>
				<? if($prev_data){ ?>
				<a href="<?=$prev_url?>" class="first">이전글&nbsp;<span class="f9">▲</span></a>
				<a href="<?=$prev_url?>" class="ellipsis">
					<span><?=$prev_data['title']?> </span>
				</a>
				<? } else { ?>
				<a href="#" class="first" style="pointer-events: none;" disabled>이전글&nbsp;<span class="f9">▲</span></a>
				<a href="<?=$prev_url?>" class="ellipsis" style="pointer-events: none;" disabled>
					<span>이전글이 없습니다. </span>
				</a>
				<? } ?>
			</li>
			<li>
				<? if($next_data){ ?>
				<a href="<?=$next_url?>" class="first">다음글&nbsp;<span class="f9">▼</span></a>
				<a href="<?=$next_url?>" class="ellipsis">
					<span><?=$next_data['title']?> </span>
				</a>
				<? } else { ?>
				<a href="#" class="first" style="pointer-events: none;" disabled>다음글&nbsp;<span class="f9">▼</span></a>
				<a href="<?=$next_url?>" class="ellipsis" style="pointer-events: none;" disabled>
					<span>다음글이 없습니다. </span>
				</a>
				<? } ?>
			</li>
		<ul>
		<!-- 이전글 다음글 -->

		<!-- 버튼 -->
		<div class="ssgap"></div>
		<div class="fl">
			<form name="del_form" action="./del.php?<?=$parameter?>" method="post">
				<input type="hidden" name="idx[]" value="<?=$_GET["idx"]?>">
				<a href="#none" onclick="javascript:del_Chk();" class="bp-btn"><span>삭제</span></a>
			</form>
			
		</div>

		<div class="fr">
			<!--a href="./BoardAnswer.php?<?=$parameter?>&idx=<?=$_GET["idx"]?>"><button class="bw-btn">답글</button></a-->
			<?if($bid=="qna"){?>
				<a href="./BoardWrite.php?mode=ans&<?=$parameter?>&idx=<?=$_GET["idx"]?>"><button class="bdp-btn">답글</button></a>
			<?}else if($bid != "question" && $bid!="QnA"){?>
				<a href="./BoardModi.php?<?=$parameter?>&idx=<?=$_GET["idx"]?>"><button class="bdp-btn">수정</button></a>
			<?}?>
			<a href="./BoardList.php?<?=$parameter?>"><button class="bw-btn">목록</button></a>
		</div>
		<!-- 버튼 -->
</div>

<div class="gap">&nbsp;</div>

<!--
<div class="board-pass">
	<p class="btxt">비밀번호 확인</p>
	<p class="stxt">확인을 위한 비밀번호을 입력하시기 바랍니다</p>
	<p>
		<input type="password" title="비밀번호를 입력해주세요"/>
		<input type="button" value="확인"/>
	</p>
</div>
-->