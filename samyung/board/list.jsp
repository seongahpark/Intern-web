<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@ page import="egovframework.com.cmm.service.EgovProperties" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="ui" uri="http://egovframework.gov/ctl/ui"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" prefix="fn" %>
<%@ taglib uri="http://www.springframework.org/tags" 		prefix="spring" %>

<!-- board type 01--->
<table class="tbl-type01">
	<colgroup>
		<c:if test="${sessionScope.loginVO.siteManager=='Y'}">
			<col style="width: 50px" />
		</c:if>
		<col style="width: 70px" />
		<col style="width: *" />
		<col style="width: 100px" />
		<col style="width: 100px" />
		<col style="width: 110px" />
		<col style="width: 100px" />
		<col style="width: 100px" />
	</colgroup>
	<thead>
		<tr>
			<c:if test="${sessionScope.loginVO.siteManager=='Y'}">
				<th class="select_all"><input type="checkbox" name="achek" value="y" onclick="javascript:All_Check('list_form','delIdx',this)"></th>
			</c:if>
			<th>번호</th>
			<th>제목</th>
			<th>파일</th>
			<th>작성자</th>
			<th>작성일</th>
			<th>조회수</th>
			<th>게시여부</th>
		</tr>
	</thead>
	<tbody>
		<c:forEach var="list" items="${noticeResult}" varStatus="status">
			<tr>
				<c:if test="${sessionScope.loginVO.siteManager=='Y'}">
		    	   	<td class="select_ex">
		    	   		<input type="checkbox" name="delIdx" value="${list.idx}" />
		    	   	</td>
	    	   	</c:if>
	           	<td class="num"><img src="/share/cmm/img/icon_notice.jpg" class="vm" alt="공지글" /></td>
	           	<td style="text-align:left">
		           	<c:if test="${list.newiconFlag == 'Y' && list.newIconDay != 0}"><img src="/share/cmm/img/icon_new.gif" title="new" class="pt8"/></c:if>
		           	<a href="${nowUrl}&idx=${list.idx}&view=view&pageIndex=${pageIndex}&sv=${searchVo.sv}&sw=${searchVo.sw}" >${list.title}</a>
		           	<c:if test="${list.secret=='Y'}"><img src="/share/cmm/img/icon_secret.gif" title="비밀글" class="pt5"/></c:if>
	           	</td>
	           	<td class="file"><c:if test="${fn:length(list.files) != 0}"><img src="/share/cmm/img/file.gif" alt="첨부파일" /></c:if></td>
	           	<td class="writer">${list.name}</td>
	           	<td class="date">${fn:substring(list.regiDtm,0,10)}</td>
	           	<td class="visited">${list.visited}</td>
	           	<td>
	           		<c:if test="${list.viewYn eq 'Y' }">게시</c:if>
	           		<c:if test="${list.viewYn eq 'N' }">미게시</c:if>
	           	</td>
			</tr>
		</c:forEach>
		<c:forEach var="list" items="${resultList}" varStatus="status">
			<tr>
				<c:if test="${sessionScope.loginVO.siteManager=='Y'}">
		    	    <td class="select_ex">
			    	   	<c:choose>
			    	   		<c:when test="${list.reCnt==0}"><input type="checkbox" name="delIdx" value="${list.idx}" /></c:when>
			    	   		<c:otherwise>-</c:otherwise>
			    	   	</c:choose>
		    	    </td>
	    	    </c:if>
	            <td class="num"><c:out value="${boardVO.totalSize - ((boardVO.pageIndex-1) * boardVO.pageSize + status.count) + 1}"/></td>
	            <td style="text-align:left;padding-left:${list.reLevel*10 + 10}px">
		            <c:if test="${list.newiconFlag == 'Y' }"><img src="/share/cmm/img/icon_new.gif" title="new" class="pt8"/></c:if>
			         <c:if test="${list.reLevel>0}"><img src="/share/cmm/img/icon_re.gif" title="re" class="pt5"/></c:if>
			         	<a href="${nowUrl}&idx=${list.idx}&view=view&pageIndex=${pageIndex}&sv=${searchVo.sv}&sw=${searchVo.sw}" >${list.title}</a>
			         <c:if test="${list.comCnt > '0' }">[${list.comCnt }]</c:if>
		            <c:if test="${list.secret=='Y'}"><img src="/share/cmm/img/icon_secret.gif" title="비밀글" class="pt5"/></c:if>
	            </td>
	            <td class="file"><c:if test="${list.fcnt>0}"><img src="/share/cmm/img/file.gif" alt="첨부파일" /></c:if></td>
	            <td class="writer">${list.name}</td>
	            <td class="date">${fn:substring(list.regiDtm,0,10)}</td>
	            <td class="visited">${list.visited}</td>
	            <td>
	           		<c:if test="${list.viewYn eq 'Y' }">게시</c:if>
	           		<c:if test="${list.viewYn eq 'N' }">미게시</c:if>
	           	</td>
			</tr>
			
		</c:forEach>
		<c:if test="${fn:length(resultList) == 0 && fn:length(noticeResult) == 0}">
			<c:if test="${sessionScope.loginVO.siteManager=='Y'}">
				<td colspan="8">
					<c:if test="${searchVo.sw eq null}">
						<spring:message code="common.nodata.msg" />
					</c:if>
					<c:if test="${searchVo.sw ne null}">
						<spring:message code="common.nosearchresult.msg" />
					</c:if>
				</td>
			</c:if>
			<c:if test="${sessionScope.loginVO.siteManager!='Y'}">
				<td colspan="7">
					<c:if test="${searchVo.sw eq null}">
						<spring:message code="common.nodata.msg" />
					</c:if>
					<c:if test="${searchVo.sw ne null}">
						<spring:message code="common.nosearchresult.msg" />
					</c:if>
				</td>
			</c:if>
		</c:if>
	</tbody>
	</table>
