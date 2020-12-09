<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/02_Board/inc/subHead.php');?>
<!--// page start -->

<?
//!$_GET['mode']	?	$mode ="write"	:	$mode	= $_GET['mode'];

if($_GET['bid'] == 'notice'){
?>

<script>
function Write_Chk(form){
		var form = document.write_form;
		//form.contents.value		=	ed1.getHtml();
		if(!Val_Chk(form.title,'제목'))			   return false;
		if(!Val_Chk(form.writer,'작성자'))	       return false;
		//GET파라미터 읽어오기
		function getQuerystring(paramName){ var _tempUrl = window.location.search.substring(1); 
			var _tempArray = _tempUrl.split('&');
			for(var i = 0; _tempArray.length; i++) { 
				var _keyValuePair = _tempArray[i].split('=');
				if(_keyValuePair[0] == paramName){ return _keyValuePair[1]; } 
			}
		}

		//게시판 구분
		/* 구분 딱히 필요없음
		var bid = getQuerystring("bid");
		if(bid == "portfolio" || bid == "notice"){
			num_temp = document.all.attribute.length;
			for (i = 0; i < num_temp; i++) {
				if (document.all.attribute[i].checked == true) { break; }
			}
			if (i == num_temp) {
				alert("구분을 선택하세요.");
				document.getElementById("attribute1").focus();
				return false;
			}
		}
		*/

		if(form.secret!=undefined){
			if(form.secret.checked==true){
				if(!Val_Chk(form.pass,'Password')) return false;
			}
		}
		
		oEditors[0].exec("UPDATE_CONTENTS_FIELD", []);
		form.submit();
	}
</script>
<? }else if($_GET['bid'] == "qna"){ ?>
<script>
function Write_Chk(form){
		var form = document.write_form;
		//form.contents.value		=	ed1.getHtml();
		//GET파라미터 읽어오기
		function getQuerystring(paramName){ var _tempUrl = window.location.search.substring(1); 
			var _tempArray = _tempUrl.split('&');
			for(var i = 0; _tempArray.length; i++) { 
				var _keyValuePair = _tempArray[i].split('=');
				if(_keyValuePair[0] == paramName){ return _keyValuePair[1]; } 
			}
		}

		//게시판 구분
		/* 구분 딱히 필요없음
		var bid = getQuerystring("bid");
		if(bid == "portfolio" || bid == "notice"){
			num_temp = document.all.attribute.length;
			for (i = 0; i < num_temp; i++) {
				if (document.all.attribute[i].checked == true) { break; }
			}
			if (i == num_temp) {
				alert("구분을 선택하세요.");
				document.getElementById("attribute1").focus();
				return false;
			}
		}
		*/

		if(form.secret!=undefined){
			if(form.secret.checked==true){
				if(!Val_Chk(form.pass,'Password')) return false;
			}
		}
		
		oEditors[0].exec("UPDATE_CONTENTS_FIELD", []);
		form.submit();
	}
</script>

<? } ?>
<!-- skin location -> Mngt/board/skin -->

<?
	include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/board/skin/Board/write.php');
?>
<!-- e : 게시판 페이징 -->

<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>
