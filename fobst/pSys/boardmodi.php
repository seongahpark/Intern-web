<?
$_classValue = array(
"공학-기계",
"공학-조선",
"공학-항공우주",
"공학-전기전자",
"공학-컴퓨터공학",
"공학-재료공학",
"공학-신소재",
"공학-화학공학",
"공학-에너지",
"공학-원자력",
"공학-환경공학",
"공학-건축",
"공학-토목",
"공학-생명공학",
"공학-도시공학",
"자연과학-물리",
"자연과학-화학",
"자연과학-생물",
"자연과학-지구과학",
"자연과학-수학",
"보건의료-의학",
"보건의료-약학",
"보건의료-치의학",
"보건의료-한의학",
"보건의료-수의학",
"보건의료-의공학",
"기타");
?><script type="text/javascript" src="../../Seditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="../../script/formCheck.js"></script>
<script type="text/javascript" src="../../script/file_script.js"></script>
<script type="text/javascript" src="../../script/script.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />  
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>  
<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

<?if($bid!="lecture_lec"){?>
<script type="text/javascript">
   $(function() { // datepicker로 날짜폼 적용
    $( "#datepicker" ).datepicker( {dateFormat: "yy-mm-dd"});
  });

<!--
	var oEditors = [];
	function Write_Chk(form){
		
		var form = document.write_form;
		oEditors[0].exec("UPDATE_CONTENTS_FIELD", []);
		if(!Val_Chk(form.name,'작성자'))			return;
		if(!Val_Chk(form.title,'제목'))				return;
		if(form.secret!=undefined){
			if(form.secret.checked==true){
				if(!Val_Chk(form.pass,'비밀번호')) return;
			}
		}
		form.submit();
	}
//-->
</script>
<?}else{?>
<script type="text/javascript">
<!--
	function Write_Chk(form){
		var form = document.write_form;
		if(!SelectBox_Chk(form.classValue,'분류'))			return false;
		if(!Val_Chk(form.title,'강연제목'))				return false;
		if(!Val_Chk(form.name,'강연자'))				return false;
		if(!Val_Chk(form.organ,'기관'))					return false;
		if(!Val_Chk(form.depart,'학과(소속)'))			return false;
		if(!Val_Chk(form.lecDate,'강연일'))				return false;
		if(!Val_Chk(form.region,'강연지역'))			return false;
		if(!Val_Chk(form.siteUrl,'금과터강연영상보기'))	return false;
		form.submit();
	}
//-->
</script>
<?}?>
<?php
	IF($_GET['idx']){
		$viewRow  = Result_Query("multiboard","*","mysql_fetch_array","where idx='".$_GET['idx']."'");#게시판
		IF(!$viewRow) History_Back(-1,"데이터가 없습니다.");
		$NCheck   = NoticeChk($viewRow['notice']);													  #공지사항체크
		$SCheck   = NoticeChk($viewRow['secret']);													  #비밀글체크
		$FileList = ADFileList($viewRow['idx'],$saveDir);										      #파일
	}else{
		History_Back(-1,"글번호가 없습니다.");
	}
?>

<form name="write_form" method="POST" enctype="multipart/form-data" action="./updateOk.php?idx=<?=$viewRow['idx']?>&<?=$getView?>">
<input type="hidden" name="bid"		value="<?=$bid?>"					/>
<input type="hidden" name="id"		value="<?=$viewRow['id']?>"	/>
<input type="hidden" name="pgMode"	value="<?=$pgMode?>"				/>
<input type="hidden" name="page"	value="<?=$page?>"				/>
<input type="hidden" name="idx"		value="<?=$idx?>"					/>
<table class="board_write">
  <colgroup>
        <col width="10%" />
        <col width="*" />
  </colgroup>
 
  <tbody>
	<?if($bid=="fobst_const" || $bid=="lecture_lec" || $bid=="posit_photo3" || $bid=="posit_photo5" || $bid=="posit_photo4"){?>
	<tr>
      <td class="tdl">년도</td>
      <td  class="tdr">
	  <select name="years">
		<option value="">년도를 선택하세요.</option>
		<?for($ii=2001;$ii<date("Y")+2 ;$ii++ ){?>
			<option value="<?=$ii?>" <?if($viewRow['years']==$ii){?> selected<?}?>><?=$ii?>년</option>
		<?}?> 
	  </select>
	  </td>
    </tr>
	<?}?>
    <?if($bid=="posit_photo3" || $bid=="posit_photo5"){?>
	<tr>
      <td class="tdl">회차</td>
      <td  class="tdr">제<input type="text" name="times" class="input_text"  style="width:100px;" value="<?=$viewRow['times'];?>"/>회</td>
    </tr>
	<?}?>
	 <?if($bid!="lecture_lec"){?>
	<tr>
      <td class="tdl"><?if($bid=="lecture_lec"){?>강연제목<?}else{?>제목<?}?></td>
      <td  class="tdr"><input type="text" name="title" class="input_text fl"  style="width:550px;" value="<?=$viewRow['title'];?>"/></td>
    </tr>
	<?
		if($boardInfo["notice"]=="Y" || $boardInfo["secret"]=="Y"){
	?>
	<tr>
      <td class="tdl">선택사항</td>
      <td  class="tdr">
			<?if($boardInfo["notice"]=="Y"){?>
			<input type="checkbox" class="input_check fl mr5 mt2" name="notice" value="Y" <?=$NCheck?>/><span class="fl pl5 pt5 mr10">공지</span> 
			<?}?>
			<?if($boardInfo["secret"]=="Y"){?>
			<input type="checkbox" class="input_check fl mr5 mt2"  name="secret" value="Y" <?=$SCheck?> /><span class="fl pl5 pt5">비밀글</span>
			<?}?>
      </td>
    </tr>
	<?}?>
	<?if($bid!="BSC"){?>
	 <tr>
      <td class="tdl">패스워드</td>
      <td  class="tdr"><input  type="password" name="pass" class="input_text fl"  style="width:280px;" value="<?=$viewRow['pass']?>"/></td>
    </tr>
	<?}?>
     <tr>
      <td class="tdl"><?if($bid=="posit_photo3" || $bid=="posit_photo5"){?>수상자<?}else{?>작성자<?}?></td>
      <td  class="tdr"><input type="text" name="name" class="input_text fl mr5"  style="width:280px;" value="<?=$viewRow['name']?>"/></td>
    </tr>
	<?if($bid=="BSC"){?>
     <tr>
      <td class="tdl">분류</td>
      <td  class="tdr"><input type="text" name="subject" class="input_text fl mr5"  style="width:280px;" value="<?=$viewRow['subject']?>"/></td>
    </tr>
     <tr>
      <td class="tdl">부서명</td>
      <td  class="tdr"><input type="text" name="depart" class="input_text fl mr5"  style="width:280px;" value="<?=$viewRow['depart']?>"/></td>
    </tr>
     <tr>
      <td class="tdl">동영상링크</td>
      <td  class="tdr"><input type="text" name="video" class="input_text fl mr5"  style="width:550px;" value="<?=$viewRow['video']?>"/></td>
    </tr>
	<?}?>
     <tr>
      <td class="tdl"><?if($bid=="posit_photo3" || $bid=="posit_photo5"){?>수상일<?}else{?>작성일<?}?></td>
      <td  class="tdr">
		<input type="text"   name="regdate"   style="width:280px;"  class="input_text fl mr5" id="datepicker" value="<?=Date('Y-m-d',$viewRow['writedate']);?>">
		<input type="Hidden" name="writedate" value="<?=$viewRow['regdate'];?>">
      </td>
    </tr>
    <tr>
      <td class="tdl">내용</td>
      <td  class="tdr">
	  <textarea class="textarea_box" style="width:99%; height:200px;" name="contents" id="contents"><?=$viewRow['contents'];?></textarea>
		<script type="text/javascript">
			nhn.husky.EZCreator.createInIFrame({
				oAppRef: oEditors,
				elPlaceHolder: "contents",
				sSkinURI: "../../Seditor/SmartEditor2Skin.html",
				fCreator: "createSEditor3"
			});
		</script>
	  </td>
    </tr>
	<?if($bid=="BSC"){?>
    <tr>
	  <td class="tdl">썸네일 <br></td>
      <td  class="tdr">
		<input type="file" name="up_file[]" class="input_file mr5"  style="width:310px;" /><br><br>
		* 썸네일 이미지가 없을 시 아래 첨부파일의 이미지가 게시됩니다<br>
		* 권장 해상도 (284x163)<br>
		* 업로드 이미지 형식 : JPG, GIF, PNG<br>
	  </td>
	</tr>
	<?}?>
	<tr>
      <td class="tdl">첨부파일 </td>
      <td  class="tdr"><?=$FileList;?></td>
    </tr>
	
	<tr>
      <td class="tdl">파일 <br> <a href="#plus" onclick="javascript:File_plus(1);return false;">+</a> <a href="#minus"  onclick="javascript:File_plus(2);return false;" >-</a></td>
      <td  class="tdr">
	  	<?if($bid=="sec_photo5"):?>
			썸네일이미지<input type="file" name="up_file[]" class="input_file mr5"  style="width:310px;" /><br>
		<?endif;?>
		<input type="file" name="up_file[]" class="input_file mr5"  style="width:380px;" /><br><br>
		<div>* 다수의 파일은 압축하여 올려주시기 바랍니다.</div>
		<input type="hidden" name="minus" value="">
		<input type="hidden" name="cnt">
		<span id="file_plus">
	  </td>
    </tr>
	<?	}else{	?>
	<input type="Hidden" name="writedate" value="<?=date('Y-m-d');?>">
	<tr>
      <td class="tdl">분류</td>
      <td  class="tdr">
	  <select name="classValue">
		<option value="">분류를 선택하세요.</option>
		<?foreach ($_classValue as $key=>$val){?>
		<option value = "<?=$val?>" <?if($viewRow['classValue']==$val){?> selected<?}?>><?=$val?></option>
		<?}?>
	  </select>
	  </td>
    </tr>
	<tr>
      <td class="tdl"><?if($bid=="lecture_lec"){?>강연제목<?}else{?>제목<?}?></td>
      <td  class="tdr"><input type="text" name="title" class="input_text fl"  style="width:550px;" value="<?=$viewRow['title'];?>"/></td>
    </tr>
     <tr>
      <td class="tdl">강연자</td>
      <td  class="tdr"><input type="text" name="name" class="input_text fl mr5"  style="width:280px;" value="<?=$viewRow['name'];?>"/></td>
    </tr>
     <tr>
      <td class="tdl">기관</td>
      <td  class="tdr"><input type="text" name="organ" class="input_text fl mr5"  style="width:280px;" value="<?=$viewRow['organ'];?>"/></td>
    </tr>
     <tr>
      <td class="tdl">학과(소속)</td>
      <td  class="tdr"><input type="text" name="depart" class="input_text fl mr5"  style="width:280px;" value="<?=$viewRow['depart'];?>"/></td>
    </tr>
     <tr>
      <td class="tdl">강연일</td>
      <td  class="tdr"><input type="text" name="lecDate" class="input_text fl mr5"  style="width:180px;" value="<?=$viewRow['lecDate'];?>"/></td>
    </tr>
	<tr>
      <td class="tdl">강연지역</td>
      <td  class="tdr"><input type="text" name="region" class="input_text fl mr5"  style="width:180px;" value="<?=$viewRow['region'];?>"/></td>
    </tr>
	<tr>
      <td class="tdl">금과터강연영상보기</td>
      <td  class="tdr"><input type="text" name="siteUrl" class="input_text fl mr5"  style="width:550px;" value="<?=$viewRow['siteUrl'];?>"/></td>
    </tr>
	<?  }?>
  </tbody>
</table>
<div class="btn_tr pt20">
<div style="float:right">
 <button class="btn_type01" style="width:70px;" onclick="javascript:location.href='./board.php?idx=<?=$idx?>&page=<?=$page?>&bid=<?=$bid?>';return false;"><p><img src="../board/btn/write.png" /><strong>목록</strong></p></button>
	
	<button class="btn_type01" style="width:70px;"  onclick="javascript:Write_Chk();return false;"><p><img src="../board/btn/save.png" /><strong>작성</strong></p></button></div>
</div>
</form>