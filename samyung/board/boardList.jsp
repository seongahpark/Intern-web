<%@ page language="java" contentType="text/html; charset=UTF-8"  pageEncoding="UTF-8"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="ui" uri="http://egovframework.gov/ctl/ui"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" prefix="fn" %>
<script type="text/javascript" src="/cmm/js/form.js"></script>

<script type="text/javascript">
	function downFile(fidx, idx){
		var form = document.board_form;
		form.action     = "/base/portal/${langType}/downFile.do";
		form.fidx.value = fidx;
		form.idx.value = idx;
		form.method = "get";
		form.submit();
	}
	//페이지 이동
	function linkPage(no){
		maskShow();
		var form = document.search_form;
		form.pageIndex.value = no;
		form.submit();
	}
</script>
<div class="boardLst">
    <table>
        <caption>
            <span class="blind">리스트입니다</span>
        </caption>
        <colgroup>
            <col width="10%" class="m-none">
            <col width="*" class="m-none">
            <col width="8%" class="m-none">
            <col width="8%" class="m-none">
            <col width="8%" class="m-none">
        </colgroup>
        <thead>
        <tr>
            <th class="m-none">번호</th>
            <th class="m-none">제목</th>
            <th class="m-none">첨부파일</th>
            <th class="m-none">등록일</th>
            <th class="m-none">조회수</th>
        </tr>
        </thead>
        <tbody>
        <c:forEach var="vo" items="${noticeResult }" varStatus="status">
	        <tr class="notice">
	      	<c:if test="${vo.viewYn == 'Y'}">
	            <td class="m-none"><span class="fe fe-bell"></span></td>
	            <td class="m-title l"><a href="${nowUrl}&idx=${vo.idx}&view=view&pageIndex=${pageIndex}&sv=${searchVo.sv}&sw=${searchVo.sw}" class="title">${vo.title }</a></td>
	            <td class="m-none">
	                <div class="board_file_area">
                    	<c:if test="${fn:length(vo.files) > 0 }">
		                    <a href="#board_file" class="board_file"><span class="fe fe-file"></span> <span class="blind">첨부파일</span></a>
		                    <div class="board_file_over">
			                    	<ul>
								        <c:forEach var="files" items="${vo.files}">
											<c:if test="${binfo.boardType ne '0040' }"> <!-- 재무정보 아님-->
												<li><span class="txt">${files.fileRealNm}</span><a onclick="javascript:downFile(${files.fidx}, ${vo.idx });" style="cursor:pointer;" class="down"><span class="fe fe-download"></span><span class="blind">다운로드</span></a></li>
											</c:if>
										</c:forEach>
									</ul>
		                    <a href="#board_file_close" class="board_file_close"><span class="fe fe-x"></span> <span class="blind">첨부파일 목록 닫기</span></a>
		                    </div>
						</c:if>
	                </div>
	            </td>
	            <td class="m-date">${vo.regiDtm }</td>
	            <td class="m-none">${vo.visited }</td>
	        </c:if>
	        </tr>
        </c:forEach>
        <c:forEach var="list" items="${resultList }" varStatus="i">
	        <tr>
	        	
	            <td class="m-none">${boardVO.totalSize - ((boardVO.pageIndex-1) * boardVO.pageSize + i.count) + 1 }</td>
	            <td class="m-title l"><a href="${nowUrl}&idx=${list.idx}&view=view&pageIndex=${pageIndex}&sv=${searchVo.sv}&sw=${searchVo.sw}" class="title">${list.title }</a></td>
	            <td class="m-none">
	                <div class="board_file_area">
	                    <c:if test="${fn:length(list.files) > 0 }">
		                    <a href="#board_file" class="board_file"><span class="fe fe-file"></span> <span class="blind">첨부파일</span></a>
		                    <div class="board_file_over">
		                    	<ul>
							        <c:forEach var="files" items="${list.files}">
										<c:if test="${binfo.boardType ne '0040' }"> <!-- 재무정보 아님-->
											<li><span class="txt">${files.fileRealNm}</span><a onclick="javascript:downFile(${files.fidx}, ${list.idx });" style="cursor:pointer;" class="down"><span class="fe fe-download"></span><span class="blind">다운로드</span></a></li>
										</c:if>
									</c:forEach>
								</ul>
		                    <a href="#board_file_close" class="board_file_close"><span class="fe fe-x"></span> <span class="blind">첨부파일 목록 닫기</span></a>
		                    </div>
						</c:if>
	                </div>
	            </td>
	            <td class="m-date">${list.regiDtm }</td>
	            <td class="m-none">${list.visited }</td>
	        </tr>
        </c:forEach>
        
        </tbody>
    </table>
</div>

${pagingView }



<form name="board_form" method="post" action="${nowUrl }">
<input type="hidden" name="siteId"  	value="${siteId}">
<input type="hidden" name="boardId" 	value="${boardInfo.boardId}" />
<input type="hidden" name="nowUrl" 		value="${nowUrl}" />
<input type="hidden" name="pageIndex"	value="${pageIndex}" />
<input type="hidden" name="no" 			value="${nowKey}" />
<input type="hidden" name="idx" 		value="${result.idx}" />
<input type="hidden" name="delIdx" 		value="${result.idx}" />
<input type="hidden" name="template" 	value="${template}" />
<input type="hidden" name="fidx" value="0" /> 
<input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
</form>	


















