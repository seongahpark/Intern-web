<?php
	$modi_data_result = Select_Query("multiboard","*","where idx='".$_GET["idx"]."'");	
	
	$modi_data_row = mysql_fetch_array($modi_data_result);
	
	$saveDir = $_SERVER["DOCUMENT_ROOT"].'/data/';
	
	$FileList = new_ADFileList1($idx,$saveDir,$bid);									      #파일
		
	$notice_check="";
	$secret_check="";
	
	if($modi_data_row["notice"]=="Y"){
		$notice_check="checked";
	}
	if($modi_data_row["secret"]=="Y"){
		$secret_check="checked";
	}

	if($modi_data_row["attribute"]=="event"){$attribute_check1="checked";}
	if($modi_data_row["attribute"]=="notice"){$attribute_check2="checked";}

	//$view_url = "./BoardView.php?page=".$_GET['page']."&sw=".$_GET['sw']."&sv=".$_GET['sv']."&corp=".$_GET['corp']."&rd=".$_GET['rd']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype'];
	$view_url = "./BoardView.php?page=".$_GET['page']."&sw=".$_GET['sw']."&sv=".$_GET['sv']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype']."&attribute=".$_GET['attribute'];

	$parameter = "page=".$_GET['page']."&sw=".$_GET['sw']."&sv=".$_GET['sv']."&bid=".$_GET['bid']."&view=".$_GET['view']."&btype=".$_GET['btype']."&attribute=".$_GET['attribute'];

?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />
<div class="board-write-wrap">
	<!-- <span class="u-line-dpoint1"></span> -->
	<span class="bd-line"></span>
	<form name="write_form" method="POST" encType="multipart/form-data"  action="./update.php?<?=$parameter?>&idx=<?=$_GET['idx']?>">
		<input type="Hidden" name="bid" value="<?=$bid?>">
		<input type="Hidden" name="id"  value="<?=$_SESSION['sess_id']?>">
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
						 <input class="w50p" type="text" title="제목을 입력해주세요" name="title" onfocus="clearText(this)"  onblur="defaultText(this)" value="<?=htmlspecialchars($modi_data_row["title"])?>"/>&nbsp;&nbsp;
						 <?if($recent_subject_row['notice'] == "Y"){?>
						 <input type="checkbox" id="checkbox01" name="notice" value="Y" <?=$notice_check?>/><label for="checkbox01">공지</label>
						 <?}?>
					  </td>
				  </tr>

				  <?if($_GET['bid']!='free' || $_GET['bid']!='member'){?>
				  <tr>
					  <th><span>작성자</span></th>
					  <td>
						 <input class="w15p" type="text" name="writer" value="<?=$modi_data_row["writer"]?>" title="작성자를 입력해주세요"/>
						 <input class="w15p" type="hidden" name="name" title="비밀번호를 입력해주세요" value="<?=$_SESSION['sess_name']?>"/>
					  </td>
				  </tr>
				  <?}?>

				  <script type="text/javascript" src="/cmmJs/jquery/jquery-ui-datepicker.ko.js"></script>
				  <tr>
					  <th><span>작성일</span></th>
					  <td>
					  <!--<?=Date('Y-m-d',$viewRow['writedate']);?>-->
						 <input class="w15p datepicker" type="text" name="writedate" value="<?=Date('Y-m-d', $modi_data_row["writedate"])?>" title="비밀번호를 입력해주세요"/>
						 <input type="Hidden" name="regdate"   size="20" class="textfield" value="<?=$modi_data_row['regdate'];?>">
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
						 <textarea rows="15" id="edit_contents" name="contents"><?=$modi_data_row["contents"]?></textarea>
					  </td>
					  <!--내용 에디터 관련-->
					  <script type="text/javascript" src="/Mngt/02_Board/inc/smarteditor/js/service/HuskyEZCreator.js" charset="utf-8"></script>
					  <script>
							var oEditors = [];

							window.onload = function(){
							nhn.husky.EZCreator.createInIFrame({
								oAppRef: oEditors,
								elPlaceHolder: "edit_contents",
								sSkinURI: "/Mngt/02_Board/inc/smarteditor/SmartEditor2Skin.html",
								fCreator: "createSEditor2"
							});
							}
					  </script>
				  </tr>
				  <tr>
					  <th><span>파일목록</span></th>
					  <td><?=$FileList["link"]?></td>
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
			  </tbody>
		</table>
	</form>
	<div class="ssgap"></div>
	<div class="fr">
		<a href="#none" onclick="javascript:Modi_Chk()" class="bw-btn"><span>등록</span></a>
		<a href="<?=$view_url?>&idx=<?=$_GET["idx"]?>" class="bp-btn"><span>취소</span></a>
	</div>
	<div class="ssgap"></div>
</div>
