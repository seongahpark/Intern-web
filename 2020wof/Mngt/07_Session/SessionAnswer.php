<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/07_Session/inc/subHead.php');?>
<!--// page start -->
<script>
function Write_Chk(form){
		var form = document.write_form;
		//form.contents.value		=	ed1.getHtml();
		if(!Val_Chk(form.title,'제목'))			   return false;
		if(!Val_Chk(form.writer,'작성자'))	       return false;
		
		if(form.secret!=undefined){
			if(form.secret.checked==true){
				if(!Val_Chk(form.pass,'Password')) return false;
			}
		}
		oEditors[0].exec("UPDATE_CONTENTS_FIELD", []);
		form.submit();
	}
</script>
<!-- skin location -> Mngt/board/skin -->
<?echo '/Mngt/board/skin/'.$_GET["btype"].'/answer.php';?>
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/board/skin/'.$_GET["btype"].'/answer.php');?>
<!-- e : 게시판 페이징 -->

<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>