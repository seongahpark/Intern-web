<?php
	include $_SERVER["DOCUMENT_ROOT"].'/Mngt/conn/conn.php';
	$list_url = "./BoardList.php?page=".$_GET['page']."&sw=".$_GET['sw']."&sv=".$_GET['sv']."&bid=".$_GET['bid']."&btype=".$_GET['btype']."&attribute=".$_GET['attribute'];
	$parameter = "page=".$_GET['page']."&sw=".$_GET['sw']."&sv=".$_GET['sv']."&bid=".$_GET['bid']."&btype=".$_GET['btype']."&attribute=".$_GET['attribute'];
	
	if($_GET['bid'] == 'qna'){
	$getQuery = "select * from multiboard where bid='qna' and idx='".$_GET["idx"]."'";
	$res = mysql_query($getQuery, $conn);
	$row = mysql_fetch_array($res);

	$modi_data_result = Select_Query("multiboard","*","where bid='qna' and idx='".$_GET["idx"]."'");	
	$modi_data_row = mysql_fetch_array($modi_data_result);

	$list_url = "./QnA.php?admin_type=board_qna";	
	}
?>
<div class="board-write-wrap">
	<!-- <span class="u-line-dpoint1"></span> -->
	<span class="bd-line"></span>
<? if($_GET['bid'] == 'notice') { 
	$answerName = 'contents_no';
?>
	<form name="write_form" method="POST" encType="multipart/form-data" action="./insert.php?<?=$parameter?>">
	<input type="Hidden" name="bid" value="notice"					/>
	<input type="Hidden" name="gid" value="<?=$gid?>"					/>
	<input type="Hidden" name="id"  value="<?=$_SESSION['sess_id']?>"  />
	<!-- <input type="Hidden" name="attribute"  value="<?=$attribute?>"  /> -->
		<table>
			  <caption><span class="blind">상담과목,지역,제목,작성자,연락처,글내용,이메일,파일첨부,비밀번호의 정보를 입력하는 글쓰기 표입니다.</span></caption>
			  <colgroup>
				  <col width="12%">
				  <col width="*">
			  </colgroup>
			  <tbody>
				  <tr>
					  <th><span class="nec">제목</span></th>
					  <td>
					  <!--
						<input class="w50p" type="text" name="title" title="비밀번호를 입력해주세요" onfocus="clearText(this)"  onblur="defaultText(this)"/>&nbsp;&nbsp;
					  -->
						 <input class="w50p" type="text" name="title" title="제목을 입력해주세요" />&nbsp;&nbsp;
						 <?if($recent_subject_row['notice'] == "Y"){?>
						 <input type="checkbox" id="checkbox01" name="notice" value="Y"/><label for="checkbox01">공지</label>
						 <?}?>
					  </td>
				  </tr>

				  <?if($_GET['bid']=='jstory'){?>
				  <tr>
					<th><span>말머리</span></th>
					<td>
						<select name="attribute">
							<option value="">조은소식</option>
							<option value="building">상가사업부 소식</option>
							<option value="officetel">오피스텔사업부 소식</option>
							<option value="junggwan">정관신도시 소식</option>
						</select>
				  </tr>
				  <?}?>

				  <tr>
					  <th><span>작성자</span></th>
					  <td>
						 <input class="w15p" type="text" name="writer" title="비밀번호를 입력해주세요" value="<?=$_SESSION['sess_name']?>"/>
						 <input class="w15p" type="hidden" name="name" title="비밀번호를 입력해주세요" value="<?=$_SESSION['sess_name']?>"/>
					  </td>
				  </tr>
				  <!--
				  <tr>
					  <th><span class="nec">구분</span></th>
					  <td>
						 <input type="radio" id="attribute1" name="attribute" value="event"/>이벤트&nbsp;&nbsp;&nbsp;
						 <input type="radio" id="attribute2" name="attribute" value="notice"/>공지사항
					  </td>
				  </tr>
				  -->
				  <script type="text/javascript" src="/cmmJs/jquery/jquery-ui-datepicker.ko.js"></script>
				  <tr>
					  <th><span>작성일</span></th>
					  <td>
						 <input type="text"   name="regdate" class="w40p datepicker" value="<?=date('Y-m-d');?>">
						 <input type="Hidden" name="writedate" size="20" value="<?=date('Y-m-d');?>">
					  </td>
				  </tr>

				  <!-- 날짜 에디터 관련 스크립트 -->
				  <script>
					 $(function(){
						$('.datepicker').datepicker({
							changeMonth: true,
							changeYear: true,
							showOtherMonths: true,
							selectOtherMonths: true,
							showButtonPanel:true,
							dayNames: ['월요일', '화요일', '수요일', '목요일', '금요일', '토요일', '일요일'],
							dayNamesMin: ['월', '화', '수', '목', '금', '토', '일'], 
							monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
							monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월']
						});
					 
					 });
				  </script>
				   <tr>
					  <td colspan="2">
						 <textarea rows="15" id="contents_no" name="contents"></textarea>
					  </td>
				  </tr>

				  <?if($bid == "brochure"){?>
				  <tr>
					  <th><span>이미지</span></th>
					  <td class="fileTd">
						  <p class="fileP">
						  <span class="filetype">
							  <input type="text" class="file-text" />
							  <span class="file-btn">파일찾기</span>
							  <span class="file-select"><input type="file" name="image_file[]" class="input-file"></span>
						  </span>
						  </p>
						  
						  
						 <!--필드 인풋 스크립트-->
						 <script>
							

							
							$(function(){
								$('.fileadd').click(function(){
									$(".fileP").last().after("<p class='fileP'><span class='filetype'><input type='text' class='file-text' />&nbsp;<span class='file-btn'>파일찾기</span><span class='file-select'><input type='file' name='image_file[]' class='input-file'></span></span></p>");
								});
								
								$('.fileminus').click(function(){
									if($('.fileP').length!=1){
										$(".fileP").last().remove();
									}
								});
						
								$(document).on("change",".input-file",function(){  
									var index = $('.input-file').index(this);
									var fileName = $(this).val();
									$('.file-text').eq(index).val(fileName);
									$('.file-text').eq(index).attr('disabled', 'disabled');
									console.log(index);
								});
								
							});

						 </script>
						 <!--//필드 인풋 스크립트-->
					  </td>
				  </tr>
				  <?}?>

				  <tr>
					  <th><span>파일첨부</span></th>
					  <td class="fileTd">
						  <p class="fileP">
						  <span class="filetype">
							  <input type="text" class="file-text" />
							  <span class="file-btn">파일찾기</span>
							  <span class="file-select"><input type="file" name="up_file[]" class="input-file"></span>
						  </span>
						  
						  <a href="#none" class="cw-btn fileadd"><span>+ 파일추가</span></a>	
						  <a href="#none" class="cw-btn fileminus"><span>- 파일제거</span></a>	
						  
						  </p>
						  
						  
						 <!--필드 인풋 스크립트-->
						 <script>
							

							
							$(function(){
								$('.fileadd').click(function(){
									$(".fileP").last().after("<p class='fileP'><span class='filetype'><input type='text' class='file-text' />&nbsp;<span class='file-btn'>파일찾기</span><span class='file-select'><input type='file' name='up_file[]' class='input-file'></span></span></p>");
								});
								
								$('.fileminus').click(function(){
									if($('.fileP').length!=1){
										$(".fileP").last().remove();
									}
								});
						
								$(document).on("change",".input-file",function(){  
									var index = $('.input-file').index(this);
									var fileName = $(this).val();
									$('.file-text').eq(index).val(fileName);
									$('.file-text').eq(index).attr('disabled', 'disabled');
									console.log(index);
								});
								
							});

						 </script>
						 <!--//필드 인풋 스크립트-->
					  </td>
				  </tr>
			  </tbody>
		</table>
	</form>
<? } else if($_GET['bid'] == 'qna') { 
$answerName = 'content_answer';
?>
<form name="write_form" method="POST" encType="multipart/form-data" action="./insert.php?idx=<?=$_GET['idx']?>&<?=$parameter?>">
<!--<input type="hidden" name="duplicate_check" />-->
<input type="Hidden" name="bid" value="qna"					/>
<input type="hidden" name="writedate" value="<?=Date('Y-m-d', $modi_data_row["writedate"])?>"/>
	<table>
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			  <col width="180">
			  <col width="*"> 
		  </colgroup>
		  <tbody>
			  <tr>
				  <th><span>제목</span></th>
				  <td><p><?=$row["title"]?></p></td>
			  </tr>
			   <tr>
				  <th><span>문의자</span></th>
				  <td><?=$row["writer"]?></a></td>
			  </tr>
			  <tr>
				  <th><span>작성일시</span></th>
				  <td><p><?=$row["regdate"]?></p></td>
			  </tr>

			  <!--<tr>
				  <th><span>이미지</span></th>
				  <td><textarea style="width:100%; height:200px; resize:none;" readonly="readonly"><?=$row["text"]?></textarea></td>
			  </tr>-->
			  <tr>
				  <th><span>내용</span></th>
				  <td><?=$row["contents"]?></td>
			  </tr>
			   <tr>
				  <th><span>답변자</span></th>
				  <td><input type="text" name="answerer" readonly="readonly" value="<?=$_SESSION['sess_name']?>"/></td>
			  </tr>
				  <tr>
					  <th><span>파일첨부</span></th>
					  <td class="fileTd">
						  <p class="fileP">
						  <span class="filetype">
							  <input type="text" class="file-text" />
							  <span class="file-btn">파일찾기</span>
							  <span class="file-select"><input type="file" name="up_file[]" class="input-file"></span>
						  </span>
						  
						  <a href="#none" class="cw-btn fileadd"><span>+ 파일추가</span></a>	
						  <a href="#none" class="cw-btn fileminus"><span>- 파일제거</span></a>	
						  
						  </p>
						  
						  
						 <!--필드 인풋 스크립트-->
						 <script>
							

							
							$(function(){
								$('.fileadd').click(function(){
									$(".fileP").last().after("<p class='fileP'><span class='filetype'><input type='text' class='file-text' />&nbsp;<span class='file-btn'>파일찾기</span><span class='file-select'><input type='file' name='up_file[]' class='input-file'></span></span></p>");
								});
								
								$('.fileminus').click(function(){
									if($('.fileP').length!=1){
										$(".fileP").last().remove();
									}
								});
						
								$(document).on("change",".input-file",function(){  
									var index = $('.input-file').index(this);
									var fileName = $(this).val();
									$('.file-text').eq(index).val(fileName);
									$('.file-text').eq(index).attr('disabled', 'disabled');
									console.log(index);
								});
								
							});

						 </script>
						 <!--//필드 인풋 스크립트-->
					  </td>
				  </tr>
			  <tr>
				  <th><span>답변</span></th>
				  <td><textarea name="content_answer" id="content_answer" style="width:100%; height:100px; resize:none;" ><?=$modi_data_row["content_answer"]?></textarea></td>
				  <!--내용 에디터 관련-->
			  </tr>
			  </tbody>
	</table>
	</form>
<? } ?>
  <script type="text/javascript" src="/Seditor/js/HuskyEZCreator.js" charset="utf-8"></script>
  <script>
		var oEditors = [];

		nhn.husky.EZCreator.createInIFrame({
			oAppRef: oEditors,
			//elPlaceHolder: "content_answer",
			elPlaceHolder: "<? echo $answerName; ?>",
			sSkinURI: "/Seditor/SmartEditor3Skin.html",
			fCreator: "createSEditor2"
		});

		function goback(){
			history.go(-1);
		}
  </script>	
	<div class="ssgap"></div>
	<div class="r">
		<a href="#none" onclick="javascript:Write_Chk()" class="bw-btn"><span>등록</span></a>
		<a href="#" onclick="goback()" class="bp-btn"><span>취소</span></a>
	</div>
</div>
