<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" 			prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" 	prefix="fn"%>
<%@ taglib uri="http://www.springframework.org/tags" 		prefix="spring" %>
<script type="text/javascript" src="/cmm/js/qrcode.js" ></script>
<script type="text/javascript">
 

//상세화면 이동
function show(qrcdSeq){
	maskShow();
	var frm = document.move_form;
	frm.qrcdSeq.value = qrcdSeq;
	frm.pgMode.value = 'show';
	frm.submit();
}

//등록
function create(){
	maskShow();
	var frm = document.move_form;
	frm.pgMode.value = 'create';
	frm.submit();
}

//수정
function edit(qrcdSeq){
	maskShow();
	var frm = document.move_form;
	frm.qrcdSeq.value = qrcdSeq;
	frm.pgMode.value = 'edit';
	frm.submit();
}

//삭제
function destory(qrcdSeq){
	var frm = document.move_form;
	if(!confirm('정말 삭제 하시겠습니까?')) return;
	maskShow();
	frm.qrcdSeq.value = qrcdSeq;
	frm.action="${pgmUrl}/destory.do";
	frm.pgMode.value = 'destory';
	frm.submit();
}

//조회
function searchProc(){
	maskShow();
	var form = document.search_form;
	form.pageIndex.value = 1;
	form.submit();
}

//조회
function linkPage(pageIndex){
	maskShow();
	var form = document.search_form;
	form.pageIndex.value = pageIndex;
	form.submit();
}

$(document).ready(function(){
	$('.qrCode').each(function(){
		var qrcdSeq = $(this).parent().find('input[name=qrcdSeq]').val();
		var url = $(this).parent().find('input[name=qrcdUrl]').val();
		var title = $(this).parent().find('input[name=qrcdTitle]').val();
		if(url){
			var qrcode = new QRCode(document.getElementById("qr_" + qrcdSeq), {
				text : url,
				width : 30,
				height : 30,
				colorDrk : "#000000",
				colorLight : "#ffffff",
				correctLevel : QRCode.CorrectLevel.H
				//qr코드 오류복원능력(L->M->Q->H)
			});
		}
	});
	
	
	$('.pop-closed-btn').on('click', function(){
		$(this).parents('.pop-container').fadeOut();
	});
	
});

function openPop(url, size){
	alert("QR 팝업창에서 '마우스 우클릭 -> 다른 이름으로 저장하기'를 눌러주세요.");
	var size = size;
	var url = url;
	$('#qrCodeView').find('img').remove();
	var qrcode = new QRCode(document.getElementById("qrCodeView"), {
		text : url,
		width : size,
		height : size,
		colorDrk : "#000000",
		colorLight : "#ffffff",
		correctLevel : QRCode.CorrectLevel.H
		//qr코드 오류복원능력(L->M->Q->H)
	});
	//resizeWin();
	setTimeout( function(){ 
		//resizeWin(); 
	}, 100);
	$('#qrCode_pop').fadeIn();
}

//하위 코드 목록 팝업 호출 
/*
function showPop(url, size){
	var popSize = Number.parseInt(size);
	popSize = popSize + (popSize * 0.1);
	//var open = window.open('${pgmUrl}/showPop.do?size=' + size + '&url=' + url ,'qrPop','width=' + popSize + ',height=' + popSize + ',scrollbars=no');
	open.focus();
}*/

</script>
<div class="cont-top">
    <div class="cont-tit">
 		<h2>QR코드 관리</h2>
    </div>
</div>

<div class="board_box mt20">
	
	<form name="search_form" method="get" action="${nowUrl }" onsubmit="return search(this);">
		<input type="hidden" name="pageIndex" value="${searchVo.pageIndex }" />
		<input type="hidden" name="pgMode" value="${searchVo.pgMode }" />
		<input type="hidden" name="nowUrl" 	value="${nowUrl }" />
		<input type="hidden" name="no" 	value="${nowKey }" />
		<div class="board-search">
			<div class="search">
				<select name="sv" class="select_box">
				  <option value="QRCD_TITLE" <c:if test="${searchVo.sv eq 'A'}">selected="selected"</c:if>>제목</option>
				</select>
				<input type="text" name="sw" value="${searchVo.sw}" onkeypress="if(event.keyCode==13) {searchProc();}" class="search_text"  title="검색어입력"/>
				<button onclick="javascript:searchProc();">검색</button>
			</div>
			
		</div>
	</form>
	<div class="gap20"></div>
	<table class="tbl-type01">
		<colgroup>
			<col style="width: 80px" />
			<col style="width: 300px" />
			<col style="width: *" />
			<col style="width: 200px" />
			<col style="width: 250px" />
		</colgroup>
		<thead>
			<tr>
				<!-- <th class="select_all"><input type="checkbox" name="" value="y" onclick="javascript:All_Check('update_form','crtIdx',this);"></th> -->
				<th>번호</th>
				<th>제목</th>
				<th>URL</th>
				<th>등록일</th>
				<th>관리</th>
			</tr>
		</thead>
		<tbody>
			<c:forEach var="vo" items="${resultList}" varStatus="status">
				<tr>
					<%-- <td><input type="checkbox" name="qrcdIdx" value="${vo.qrcdSeq }"></td> --%>
					<td>${vo.listNum}</td>
					<td>
						<a href="#none" onclick="javascript:show('${vo.qrcdSeq }');">${vo.qrcdTitle }</a>
					</td>
					<td class="tl">
						<input type="hidden" name="qrcdSeq" value="${vo.qrcdSeq }" />
						<input type="hidden" name="qrcdUrl" value="${vo.qrcdUrl }" />
						<input type="hidden" name="qrcdTitle" value="${vo.qrcdTitle }" />
						<span class="qrCode fl" id="qr_${vo.qrcdSeq }"></span>
						${vo.qrcdUrl}
					</td>
					<td>${vo.regiDtm }</td>
					<td>
						<input class="cdp-btn popup-openbtn" onclick="javascript:openPop('${vo.qrcdUrl}', '${vo.qrcdSize }')" type="button" value="다운로드" title="다운로드">
						<input class="cp-btn"  onclick="javascript:edit('${vo.qrcdSeq }');" type="button" value="수정" title="수정">
		                <input class="cdg-btn" onclick="javascript:destory('${vo.qrcdSeq }');" type="button" value="삭제" title="삭제" />
					</td>
				</tr>
			</c:forEach>
			<c:if test="${fn:length(resultList) eq 0 }">
				<tr>
					<td colspan="5">
						<c:if test="${searchVo.sw eq null}">
							<spring:message code="common.nodata.msg" />
						</c:if>
						<c:if test="${searchVo.sw ne null}">
							<spring:message code="common.nosearchresult.msg" />
						</c:if>
					</td>
				</tr>
			</c:if>
		</tbody>
	</table>
	<div class="board_btn">
	
	    <div class="fr">
			<button type="button" class="bdp-btn" onclick="javascript:create();"><span>등록</span></button>
	    </div>
	   
	</div>
	<div class="board_page">
	${pagingView }
	</div>
</div>  
<form name="move_form" method="post" action="${nowUrl }">
	<input type="hidden" name="qrcdSeq" 	 		value="${searchVo.qrcdSeq }" />
	<input type="hidden" name="pageIndex" 	value="${searchVo.pageIndex }" />
	<input type="hidden" name="pgMode" value="${searchVo.pgMode }" />
	<input type="hidden" name="nowUrl" 	value="${nowUrl }" />
	<input type="hidden" name="no" 	value="${nowKey }" />
	<input type="hidden" name="sv" 	 		value="${searchVo.sv }" />
	<input type="hidden" name="sw" 	 		value="${searchVo.sw }" />
	<input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
</form>


<!-- 2020. 11. 13. 이현진 추가 -->
<div id="qrCode_pop" class="pop-container">
	<div class="rel-box">
		<div class="pop-contents">
			<div class="rel-box" id="qrCodeView">
				<!--<img src="../img/sub/img_noimage.gif" alt="test file">  -->

				<a href="#none" class="pop-closed-btn">
					<span class="blinde"></span>
				</a>
			</div>
		</div>
	</div><!-- rel-box :: e -->
</div><!-- pop-cont :: e -->

<style>	
	.pop-container#qrCode_pop {width: 100%; height: 100%; background: rgba(60, 64, 74, 0.9); position: fixed; left: 0; top: 0; z-index: 90; display: none;}
	.pop-container .rel-box {width: 100%; height: 100%; display: block; position: relative;}
	.pop-contents {position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);}
	.pop-contents .rel-box {padding: 60px 30px 30px 30px; background: #fff; text-align:center;}
	.pop-contents .rel-box:before {content:''; width:100%; height:50px; background:#20add6; position:absolute; top:0; left:0; display:block;}
	.pop-contents .rel-box img {margin:10px auto 0 auto;}
	.pop-closed-btn {display:block; position:absolute; top:12px; right:15px; transform:rotate(45deg);}
	.pop-closed-btn span {width: 25px; height: 25px; position: relative; display: block; top: 0; left: 0; opacity: 1; text-indent: -99999px;}
	.pop-closed-btn span:before {content:''; width:100%; height:1px; background:#fff; display:block; position:absolute; top:50%; left:0; transform:translateY(-50%);}
	.pop-closed-btn span:after {content:''; width:1px; height:100%; background:#fff; display:block; position:absolute; top:0; left:50%; transform:translateX(-50%);}
</style>