@extends('layouts.manager')

@section('content')

<div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">강좌관리 > 기간관리 </a> </div>
    <h1>기간관리 > 수정</h1>
 </div>

<div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      	<div class="alert alert-info alert-block mt10"> <a class="close" data-dismiss="alert" href="#">×</a>
			<p>- 기간에 속해있는 강좌들 중 <span class="badge badge-success">등록</span> <span class="badge badge-success">개설</span> 상태인 강좌가 있는경우 하단에 강좌목록이 보여집니다.</p>
			<p>- 선택한 강좌들은 수정내용이 반영 됩니다.</p>
		</div>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>기간관리 등록</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ route('ltrPrd.update',[$vo->PRD_SEQ, 'page' => $page, 'sw2' => $sw2, 'sw3' => $sw3]) }}" name="ltrPrd_form" id="ltrPrd_form" novalidate="novalidate"  >
              {{ method_field('PUT') }}
              @csrf
              <input type="hidden" id="mAltrReqStartHour" value="{{ substr($vo->ALTR_REQ_START_DT,11,2) }}"/>
              <!-- input type="hidden" id="mAltrReqStartMin" value="{{ substr($vo->ALTR_REQ_START_DT,14,2) }}"/ !-->         
              <input type="hidden" id="mAltrReqEndHour" value="{{ substr($vo->ALTR_REQ_END_DT,11,2) }}"/>
              <!--<input type="hidden" id="mAltrReqEndMin" value="{{ substr($vo->ALTR_REQ_END_DT,14,2) }}"/>-->
  			  <input type="hidden" name="prdSeq" id="prdSeq" value="{{ $vo->PRD_SEQ }}" />
  			  <input type="hidden" name="ltrSeq" id="ltrSeq" value="" />
  			  
              <div class="control-group">
                <label class="control-label"><i class="icon-asterisk"></i>강좌년도</label>
                <div class="controls">
                  <select name="ltrYear" id="ltrYear" style="width:110px;">
                  		<option value="">선택하세요</option> 
						@for($i = 0 ; $i < count($yearArr) ; $i++)
							<option value="{{ $yearArr[$i] }}" @if( $vo->LTR_YEAR == $yearArr[$i] ) selected="selected" @endif >{{ $yearArr[$i] }}학년도</option> 
						@endfor	
                  </select>
                  {!! $errors->first('ltrYear', '<span class="alert alert-danger">:message</span>') !!}
                </div>
              </div>
              <div class="control-group">
                <label class="control-label"><i class="icon-asterisk"></i>기간명</label>
                <div class="controls">
 					<input type="text" name="prdNm" value="{{ $vo->PRD_NM }}" title="기간명" style="width:230px;"/>
 					{!! $errors->first('prdNm', '<span class="alert alert-danger">기간명을 입력해 주세요</span>') !!}
                </div>
              </div>
              <div class="control-group">
                <label class="control-label"><i class="icon-asterisk"></i>운영기간</label>
                <div class="controls">
                	<input type="text" name="oprtStartDt" id="oprtStartDt" title="시작일을 입력해주세요" placeholder="시작일" data-date="0000-00-00" data-date-format="yyyy-mm-dd" value="{{ substr($vo->OPRT_START_DT,0,10) }}" class="datepicker span11 center small calendar wd_100" readonly/>                   
                  <span style="padding:0 10px 0 10px"> ~ </span>
                  <input type="text" name="oprtEndDt" id="oprtEndDt" title="종료일을 입력해주세요" placeholder="종료일" data-date="0000-00-00" data-date-format="yyyy-mm-dd" value="{{ substr($vo->OPRT_END_DT,0,10) }}" class="datepicker span11 center small calendar wd_100" readonly/>                 
                  {!! $errors->first('oprtStartDt', '<span class="alert alert-danger">운영 시작일을 입력해주세요</span>') !!}
                  {!! $errors->first('oprtEndDt', '<span class="alert alert-danger">운영 종료일을 입력해주세요</span>') !!}
                </div>
              </div>
              <div class="control-group">
                <label class="control-label"><i class="icon-asterisk"></i>수강신청기간</label>
                <div class="controls">
                	<input type="text" name="altrReqStartDt" id="altrReqStartDt" title="시작일을 입력해주세요" placeholder="시작일" data-date="0000-00-00" data-date-format="yyyy-mm-dd" value="{{ substr($vo->ALTR_REQ_START_DT,0,10) }}" class="datepicker span11 center small calendar wd_100" readonly/>
                 
                  <select class="wd_120" name="altrReqStartHour" id="altrReqStartHour" style="width:100px;">
                    <option value="">시간선택</option>
                    @for($i = 9 ; $i < 24 ; $i++)                    
                  		<option value="{{ str_pad( $i, 2, '0', STR_PAD_LEFT) }}">{{ $i }}시</option>
                    @endfor          	
                  </select>
                  <!-- 
                  <select class="wd_120" name="altrReqStartMin" id="altrReqStartMin"  style="width:100px">
                    <option value="">분선택</option>
                    @for($i = 0 ; $i < 60 ; $i = $i + 10)
                    		<option value="{{ str_pad( $i, 2, "0", STR_PAD_LEFT) }}">{{ $i }}분</option>                    
                    @endfor   
                  </select>
                   -->
                  <span style="padding:0 10px 0 10px"> ~ </span>

					<input type="text" name="altrReqEndDt" id="altrReqEndDt" title="종료일을 입력해주세요" placeholder="종료일" data-date="0000-00-00" data-date-format="yyyy-mm-dd" value="{{ substr($vo->ALTR_REQ_END_DT,0,10) }}" class="datepicker span11 center small calendar wd_100" readonly/>
                 
                  
                  <select class="wd_120" name="altrReqEndHour" id="altrReqEndHour"  style="width:100px;">
                    <option value="">시간선택</option>
                    @for($i = 9 ; $i < 24 ; $i++)
                   	 <option value="{{ str_pad( $i, 2, '0', STR_PAD_LEFT) }}">{{ $i }}시</option>
                    @endfor       
                  </select>
                  <!--
                  <select class="wd_120" name="altrReqEndMin" id="altrReqEndMin"  style="width:100px">
                    <option value="">분선택</option>
                   	@for($i = 0 ; $i < 60 ;  $i = $i + 10)
                   	 <option value="{{ str_pad( $i, 2, "0", STR_PAD_LEFT) }}">{{ $i }}분</option>       
                    @endfor   
                  </select>
                   -->
                </div>
              </div>
              <div class="control-group">
                <label class="control-label"><i class="icon-asterisk"></i>기간마감 여부</label>
                <!-- 201005 박성아 운영기간 마감된 강좌 자동으로 마감되도록 수정  -->
                <!-- 일단 수정 버튼을 눌렀을 때 기간이 지난 강의면 자동으로 yes에 체크되도록 설정 -->
                <?php $nowh = date("Y-m-d");   ?>
                @if($vo->OPRT_END_DT < $nowh)
                	<!-- <p>마감되었습니다</p> -->
                	<?php $vo->PRD_CLOSE_YN = 'Y'; ?>
                @else
                	<!-- <p>마감 전 입니다</p> -->
                @endif
                <!-- 201005 박성아 수정구간  -->
                <div class="controls">
                	<label><input type="radio" name="prdCloseYn" value="Y" @if( $vo->PRD_CLOSE_YN == 'Y' ) checked="checked" @endif />예</label>
                	<label><input type="radio" name="prdCloseYn" value="N" @if( $vo->PRD_CLOSE_YN == 'N' ) checked="checked" @endif />아니오</label>
                	<span class="c_blue">*기간마감이면 해당기간에 등록된 강좌들은 수정/삭제가 불가능 합니다.</span>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label c_red"><i class="icon-asterisk"></i>회계생성월</label>
                <div class="controls">
                	<!-- 전체 선택체크를 숨겨달라는 요청이 있어 숨김(2020-02-17 조정은) -->
                	<!-- <label class="badge fl"><input type="checkbox" name="ltrAmtPayMonthCheckAll" id="ltrAmtPayMonthCheckAll" />전체선택&nbsp;&nbsp;</label> -->
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth3" value="3" @if( in_array(3,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />3월&nbsp;&nbsp;</label>
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth4" value="4" @if( in_array(4,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />4월&nbsp;&nbsp;</label>
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth5" value="5" @if( in_array(5,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />5월&nbsp;&nbsp;</label>
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth6" value="6" @if( in_array(6,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />6월&nbsp;&nbsp;</label>
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth7" value="7" @if( in_array(7,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />7월&nbsp;&nbsp;</label>
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth8" value="8" @if( in_array(8,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />8월&nbsp;&nbsp;</label>
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth9" value="9" @if( in_array(9,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />9월&nbsp;&nbsp;</label>
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth10" value="10" @if( in_array(10,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />10월&nbsp;&nbsp;</label>
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth11" value="11" @if( in_array(11,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />11월&nbsp;&nbsp;</label>
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth12" value="12" @if( in_array(12,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />12월&nbsp;&nbsp;</label>
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth1" value="1" @if( in_array(1,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />1월&nbsp;&nbsp;</label>
                	<label class="fl"><input type="checkbox" name="ltrAmtPayMonth[]" id="ltrAmtPayMonth2" value="2" @if( in_array(2,$vo->LTR_AMT_PAY_MONTH)) checked="checked" @endif />2월&nbsp;&nbsp;</label>
                	{!! $errors->first('ltrAmtPayMonth', '<span class="alert alert-danger">회계생성월을 선택해주세요</span>') !!}
                </div>
              </div>
               <div class="control-group" >
                <label class="control-label"></label>
                <div class="controls">
                	{!! $errors->first('altrReqStartDt', '<span class="alert alert-danger">수강신청 시작일을 입력해주세요</span>') !!}
                	{!! $errors->first('altrReqStartHour', '<span class="alert alert-danger">수강신청 시작시간(시)을 입력해주세요</span>') !!}
                </div>
                <div class="controls">                
                 	{!! $errors->first('altrReqEndDt', '<span class="alert alert-danger">수강신청 종료일을 입력해주세요</span>') !!}
                 	{!! $errors->first('altrReqEndHour', '<span class="alert alert-danger">수강신청 종료시간(시)을 입력해주세요</span>') !!}
                </div>
              </div>           

              <div class="form-actions">
                <button type="submit" value="Validate" class="btn btn-primary"><i class="icon-save"></i> 저장</button>
                <a href="{{ url('/ltr/ltrPrd?page='.$page.'&sw2='.$sw2.'&sw3='.$sw3) }}" class="btn btn-danger"><i class="icon-remove"></i> 취소</a>
              </div>
            </form>
          </div>
          @if(count($ltrList) > 0) 
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
           	<h5>강좌 목록</h5>
          </div>
          <div class="widget-content nopadding">
          	<table class="table">
          		<colgroup>
					<col width="60px" />
					<col width="100px" />
					<col width="250px" />
					<col width="100px" />
					<col width="100px" />
					<col width="100px" />
					<col width="150px" />
					<col width="100px" />
					
				</colgroup>
				<thead>
					<tr>
						<th><input type="checkbox" name="checkAll" id="checkAll" value="1" /></th>
						<th>학년도</th>
						<th>강좌명</th>
						<th>강좌분류</th>
						<th>강사명</th>
						<!-- 2020-05-28 조영혜선생님 삭제 요청 (조정은)
						<th>운영기간</th>
						<th>수강신청기간</th>  -->
						<th>신청/정원</th>
						<th>대상학년</th>
						<th>수강료</th> <!-- 2020-05-28 조영혜 선생님 추가 요청(조정은) -->
					</tr>
				</thead>
				<tbody>
						@for($i =0; $i < count($ltrList) ; $i++)
						<tr class="odd gradeX gradeC gradeA">
							<td class="center">
								<input type="checkbox" 	name="ltrSeqChk[]" value="{{ $ltrList[$i]->LTR_SEQ }}"/> 
							</td>
							<td class="center">{{ $ltrList[$i]->SCHL_YEAR }}</td>
							<td><!-- 2020-05-29 조영혜 선생님 요청으로 강좌 이름 클릭시 강좌 수정으로 이동하도록 (조정은) -->
								<a href="{{ route('ltrInfo.edit', [$ltrList[$i]->LTR_SEQ, 'page' => $page,'sw2' => $sw2, 'sw3'=>$sw3, 'ltrStSearch'=>$ltrList]) }}">
										{{ $ltrList[$i]->LTR_NM }}
								</a>
							</td>
							<td class="center">{{ $ltrList[$i]->LTR_DVSN_NM }}</td>
							<td class="center">{{ $ltrList[$i]->TCHR_NM }}</td>
							<!--2020-05-28 조영혜선생님 삭제 요청 (조정은) 
							<td class="center">{{ substr($ltrList[$i]->OPRT_START_DT,0,10) }} ~ {{ substr($ltrList[$i]->OPRT_END_DT , 0, 10)}}</td>
							<td class="center">{{ substr($ltrList[$i]->ALTR_REQ_START_DT,0,16) }} ~ {{substr($ltrList[$i]->ALTR_REQ_END_DT,0,16)}}</td>-->
							<td class="center">{{ $ltrList[$i]->ATND_CNT }}/{{$ltrList[$i]->MAX_PPL_NUM }}</td>
							<td class="center">{{ $ltrList[$i]->TGT_GRD }}</td>
							<td class="center commify">{{ $ltrList[$i]->ALTR_AMT }}</td><!-- 2020-05-28 조영혜 선생님 추가 요청(조정은) -->
						</tr>
						@endfor 
					
				</tbody>
          	</table>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">



//startㅡㅡㅡㅡ유효성검사
$("#oprtStartDt").focusout(function(){
	if($("#oprtEndDt").val() != ""  && $("#oprtEndDt").val() < $("#oprtStartDt").val()   ){
		alert("종료일은 시작일보다 앞에 있을 수 없습니다.");
		$("#oprtStartDt").datepicker('update', $("#oprtEndDt").val());
		return false;
	}	
});
$("#oprtEndDt").focusout(function(){
	if($("#oprtEndDt").val() != ""  && $("#oprtEndDt").val() < $("#oprtStartDt").val()   ){
		alert("종료일은 시작일보다 앞에 있을 수 없습니다.");
		$("#oprtEndDt").datepicker('update', $("#oprtStartDt").val());
		return false;
	}	
});

$("#altrReqStartDt").focusout(function(){
	if($("#altrReqEndDt").val() != ""  && $("#altrReqEndDt").val() < $("#altrReqStartDt").val()   ){
		alert("종료일은 시작일보다 앞에 있을 수 없습니다.");
		$("#altrReqStartDt").datepicker('update', $("#altrReqEndDt").val());
		return false;
	}		
	if( ($("#oprtEndDt").val() != "" && $("#oprtEndDt").val() != "") && $("#oprtEndDt").val() < $("#altrReqStartDt").val()   ){
		alert("운영이 종료되기 전에 수강신청이 종료되어야 합니다.");
		$("#altrReqStartDt").datepicker('update', $("#oprtStartDt").val());
		return false;
	}		
});
$("#altrReqEndDt").focusout(function(){
	if($("#altrReqStartDt").val() != ""  && $("#altrReqEndDt").val() < $("#altrReqStartDt").val()   ){
		alert("종료일은 시작일보다 앞에 있을 수 없습니다.");
		$("#altrReqEndDt").datepicker('update', $("#altrReqStartDt").val());
		return false;
	}
	if( ($("#oprtEndDt").val() != "" && $("#oprtEndDt").val() != "") && $("#oprtEndDt").val() < $("#altrReqEndDt").val()   ){
		alert("운영이 종료되기 전에 수강신청이 종료되어야 합니다.");
		$("#altrReqEndDt").datepicker('update', $("#oprtStartDt").val());
		return false;
	}			
});
//endㅡㅡㅡㅡ유효성검사
/*
$.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd',
        prevText: '이전 달',
        nextText: '다음 달',
        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        showMonthAfterYear: true,
        yearSuffix: '년',
        showOn : 'both',
        buttonImage : '/img/icons/32/calendar.png',
        buttonImageOnly : true
    });
    

$(function() {
  $( "#oprtStartDt" ).datepicker();
  $( "#oprtEndDt" ).datepicker();
  $( "#altrReqStartDt" ).datepicker();
  $( "#altrReqEndDt" ).datepicker();
});
*/


/*2020-05-28 조정은
	조영혜 선생님 요청 : 기간 수정->저장시에 해당 기간에 속해있는 강좌가 모두 똑같이 변경되게 해달라 (저장될때 전체 일괄 변경)
	-> 기존 이용자들이 혼돈이 있을 수 있어 저장을 누를시에 전체 수정을 하는 것 말고 
	창을 불러올때 처음부터 전체 선택이 되어있을 수 있도록 수정
*/
window.onload = function(){
	$("#checkAll").prop("checked", true);
	var check = document.getElementsByName('ltrSeqChk[]');
	for(var i=0; i<check.length; i++){
		check[i].checked = true;
	}
	$.uniform.update();
}


$(document).ready(function(){
	
	//수강료 콤마찍기 (2020-05-28 추가 조정은)
	var cnt = $(".commify").length;	
	for(var i = 0 ; i < cnt ; i++){
		$(".commify:eq("+i+")").text(commify($(".commify:eq("+i+")").text()));
	}			
	
	$("#ltrAmtPayMonthCheckAll").change(function(){
	  if (! $('#ltrAmtPayMonthCheckAll').is(':checked')) {
		  $('input:checkbox[name^=ltrAmtPayMonth]').prop("checked", false);
	  } else {
		  $('input:checkbox[name^=ltrAmtPayMonth]').prop("checked", true);
	  }       
	  $.uniform.update();
	});
	
	
	$('.datepicker').datepicker({
		
	});
	
	//수강신청 시작에서 시간,분 DB값 넣기
	$("#altrReqStartHour").val($("#mAltrReqStartHour").val());
	//$("#altrReqStartMin").val($("#mAltrReqStartMin").val());
	$("#altrReqEndHour").val($("#mAltrReqEndHour").val());
	//$("#altrReqEndMin").val($("#mAltrReqEndMin").val());		

		
	$("#ltrPrd_form").validate({
		rules:{
			ltrYear :{
				required:true
			},
	    	prdNm:{
			    required: true,
			    maxlength:100
			},		  
			oprtStartDt:{
			    required: true
			},
			oprtEndDt:{
			    required: true
			},
			altrReqStartDt:{
			    required: true
			},
			altrReqStartHour:{
			    required: true
			},
			//altrReqStartMin:{
			//    required: true
			//},			
			altrReqEndDt:{
			    required: true
			},
			altrReqEndHour:{
			    required: true
			},
			//altrReqEndMin:{
			//    required: true
			//},
			'ltrAmtPayMonth[]':{
				required: true
			}
		},
		errorPlacement:function(error, element){
			 $("#modal-message").html(error);
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
      		$(element).parents('.control-group').removeClass('success');
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		},submitHandler : function(form){		

			var chk = document.getElementsByName('ltrSeqChk[]');
			var tag = [];
			var cnt = 0;
			for(var i=0 ; i<chk.length ; i++){
				if(chk[i].checked == true){
					tag[cnt] = chk[i].value;
					cnt++;
				}
			}

			var msg = '';

			if(cnt > 0){
				msg = cnt + '건의 강좌를 선택하셨습니다.\n선택한 강좌의 기간도 함께 수정됩니다.\n수정하시겠습니까?';
			}else{
				msg = '수정하시겠습니까?';
			}
			
			if(confirm(msg)){
				//startㅡㅡㅡㅡ유효성검사				
				// 운영기간 : 종료일은 시작일보다 앞에 있을 수 없습니다.
				if( $("#oprtEndDt").val() < $("#oprtStartDt").val() ){
					alert("종료일은 시작일보다 앞에 있을 수 없습니다.");
					$("#oprtStartDt").datepicker('update', $("#oprtEndDt").val());		
					return false;
				}					
				// 수강신청기간 : ( 날짜만 ) 종료일은 시작일보다 앞에 있을 수 없습니다.
				if( $("#altrReqEndDt").val() < $("#altrReqStartDt").val() ){
					alert("종료일은 시작일보다 앞에 있을 수 없습니다.");
					$("#altrReqStartDt").datepicker('update', $("#altrReqEndDt").val());
					return false;
				}
				// 수강신청기간 : ( 시간만 ) 종료시간은 시작시간보다 앞에 있을 수 없습니다		
				if( $("#altrReqStartDt").val() ==  $("#altrReqEndDt").val() ){
					if( $("#altrReqEndHour").val() < $("#altrReqStartHour").val()) {
// 					    ||
// 					    	( $("#altrReqEndHour").val() == $("#altrReqStartHour").val()  
// 						    	&& $("#altrReqStartMin").val() > $("#altrReqEndMin").val() ) )
						alert("종료시간은 시작시간보다 앞에 있을 수 없습니다.");
						//$("#altrReqStartMin").val("00");
						return false;				    	
					}   				
				}	
				// 운영이 시작되기 전에 수강신청이 종료되어야 합니다			
				if( $("#oprtEndDt").val() < $("#altrReqStartDt").val()   ){
					alert("운영이 종료되기 전에 수강신청이 종료되어야 합니다.");
					$("#altrReqStartDt").datepicker('update', $("#oprtEndDt").val());
					return false;
				}		
				//endㅡㅡㅡㅡ유효성검사			
				var frm = document.ltrPrd_form;
				frm.ltrSeq.value = tag;
					
				frm.submit();				
			}else{
				return false;
			} 						
			
		},
		invalidHandler: function(form, validator) {
			var errors = validator.numberOfInvalids();
			 
            if (errors) {
                alert(validator.errorList[0].message);
                validator.errorList[0].element.focus();
            }
		}
	});
});

</script>

@endsection
