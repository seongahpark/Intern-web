<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/02_Board/inc/subHead.php');?>
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/lib_paging.php');?>
<!--// page start -->

<!-- skin location -> Mngt/board/skin -->
<script>
function del_Chk(form){
	var form = document.list_form;
	if(!All_Check_Num(form,'idx[]',1,'게시물')) return;
	var msg = confirm('정말 삭제하시겠습니까?');
	if(msg==true){
		form.submit();
	}
}
</script>

<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/board/skin/Board/list.php');?>
<!-- e : 게시판 페이징 -->

<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>
