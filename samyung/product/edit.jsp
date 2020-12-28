<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" 			prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" 	prefix="fn"%>
<%@ taglib uri="http://www.springframework.org/tags" 		prefix="spring" %>
<script type="text/javascript" src="/share/cmm/nhn_se2_mstr/dist/js/service/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="/cmm/js/EgovMultiFile.js" ></script>
<script type="text/javascript" src="/cmm/js/jquery/jqueryFromCheck.js"></script>
<script type="text/javascript">
var oEditors = [];
var oEditors2 = [];
var oEditors3 = [];

window.onload = function(){
		//첫번째에디터 - 특징
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		elPlaceHolder: "naverSmartEditCnts",
		sSkinURI: "/share/cmm/nhn_se2_mstr/dist/SmartEditor2SkinUser.html",
		fCreator: "createSEditor2",
		htParams : {
			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		    bUseModeChanger : false
		}
	});
		//두번째에디터 - 사양
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors2,
		elPlaceHolder: "naverSmartEditCnts2",
		sSkinURI: "/share/cmm/nhn_se2_mstr/dist/SmartEditor2SkinUser.html",
		fCreator: "createSEditor2",
		htParams : {
			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		    bUseModeChanger : false
		}
	});
		//세번째에디터 - 소프트웨어업데이트방법
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors3,
		elPlaceHolder: "naverSmartEditCnts3",
		sSkinURI: "/share/cmm/nhn_se2_mstr/dist/SmartEditor2SkinUser.html",
		fCreator: "createSEditor2",
		htParams : {
			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		    bUseModeChanger : false
		}
	});
}
function move(){
	maskShow();
	var frm = document.move_form;
	frm.pgMode.value = 'index';
	frm.submit();
}

function store(frm){	
	oEditors.getById["naverSmartEditCnts"].exec("UPDATE_CONTENTS_FIELD", []);
	oEditors2.getById["naverSmartEditCnts2"].exec("UPDATE_CONTENTS_FIELD", []);
	oEditors3.getById["naverSmartEditCnts3"].exec("UPDATE_CONTENTS_FIELD", []);
	
	if(!Val_Chk(frm.srcFstSv,'1차 분류 선택값')) return false;
	if(frm.srcFstSv.value != "1" && frm.srcFstSv.value != "6" && frm.srcFstSv.value != "7"  ){
		if(!Val_Chk(frm.srcScdSv,'2차 분류 선택값')) return false;
	}
	if(!Val_Chk(frm.prd_nm,'제품명')) return false;
	if(!Val_Chk(frm.egovComFileUploader.value,'대표이미지')) return false;
	
	maskShow(); 
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
function changeScd(){
	
	maskShow();
	var bunryuSeq = document.write_form.srcFstSv.value;
	
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
					$("#scd_sv").html("<option value=''>2차 분류 선택</option>");
					for(var i = 0; i < length; i++){
						if(selSrcScdSv == result[i].bunryuSeq){
							selected = 'selected="selected"';
						}
						$("#scd_sv").append("<option value='"+result[i].bunryuSeq+"' " + selected + ">"+result[i].bunryuNm+"</option>");
						selected = '';
					}
				}else{
					$("#scd_sv").html("<option value=''>2차 분류 선택</option>");
				}
			}
		}); 
	maskHide();
}

$(document).ready(function(){
	var bunryuSeq = document.write_form.srcFstSv.value;
	if(bunryuSeq){
		changeScd();
	}
});

function numberMaxLength(e){
	if(e.value.length > e.maxLength){
		alert("설명은 최대 1,000자까지 입력 가능합니다.");
		e.value = e.value.slice(0, e.maxLength);
	}
}
</script>
<div class="cont-top">
    <div class="cont-tit">
        <h2>제품상세</h2>
    </div>
</div>

<div class="board_box mt20">

<!-- enctype="multipart/form-data" 인 경우 .do 뒤에 csrf 추가 -->
<%-- <form name="write_form" method="post" action="${pgmUrl }/store.do?${_csrf.parameterName}=${_csrf.token}" onsubmit="return store(this);" enctype="multipart/form-data"> --%>

<form name="write_form" method="post" action="${pgmUrl }/update.do?${_csrf.parameterName}=${_csrf.token}"  onsubmit="return store(this);" enctype="multipart/form-data">
	 <input type="hidden" name="pgMode" value="${searchVo.pgMode }" />
	 <input type="hidden" name="nowUrl" 	value="${nowUrl }" />
	 <input type="hidden" name="posblAtchFileNumber" value="1"/>
	 <input type="hidden" name="posblAtchFileNumber2" value="10"/>
	 <input type="hidden" name="langType" value="${searchVo.langType }"/>
	 <input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
	 <input type="hidden" name="prdSeq" value="${viewRow.prdSeq }"/>
	<div class="board-list-warp">
	<span class="bd-line"></span>
	<table class="tbl-basic1">
		<colgroup>
			<col style="width: 250px;"/>
			<col style="width: *"/>
		</colgroup>
		<tr>
			<th>제품상태</th>
			<td class="left">
				
				<label><input type="checkbox" name="status" id="status1" value="0010" <c:if test="${fn:contains(viewRow.prdStatus, '0010') }"> checked</c:if> >신제품</label>&ensp;&ensp;
				<label><input type="checkbox" name="status" id="status2" value="0020" <c:if test="${fn:contains(viewRow.prdStatus, '0020') }"> checked</c:if> >판매예정</label>
			</td>
		</tr>
		<tr>
			<th>*제품군</th>
			<td class="left">
				<select name="srcFstSv" class="select_box" onchange="javascript:changeScd();">
					<option value="">1차 분류 선택</option>
					
					<c:set var="bunryu" value="0"/>
					<c:if test="${viewRow.bunryuUppSeq eq 0 }">
						<c:set var="bunryu" value="${viewRow.bunryuSeq }"/>
					</c:if>
					<c:if test="${viewRow.bunryuUppSeq ne 0 }">
						<c:set var="bunryu" value="${viewRow.bunryuUppSeq }"/>
					</c:if>
					
					<c:forEach var="vo" items="${bunryuList}" varStatus="status">
						<c:if test="${vo.upBunryuNo  eq '0'}">
							<option value="${vo.bunryuSeq }" <c:if test='${vo.bunryuSeq eq bunryu }'> selected="selected" </c:if> > ${vo.bunryuNm }</option>
						</c:if>
					</c:forEach>
				</select> 
					
				<select name="srcScdSv" id="scd_sv" class="select_box">
					<option value="">2차 분류 선택</option>
					<c:forEach var="vo" items="${bunryuList}" varStatus="status">
						<c:if test="${vo.upBunryuNo  ne '0'}">
							<option value="${vo.bunryuSeq }" <c:if test='${vo.bunryuSeq eq viewRow.bunryuSeq }'> selected="selected" </c:if> > ${vo.bunryuNm }</option>
						</c:if>
					</c:forEach>
				</select>
			</td>
		</tr>
		<tr>
			<th>*제품명</th>
			<td class="left">
				<input class="w400 " type="text" id="prdNm" name="prdNm" title="제품명"   value="${viewRow.prdNm }"/>
			</td>
		</tr>
		<tr>
			<th>설명</th>
			<td class="left">
				<input class="w80p " type="text" id="prdInfoTxt" name="prdInfoTxt" title="설명"   value="${viewRow.prdInfoTxt }" maxlength="1000" oninput="numberMaxLength(this);"/>
			</td>
		</tr>
		<tr>
			<th>특징</th>
			<td class="left">
				<textarea id="naverSmartEditCnts" name="prdChr" class="w98p" rows="10" title="제품특징을입력해주세요" rows="10" nec="nec">${viewRow.prdChr }</textarea>
					<br><span style="display:none;" id="chr"></span>
			</td>
		</tr>
		<tr>
			<th>제품사양</th>
			<td class="left">
				<textarea id="naverSmartEditCnts2" name="prdSpec" class="w98p" rows="10" title="제품사양을입력해주세요" rows="10" nec="nec">${viewRow.prdSpec }</textarea>
					<br><span style="display:none;" id="spec"></span>
			</td>
		</tr>
		<tr>
			<th>소프트웨어<br>업데이트방법</th>
			<td class="left">
				<textarea id="naverSmartEditCnts3" name="prdSfware" class="w98p" rows="10" title="소프트웨어업데이트방법을입력해주세요" rows="10" nec="nec">${viewRow.prdSfware }</textarea>
					<br><span style="display:none;" id="software"></span>
			</td>
		</tr>
		<tr>
			<th>*대표이미지</th>
			<td class="left">
				<input type="file" id="egovComFileUploader" title="파일을 선택해주세요" class="w300" name="up_file"/>
				<br><span style="display:none;" id="up_fileMessage"></span>
			</td>
		</tr>
		<tr>
			<th>첨부 대표이미지</th>
			<td id="egovComFileList" class="left">
			<c:forEach var="files" items="${viewRow.flist }" varStatus="status">
				 <c:if test="${files.fileCheck eq '1'}"> 

					<a href="#none" onclick="javascript:downFile('${files.pgmFileId }', ${files.pgmFileSeq});">${files.fileRealNm}</a>
			      			&nbsp;<a href="#none" class="sw-btn" onclick="javascript:deleteFile('${files.pgmFileId }', ${files.pgmFileSeq})">파일삭제</a>
				 </c:if>
			</c:forEach> 
			</td>
		</tr>
		
		<tr>
			<th>제품이미지</th>
			<td class="left">
				<input type="file" id="egovComFileUploader2" title="파일을 선택해주세요" class="w300" /> <!-- name="up_file"  -->
				<br><span style="display:none;" id="up_fileMessage2"></span>
				
			</td>
		</tr>
		<tr>
			<th>첨부 제품이미지</th>
			<td id="egovComFileList2" class="left">
			<c:forEach var="files" items="${viewRow.flist }" varStatus="status">
				<c:if test="${files.fileCheck eq '0'}">
					<a href="#none" onclick="javascript:downFile('${files.pgmFileId }', ${files.pgmFileSeq});">${files.fileRealNm}</a>
		      			&nbsp;<a href="#none" class="sw-btn" onclick="javascript:deleteFile('${files.pgmFileId }', ${files.pgmFileSeq})">파일삭제</a>
				</c:if>
			</c:forEach> 
			</td>
		</tr>
		
		<tr>
			<th>인증마크</th>
			<td class="left">
				<c:if test="${fn:length(crtMarkList) > 0 }">
					<c:forEach var="crtVo" items="${crtMarkList }" varStatus="status">
						<c:set var="check" value=""/>
						<c:set var="loop" value="false"/>
						<c:forTokens var="certifiMarkNums" items="${viewRow.certifiMarkNums}" delims=",">
							<c:if test="${not loop }">
								<c:if test="${crtVo.crtSeq eq certifiMarkNums }">
									<c:set var="check" value="checked"/>
									<c:set var="loop" value="true"/>
								</c:if>
							</c:if>
						</c:forTokens>
						<label>
						<input type="checkbox" name="certifiMark" id="certifiMark_${status.index }" value="${crtVo.crtSeq }" ${check} >
						<c:if test="${fn:length(crtVo.flist) > 0 }">
							<img src="/data${crtVo.flist[0].filePath }${crtVo.flist[0].fileSaveNm }" width="50" height="50">
						</c:if>
						</label>&ensp;&ensp;&ensp;
					</c:forEach>
				</c:if>
			</td>
		</tr>
		
		<tr>
			<th>*게시여부</th>
			<td class="left">
				<label><input type="radio" name="viewYn" id="view_yn1" value="Y" <c:if test="${viewRow.viewYn eq 'Y' }"> checked</c:if> >게시</label>&ensp;&ensp;
				<label><input type="radio" name="viewYn" id="view_yn2" value="N" <c:if test="${viewRow.viewYn eq 'N' }"> checked</c:if>>미게시</label>
			</td>
		</tr>
		
	</table>
	<div class="board_btn">
	
	    <div class="fr">
			<button type="submit" class="bdp-btn" ><span>수정</span></button>
			<button type="button" class="bw-btn" onclick="javascript:move();"><span>목록</span></button>
	    </div>
	   
	</div>
</div>
</form>
 
</div>

<form name="file_form" method="post" action="">
	<input type="hidden" name="id" value="${viewRow.prdSeq }"/>
	<input type="hidden" name="siteId"  value="${siteId}">
	<input type="hidden" name="prdSeq" value="${viewRow.prdSeq }"/>
	<input type="hidden" name="pgmFileId" value="${viewRow.pgmFileId }" />
	<input type="hidden" name="pgmFileSeq" value="" />
	<input type="hidden" name="rtnPage"		value="${nowUrl}&prdSeq=${viewRow.prdSeq }&pgMode=edit"/>
	<input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
</form>


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
  var maxFileNum2 = document.write_form.posblAtchFileNumber2.value;
  if(maxFileNum2==null || maxFileNum2==""){
   maxFileNum2 = 1;
  }  
 var multi_selector = new Main_MultiSelector( document.getElementById( 'egovComFileList' ), maxFileNum );
 var multi_selector2 = new MultiSelector( document.getElementById( 'egovComFileList2' ), maxFileNum2 );
 
 multi_selector.addElement( document.getElementById('egovComFileUploader'));
 multi_selector2.addElement( document.getElementById('egovComFileUploader2'));
</script> 