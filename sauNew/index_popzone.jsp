<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" 			prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" 	prefix="fn"%>
<%@ taglib uri="http://www.springframework.org/tags" 		prefix="spring" %>
<script type="text/javascript" src="/share/cmm/js/jquery/jqueryFromCheck.js"></script>
<script type="text/javascript">

//등록화면 이동
function create(){
	maskShow();
	var form = document.move_form;
	form.pgMode.value = "create";
	form.submit();
}

//수정화면 이동
function updatePage(popzoneSeq){
	maskShow();
	var form = document.move_form;
	form.popzoneSeq.value = popzoneSeq;
	form.pgMode.value = "edit";
	form.submit();
}

function deleteProc(popzoneSeq){
	if(confirm('삭제하시겠습니까?')){
		var form = document.search_form;
		form.delIdx.value = popzoneSeq;
		form.rtnPage.value ="${nowUrl}" + createGetParameterData("move_form");
		form.action = "${pgmUrl}/destory.do";
		form.submit();	
	}
}

//체크박스삭제
function chkDestory(){
	var frm = document.list_form;

	if(!All_Check_Num(frm,'delIdx',1,'팝업 ')) return;
	if(!confirm('팝업을 삭제하시겠습니까?')) return;

	<c:if test="${searchVo.totalSize % 10 eq 1 && searchVo.totalSize > 1}">
		frm.pageIndex.value = frm.pageIndex.value -1;
	</c:if>

	frm.rtnPage.value ="${nowUrl}" + createGetParameterData("move_form");

	frm.action = "${pgmUrl}/destory.do";
	frm.method="post";

	frm.submit();
}

//검색 
function searchProc(){
	maskShow();
	var form = document.search_form;
	form.pgMode.value = "index";
	form.pageIndex.value = 1;
	form.submit();
}

</script>
<div class="cont-top">
    <div class="cont-tit">
        <h2>팝업존 관리</h2>       	
    </div>
</div>

<div class="board_box mt20">
<p style="padding:20px 0; color:blue; font-weight:bold">팝업존 최소 이미지 사이즈는 580 * 380입니다. (580 너비보다 작을시 강재로 확대되어 흐려짐)<br>고해상도 기기를 위해 권장사이즈는 2배인 1160 * 760입니다. (레티나, 4k 모니터 고려)</p>
<form name="search_form" method="get" action="${nowUrl }" onsubmit="return search(this);">
	<input type="hidden" name="pageIndex"	value="${searchVo.pageIndex }" />
	<input type="hidden" name="pgMode"		value="${searchVo.pgMode }" />
	<input type="hidden" name="no" 			value="${nowKey }" />
	<input type="hidden" name="rtnPage"		value="${nowUrl }" />
	<input type="hidden" name="delIdx" />
	<div class="board-search">
		<div class="search">
			<select name="sv" class="select_box">
				<option value="TITLE" <c:if test="${searchVo.sv eq 'TITLE'}">selected="selected"</c:if>>제목</option>
        	</select>
	        <input type="text" name="sw" value="${searchVo.sw}" onkeypress="if(event.keyCode==13) {searchProc();}" class="search_text"  title="검색어입력"/>
	        <button onclick="javascript:searchProc();">검색</button>
		</div>
		
	</div>
</form>
<form name="list_form" method="post" action="">
	<input type="hidden" name="pageIndex"	value="${searchVo.pageIndex }" />
	<input type="hidden" name="pgMode"		value="${searchVo.pgMode }" />
	<input type="hidden" name="rtnPage" 	value="" />
	<span class="bd-line"></span>
	<table class="tbl-type01">
		<colgroup>
			<col style="width: 60px"/>
			<col style="width: 70px" />
			<col style="width: 150px" />
			<col style="width: 200px" />
			<col style="width: *" />
			<col style="width: 150px" />
		</colgroup>
		<thead>
			<tr>
				<th class="select_all"><input type="checkbox" name="achek" value="y" onclick="javascript:All_Check('list_form','delIdx',this)"></th>
				<th>노출순서</th>
				<th>이미지</th>
				<th>링크주소</th>
				<th>제목</th>
				<th>관리</th>
			</tr>
		</thead>
		<tbody>
			<c:forEach var="vo" items="${resultList }" varStatus="status">
				<tr>
					<td><input type="checkbox" class="vm" name="delIdx" title="삭제" value="${vo.popzoneSeq}" /></td>
					<td>${vo.sortSeq }</td>
<%-- 				<td>${vo.pgmFileId }</td> --%>
					<!-- <td><img id="module-img" src="${imgPath }${vo.FILE_SAVE_NM}.${vo.FILE_EXT}" /></td> -->
					<td> <img src="/cmm/file/setFile.do?fidx=${vo.pgmFileId}&fseq=0"  alt="이미지" style="width: 50px;"/>
					<!-- <img id="module-img" src="/img/WC_PGM_POPZONE/${vo.fileSaveNm}.${vo.fileExt}" style="width: 50px;"/> -->
					</td>
					<td>${vo.linkUrl }</td>
					<td style="padding-left:20px;" class="left">${vo.title }</td>
					<td>
						<input class="cp-btn" onclick="javascript:updatePage('${vo.popzoneSeq}'); return false;" type="button" value="수정" title="수정" class="small cyan">
						<input class="cdp-btn" onclick="javascript:deleteProc('${vo.popzoneSeq}'); return false;" type="button" value="삭제" title="삭제" class="small black" />
					</td>
				</tr>
			</c:forEach>
			<c:if test="${fn:length(resultList) eq 0 }">
				<tr>
					<td colspan="7">
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
		<div class="fl">
			<button type="button" class="bg-btn" onclick="javascript:chkDestory();"><span>삭제</span></button>
	    </div>

	    <div class="fr">
			<button type="button" class="bdp-btn" onclick="javascript:create();"><span>등록</span></button>
	    </div>
	   
	</div>
	<div class="board_page">
	${pagingView }
	</div>
</form>
</div>


<form name="move_form" method="get" action="${nowUrl }">
	<input type="hidden" name="pageIndex" 	value="${searchVo.pageIndex }" />
	<input type="hidden" name="pgMode" 	 	value="${searchVo.pgMode }" />
	<input type="hidden" name="sv" 	 		value="${searchVo.sv }" />
	<input type="hidden" name="sw" 	 		value="${searchVo.sw }" />
	<input type="hidden" name="rtnPage" 	value="${nowUrl }" />
	<input type="hidden" name="no" 			value="${nowKey }" />
	<input type="hidden" name="popzoneSeq" />
</form>
