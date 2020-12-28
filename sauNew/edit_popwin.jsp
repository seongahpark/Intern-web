<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" 			prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" 	prefix="fn"%>
<%@ taglib uri="http://www.springframework.org/tags" 		prefix="spring" %>
<script type="text/javascript" src="/cmm/js/EgovMultiFile.js" ></script>
<script type="text/javascript" src="/share/cmm/nhn_se2_mstr/dist/js/service/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="/cmm/js/jquery/jqueryFromCheck.js"></script>

<script type="text/javascript">

var oEditors = [];

window.onload = function(){
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		elPlaceHolder: "naverSmartEditCnts",
		sSkinURI: "/share/cmm/nhn_se2_mstr/dist/SmartEditor2Skin.html",
		fCreator: "createSEditor2"
	});
}

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
// 	var xpsPos = form.xpsPos.value;
	
	oEditors.getById["naverSmartEditCnts"].exec("UPDATE_CONTENTS_FIELD", []);
	
	var checkFormFlag = checkForm("#write_form");		//기본적인 필수입력값을 검사를 한다.
	var etcFormCheckFlag = etcFormCheck(form);
	
 
	if(!checkFormFlag || !etcFormCheckFlag){
		alert("필수 입력 또는 선택을 하십시요.");
		return;
	}
			
// 	if(xpsPos == 'MENU'){
// 		if(!Val_Chk(form.menuSeq,"노출메뉴")){
// 			return;
// 		}	
// 	}
	
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
// 	if(Val_ChkFlag(form.sortSeq, '순서')){
// 		if(!Num_ChkFlag(form.sortSeq, '순서')){
// 			flag = false;
// 			printMessage("sortSeq","Y","숫자만 입력 해주세요.");	
// 		}else{
// 			printMessage("sortSeq","N","");
// 		}
// 	}
	
	if(!Check_DateFlag(form.startDt)) {
		flag = false;
		printMessage("startDt","Y");
	}else{
		if(!Check_DateFlag(form.endDt)){
			flag = false;
			printMessage("endDt","Y");	
		}else{
			if(form.startDt.value > form.endDt.value){
				flag = false;
				printMessage("endDt","Y","종료일자가 시작일자 보다 작습니다.");	
			}else{
				printMessage("startDt","N","");	
				printMessage("endDt","N","");	
			}
		}
	}
	
// 	if(Val_ChkFlag(form.width, '넓이')){
// 		if(!Num_ChkFlag(form.width, '넓이')){
// 			flag = false;
// 			printMessage("width","Y","숫자만 입력 해주세요.");	
// 		}else{
// 			printMessage("width","N","");
// 		}
// 	}
	
// 	if(Val_ChkFlag(form.height, '높이')){
// 		if(!Num_ChkFlag(form.height, '높이')){
// 			flag = false;
// 			printMessage("height","Y","숫자만 입력 해주세요.");	
// 		}else{
// 			printMessage("height","N","");
// 		}
// 	}
	
	if(Val_ChkFlag(form.xPos, 'x위치')){
		if(!Num_ChkFlag(form.xPos, 'x위치')){
			flag = false;
			printMessage("xPos","Y","숫자만 입력 해주세요.");	
		}else{
			printMessage("xPos","N","");
		}
	}
	
	if(Val_ChkFlag(form.yPos, 'y위치')){
		if(!Num_ChkFlag(form.yPos, 'y위치')){
			flag = false;
			printMessage("yPos","Y","숫자만 입력 해주세요.");	
		}else{
			printMessage("yPos","N","");
		}
	}
	
	
	return flag;
}




function downFile(pgmFileId, pgmFileSeq){
	var form = document.file_form;
	form.pgmFileId.value = pgmFileId;
	form.pgmFileSeq.value = pgmFileSeq;
	form.action 	= "/cmm/file/downFile.do";
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
	$('.dateinput').datepicker({
		
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		showButtonPanel:true
	});
	
	//노출위치에서 메뉴선택시 팝업 호출
	$("input:radio[name=xpsPos]").click(function(){
		var radioVal = $('input[name="xpsPos"]:checked').val();
		if(radioVal == 'MENU'){
			viewChildMenuList(); 
		}else{
			$('#menuInfo').hide();
		}
		
    });
 
 });
</script>
<div class="cont-top">
    <div class="cont-tit">
        <h2>팝업창 수정</h2>
    </div>
</div>

<div class="board_box mt20">
<p style="padding:20px 0; color:blue; font-weight:bold">팝업이미지 등록후 팝업창 사이즈 입력시 이미지 사이즈를 입력해주시고 높이에 +37을 해주세요 (* 오늘하루보기 검은색 바 높이)</p>
<form name="write_form" id="write_form" method="post" enctype="multipart/form-data">
	<input type="hidden" name="posblAtchFileNumber"	value="${1 - fn:length(viewRow.flist) }" />
	<input type="hidden" name="pageIndex"			value="${searchVo.pageIndex }" />
	<input type="hidden" name="pgMode"				value="${searchVo.pgMode }" />
	<input type="hidden" name="rtnPage"				value="${nowUrl }" />
	<input type="hidden" name="popwinSeq" 			value="${viewRow.popwinSeq }"/>
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
			<th><span class="nec">팝업명칭</span></th>
			<td colspan="3" class="left">
				<input class="w300" type="text" id="title" name="title" title="팝업명칭을 입력해주세요." maxlength="30" value="${viewRow.title }" nec="nec"/>
				<br><span style="display:none;" id="titleMessage"></span>
			</td>
		</tr>
		<tr>
			<th><span class="nec">시작일자</span></th>
			<td class="left">
				<input type="text" class="dateinput" style="width:120px;" id="startDt" name="startDt" title="시작일자를 선택해주세요." maxlength="100" value="${viewRow.startDt }" nec="nec"/>
				<br><span style="display:none;" id="startDtMessage"></span>
			</td>
			<th><span class="nec">종료일자</span></th>
			<td  class="left">
				<input type="text" class="dateinput" style="width:120px;" id="endDt" name="endDt" title="종료일자를 선택해주세요." maxlength="100" value="${viewRow.endDt }" nec="nec" />
				<br><span style="display:none;" id="endDtMessage"></span>
			</td>
		</tr>
		<tr>
			<th><span class="nec">좌표(X)</span></th>
			<td class="left">
				<input class="w50" type="text" id="xPos" name="xPos" title="팝업 x 위치를 입력해주세요." maxlength="9" value="${viewRow.xPos }" nec="nec" onChange="javascript:onlyNum(this);"/>
				<br><span style="display:none;" id="xPosMessage"></span>
			</td>
			<th><span class="nec">좌표(Y)</span></th>
			<td  class="left">
				<input class="w50" type="text" id="yPos" name="yPos" title="팝업 Y 위치를 입력해주세요." maxlength="9" value="${viewRow.yPos }" nec="nec" onChange="javascript:onlyNum(this);"/>
				<br><span style="display:none;" id="yPosMessage"></span>
			</td>
		</tr>
		<tr>
			<th><span class="nec">넓이</span></th>
			<td class="left">
				<input class="w50" type="text" id="width" name="width" title="넓이를 입력해주세요." maxlength="9" value="${viewRow.width }" nec="nec" onChange="javascript:onlyNum(this);"/>
				<br><span style="display:none;" id="widthMessage"></span>
			</td>
			<th><span class="nec">높이</span></th>
			<td  class="left">
				<input class="w50" type="text" id="height" name="height" title="높이를 입력해주세요." maxlength="9" value="${viewRow.height }" nec="nec" onChange="javascript:onlyNum(this);"/>
				<br><span style="display:none;" id="heightMessage"></span>
			</td>
		</tr>
		<tr>
				<th><span class="nec">링크형태</span></th>
				<td class="left">
					<c:forEach var="item" items="${linkTypeList}" varStatus="status">
						<c:if test="${item.sysCd ne '0040'}">
							<c:choose>
								<c:when test="${status.first and (vo eq null or vo.pgmType eq null or vo.pgmType eq '') }">
									<input type="radio" name="linkType" title="링크형태 " value="${item.sysCd}" checked />
								</c:when>
								<c:otherwise>
									<input type="radio" name="linkType" title="링크형태 " value="${item.sysCd}" />
								</c:otherwise>
							</c:choose>
									<label for="${item.sysCd}">${item.sysCdNm }</label>
						</c:if>
					</c:forEach>
				</td>

			<th><span class="nec">링크URL</span></th>
			<td colspan="3" class="left">
				<input class="w300" type="text" id="linkUrl" name="linkUrl" title="링크URL을 입력해주세요." maxlength="100" value="${viewRow.linkUrl }" nec="nec"/>
				<br><span style="display:none;" id="linkUrlMessage"></span>
			</td>
		</tr>
		<tr>
			<th><span class="nec">노출여부</span></th>
			<td colspan="3" class="left">
				<input type="radio" name="useYn" title="노출여부" id="Y" value="Y" ${viewRow eq null or viewRow.useYn eq '' or viewRow.useYn eq 'Y' ? 'checked':'' }>
				<label for="Y">사용</label>
				<input type="radio" name="useYn" title="노출여부" id="N" value="N" ${viewRow.useYn eq 'N' ? 'checked':'' }>
				<label for="N">사용안함</label>
			</td>
		</tr>
		<c:choose>
			<c:when test="${viewRow.pgmFileId ne null }">
			<tr>
				<th><label for="egovComFileUploader">첨부파일 </label></th>
				<td class="left" colspan="3">
					<input type="file" name="up_file" id="egovComFileUploader" title="파일을 선택해주세요" class="w300" />
					<br><span style="display:none;" id="up_fileMessage"></span>
				</td>
			</tr>
			<tr>
				<th>첨부파일 목록</th>
				<td id="egovComFileList" colspan="3" class="left">
					<input type="hidden" name="pgmFileId" value="${viewRow.pgmFileId }" class="egovComFileUploaderFile" />
					<c:forEach var="files" items="${viewRow.flist }" varStatus="status">
<%-- 						<c:set var="fileUrl">/cmm/file/showFile.do?pgmFileId=${files.pgmFileId }&pgmFileSeq=${files.pgmFileSeq }</c:set> --%>
<%-- 						<img id="module-img" src="${fileUrl}" alt="${files.fileRealNm}"/> --%>
						
						<!-- ie 11 대응 -->
						<img src="/cmm/file/setFile.do?fidx=${files.pgmFileId}&fseq=${files.pgmFileSeq}"  />
            			<img id="module-img" src="/data${files.filePath}sample_${files.fileSaveNm}.${files.fileExt}" alt="${files.fileRealNm}" style="display: none;"/>
						
						<br />
						
						<a href="#none" onclick="javascript:downFile('${files.pgmFileId }', ${files.pgmFileSeq});">${files.fileRealNm}</a>
	         			&nbsp;<a href="#none" class="sw-btn" onclick="javascript:deleteFile('${files.pgmFileId }', ${files.pgmFileSeq})">파일삭제</a>
					</c:forEach> 
				</td>
			</tr>
			</c:when>
			<c:otherwise>
			<tr>
				<th><label for="egovComFileUploader">첨부파일 </label></th>
				<td class="left" colspan="3">
					<input type="file" name="up_file" id="egovComFileUploader" title="파일을 선택해주세요" class="w300" />
					<br><span style="display:none;" id="up_fileMessage"></span>
				</td>
			</tr>
			<tr>
				<th>첨부파일 목록</th>
				<td id="egovComFileList" colspan="3" class="left">
				</td>
			</tr>

			</c:otherwise>
		</c:choose>	
			<tr>
				<th><label for="cnts">내용</label></th>
				<td class="left" colspan="3">
					<textarea name="cnts" id="naverSmartEditCnts" style="width:650px;" rows="20">${viewRow.cnts }</textarea>
					<br><span style="display:none;" id="naverSmartEditCntsMessage"></span>
				</td>
			</tr>
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
<input type="hidden" name="rtnPage"		value="${nowUrl}&popwinSeq=${viewRow.popwinSeq }&pgMode=edit"/>
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