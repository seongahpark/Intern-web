<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/07_Session/inc/subHead.php');?>
<?php
	include "../conn/conn.php";
	$getQuery = "select * from session_jpn where idx='".$_GET["idx"]."'";
	$res = mysql_query($getQuery, $conn);
	$row = mysql_fetch_array($res);
	$list_url = "./SessionList.php?admin_type=SessionList";
?>
<h3 class="u-tit02">일문</h3>
<div class="board-view-wrap">
	<span class="bd-line"></span>
	<table>
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			  <col width="180">
			  <col width="*"> 
			  <col width="180">
			  <col width="*"> 
		  </colgroup>
		  <tbody>
			  <tr>
				  <th><span>세선종류</span></th>
				  <td><p><?=$row["kind"]?></p></td>
			  </tr>
			  <tr>
				  <th><span>세션명</span></th>
				  <td><p><?=$row["title"]?></p></td>
			  </tr>
			   <tr>
				  <th><span>유튜브주소</span></th>
				  <td><a href="<?=$row["video"]?>"><?=$row["video"]?></a></td>
			  </tr>
			  <tr>
				  <th><span>세션 소개글</span></th>
				  <td><textarea style="width:100%; height:200px; resize:none;" readonly="readonly"><?=$row["text"]?></textarea></td>
			  </tr>
			  <tr>
				  <th><span>좌장</span></th>
				  <td><p><?=$row["place"]?></p></td>
			  </tr>
			  <tr>
				  <th><span>기조연설</span></th>
				  <td><textarea style="width:100%; height:100px; resize:none;" readonly="readonly"><?=$row["speech"]?></textarea></td>
			  </tr>
			  <tr>
				  <th><span>세션기조</span></th>
				  <td><textarea style="width:100%; height:100px; resize:none;" readonly="readonly"><?=$row["keynote"]?></textarea></td>
			  </tr>
			  <tr>
				  <th><span>발제자</span></th>
				  <td><textarea style="width:100%; height:100px; resize:none;" readonly="readonly"><?=$row["present"]?></textarea></td>
			  </tr>
			  <tr>
				  <th><span>토론좌장</span></th>
					<td><p><?=$row["panel"]?></p></td>
			  </tr>
			  <tr>
				  <th><span>토론자</span></th>
					<td><textarea style="width:100%; height:100px; resize:none;" readonly="readonly"><?=$row["panelist"]?></textarea></td>
			  </tr>
			  </tbody>
	</table>
</div>

	<div class="gap"></div>
	<div class="fr">
		<button class="bw-btn" onclick="location.href='<?=$list_url?>'"><span>목록</span></button>
	</div>
<div class="gap"></div>
<!--// page end -->
<? include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/subTail.php');?>