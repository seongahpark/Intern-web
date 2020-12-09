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
	    <th><span>일자</span></th>
	    <td colspan="2"><input type="text" name="session_date" id="datepicker" title="세션명"/></td>
	</tr>
	<tr>
	    <th><span>세션종류</span></th>
	    <td colspan="2"> <input type="text" name="session_kind" title="세션종류" placeholder="국문 100자, 영문 200자 이내 입력" style="width:100%"/></td>
	</tr>

	<tr>
	    <th rowspan="2"><span>시간</span></th>
		<td><span>시작시간&nbsp;&nbsp;</span><input type="text" name="session_time" title="시작시간"/></td>
		<td rowspan="2" style="width:400px;">
			<span>* 시간은 24시간 표시 방식으로 시간 2자리 분 2자리 정수 입력</span>
			<span>&nbsp;&nbsp;예시) 오후 4시 30분 => 16:30</span>
		</td>
	</tr>
		<tr>
		<td><span>종료시간&nbsp;&nbsp;</span><input type="text" name="session_end_time" title="종료시간"/></td>
	</tbody>
    </table>
</div>


<!-- kor, eng, jpn, chi 입력 구간 -->
<div class="gap"></div>
<div class="board-view-wrap">
	<span class="bd-line"></span>
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
				     <input type="text" name="title_kor" title="세션명" placeholder="국문 100자, 영문 200자 이내 입력" style="width:100%"/>
				  </td>
			  </tr>
			   <tr>
				  <th><span>Youtube 주소</span></th>
				  <td><input type="text" name="video_kor" title="유튜브 주소" style="width:100%"/></td>
			  </tr>
			  <tr>
				  <th><span>세션 소개글</span></th>
				  <td>
				  <textarea name="explain_kor" title="세션 소개글" placeholder="국문 500자, 영문 1000자 이내 입력" style="width:100%; height: 100px; resize: none;"></textarea></td>
			  </tr>
			  <tr>
			  	<th colspan="2"><span>연사정보</span></td>
			  </tr>
			  <tr>
				  <th><span>좌장</span></th>
				  <td><input type="text" name="place_kor" title="좌장" style="width:100%;"/></td>
			  </tr>
			  <tr>
				  <th><span>기조연설</span></th>
				  <td>
						<textarea rows="3" name="speech_kor" title="기조연설" style="width:100%; resize: none;"></textarea>
				  </td>
			  </tr>
			  <tr>
				  <th><span>세션기조</span></th>
				  <td>
						<textarea rows="5" name="keynote_kor" title="세션기조" style="width:100%; resize: none;"></textarea>
				  </td>
			  </tr>
			  <tr>
				  <th><span>발제자</span></th>
				  <td>
						<textarea rows="5" name="present_kor" title="발제자" style="width:100%; resize: none;"></textarea>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론좌장</span></th>
				  <td>
						<input type="text" name="panel_kor" title="토론좌장" style="width:100%;"/>
				  </td>
			  </tr>
			  <tr>
				  <th><span>토론자</span></th>
				  <td>
						<textarea rows="5" name="panelist_kor" title="토론자" style="width:100%; resize: none;"></textarea>
				  </td>
			  </tr>
			  </tbody>
			</table>
		</div>
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
