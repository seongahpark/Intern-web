<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/07_Session/inc/subHead.php');?>
<!--// page start -->

<!-- skin location -> Mngt/board/skin -->
<script>
	function del_Chk(form){
		var form = document.del_form;
		var msg = confirm('정말 삭제하시겠습니까?');
		if(msg==true){
			form.submit();
		}

	}
</script>

<?include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/board/skin/Session/view.php');?>
<!-- e : 게시판 페이징 -->


<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>

