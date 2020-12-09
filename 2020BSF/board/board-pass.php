<?php
	require_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/conn/conn.php');
	include "../Mngt/cmmInc/msgScript.php";
	$idx = $_GET["idx"];
?>

<div class="board">
	<div class="password_box">
		<div class="title">비밀번호 확인</div>
		<div class="exp">확인을 위한 비밀번호을 입력하시기 바랍니다</div>
		<div class="input_box">
			<form name="add_form" action="qna_passChk.php?idx=<?=$idx?>" method="post">
				<input type="password" name = "password" class="input_text" title="비밀번호를 입력해주세요" />
			</form>
		</div>
		<div class="btn_wrapper ">
			<button class="board_btn cancel" onclick="javascript:goBack();">취소</button>
			<button type="button" class="board_btn confirm" onclick="javascript:add_form_check();">확인</button>
		</div>
	</div>
</div>

<!-- 글 작성 시, 빈 칸 확인여부 -->
<script type="text/javascript" src="../Mngt/cmmJs/formCheck.js"></script>
<script type="text/javascript">
	function add_form_check(){
		var form = document.add_form;
		
		if(!Val_Chk(form.password,'비밀번호')) return false;

		form.submit();
	}
	//이전 페이지로 돌아가기
	function goBack() {
		window.history.back();
	}
</script>