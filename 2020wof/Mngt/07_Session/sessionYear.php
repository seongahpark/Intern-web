<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/07_Session/inc/subHead.php');?>
<!--// page start -->
<div class="board-view-wrap">
<span class="bd-line"></span>
<form name="session_year" action="./insertYear.php" method="post">
    <table>
	<tbody>
	<tr>
		<th><span>제목</span></th>
		<td><input type="text" name="session_title"/></td>
	</tr>
	<tr>
	    <th><span>세션년도</span></th>
	    <td>
			<select name="session_year" class="select" style="width:100px; height:27px;">
			<?
				echo "===" .$year;
				//2015~현재년도까지
				foreach(range(date('Y'), 2010) as $year) {
				echo '<option value="'.$year.'">'.$year.'</option>';
				}       
			?>
		</select> 			
	    </td>
	</tr>
	<tr>
	    <th><span>사용여부</span></th>
	    <td>
			<select name="session_validate" class="select" style="width:100px; height:27px;">
			<option value = "Y">Y</option>
			<option value = "N">N</option>
			</select>
	    </td>
	</tr>
	</tbody>
    </table>

</div>
<div class="gap"></div>
<div class="fr">
	<button class="bpc-btn" type="submit"><span>등록</span></button>
</div>
</form>
<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>