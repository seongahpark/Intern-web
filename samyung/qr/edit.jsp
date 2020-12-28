<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" 			prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" 	prefix="fn"%>
<%@ taglib uri="http://www.springframework.org/tags" 		prefix="spring" %>
<script type="text/javascript">

function move(){
	maskShow();
	var frm = document.move_form;
	frm.pgMode.value = 'index';
	frm.submit();
}

function update(frm){		
	var frm = document.write_form;
	if(!Val_Chk(frm.qrcdTitle,'제목')) return false;
	if(!SelectBox_Chk(frm.qrcdSize,'이미지 크기')) return false;
	if(!Val_Chk(frm.qrcdUrl,'URL')) return false;
	maskShow();
	frm.pgMode.value = 'update';
	frm.submit();
}

</script>
<div class="cont-top">
    <div class="cont-tit">
        <h2>QR코드 수정</h2>
    </div>
</div>

<div class="board_box mt20">

<form name="write_form" method="post" action="${pgmUrl }/update.do" onsubmit="return update(this);">
	<input type="hidden" name="asSeq" value="${viewRow.asSeq }" />
	<input type="hidden" name="pageIndex" 	value="${searchVo.pageIndex }" />
	<input type="hidden" name="pgMode" value="${searchVo.pgMode }" />
	<input type="hidden" name="nowUrl" 	value="${nowUrl }" />
	<input type="hidden" name="sv" 	 		value="${searchVo.sv }" />
	<input type="hidden" name="sw" 	 		value="${searchVo.sw }" />
	<input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
	<input type="hidden" name="qrcdSeq" value="${searchVo.qrcdSeq }"/>
	<div class="board-list-warp">
	<table class="tbl_form">
		<colgroup>
			<col style="width: 150px;"/>
			<col style="width: *"/>
		</colgroup>
		<tr>
			<th><span class="nec">제목</span></th>
			<td class="left">
				<input class="w300" type="text" id="qrcdTitle" name="qrcdTitle" title="제목" maxlength="30"  value="${viewRow.qrcdTitle }"/>
			</td>
		</tr>
		<tr>
			<th><span class="nec">이미지 크기</span></th>
			<td class="left">
				<select name="qrcdSize" class="select_box">
					<c:forEach var="i" begin="50" end="500">
						<c:if test="${i%50 eq 0 }">
							<option value="${i }" <c:if test="${viewRow.qrcdSize eq i }">selected="selected"</c:if>>${i } x ${i }</option>
						</c:if>
					</c:forEach>
				</select>
			</td>
		</tr>
		
		<tr>
			<th><span class="nec">URL</span></th>
			<td class="left">
				<input class="w300" type="text" id="qrcdUrl" name="qrcdUrl" title="URL"  maxlength="100" placeholder="http://" value="${viewRow.qrcdUrl }"/>
			</td>
		</tr>
	</table>
	<div class="board_btn">
	
	    <div class="fr">
			<button type="button" class="bp-btn" onclick="javascript:update();"><span>수정</span></button>
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
