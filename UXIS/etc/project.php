<script type="text/javascript">
	function checkFile(el){
		// files 로 해당 파일 정보 얻기.
		var file = document.getElementById("ex_filename_1").files[0].size;

		// file[0].size 는 파일 용량 정보입니다.
		if(file > 1024 * 1024 * 10){
			// 용량 초과시 경고후 해당 파일의 용량도 보여줌
			alert('10MB 이하 파일만 등록할 수 있습니다.\n\n' + '현재파일 용량 : ' + (Math.round(file / 1024 / 1024 * 100) / 100) + 'MB');
			$("#ex_filename_1").val('');
		}

		// 체크를 통과했다면 종료.
		else return;
	}
	function Val_Chk(id,alias){
		if($("#"+id).val().trim() == ""){
			alert(alias + "을(를) 입력해주세요.");
			$("#"+id).focus();
			return false;
		}
		return true;
	}
	
	function writeCheck(){
		var form = document.protest_form;

		if(!Val_Chk('dam_name','성함 / 직급'))	return false;
		if(!Val_Chk('cp_name','회사명'))		return false;
		if(!Val_Chk('dam_email','이메일'))		return false;
		if(!Val_Chk('dam_tel','연락처'))		return false;

		if($('input[name=consult_method]').val()=="" || $('input[name=consult_method]').val()=="견적 요청 방법"){
			alert('견적요청 방법을(를) 선택해주세요.');
			return false;
		}

		if($("input:checkbox[name='agree_y']").is(":checked") != true){
			alert('개인정보 수집에 동의해 주세요.');
			return false;
		}

		form.make_product.value = $('input:checkbox[name=make_product]').val();

		switch($('input[name=money]').val()){
			case "예산규모를 선택해주세요":
				form.c_money.value = "";
				form.c_moneyMax.value = "";
				break;
			case "1,000만원 ~ 3,000만원":
				form.c_money.value = "1000";
				form.c_moneyMax.value = "3000";
				break;
			case "3,000만원 ~ 5,000만원":
				form.c_money.value = "3000";
				form.c_moneyMax.value = "5000";
				break;
			case "5,000만원 ~ 1억":
				form.c_money.value = "5000";
				form.c_moneyMax.value = "10000";
				break;
			case "1억초과":
				form.c_money.value = "10000";
				form.c_moneyMax.value = "";
				break;
		}

		var msg = confirm("등록하시겠습니까?");
		if(!msg) return false;

		form.process.value = "insert";

		form.submit();

	}
</script>


<form name="protest_form" method="post" action="../../../web_control/control_consult.php" enctype="multipart/form-data">
<input type="hidden" name="process" value="insert"/>
<input type="hidden" name="params"  value="<?=$_params['list']?>"/>
<input type="hidden" name="c_moneyMax" value=""/>
<input type="hidden" name="c_money" value=""/>
<input type="hidden" name="page_url" value="<?=$_SERVER['REQUEST_URI'];?>"/>

<div id="project-pop-box">
	<div class="project-pop-inwrap">
		<h3 class="b-tit">Tell us about your project.</h3>
		
		<div class="box-01">
			<input type="text" name="dam_name"	id="dam_name"	placeholder="성함 / 직급">
			<input type="text" name="cp_name"	id="cp_name"	placeholder="회사명이 무엇인가요?">
			<input type="text" name="dam_email"	id="dam_email"	placeholder="이메일 주소를 입력해주세요">
			<input type="text" name="dam_tel"	id="dam_tel"	placeholder="연락처가 어떻게 되세요?">
		</div>


		<div class="box-02">
			<div class="tit-box">
				<p class="tit">제작 분야를 선택해주세요</p>
				
				<input type="checkbox" id="project-check-01" name="make_product" value="시스템 개발" class="mb25">
				<label for="project-check-01">시스템 개발</label>

				<input type="checkbox" id="project-check-02" name="make_product" value="웹사이트 개발" class="mb25 ty01">
				<label for="project-check-02">웹사이트 개발</label>

				<input type="checkbox" id="project-check-03" name="make_product" value="마케팅" class="mb25 ty02">
				<label for="project-check-03">마케팅</label>
				<br/>

				<input type="checkbox" id="project-check-04" name="make_product" value="모바일 앱">
				<label for="project-check-04">모바일 앱</label>

				<input type="checkbox" id="project-check-05" name="make_product" value="디자인" class="ty01">
				<label for="project-check-05">디자인</label>

				<input type="checkbox" id="project-check-06" name="make_product" value="기타" class="ty02">
				<label for="project-check-06">기타</label>
			</div>


			<div id="project_select">
				<dl id="rnb" class="">
					<dt>
						<a href="#rnb" id="money" value="">예산규모를 선택해주세요</a>
					</dt>
					<dd style="display: none;">
						<ul>
							<li><a href="#n"><span>예산규모를 선택해주세요</span><input type="hidden" name="money" class="sub"></a></li>	
							<li><a href="#n"><span>1,000만원 ~ 3,000만원</span><input type="hidden" name="money" class="sub"></a></li>	
							<li><a href="#n"><span>3,000만원 ~ 5,000만원</span><input type="hidden" name="money" class="sub"></a></li>
							<li><a href="#n"><span>5,000만원 ~ 1억</span><input type="hidden" name="money" class="sub"></a></li>
							<li><a href="#n"><span>1억초과</span><input type="hidden" name="money" ></a></li>
						</ul>
					</dd>
				</dl>
			</div>

					

			<div id="estimate_select">
				<dl id="estimate_dl" class="">
					<dt>
						<a href="#estimate_dl">견적 요청 방법</a>
					</dt>
					<dd style="display: none;">
						<ul>
							<li><a href="#n"><span>견적 요청 방법</span><input type="hidden" name="consult_method" value="" class="sub"></a></li>
							<li><a href="#n"><span>방문상담</span><input type="hidden" name="consult_method" value="방문상담" class="sub"></a></li>
							<li><a href="#n"><span>전화상담</span><input type="hidden" name="consult_method" value="전화상담" class="sub"></a></li>
							<li><a href="#n"><span>이메일</span><input type="hidden" name="consult_method" value="이메일" class="sub"></a></li>
						</ul>
					</dd>
				</dl>
			</div>
		</div>



		<div class="box-03">
			<div class="tit-box">
				<p class="tit02">참고할 사항을 입력해주세요</p>

				<textarea name="contents" class="project-area"></textarea>
				
				<div class="project-fileBox">
					<input class="upload-name" value="파일을 업로드 해주세요" disabled="disabled">
					<label for="ex_filename_1" class="file-btn">파일선택</label>
					<input type="file" id="ex_filename_1" name="up_file" class="file-text write-file upload-hidden" title="첨부파일을 등록해주세요." onchange="checkFile(this)">
					<p class="info-txt01">파일은 최대 10MB 입니다.</p>
				</div>
				
				

				<div class="service-terms-box">
					<div class="fl">
						<input type="checkbox" id="service-terms" name="agree_y">
						<label for="service-terms">
							<a href="#n" class="terms-pop">개인정보보호정책</a>에 동의합니다.
						</label>
					</div>

					<a href="#n" class="send-btn" onclick="writeCheck(this);">SEND REQUEST</a>

					<div class="cb"></div>
				</div>
			</div>
		</div>

		<a href="#n" class="project-pop-close"><span class="blinde">견적문의 팝업 닫기</span></a>

		<div id="terms-txt-box">
			<div class="rel-box">
				<h3 class="terms-btit">개인정보처리방침</h3>

				<h3 class="terms-stit">개인정보 수집이용에 대한 동의</h3>
				<p class="terms-txt">
					고객의 소중한 개인정보는 다음과 같은 정책에 따라 수집 및 이용됩니다. 저희 (주)유시스에서는 해당 목적에 연관 되는 개인정보만을 수집하며, 수집된 정보를 투명하고 안전하게 보호 관리할 것을 약속합니다.<br/>이에 개인정보 수집 및 이용에 대한 동의를 구합니다.
				</p> 


				<h3 class="terms-stit">개인정보의 수집·이용 목적</h3>
				<ul class="terms-list">
					<li>고객의 프로젝트 개발을 위한 상담, 견적, 개발방법 등의 문의에 대한 정보가 보다 정확한 답변을 위해 수집됩니다.</li>
				</ul>


				<h3 class="terms-stit">수집항목</h3>
				<ul class="terms-list">
					<li>필수항목: 성함/직급, 회사명, 연락처, 이메일, 제작분야, 의뢰내용, 예산규모, 견적요청방법</li>
					<li>선택항목: 홈페이지 정보</li>
				</ul>


				<h3 class="terms-stit">보유이용기간</h3>
				<p class="terms-txt02">
					원칙적으로, 개인정보 수집 및 이용목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 다음의 정보에 대해 서는 아래의 이유로 명시한 기간 동안 보존합니다.
				</p>
				<ul class="terms-list">
					<li>보존 이유 : 고객의 동의를 통한 의뢰정보 유지</li>
					<li>보존 기간 : 고객의 삭제 요청시까지</li>
				</ul>


				<h3 class="terms-stit">동의를 거부할 권리와 이익</h3>
				<p class="terms-txt02">
					위 개인정보 중 필수적 정보의 수집•이용에 관한 동의는 프로젝트 상담을 위하여 필수적이므로, 위 사항에 동의하셔야만 상담이 가능합니다. 위 개인정보 중 선택적 정보의 수집•이용에 관한 동의는 거부하실 수 있으며, 다만 동의하지 않으시는 경우 프로젝트 의뢰시 정확한 정보를 제공 받으실 수도 있습니다.
				</p>
			
				<a href="#n" class="terms-pop-close"><span class="blinde">개인정보처리방침 팝업 닫기</span></a>
			</div> <!-- rel-box :: e -->
		</div> <!-- terms-txt-box :: e -->


	</div> <!-- project-pop-inwrap :: e -->
</div> <!-- project-pop-box :: e -->

</form>

<script>
	$(function() {
		// 예산규모 select 커스텀
		$('#rnb dt a').click(function() {
			$(this).closest('dl').toggleClass('on');
			$(this).closest('dl').find('dd').stop().slideToggle('200');
			return false;
		});

		// 예산규모 선택
		$("#rnb dd ul li a span").click(function() {
			var text = $(this).html();
			$("#rnb dt a" ).html(text);
			$('input[name=money]').val(text)
			$(this).closest('dl').toggleClass('on');
			$(this).closest('dl').find('dd').stop().slideToggle('200');
		});

		// 제작분야 하나만 선택 가능
		$('input[name=make_product]').click(function() {
			if ($(this).prop('checked')) {
				$('input[type="checkbox"][name="make_product"]').prop('checked', false);
				$(this).prop('checked', true);
			}
		});




		// 견적방법 select 커스텀
		$('#estimate_dl dt a').click(function() {
			$(this).closest('dl').toggleClass('on');
			$(this).closest('dl').find('dd').stop().slideToggle('200');
			return false;
		});

		// 견적방법 선택
		$("#estimate_dl dd ul li a span").click(function() {
			var text = $(this).html();
			$("#estimate_dl dt a" ).html(text);
			$('input[name=consult_method]').val(text)
			$(this).closest('dl').toggleClass('on');
			$(this).closest('dl').find('dd').stop().slideToggle('200');
		});



	});

	
	/* 프로젝트 팝업 */
	$('.project-btn').click(function(){
		$('#project-pop-box').fadeIn();
		return false;
	});
	$('.project-pop-close').click(function(){
		$('#project-pop-box').fadeOut();
		return false;
	});


	$(document).ready(function(){
		$(".terms-pop").click(function(){
			$('#terms-txt-box').stop().animate({right:'0'},300,"swing");
		});

		$(".terms-pop-close").click(function(){
			$('#terms-txt-box').stop().animate({right:'-100%'},300,"swing");
		});
	});

	$(document).ready(function(){
		$('.project-btn').click(function(){	
			$('.menu-btn').css('display', 'none');
		});
		$('.project-pop-close').click(function(){
			$('.menu-btn').css('display', 'block');
		});
	});
</script>