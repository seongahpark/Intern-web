<?php
if(!is_object($process)) die('error process');

$process->sql = "select * from consult where idx='".$idx."'";
$ret = $process -> query();
if(!is_resource($ret)) die('error');
$row = mysql_fetch_array($ret);
if(!$row) history_go(-1,'등록된 업체가 없습니다.');

$benchmark_url	= @explode(",",$row['benchmark_url']);

//첨부파일
$sql			   = "select fidx,idx,sname,rname,type from common_file where bid='consult' and idx='".$idx."'";
$process -> sql     = $sql;
$fret = $process    -> query();
$fnum = mysql_num_rows($fret);

//print_r($row);
?>
<script type="text/javascript">
<!--

function downContents(fidx){
	var form = document.down_form;
	form.fidx.value = fidx;
	form.submit();
}

function delCheck(){
	var form=document.delete_form;
	var msg = confirm('정말 삭제하시겠습니까?');
	if(msg==true) form.submit();
}

function fileDown(fidx){
	var form		   = document.down_form;
	form.fidx.value    = fidx;
	form.submit();
}

//-->
</script>
<div class="board_btn">
 <p class="pl7 fl">
     <a href="<?=SELF?>?<?=$_params['modi']?>"><img src="../images/board/btn/modify.jpg" alt="수정" /></a>
     <a href="#none" onclick="javascript:delCheck();"><img src="../images/board/btn/del.jpg" alt="삭제" /></a>
     <a href="<?=SELF?>?<?=$_params['list']?>"><img src="../images/board/btn/list.jpg" alt="목록" /></a>
 </p>
 <p class="fr pr5"><a href="#"><img src="../images/board/btn/print.jpg" alt="프린트" /></a></p>
</div>
<div class="board_sc">

<table class="board_write" id="write_table">
  <colgroup>
        <col width="13%" />
        <col width="*" />
  </colgroup>

  <tbody>
  <tr>
      <td class="tdl">문의 대상</td>
      <td  class="tdr"><?=$row['consult_div'];?></td>
    </tr>
	<tr>
      <td class="tdl">상담일</td>
      <td  class="tdr"><?=substr($row['consult_date'],0,10)?></td>
    </tr>
	<tr>
      <td class="tdl">요청일</td>
      <td  class="tdr"><?=$row['regdate']?></td>
    </tr>
	<tr>
      <td class="tdl">상담자</td>
      <td  class="tdr"><?=$row['staff_name']?></td>
    </tr>
	<tr>
      <td class="tdl">진행상황</td>
      <td  class="tdr">
		<?=$row['state']?>
	  </td>
    </tr>

    <tr>
      <td class="tdl">업체명</td>
      <td  class="tdr"><?=$row['cp_name']?></td>
    </tr>



     <tr>
      <td class="tdl">담당자명</td>
      <td  class="tdr"><?=$row['dam_name']?></td>
    </tr>
	<tr>
      <td class="tdl_no">연락처(직통)</td>
      <td  class="tdr">
		<?=$row['dam_tel']?>
	  </td>
    </tr>
	<tr>
      <td class="tdl_no">핸드폰(담당자)</td>
      <td  class="tdr">
		<?=$row['dam_phone']?>
	  </td>
    </tr>
	<tr>
      <td class="tdl_no">이메일(담당자)</td>
      <td  class="tdr">
		<?=$row['dam_email']?>
	  </td>
    </tr>
     <tr>
      <td class="tdl">WEB URL</td>
      <td  class="tdr">
		   <input type="radio" class="check-box"  id="web-no"  <?if($row["web_url_chk"]=="N"):?> checked<?else:?><?endif;?> />
		   <label for="web-no">없음</label>
		   <input type="radio" class="check-box" id="web-yes"  <?if($row["web_url_chk"]=="Y"):?> checked<?else:?><?endif;?> />
		   <label for="web-yes">있음(해당주소 기입)</label>
							<br>
		<?=$row['web_url']?>
	  </td>
    </tr>
   <tr>
		<td class="tdl" rowspan="3">참고사이트</td>
		<td  colspan="3"><span class="fl pr5">1.</span><?=$benchmark_url[0]?></td>
	</tr>
	<tr>
		<td  colspan="3"><span class="fl pr5">2.</span><?=$benchmark_url[1]?></td>
	</tr>
	<tr>
		<td  colspan="3"><span class="fl pr5">3.</span><?=$benchmark_url[2]?></td>
	</tr>
  <tr>
    <td class="tdl">제작상품</td>
    <td  colspan="3">
		<?=$row['make_product']?>
    </td>
  </tr>
<!--
    <tr>
    <td class="tdl">제작유형</td>
    <td  colspan="3">
		<?=$row['make_type']?>
    </td>
  </tr>
-->
  <tr>
    <td class="tdl">업체예산</td>
    <td  colspan="3"><?=$row['c_money']?>만원~<?=$row['c_moneyMax']?>만원</td>
  </tr>
  <tr>
    <td class="tdl">예상책정가</td>
    <td  colspan="3"><?=$row['cp_est']?>만원</td>
  </tr>
  <tr>
    <td class="tdl">예상견적</td>
    <td  colspan="3"><?=$row['e_money']?>만원</td>
  </tr>
  <tr>
    <td class="tdl">견적방법(요청)</td>
    <td  colspan="3">
		<?=$row['consult_method']?>
    </td>
  </tr>
  <tr>
    <td class="tdl">성사여부</td>
    <td  colspan="3">
		<?=$row['yns']?>
    </td>
  </tr>
    <tr>
      <td class="tdl">메모</td>
      <td  class="tdr"><?=$row['contents']?></td>
    </tr>
    <tr>
      <td class="tdl">파일첨부</td>
      <td  class="tdr">

		<?php
		if($fnum==0):
			echo "등록된 첨부파일이 없습니다.";
		else:
		for($f=0;$f<$fnum;$f++):
			$frow = mysql_fetch_assoc($fret);

			//print_r($frow);
		?>
			<p><a href="fileDown.php?idx=<?=$idx?>" onclick="javascript:fileDown(<?=$frow['fidx']?>);return false;"><?=$frow['rname']?></a></p>
		<?endfor;
		endif;?>

	  </td>
    </tr>
  </tbody>
</table>

</div>
<form name="down_form" method="post" action="../web_control/control_filedown.php">
	<input type="hidden" name="fidx"	value="">
	<input type="hidden" name="ftype"   value="consult">
	<input type="hidden" name="process" value="fileDownLoad">
</form>
<form name="delete_form" method="post" action="../web_control/control_consult.php">
	<input type="hidden" name="idx"	value="<?=$idx?>">
	<input type="hidden" name="process" value="delete">
	<input type="hidden" name="params" value="<?=$_params['list']?>">
</form>
