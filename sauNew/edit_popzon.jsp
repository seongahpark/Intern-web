<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" 			prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" 	prefix="fn"%>
<%@ taglib uri="http://www.springframework.org/tags" 		prefix="spring" %>
<script type="text/javascript" src="/cmm/js/EgovMultiFile.js" ></script>
<script type="text/javascript" src="/share/cmm/nhn_se2_mstr/dist/js/service/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="/cmm/js/jquery/jqueryFromCheck.js"></script>

<script type="text/javascript">

//목록 이동 
function moveList(){
	maskShow();
	var form = document.move_form;
	form.pgMode.value = "index";
	form.submit();
}

//수정 처리 스크립트
function writeProc(){		
	var form = document.write_form;
	
	var checkFormFlag = checkForm("#write_form");		//기본적인 필수입력값을 검사를 한다.
	var etcFormCheckFlag = etcFormCheck(form);
 
	if(!checkFormFlag || !etcFormCheckFlag){
		alert("필수 입력 또는 선택을 하십시요.");
		return;
	}

	maskShow();
	form.pgMode.value = 'update';
	form.action = "${pgmUrl}/update.do";		
	form.submit();
}

//기본 적 필수 검사 외의 조건 검사 처리 메소드
function etcFormCheck(form){
	var flag = true;
	/*
	if($('.egovComFileUploaderFile').length < 1){
		flag = false;
		printMessage("up_file","Y","파일을 선택해주세요");
	}else{
		printMessage("up_file","N","");
	}
	*/
	if(Val_ChkFlag(form.sortSeq, '노출순서')){
		if(!Num_ChkFlag(form.sortSeq, '노출순서')){
			flag = false;
			printMessage("sortSeq","Y","숫자만 입력 해주세요.");	
		}else{
			printMessage("sortSeq","N","");
		}
	}
	
	return flag;
}




function downFile(pgmFileId, pgmFileSeq){
	var form = document.file_form;
	form.pgmFileId.value = pgmFileId;
	form.pgmFileSeq.value = pgmFileSeq;
	form.action 	= "/cmm/file/downFileImg.do";
	form.submit();
}

function deleteFile(pgmFileId, pgmFileSeq){
	var form = document.file_form;
	form.pgmFileId.value = pgmFileId;
	form.pgmFileSeq.value = pgmFileSeq;
	if(confirm("정말삭제하시겠습니까?")){
		maskShow();
		form.action 	= "/cmm/file/deleteFile.do";
		form.submit();
	}
}

function setMenuUppSeq(menuSeq, menuNm){
	//상위메뉴코드
	document.write_form.menuSeq.value = menuSeq;
	//상위메뉴이름
	$('#menuNm').html( menuNm );
	if(menuNm != '' && menuNm != null && menuNm!=undefined){
		$('#menuInfo').show();
	}
}

function viewChildMenuList(){ 
	var open = window.open('${nowUrl }&pgMode=indexPop','pgmPop','width=400,height=600');
	open.focus();
}

$(function(){
	
 });
</script>
<div class="cont-top">
    <div class="cont-tit">
        <h2>팝업존 수정</h2>
    </div>
</div>

<div class="board_box mt20">
<p style="padding:20px 0; color:blue; font-weight:bold">팝업존 최소 이미지 사이즈는 580 * 380입니다. (580 너비보다 작을시 강재로 확대되어 흐려짐)<br>고해상도 기기를 위해 권장사이즈는 2배인 1160 * 760입니다. (레티나, 4k 모니터 고려)</p>
<form name="write_form" id="write_form" method="post" enctype="multipart/form-data">
	<input type="hidden" name="posblAtchFileNumber"	value="${1 - fn:length(viewRow.flist) }" />
	<input type="hidden" name="pageIndex"			value="${searchVo.pageIndex }" />
	<input type="hidden" name="pgMode"				value="${searchVo.pgMode }" />
	<input type="hidden" name="rtnPage"				value="${nowUrl }" />
	<input type="hidden" name="popzoneSeq" 			value="${viewRow.popzoneSeq }"/>
	<input type="hidden" name="menuSeq" 			value="${viewRow.menuSeq }"/>
	
	<div class="board-list-warp">
	<span class="bd-line"></span>
	<table class="tbl_form">
		<colgroup>
			<col style="width: 150px;"/>
			<col style="width: 400px;"/>
			<col style="width: 150px;"/>
			<col style="width: *"/>
		</colgroup>
		<tbody>
			<tr>
				<th><span class="nec">링크형태</span></th>
				<td colspan="3" class="left">
					<c:forEach var="item" items="${linkTypeList}" varStatus="status">
						<c:if test="${item.sysCd ne '0040'}">
							<c:choose>
								<c:when test="${status.first and (vo eq null or vo.pgmType eq null or vo.pgmType eq '') }">
									<input type="radio" name="linkType" id="${item.sysCd}" title="링크형태 " value="${item.sysCd}" checked />
								</c:when>
								<c:otherwise>
									<input type="radio" name="linkType" id="${item.sysCd}" title="링크형태 " value="${item.sysCd}" ${item.sysCd eq viewRow.linkType ? 'checked':'' } />
								</c:otherwise>
							</c:choose>
							<label for="${item.sysCd}">${item.sysCdNm }</label>
						</c:if>
					</c:forEach>
				</td>
			</tr>
			<tr>
				<th><span class="nec">제목</span></th>
				<td colspan="3" class="left">
					<input class="w300" type="text" id="title" name="title" title="제목을 입력해주세요." maxlength="30" value="${viewRow.title }" nec="nec"/>
					<br><span style="display:none;" id="titleMessage"></span>
				</td>
			</tr>
			<tr>
				<th><span class="nec">링크주소</span></th>
				<td colspan="3" class="left">
					<input class="w300" type="text" id="linkUrl" name="linkUrl" title="링크주소을 입력해주세요." maxlength="100" value="${viewRow.linkUrl }" nec="nec"/>
					<br><span style="display:none;" id="linkUrlMessage"></span>
				</td>
			</tr>
			<tr>
				<th><span class="nec">노출순서</span></th>
				<td class="left">				
					<input  type="text" id="sortSeq" name="sortSeq" title="노출순서를 입력해주세요." value="${viewRow.sortSeq }" class="onlyNum" maxlength="2" style="width:50px;" nec="nec" onChange="javascript:onlyNum(this);"/>
					<br><span style="display:none;" id="sortSeqMessage"></span>
				</td>
			</tr>
			<tr>
				<th><span class="nec">사용여부</span></th>
				<td class="left">
					<input type="radio" name="useYn" title="사용여부" id="Y" value="Y" ${vo eq null or vo.useYn eq '' or vo.useYn eq 'Y' ? 'checked':'' }>
					<label for="Y">사용</label>				
					<input type="radio" name="useYn" title="사용여부" id="N" value="N" ${vo.useYn eq 'N' ? 'checked':'' }>
					<label for="N">중지</label>
				</td>
			</tr>

			<tr>
				<th><span class="nec">첨부파일 </span></th>
				<td class="left file" colspan="3">
					<input type="file" name="up_file" id="egovComFileUploader" title="파일을 선택해주세요" class="w300" />
				</td>
			</tr>
			<c:choose>
				<c:when test="${viewRow.pgmFileId ne null }">
					<tr>
						<th>첨부파일 목록</th>
						<td id="egovComFileList" colspan="3" class="left">
							<input type="hidden" name="pgmFileId" value="${viewRow.pgmFileId }" class="egovComFileUploaderFile" />
							<c:forEach var="files" items="${viewRow.flist }" varStatus="status">
								<img src="/cmm/file/setFile.do?fidx=${files.pgmFileId}&fseq=${files.pgmFileSeq}"  style="display: none;"/>
		            			<img id="module-img" src="/data${files.filePath}sample_${files.fileSaveNm}.${files.fileExt}" alt="${files.fileRealNm}" style="display: none;"/>
		            			<img src="/cmm/file/setFile.do?fidx=${files.pgmFileId}&fseq=${files.pgmFileSeq}"  alt="${files.fileRealNm}"/>
								<br />
								<a href="#none" onclick="javascript:downFile('${files.pgmFileId }', ${files.pgmFileSeq});">${files.fileRealNm}</a>
			         			&nbsp;<a href="#none" class="sw-btn" onclick="javascript:deleteFile('${files.pgmFileId }', ${files.pgmFileSeq})">파일삭제</a>
							</c:forEach> 
						</td>
					</tr>
				</c:when>
				<c:otherwise>
					<tr>
						<th>첨부파일 목록</th>
						<td id="egovComFileList" colspan="3" class="left"></td>
					</tr>
				</c:otherwise>
			</c:choose>	
		
		</tbody>
	</table>
	<div class="board_btn">
	
	    <div class="fr">
			<button type="button" class="bp-btn" onclick="javascript:writeProc();"><span>수정</span></button>
			<button type="button" class="bw-btn" onclick="javascript:moveList();"><span>목록</span></button>
	    </div>
	   
	</div>
</div>
</form>

<form name="move_form" method="get" action="${nowUrl }">
	<input type="hidden" name="pageIndex"	value="${searchVo.pageIndex }" />
	<input type="hidden" name="pgMode"		value="${searchVo.pgMode }" />
	<input type="hidden" name="no" 			value="${nowKey }" />
	<input type="hidden" name="sv"			value="${searchVo.sv }" />
	<input type="hidden" name="sw"			value="${searchVo.sw }" />
</form>

<form name="file_form" method="post" action="/cmm/file/downFile.do">
<input type="hidden" name="siteId"  value="${siteId}">
<input type="hidden" name="pgmFileId" value="${viewRow.pgmFileId }" />
<input type="hidden" name="pgmFileSeq" value="" />
<input type="hidden" name="rtnPage"		value="${nowUrl}&popzoneSeq=${viewRow.popzoneSeq }&pgMode=edit"/>
<input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
</form>

</div>
<script type="text/javascript">
   var maxFileNum = document.write_form.posblAtchFileNumber.value;
   if(maxFileNum==null || maxFileNum==""){
     maxFileNum = 1;
    }   
   
   var multi_selector = new MultiImgSelector( document.getElementById( 'egovComFileList' ), maxFileNum );
   multi_selector.addElement( document.getElementById( 'egovComFileUploader' ) );			
</script>