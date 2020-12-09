<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/07_Session/inc/subHead.php');?>
<?php
	//활성화 되어있는 연도만 출력

	$parameter = "admin_type=".$_GET["admin_type"];

	$list_url = "./SessionList.php?".$parameter;

	$modi_data_result = Select_Query("session","*","where idx='".$_GET["idx"]."'");	
	$modi_data_row = mysql_fetch_array($modi_data_result);

	$modi_kor_data_result = Select_Query("session_kor","*","where idx='".$_GET["idx"]."'");
	$modi_kor_data_row = mysql_fetch_array($modi_kor_data_result);
	
	$modi_eng_data_result = Select_Query("session_eng","*","where idx='".$_GET["idx"]."'");
	$modi_eng_data_row = mysql_fetch_array($modi_eng_data_result);

	$modi_jpn_data_result = Select_Query("session_jpn","*","where idx='".$_GET["idx"]."'");
	$modi_jpn_data_row = mysql_fetch_array($modi_jpn_data_result);

	$modi_chi_data_result = Select_Query("session_chi","*","where idx='".$_GET["idx"]."'");
	$modi_chi_data_row = mysql_fetch_array($modi_chi_data_result);
	
	//select 박스에서 기존에 설정해둔 연도는 출력 안하기 위함
	$getQuery = "select year from session_year where validate='Y' and year != '".$modi_data_row["year"]."'";
	$res = mysql_query($getQuery, $conn);	
?>
<!--// page start -->
<h3 class="u-tit02">관리자 정보변경</h3>
<!-- <p class="info-ex">회원등록시 회원그룹을 선택해주시기 바랍니다.</p> -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
  <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="jqueryui/style.css">
<script>
 $(document).ready(function() { // 언어별 TAB 메뉴
	$(".tab_cont > li").hide();		
	$(".tab_cont > li").eq(0).show();
   $(".tab_btn li").click(function() {
     var list = $(this).index();
     $(".tab_btn li").removeClass("on");
     $(this).addClass("on");
     $(".tab_cont > li").hide();
     $(".tab_cont > li").eq(list).show();
   });
 });

   $(function() { // datepicker로 날짜폼 적용
    $( "#datepicker" ).datepicker( {dateFormat: "yy-mm-dd"});
  });

	function add_form_check(){
		//필수 입력사항 알아서 해당 항목 추가하기
		var form = document.add_form;
	
		if(!Val_Chk(form.session_date,'일자'))	return false;
		if(!Val_Chk(form.session_time,'시간')) return false;

		form.submit();
	}

	function del_Chk(form){
		var form = document.del_form;
		var msg = confirm('정말 삭제하시겠습니까?');
		if(msg==true){
			form.submit();
		}
	}
</script>

<div class="board-view-wrap">
<span class="bd-line"></span>
<form name="add_form" action="update.php?" method="post">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>"/>
    <table>
		  <colgroup>
			  <col width="180">
			  <col width="*"> 
			  <col width="180">
			  <col width="*"> 
		  </colgroup>
	<tbody>
	<tr>
		<th><span>년도</span></th>
		<td>		
		<select name='session_year' class='select' style="width:100px">
			<option value = "<?=$modi_data_row["year"]?>"><?=$modi_data_row["year"]?></option>
			<?
				while($row = mysql_fetch_row($res)){
					echo "<option value = '".$row[0]."'>".$row[0]."</option>";
				}
			?>
		</select>
		</td>
		<!--활성화 된 연도만 갖고 올 수 있도록-->
	</tr>
	<tr>
	    <th><span>세션종류</span></th>
	    <td>
		<select name="session_kind" class="select" style="width:100px; height:27px;" value="<?=$modi_data_row["kind"]?>">
			<option value = "개막&기조">개막&기조</option>
			<option value = "정규세션1">정규세션1</option>
			<option value = "정규세션2">정규세션2</option>
			<option value = "정규세션3">정규세션3</option>
			<option value = "정규세션4">정규세션4</option>
			<option value = "폐막식">폐막식</option>
		</select> 			
	    </td>
	</tr>
	<tr>
	    <th><span>일자</span></th>
	    <td><input type="text" name="session_date" id="datepicker" value="<?=$modi_data_row["date"]?>"/></td>
	</tr>
	<tr>
	    <th><span>시간</span></th>
	    <td><input type="text" name="session_time" value="<?=$modi_data_row["time"]?>"/></td>
	</tr>
	</tbody>
    </table>
</div>


<!-- kor, eng, jpn, chi 입력 구간 -->
<div class="gap"></div>
<div class="u-tab03">
<ul class="tab_btn">
	<li class="on"><a href="#tabContent01"><span>KOR</span></a></li>
	<li><a href="#tabContent02"><span>ENG</span></a></li>
	<li><a href="#tabContent03"><span>JPN</span></a></li>
	<li><a href="#tabContent04"><span>CHI</span></a></li>
</ul>
</div>
<div class="board-view-wrap">
	<span class="bd-line"></span>
	<ul class="tab_cont">
	<li>
		<!-- KOR 입력 구간 -->
		<div id="tabContent01" class="tabPage">
		<table>
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			  <col width="180">
			  <col width="*"> 
			  <col width="180">
			  <col width="*"> 
		  </colgroup>
		  <tbody>
			  <tr>
				  <th><span>세션명</span></th>
				  <td colspan="3">
				     <input type="text" name="title_kor" value="<?=$modi_kor_data_row["title"]?>"/>
				  </td>
			  </tr>
			   <tr>
				  <th><span>유튜브주소</span></th>
				  <td><input type="text" name="video_kor" value="<?=$modi_kor_data_row["video"]?>" /></td>
			  </tr>
			  <tr>
				  <th><span>세션 소개글</span></th>
				  <td colspan="3"><input type="text" name="explain_kor" value="<?=$modi_kor_data_row["text"]?>"/></td>
			  </tr>
			  <tr>
				  <th><span>좌장</span></th>
				  <td><input type="text" name="place_kor" value="<?=$modi_kor_data_row["place"]?>"/></td>
				  
			  <tr>
				  <th><span>세션기조</span></th>
				  <td colspan="3">
						<input type="text" name="keynote_kor" value="<?=$modi_kor_data_row["keynote"]?>"class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>발제자</span></th>
				  <td colspan="3">
						<input type="text" name="present_kor" value="<?=$modi_kor_data_row["present"]?>" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론좌장</span></th>
				  <td colspan="3">
						<input type="text" name="panel_kor" value="<?=$modi_kor_data_row["panel"]?>" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론자</span></th>
				  <td colspan="3">
						<input type="text" name="panelist_kor" value="<?=$modi_kor_data_row["panelist"]?>" class="w40p"/>
				  </td>
			  </tr>
			  </tbody>
			</table>
		</div>
	</li>
	<li>
		<!-- ENG 입력 구간 -->
		<div id="tabContent02" class="tabPage">
		<table>
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			  <col width="180">
			  <col width="*"> 
			  <col width="180">
			  <col width="*"> 
		  </colgroup>
		  <tbody>
			  <tr>
				  <th><span>Session Name</span></th>
				  <td colspan="3">
				     <input type="text" name="title_eng" value="<?=$modi_eng_data_row["title"]?>"/>
				  </td>
			  </tr>
			   <tr>
				  <th><span>Youtube Link</span></th>
				  <td><input type="text" name="video_eng" value="<?=$modi_eng_data_row["video"]?>" /></td>
			  </tr>
			  <tr>
				  <th><span>Session Introduction</span></th>
				  <td colspan="3"><input type="text" name="explain_eng" value="<?=$modi_eng_data_row["text"]?>"/></td>
			  </tr>
			  <tr>
				  <th><span>Place</span></th>
				  <td><input type="text" name="place_eng" value="<?=$modi_eng_data_row["place"]?>" /></td>
				  
			  <tr>
				  <th><span>Session Keynote</span></th>
				  <td colspan="3">
						<input type="text" name="keynote_eng" value="<?=$modi_eng_data_row["keynote"]?>"class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>Presenter</span></th>
				  <td colspan="3">
						<input type="text" name="present_eng" value="<?=$modi_eng_data_row["present"]?>" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>Forum Hall</span></th>
				  <td colspan="3">
						<input type="text" name="panel_eng" value="<?=$modi_eng_data_row["panel"]?>" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>Debater</span></th>
				  <td colspan="3">
						<input type="text" name="panelist_eng" value="<?=$modi_eng_data_row["panelist"]?>" class="w40p"/>
				  </td>
			  </tr>
			  </tbody>
			</table>
		</div>
	</li>
	<li>
		<!-- JPN 입력 구간 -->
		<div id="tabContent03" class="tabPage">
		<table>
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			  <col width="180">
			  <col width="*"> 
			  <col width="180">
			  <col width="*"> 
		  </colgroup>
		  <tbody>
			  <tr>
				  <th><span>セッション名</span></th>
				  <td colspan="3">
				     <input type="text" name="title_jpn" value="<?=$modi_jpn_data_row["title"]?>"/>
				  </td>
			  </tr>
			   <tr>
				  <th><span>유튜브주소</span></th>
				  <td><input type="text" name="video_jpn" value="<?=$modi_jpn_data_row["video"]?>" /></td>
			  </tr>
			  <tr>
				  <th><span>세션 소개글</span></th>
				  <td colspan="3"><input type="text" name="explain_jpn" value="<?=$modi_jpn_data_row["text"]?>"/></td>
			  </tr>
			  <tr>
				  <th><span>좌장</span></th>
				  <td><input type="text" name="place_jpn" value="<?=$modi_jpn_data_row["place"]?>" /></td>
				  
			  <tr>
				  <th><span>세션기조</span></th>
				  <td colspan="3">
						<input type="text" name="keynote_jpn" value="<?=$modi_jpn_data_row["keynote"]?>"class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>발제자</span></th>
				  <td colspan="3">
						<input type="text" name="present_jpn" value="<?=$modi_jpn_data_row["present"]?>" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론좌장</span></th>
				  <td colspan="3">
						<input type="text" name="panel_jpn" value="<?=$modi_jpn_data_row["panel"]?>" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론자</span></th>
				  <td colspan="3">
						<input type="text" name="panelist_jpn" value="<?=$modi_jpn_data_row["panelist"]?>"class="w40p"/>
				  </td>
			  </tr>
			  </tbody>
			</table>
		</div>
	</li>
	<li>
		<!-- CHI 입력 구간-->
		<div id="tabContent04" class="tabPage">
		<table>
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			  <col width="180">
			  <col width="*"> 
			  <col width="180">
			  <col width="*"> 
		  </colgroup>
		  <tbody>
			  <tr>
				  <th><span>Session名</span></th>
				  <td colspan="3">
				     <input type="text" name="title_chi" value="<?=$modi_chi_data_row["title"]?>"/>
				  </td>
			  </tr>
			   <tr>
				  <th><span>유튜브주소</span></th>
				  <td><input type="text" name="video_chi" value="<?=$modi_chi_data_row["video"]?>" /></td>
			  </tr>
			  <tr>
				  <th><span>세션 소개글</span></th>
				  <td colspan="3"><input type="text" name="explain_chi" value="<?=$modi_chi_data_row["text"]?>"/></td>
			  </tr>
			  <tr>
				  <th><span>좌장</span></th>
				  <td><input type="text" name="place_chi" value="<?=$modi_chi_data_row["place"]?>" /></td>
				  
			  <tr>
				  <th><span>세션기조</span></th>
				  <td colspan="3">
						<input type="text" name="keynote_chi" value="<?=$modi_chi_data_row["keynote"]?>" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>발제자</span></th>
				  <td colspan="3">
						<input type="text" name="present_chi" value="<?=$modi_chi_data_row["present"]?>" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론좌장</span></th>
				  <td colspan="3">
						<input type="text" name="panel_chi" value="<?=$modi_chi_data_row["panel"]?>" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론자</span></th>
				  <td colspan="3">
						<input type="text" name="panelist_chi" value="<?=$modi_chi_data_row["panelist"]?>" class="w40p"/>
				  </td>
			  </tr>
			  </tbody>
			</table>
		</div>
	</li>
	</form>
</div>
	<div class="gap"></div>
	<div class="fl">
		<form name="del_form" action="del.php?idx=<?=$_GET["idx"]?>" method="post">
			<!--<input type="hidden" name="idx" value="<?=$_GET["idx"]?>"/>-->
			<a href="#none" onclick="javascript:del_Chk();" class="bdp-btn"><span>삭제</span></a>
		</form>
	</div>
	<div class="fr">
		<button class="bp-btn" onclick="javascript:add_form_check();"><span>수정</span></button>
		<button class="bw-btn" onclick="location.href='<?=$list_url?>'"><span>목록</span></button>
	</div>
</div>
<div class="gap"></div>
<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>
