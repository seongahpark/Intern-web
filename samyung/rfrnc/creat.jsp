<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" 			prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" 	prefix="fn"%>
<%@ taglib uri="http://www.springframework.org/tags" 		prefix="spring" %>
<script type="text/javascript" src="/cmm/js/form.js"></script>
<script type="text/javascript" src="/cmm/js/EgovMultiFile.js" ></script>
<script type="text/javascript" src="/cmm/js/jquery/jqueryFromCheck.js"></script>
<script type="text/javascript">

function move(){
	maskShow();
	var frm = document.move_form;
	frm.pgMode.value = 'index';
	frm.submit();
}

function store(frm){		
	
	if(!Val_Chk(frm.srcFstSv,'1차 분류')) return false;
	if(frm.srcFstSv.value != '1' && frm.srcFstSv.value == '6' && frm.srcFstSv.value == '7'){
		if(!Val_Chk(frm.srcScdSv,'2차 분류')) return false;
	}
	if(!Val_Chk(frm.srcPrdNm,'제품명')) return false;
	if(!Val_Chk(frm.version,'버전')) return false;
	//if(!Val_Chk(frm.up_file,'첨부파일')) return false;
	if(!Val_Chk(frm.viewYn,'게시여부')) return false;
	var fileChk = document.getElementById("egovComFileUploader").value;
	if(!fileChk) {
		alert("첨부파일을 업로드해주세요.");
		return false;
	}
	maskShow();
	frm.pgMode.value = 'store';
}

function changeScd(){
	maskShow();
	
	var bunryuSeq = document.write_form.srcFstSv.value;
	if(bunryuSeq == '1' || bunryuSeq == '6' || bunryuSeq == '7'){
		changePrdNm(bunryuSeq);
	}
	
	// ajax의 경우 아래와 같이 beforeSend 항목 추가
	$.ajax({
			url : '${pgmUrl}/selectBunryuAjax.do',
			data : {
				bunryuSeq : bunryuSeq
			},
			dataType : "json",
			type : 'POST',
			beforeSend : function(xhr)
		 {   /*데이터를 전송하기 전에 헤더에 csrf값을 설정한다*/
		     xhr.setRequestHeader("${_csrf.headerName}", "${_csrf.token}");
		 },
			success : function(res) {
				var result = res.result;
				var length = result.length;
				var selSrcScdSv = '${viewRow.bunryuSeq}';
				var selected = '';

				if(length > 0){
					$("#scd_sv").html("<option value='null'>2차 분류 선택</option>");
					for(var i = 0; i < length; i++){
						$("#scd_sv").append("<option value='"+result[i].bunryuSeq+"' " + selected + ">"+result[i].bunryuNm+"</option>");
						selected = '';
					}
					$("#prd_nm").html("<option value=''>제품명 선택</option>");
				}else{
					$("#scd_sv").html("<option value='null'>2차 분류 선택</option>");
				}
			}
		}); 
	maskHide();
}

function changePrdNm(bunryuSeq){

	if(bunryuSeq == '1' || bunryuSeq == '6' || bunryuSeq == '7'){
		// 1번 6번 7번은 2차분류 없으니까..
	}else{
		bunryuSeq = bunryuSeq;
	}

	maskShow();
	
	//var bunryuSeq = document.write_form.srcScdSv.value;	
	/*
	if(bunryuSeq == ''){
		bunryuSeq = '${viewRow.bunryuSeq}';
		console.log("seq null: "+bunryuSeq);
	}
	*/
	
	// ajax의 경우 아래와 같이 beforeSend 항목 추가
	$.ajax({
			url : '${pgmUrl}/selectProductNmAjax.do',
			data : {
				bunryuSeq : bunryuSeq,
				langType : '${searchVo.langType}'
			},
			dataType : "json",
			type : 'POST',
			beforeSend : function(xhr)
			 {   /*데이터를 전송하기 전에 헤더에 csrf값을 설정한다*/
			     xhr.setRequestHeader("${_csrf.headerName}", "${_csrf.token}");
			 },
			success : function(res) {

				var result = res.result;
				var length = result.length;

				if(length > 0){
					var selSrcPrdSeq = '${viewRow.prdSeq}';
					var selected = '';
					
					$("#prd_nm").html("<option value=''>제품명 선택</option>");

					for(var i = 0; i < length; i++){
						$("#prd_nm").append("<option value='"+result[i].prdSeq+"' " + selected + ">"+result[i].prdNm+"</option>");
						selected = '';
					}
				}else{
					$("#prd_nm").html("<option value=''>제품명 선택</option>");
				}
			}
		}); 
	maskHide();
}
 // ajax의 경우 아래와 같이 beforeSend 항목 추가
//  	$.ajax({
// 		url : '/base/boss/sample/store.do',
// 		data : {
// 			seq: seq
// 		},
// 		dataType : "json",
// 		type : 'POST',
// 		beforeSend : function(xhr)
//         {   /*데이터를 전송하기 전에 헤더에 csrf값을 설정한다*/
//             xhr.setRequestHeader("${_csrf.headerName}", "${_csrf.token}");
//         },
// 		success : function(res) {
			
// 		}
//  	});
</script>
<div class="cont-top">
    <div class="cont-tit">
        <h2>${menuType } 등록</h2>
    </div>
</div>

<div class="board_box mt20">

<!-- enctype="multipart/form-data" 인 경우 .do 뒤에 csrf 추가 -->
<!-- 박성아 첨부파일 업로드 유무 확인 추가 -->
<%--<form name="write_form" method="post" action="${pgmUrl }/store.do" onsubmit="return store(this);">--%>

 <form name="write_form" method="post" action="${pgmUrl }/store.do?${_csrf.parameterName}=${_csrf.token}" onsubmit="return store(this);" enctype="multipart/form-data"> 
	<input type="hidden" name="posblAtchFileNumber" value="10"/>
	 <input type="hidden" name="pgMode" value="${searchVo.pgMode }" />
	 <input type="hidden" name="nowUrl" 	value="${nowUrl }" />
	 <input type="hidden" name="langType" 	 		value="${searchVo.langType }" />
	 <input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
	<div class="board-list-warp">
	<span class="bd-line"></span>
	<table class="tbl-basic1">
		<colgroup>
			<col style="width: 150px;"/>
			<col style="width: *"/>
			
		</colgroup>
		<tr>
			<th>* 구분</th>
			<td class="left">
				<c:choose>
					<c:when test="${searchVo.srcMenuType eq 'S' }">
						<label><input type="radio" id="rfrncType" name="rfrncType" title="구분"   value="001" checked/> 소프트웨어</label>&ensp;
					</c:when>
					<c:when test="${searchVo.srcMenuType eq 'M' }">
						<label><input type="radio" id="rfrncType" name="rfrncType" title="구분"   value="002" checked/> 카탈로그</label>&ensp;
						<label><input type="radio" id="rfrncType" name="rfrncType" title="구분"   value="003"/> 사용자 매뉴얼</label>&ensp;
						<label><input type="radio" id="rfrncType" name="rfrncType" title="구분"   value="004"/> 간편 매뉴얼</label>&ensp;
					</c:when>
					<c:when test="${searchVo.srcMenuType eq 'C' }">
						<label><input type="radio" id="rfrncType" name="rfrncType" title="구분"   value="005" checked /> 인증서</label>&ensp;
					</c:when>
					<c:when test="${searchVo.srcMenuType eq 'G' }">
						<label><input type="radio" id="rfrncType" name="rfrncType" title="구분"   value="006" checked /> 해도</label>&ensp;
					</c:when>
					<c:otherwise>
						<label><input type="radio" id="rfrncType" name="rfrncType" title="구분"   value="007" checked /> 소비자가격표</label>
					</c:otherwise>
				</c:choose>
			</td>
		</tr>
		<tr>
			<th>* 관련 제품</th>
			<td class="left">
				<select name="srcFstSv" class="select_box" onchange="javascript:changeScd();">
					<option value="">1차 분류 선택</option>
					<c:forEach var="vo" items="${bunryuList}" varStatus="status">
						<c:if test="${vo.upBunryuNo  eq '0'}">
							<option value="${vo.bunryuSeq }" <c:if test="${searchVo.srcFstSv eq vo.bunryuSeq }"> selected = "selected" </c:if> > ${vo.bunryuNm }</option>
						</c:if>
					</c:forEach>
				</select> 
				
				<select name="srcScdSv" id="scd_sv" class="select_box" onchange="javascript:changePrdNm(this.value);">
					<option value="">2차 분류 선택</option>
					<c:forEach var="vo" items="${bunryuList}" varStatus="status">
							<option value="${vo.bunryuSeq }" <c:if test="${searchVo.srcScdSv eq vo.bunryuSeq }"> selected = "selected" </c:if> > ${vo.bunryuNm }</option>
					</c:forEach>
				</select>
				
				<select name="srcPrdNm" id="prd_nm" class="select_box">
					<option value="">제품명</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>* Version</th>
			<td class="left">
				<input class="w500" type="text" id="version" name="version" title="버전"   value="" maxlength="10"/>
			</td>
		</tr>
		<tr>
			<th>내용</th>
			<td class="left">
				<input class="w500" type="text" id="rfrncTxt" name="rfrncTxt" title="내용"   value="" maxlength="255"/>
			</td>
		</tr>
		<tr>
			<th>언어</th>
			<td class="left">
				<input class="w500" type="text" id="rfrncLang" name="rfrncLang" title="언어"   value="" maxlength="50"/>
			</td>
		</tr>
			<tr>
			<th>해당지역</th>
			<td class="left">
				<input class="w500" type="text" id="region" name="region" title="지역"   value="" maxlength="10"/>
			</td>
		</tr>
		<tr>
			<th>메모</th>
			<td class="left">
				<input class="w500" type="text" id="rfrncMemo" name="rfrncMemo" title="메모"   value="" maxlength="255"/>
			</td>
		</tr>
		<tr>
			<th>* 첨부파일</th>
			<td class="left" id="fileInput">
				<input type="file" name="up_file" id="egovComFileUploader" title="첨부파일"  class="w500"/>
			</td>
		</tr>
		<tr>
				<th>첨부파일 목록</th>
				<td id="egovComFileList" colspan="3" class="left"></td>
		</tr>
		<tr>
			<th>* 게시여부</th>
			<td class="left">
				<label><input type="radio" id="viewYn1" name="viewYn" title="게시여부" value="Y" checked> 게시</label>&ensp;
				<label><input type="radio" id="viewYn2" name="viewYn" title="게시여부" value="N"> 미게시</label>
			</td>
		</tr>
		
	</table>
	<div class="board_btn">
	
	    <div class="fr">
			<button type="submit" class="bdp-btn"><span>저장</span></button>
			<button type="button" class="bw-btn" onclick="javascript:move();"><span>목록</span></button>
	    </div>
	   
	</div>
</div>
</form>
 
</div>

<form name="move_form" method="post" action="${nowUrl }">
	<input type="hidden" name="pageIndex" 	value="${searchVo.pageIndex }" />
	<input type="hidden" name="pgMode" value="${searchVo.pgMode }" />
	<input type="hidden" name="sv" 	 		value="${searchVo.sv }" />
	<input type="hidden" name="sw" 	 		value="${searchVo.sw }" />
	<input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
</form>
<script type="text/javascript">
   var maxFileNum = document.write_form.posblAtchFileNumber.value;
   if(maxFileNum==null || maxFileNum==""){
     maxFileNum = 1;
    }   
   
   var multi_selector = new MultiSelector( document.getElementById( 'egovComFileList' ), maxFileNum );
   multi_selector.addElement( document.getElementById( 'egovComFileUploader' ) );			
 </script>