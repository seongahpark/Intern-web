<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/07_Session/inc/subHead.php');?>
<!--// page start -->
    <table border="1">
	<th>제목</th>
	<th>2020 온라인 포럼</th>
	<tr><!-- 첫번째 줄 시작 -->
	    <td>세션년도</td>
	    <td>
			<select name="year" class="select" style="width:100px; height:27px;">
			<option value = "">년도</option>
			<?
				echo "===" .$year;
				//2010~현재년도까지
				foreach(range(date('Y'), 2010) as $year) {
				echo '<option value="'.$year.'">'.$year.'</option>';
				}       
			?>
		</select> 			
	    </td>
	</tr><!-- 첫번째 줄 끝 -->
	<tr><!-- 두번째 줄 시작 -->
	    <td>사용여부</td>
	    <td>Y</td>
	</tr><!-- 두번째 줄 끝 -->
    </table>

<div class="fr">
	<button class="bpc-btn" onclick="location.href='<?=$write_url?>'"><span>등록</span></a>
</div>
<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>