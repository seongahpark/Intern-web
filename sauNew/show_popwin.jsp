<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" 			prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" 	prefix="fn"%>
<%@ taglib uri="http://www.springframework.org/tags" 		prefix="spring" %>
<head>
<link rel="icon" type="image/png" href="http://example.com/myicon.png">
</head>
<script type="text/javascript">


//목록화면 이동
function move(){
	maskShow();
	var form = document.move_form;
	form.pgMode.value = "index";
	form.submit();
}

//수정화면 이동
function edit(){
	maskShow();
	var form = document.move_form;
	form.pgMode.value = "edit";
	form.submit();
}

//삭제 처리
function destory(id){
	if(confirm('삭제하시겠습니까?')){
		maskShow();
		var form = document.move_form;
		form.action="${pgmUrl}/destory.do?no=" + ${nowKey};
		form.submit();	
	}
}


function downFile(pgmFileId, pgmFileSeq){
	var form = document.file_form;
	form.pgmFileId.value = pgmFileId;
	form.pgmFileSeq.value = pgmFileSeq;
	form.action 	= "/cmm/file/downFileImg.do";
	form.submit();
}

</script>
<div class="cont-top">
    <div class="cont-tit">
        <h2>상세화면</h2>
    </div>
</div>

<div class="board_box mt20">

  
	<div class="board-list-warp">
		<span class="bd-line"></span>
		<table class="tbl-basic1">
			<colgroup>
				<col style="width: 150px;"/>
				<col style="width: 400px;"/>
				<col style="width: 150px;"/>
				<col style="width: *"/>
			</colgroup>
			<tr>
				<th><label for="title">팝업 명칭</label></th>
				<td colspan="3" class="left">${viewRow.title }</td>
<!-- 				<th><label for="sortSeq">순서</label></th> -->
<%-- 				<td class="left">${viewRow.sortSeq}</td> --%>
			</tr>
			<tr>
				<th><label for="startDt">시작일</label></th>
				<td class="left">
					${viewRow.startDt }
				</td>
				<th><label for="endDt">종료일</label></th>
				<td class="left">${viewRow.endDt }</td>
			</tr>
			<tr>
				<th><label for="xPos">좌표(X)</label></th>
				<td class="left">${viewRow.xPos }</td>
				<th><label for="yPos">좌표(Y)</label></th>
				<td  class="left">${viewRow.yPos }</td>
				
			</tr>
			<tr>
				<th><label for="linkUrl">링크 URL</label></th>
				<td colspan="3" class="left">${viewRow.linkUrl }</td>
			</tr>
			<tr>
<!-- 				<th><label for="linkType">링크형태</label></th> -->
<!-- 				<td class="left"> -->
<%-- 	<c:forEach var="item" items="${linkTypeList}" varStatus="status"> --%>
<%-- 				<c:if test="${item.sysCd eq viewRow.linkType }">${item.sysCdNm }</c:if> --%>
<%-- 	</c:forEach> --%>
<!-- 				</td> -->
				<th><label for="Y">노출여부</label></th>
				<td colspan="3" class="left">
					<c:choose>
						<c:when test="${viewRow.useYn eq 'Y'}">사용</c:when>
						<c:when test="${viewRow.useYn eq 'N'}">사용안함</c:when>
					</c:choose>
				</td>
			</tr>
<!-- 			<tr> -->
<!-- 				<th><label for="width">넓이</label></th> -->
<%-- 				<td class="left">${viewRow.width }</td> --%>
<!-- 				<th><label for="height">높이</label></th> -->
<%-- 				<td class="left">${viewRow.height }</td> --%>
<!-- 			</tr> -->
<!-- 			<tr> -->
<!-- 				<th><label for="xpsPos">노출위치</label></th> -->
<!-- 				<td colspan="3" class="left"> -->
<%-- 					<c:choose> --%>
<%-- 						<c:when test="${viewRow.xpsPos eq 'MAIN'}">메인</c:when> --%>
<%-- 						<c:when test="${viewRow.xpsPos eq 'MENU'}">메뉴(${viewRow.menuNm })</c:when> --%>
<%-- 					</c:choose> --%>
<!-- 				</td> -->
<!-- 			</tr> -->
			<tr>
				<th><label for="egovComFileUploader">첨부파일</label></th>
				<td class="left file" colspan="3">
					<input type="hidden" name="pgmFileId" value="${viewRow.pgmFileId }" />		
					<c:forEach var="files" items="${viewRow.flist }" varStatus="status">
<%-- 						<c:set var="fileUrl">/cmm/file/showFile.do?pgmFileId=${files.pgmFileId }&pgmFileSeq=${files.pgmFileSeq }</c:set> --%>
<%-- 						<img id="module-img" src="${fileUrl}" alt="${files.fileRealNm}" style="display: none;/> --%>
						
						<!-- ie 11 대응 -->
						<img src="/cmm/file/setFile.do?fidx=${files.pgmFileId}&fseq=${files.pgmFileSeq}"  alt="${files.fileRealNm}"/>
            			<!-- <img src="/img/${files.tgtTbl}/${files.fileSaveNm}.${files.fileExt}" alt="${files.fileRealNm}"/> --> 
            			<!-- <img id="module-img" src="/data${files.filePath}sample_${files.fileSaveNm}.${files.fileExt}" alt="${files.fileRealNm}"/>  -->
						<br />
						<a href="#none" onclick="javascript:downFile('${files.pgmFileId }', ${files.pgmFileSeq});">${files.fileRealNm}</a>
					</c:forEach> 
				</td>
			</tr>
			<tr>
				<th><label for="cnts">내용</label></th>
				<td class="left" colspan="3">${viewRow.cnts }</td>
			</tr>
		</table> 
		<div class="board_btn">
		    <div class="fr">
				<button type="button" class="bg-btn" onclick="javascript:destory();"><span>삭제</span></button>
				<button type="button" class="bp-btn" onclick="javascript:edit();"><span>수정</span></button>
				<button type="button" class="bw-btn" onclick="javascript:move();"><span>목록</span></button>
		    </div>
		   
		</div>
	</div> 
 
</div>

<form name="move_form" method="post" action="${nowUrl }">
	<input type="hidden" name="popwinSeq" 	value="${viewRow.popwinSeq }" />
	<input type="hidden" name="delIdx" value="${viewRow.popwinSeq }"/>
	<input type="hidden" name="pageIndex" 	value="${searchVo.pageIndex }" />
	<input type="hidden" name="pgMode" 		value="${searchVo.pgMode }" />
	<input type="hidden" name="sv" 	 		value="${searchVo.sv }" />
	<input type="hidden" name="sw" 	 		value="${searchVo.sw }" />
	<input type="text" name="rtnPage"		value="${nowUrl}"/>
</form>

<form name="file_form" method="post" action="/cmm/file/downFile.do">
	<input type="hidden" name="siteId"  	value="${siteId}">
	<input type="hidden" name="pgmFileId"	value="${viewRow.pgmFileId}" />
	<input type="hidden" name="pgmFileSeq"	value="" />
	<input type="hidden" name="rtnPage"		value="${nowUrl}&popwinSeq=${viewRow.popwinSeq }&pgMode=show"/>
	<input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
</form>
