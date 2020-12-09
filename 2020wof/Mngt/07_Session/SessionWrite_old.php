<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/07_Session/inc/subHead.php');?>
<?php
	include "../conn/conn.php";
	//활성화 되어있는 연도만 출력
	$getQuery = "select year from session_year where validate='Y'";
	$res = mysql_query($getQuery, $conn);

	$list_url = "./SessionList.php?".$parameter;
?>
<!--// page start -->
<h3 class="u-tit02">세션 등록</h3>
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
	var form = document.add_form;
	
	if(!Val_Chk(form.session_date,'일자'))	return false;
	if(!Val_Chk(form.session_time,'시간')) return false;

	form.submit();
}


</script>

<div class="board-view-wrap">
<span class="bd-line"></span>
<form name="add_form" action="insert.php?" method="post">
<input type="hidden" name="duplicate_check" />
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
		<!--<td><input type="text" name="session_year" title="년도"/></td>-->
		<!--활성화 된 연도만 갖고 올 수 있도록-->
		<td colspan="2">
		<select name='session_year' class='select' style="width:100px">
			<?
				while($row = mysql_fetch_row($res)){
					echo "<option value = '".$row[0]."'>".$row[0]."</option>";
				}
			?>
		</select>
		</td>
	</tr>
	<tr>
	    <th><span>세션종류</span></th>
	    <td colspan="2">
		<select name="session_kind" class="select" style="width:100px; height:27px;">
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
	    <td colspan="2"><input type="text" name="session_date" id="datepicker" title="세션명"/></td>
	</tr>
	<tr>
	    <th rowspan="2"><span>시간</span></th>
		<td><span>시작시간&nbsp;&nbsp;</span><input type="text" name="session_time" title="시작시간"/></td>
		<td rowspan="2" style="width:400px;">
			<span>* 시간은 24시간 표시 방식으로 시간 2자리 분 2자리 정수 입력</span>
			<span>&nbsp;&nbsp;예시) 오후 4시 30분 => 1630</span>
		</td>
	</tr>
		<tr>
		<td><span>종료시간&nbsp;&nbsp;</span><input type="text" name="session_end_time" title="종료시간"/></td>
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
				     <input type="text" name="title_kor" title="세션명"/>
				  </td>
			  </tr>
			   <tr>
				  <th><span>유튜브주소</span></th>
				  <td><input type="text" name="video_kor" title="유튜브 주소" /></td>
			  </tr>
			  <tr>
				  <th><span>세션 소개글</span></th>
				  <td colspan="3"><input type="text" name="explain_kor" title="세션 소개글"/></td>
			  </tr>
			  <tr>
				  <th><span>좌장</span></th>
				  <td><input type="text" name="place_kor" title="좌장" /></td>
				  
			  <tr>
				  <th><span>세션기조</span></th>
				  <td colspan="3">
						<input type="text" name="keynote_kor" title="세션기조" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>발제자</span></th>
				  <td colspan="3">
						<input type="text" name="present_kor" title="발제자" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론좌장</span></th>
				  <td colspan="3">
						<input type="text" name="panel_kor" title="토론좌장" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론자</span></th>
				  <td colspan="3">
						<input type="text" name="panelist_kor" title="토론자" class="w40p"/>
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
				     <input type="text" name="title_eng" title="세션명"/>
				  </td>
			  </tr>
			   <tr>
				  <th><span>Youtube Link</span></th>
				  <td><input type="text" name="video_eng" title="유튜브 주소" /></td>
			  </tr>
			  <tr>
				  <th><span>Session Introduction</span></th>
				  <td colspan="3"><input type="text" name="explain_eng" title="세션 소개글"/></td>
			  </tr>
			  <tr>
				  <th><span>Place</span></th>
				  <td><input type="text" name="place_eng" title="좌장" /></td>
				  
			  <tr>
				  <th><span>Session Keynote</span></th>
				  <td colspan="3">
						<input type="text" name="keynote_eng" title="세션기조" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>Presenter</span></th>
				  <td colspan="3">
						<input type="text" name="present_eng" title="발제자" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>Forum Hall</span></th>
				  <td colspan="3">
						<input type="text" name="panel_eng" title="토론좌장" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>Debater</span></th>
				  <td colspan="3">
						<input type="text" name="panelist_eng" title="토론자" class="w40p"/>
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
				     <input type="text" name="title_jpn" title="세션명"/>
				  </td>
			  </tr>
			   <tr>
				  <th><span>유튜브주소</span></th>
				  <td><input type="text" name="video_jpn" title="유튜브 주소" /></td>
			  </tr>
			  <tr>
				  <th><span>세션 소개글</span></th>
				  <td colspan="3"><input type="text" name="explain_jpn" title="세션 소개글"/></td>
			  </tr>
			  <tr>
				  <th><span>좌장</span></th>
				  <td><input type="text" name="place_jpn" title="좌장" /></td>
				  
			  <tr>
				  <th><span>세션기조</span></th>
				  <td colspan="3">
						<input type="text" name="keynote_jpn" title="세션기조" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>발제자</span></th>
				  <td colspan="3">
						<input type="text" name="present_jpn" title="발제자" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론좌장</span></th>
				  <td colspan="3">
						<input type="text" name="panel_jpn" title="토론좌장" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론자</span></th>
				  <td colspan="3">
						<input type="text" name="panelist_jpn" title="토론자" class="w40p"/>
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
				     <input type="text" name="title_chi" title="세션명"/>
				  </td>
			  </tr>
			   <tr>
				  <th><span>유튜브주소</span></th>
				  <td><input type="text" name="video_chi" title="유튜브 주소" /></td>
			  </tr>
			  <tr>
				  <th><span>세션 소개글</span></th>
				  <td colspan="3"><input type="text" name="explain_chi" title="세션 소개글"/></td>
			  </tr>
			  <tr>
				  <th><span>좌장</span></th>
				  <td><input type="text" name="place_chi" title="좌장" /></td>
				  
			  <tr>
				  <th><span>세션기조</span></th>
				  <td colspan="3">
						<input type="text" name="keynote_chi" title="세션기조" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>발제자</span></th>
				  <td colspan="3">
						<input type="text" name="present_chi" title="발제자" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론좌장</span></th>
				  <td colspan="3">
						<input type="text" name="panel_chi" title="토론좌장" class="w40p"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론자</span></th>
				  <td colspan="3">
						<input type="text" name="panelist_chi" title="토론자" class="w40p"/>
				  </td>
			  </tr>
			  </tbody>
			</table>
		</div>
	</li>
	</form>
</div>
	<div class="gap"></div>
	<div class="fr">
		<button class="bpc-btn" onclick="javascript:add_form_check();"><span>저장</span></button>
		<button class="bw-btn" onclick="location.href='<?=$list_url?>'"><span>목록</span></button>
	</div>
</div>
<div class="gap"></div>
<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>
