<link rel="stylesheet" type="text/css" href="../../boss/js/axisj-1.1.11/ui/arongi/AXJ.min.css"/>
<link rel="stylesheet" type="text/css" href="../../boss/js/axisj-1.1.11/ui/arongi/AXInput.css" />
<link rel="stylesheet" type="text/css" href="../../boss/js/axisj-1.1.11/ui/arongi/AXSelect.css" />
<link rel="stylesheet" type="text/css" href="../../boss/js/axisj-1.1.11/ui/arongi/AXProgress.css" />
<link rel="stylesheet" type="text/css" href="/../../boss/js/axisj-1.1.11/axicon/axicon.min.css" />
<script type="text/javascript" src="../../boss/js/axisj-1.1.11/jquery/jquery.min.js"></script>
<script type="text/javascript" src="../../boss/js/axisj-1.1.11/dist/AXJ.min.js"></script>
<script type="text/javascript" src="../../boss/js/axisj-1.1.11/lib/AXInput.js"></script>
<script type="text/javascript" src="../../boss/js/axisj-1.1.11/lib/AXSelect.js"></script>
<script type="text/javascript" src="../../boss/js/axisj-1.1.11/lib/AXProgress.js"></script>
<?php
	if(!is_object($process)) die('error process');
	require_once(CMS_ROOT."/common/class_paging_new.php");

	$sclass = new pagingClass($process);

	$svTitle01 = array('name','type');
	$svTitle02 = array('');

	$searchFlag= false;
	$searchFlag= in_array($sv,$svTitle01);
	//$sv        = $searchFlag ? $sv : 'title';
	$sv = $svTitle01;
	$vrecord   = 15;
	$pageSQL   = "select *,DATE_FORMAT(`sdate`,'%Y-%m-%d') as sdate,DATE_FORMAT(`edate`,'%Y-%m-%d') as edate ";
	$pageSQL  .= " from vacation_tbl";
	$sclass -> pageSQL		= $pageSQL;
	$sclass -> viewPage		= 10;
	$sclass -> scale		= $vrecord;
	$sclass -> page			= $page;
	$sclass -> sv			= $sv;
	$sclass -> sw			= $sw;
	$sclass -> ex_type		= $ex_type;
	$sclass -> where		= "where 1".$add_where;
	$sclass -> get			= "view=".$view;
	$sclass -> orderBy	    = " order by sdate desc";
	$sclass -> groupBy	    = "";
	$sclass -> npageStyle	= "font-size:12px;color:#0b68bb;font-weight:bold;";
	$sclass -> pageStyle	= "";
	$listImgIcon            = array("../images/board/arrow_01.jpg","../images/board/arrow_02.jpg","../images/board/arrow_03.jpg","../images/board/arrow_04.jpg",);
	$sclass -> listImg		= $listImgIcon;
	$sclass -> svTitle01	= $svTitle01;
	$Result    = $sclass   -> pagingView();

	$confirmArray = Array("Y"=>"승인","N"=>"승인대기");
?>
<script type="text/javascript">
	<!--
	function delCheck(){
		var form=document.list_form;
		if(!All_Check_Num(form,'idx[]',1,'휴가신청')) return;
		var msg = confirm('정말 삭제하시겠습니까?');
		if(msg==true) form.submit();
	}
	function cAlert(title,oData,cData){
	  var alertConfig = {
	    body:title,
	    top:100,
	    type:'Caution',
	    buttons:[
	      {buttonValue:'확인', buttonClass:'Red ', onClick:oData.func, data:oData.param}
	    ]
	  }
		//취소 버튼 정보가 없는 경우 취소버튼을 생성 하지 않는다.
		if(cData){
			alertConfig.buttons.push({buttonValue:'취소', buttonClass:'Blue', onClick:cData.func, data:cData.param});
		}
	  dialog.push(alertConfig);
	}

	function deleteVacation(){
		if ($(".idxClass:checked").length > 0) {
			var checkValues = [];
			var idxValue = "";
			cAlert("삭제하시면 복구가 불가능 합니다.<br/>삭제 하시겠습니까?",{func:function(){
				$(".idxClass:checked").each(function(){
					checkValues.push($(this).val());
				});
				idxValue = checkValues.join(",");
				$.ajax({
					url:"../web_control/control_vacation.php",
					data:{process:"del",idxs:idxValue},
					type:"post",
					dataType:"json",
					success:function(res){
						if (res.result=="success") {
							cAlert("휴가신청 기록이 삭제 되었습니다.<br/>데이터를 다시 불러옵니다.",{func:function(){
								location.reload();
							},param:""});
						}else{
							toast.push("삭제처리가 실패 했습니다.");
						}
					},
					error:function(e){
            //console.log(e.responseText);
					},
					complete:function(){

					}
				});
			},param:""},{func:"",param:""});
		}else{
			toast.push("삭제할 대상을 선택해 주십시요.");
		}
	}
	$(function(){

	});
	//-->
</script>
<div class="board_btn">
 <p class="pl7 fl">
     <button type="button"  class="AXButton Red" id="button" onclick="location.href='./applyVacation_test.php?view=vacWrite';">
       <i class="axi axi-control-point-duplicate"></i>등록하기
     </button>
     <button type="button"  class="AXButton " id="button" onclick="deleteVacation();">
       삭제
     </button>
	 <?if($_SESSION["login_auth"]==9):?>
	 <!-- 201228 박성아 엑셀다운로드 기능 -->
	 <form method="GET" action="./excelDown.php">
     <button type="submit"  class="AXButton Red" id="button" style="float: right; margin-right: 10px;">
       <i class="axi axi-control-point-duplicate"></i>엑셀 다운로드
     </button>
	 <?
		 // 보여질 년도의 범위
		 $yearRange = 5;
		 // 선택되어질 년도
		 $ageLimit = 0;

		 $currentYear = date('Y');
		 $startYear = ($currentYear - $yearRange);
		 $selectYear = ($currentYear - $ageLimit);
		 echo '<select name="year" style="float: right; margin-right: 10px; height:28px;">';
		 foreach (range($currentYear, $startYear) as $year) {
			$selected = "";
			if($year == $selectYear) { $selected = " selected"; }
			echo '<option' . $selected . '>' . $year . '년도</option>';
		 }
		 echo '</select>';
	 ?>
	 </form>
	 <?endif;?>
     <p  style="display:none;font-size:15px; float:right; padding-right:20px;">TotalRecords : <span style="color:#2F9D27"><?=$Result['totalRecord']?></span></p>
 </p>
</div>

<div class="board_box">
  <div class="board_search">
	 <form name="search_form" method="get" action="<?=SELF?>">
	 <input type="hidden" name="page" value="<?=$page?>" class="search_input fl" />
	 <input type="hidden" name="view" value="<?=$view?>" class="search_input fl" />
	 <input type="hidden" name="staff" value="<?=$staff?>" class="search_input fl" />
	 <input type="hidden" name="dis" value="<?=$dis?>" class="search_input fl" />
	 <input type="hidden" name="page" value="<?=$name?>" class="search_input fl" />
	 <input type="hidden" name="state" value="<?=$state?>" class="search_input fl" />

	 <input type="text" name="sw" value="<?=$sw?>" class="search_input fl" />
	 <a href="#none" class="fl" onclick="javascript:document.search_form.submit();"><img src="../images/sub/search_btn.jpg" alt="검색" /></a>
	 </form>
  </div>

  <div class="board_cont">
  <form name="list_form" method="post" action="../web_control/control_customer.php">
  <input type="hidden" name="process" value="delete">
  <input type="hidden" name="params" value="<?=$_params['list']?>">
  <table class="board_list">
	 <colgroup>
	  <col width="2%" />
	  <col width="80" />
    <col width="80" />
		<col width="60" />
	  <col width="180" />
	  <col width="100" />
	  <col width="120" />
		<col width="*" />
    <col width="50" />
		<col width="50" />
		<col width="50" />
		<col width="50" />
	<col width="50" />
	<col width="70" />
	</colgroup>
	<thead>
		  <tr>
			<th class="thl" rowspan="2"><input type="checkbox" name="all_check" value="y" class="input_check " onclick="javascript:All_Check('list_form','idx[]',this)"/></th>
			<th rowspan="2"><a class="th_off">부서</a></th>
      <th rowspan="2"><a class="th_off">직책</a></th>
			<th rowspan="2"><a class="th_off">신청자</a></th>
			<th rowspan="2"><a class="th_off">휴가기간</a></th>
			<th rowspan="2"><a class="th_off">업무대행자</a></th>
			<th rowspan="2"><a class="th_off">비상연락망</a></th>
			<th rowspan="2"><a class="th_off">사유</a></th>
			<th rowspan="2"><a class="th_off">신청합계</a></th>
			<th colspan="4"><a class="th_off">휴가종류</a></th>
			<th><a class="th_off">승인여부</a></th>
		 </tr>
		 <tr>
		 	<th ><a class="th_off">연차</a></th>
			<th ><a class="th_off">월차</a></th>
			<th ><a class="th_off">대체</a></th>
			<th ><a class="th_off">경조사등</a></th>
			<th ><a class="th_off">부서장</a></th>
      </tr>
		</thead>
	<tbody>
	<?php

	  $num = ($Result['totalRecord']-($page*$vrecord));
	  if($Result['listNum']==0) echo(" <tr><td colspan=\"11\" style='height:150px;text-align:center;'>신청정보가 없습니다.</td></tr>");
	  for($i=0;$i<$Result['listNum'];$i++):
		  $row = mysql_fetch_array($Result['listResult']);
	?>
	  <tr>
		<td class="tdl"><input type="checkbox" name="idx[]" value="<?=$row['vidx']?>" class="input_check idxClass" /></td>

		<td class="tdc">
		<a href="<?=SELF?>?view=vacModi&idx=<?=$row['vidx']?>&page=<?=$page?>&sv=<?=$sv?>&sw=<?=$sw?>"><?=$row['class']?></a>
		</td>
		<td  class="tdc"><?=$row['grade']?> </td>
		<td  class="tdc"><?=$row['name']?> </td>
		<td class="tdc"><?=$row['sdate']?>~<?=$row['edate']?></td>
		<td class="tdc"><?=$row['agent']?></td>
		<td class="tdc" ><?=$row['phone']?></td>
    <td class="tdc"><?=$row['reason']?></td>
	<td class="tdc"><?=$row['reqSumDate']?></td>
	<td class="tdc"><?=$row['date1']?></td>
	<td class="tdc"><?=$row['date2']?></td>
	<td class="tdc"><?=$row['date3']?></td>
	<td class="tdc"><?=$row['date4']?></td>
    <td class="tdc"><?=$confirmArray[$row['confirm']]?></td>
	  </tr>
      <?
		$num--;
	 endfor;
	 ?>

	</tbody>
  </table>
  </form>
</div>


<?php
if($Result['listNum']>0):
?>
<div class="board_page">
	<div class="paginate">
			<?=$Result['firstPage']?>
			<?=$Result['pageBack']?>
			<div class="pageNum"><?=$Result['nowPage']?></div>
			<?=$Result['nextPage']?>
			<?=$Result['lastPage'];?>
		</div>
</div>
<?endif?>
