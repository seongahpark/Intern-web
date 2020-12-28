<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" prefix="fn" %>
<table class="write_01" summary="게시판글쓰기 폼으로 각 해당하는 항목에 알맞게 내용을 입력해주세요">
       <caption>게시판 글쓰기 입력폼</caption>
       <colgroup>
         <col width="15%" />
         <col width="85%" />
       </colgroup>
       <tbody> 
       	 <c:if test="${ binfo.flagNotice==true}">
       	 <tr>
          	  <th class="pd_no">공지글</th>
            <td>
            	<input type="checkbox" class="vm" <c:if test="${result.notice=='Y'}">checked="checked"</c:if> name="notice" id="notice" value="Y" title="공지글"/>
            	<label for="notice">공지글사용</label>
            </td>
          </tr>
         </c:if>
        
         <c:if test="${binfo.periodUse=='Y' || binfo.boardType=='REQUEST'}">
         <tr>
          	 <th class="pd_no">기간</th>
             <td>
             	<input type="text" name="sdate" value="${result.sdate }" class="input_text datepicker tc"  style="width:100px" title="시작일" />
             	~
             	<input type="text" name="edate" value="${result.edate }" class="input_text datepicker tc"  style="width:100px;" title="종료일" />
             </td>
         </tr>
         </c:if>
         <tr>
          	<th class="pd_no">작성자</th>
            <td>
            	 
            	<c:choose>
             		<c:when test="${sessionScope.loginVO.name==null || sessionScope.loginVO.name==''}">
             		<input type="text" name="name" value="${result.name}" class="input_text"  style="width:120px;" title="작성자를 입력해주세요"/>	
             		</c:when>
             		<c:otherwise>
             		${sessionScope.loginVO.name}
             		</c:otherwise>
             	</c:choose>
             	
            </td>
          </tr>
            	<c:if test="${binfo.flagManager eq true}">
          <tr>
          	<th class="pd_no">노출 여부</th>
          	<td class="check"><input type="checkbox" name="temporary" value="1" title="선택" />체크시 글이 비노출상태가 됩니다.</td>
          </tr>
            	</c:if>
          <tr>
             <th class="pd_no">핸드폰번호</th>
             <td>
             	<input type="text" name="etc1" value="${result.etc1}" class="input_text" style="width:50%;" title="핸드폰번호를 입력해주세요"/>
             </td>
          </tr>
           <tr>
             <th class="pd_no">이메일</th>
             <td>
             	<input type="text" name="etc2" value="${result.etc2}" class="input_text" style="width:50%;" title="이메일을 입력해주세요"/>
             </td>
          </tr>
          <tr>
          	  <th class="pd_no">제목</th>
            <td>
            	<input type="text" name="title" value="${result.title}" class="input_text" style="width:500px;"title="제목을 입력해주세요"/>
            </td>
          </tr>
           
          <tr>
             <th class="pd_no">내용</th>
             <td><textarea  id="edit_contents" name="contents" title="내용을 입력해주세요" style="width:99%; height:300px">${result.contents}</textarea>
             </td>
          </tr>
           
           <tr>
             <th class="pd_no"> 파일첨부</th>
             <td>
             	 <c:forEach var="files" items="${files}" varStatus="i">
		         <p class="file">파일 : 
		         	<a href="#none" onclick="javascript:downFile(${files.fidx});">${files.realName}</a>
		         	<a href="#none" onclick="javascript:deleteFile(${files.fidx})">파일삭제</a>
		         </p>
		         </c:forEach>
		         <c:if test="${binfo.fileNum > 0}">
	             <p><input type="file" name="up_file" id="egovComFileUploader" title="파일을 선택해주세요"/></p>
	             </c:if>
             </td>
          </tr>
         <c:if test="${binfo.fileNum > 0}">
         <tr>
             <th class="pd_no">첨부목록</th>
             <td id="egovComFileList"></td>
         </tr>
         </c:if>
         <c:if test="${sessionScope.loginVO.name==null || sessionScope.loginVO.name=='' || binfo.secretUse=='Y'}">
         <tr>
             <th class="pd_no">비밀번호</th>
             <td>
             <c:if test="${isSecret != 1 }">
             	<input type="password" value="${result.pass}" name="pass" class="write_text"  style="width:120px;" title="비밀번호를 입력해주세요" maxlength="10"/>
             	</c:if>
             <c:if test="${isSecret == 1 }">
             	<input type="hidden" name="pass" class="write_text"  style="width:120px;" title="비밀번호를 입력해주세요" maxlength="10" value="${result.pass}"/>
             	</c:if>
             	<c:if test="${binfo.secretUse=='Y'}">
             	<!-- <input type="checkbox" name="secret" <c:if test="${result.secret=='Y'}">checked="checked"</c:if> class="vm" id="secret" value="Y" title="비밀글" /><label for="secret">비밀글</label> -->
             	<input type="checkbox" name="secret" class="vm" id="secret" value="Y" title="비밀글" <c:if test="${binfo.boardNm=='불만접수'}"> checked="checked" onclick="return false"</c:if>/><label for="secret">비밀글</label>
             	</c:if>
             </td>
          </tr>
         </c:if>
         
       </tbody>
    </table> 
 