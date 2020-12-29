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

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css">
<?php
if(!is_object($process)) die('error process');
$idx = $_GET["idx"];
$sql = "select *,DATE_FORMAT(`sdate`,'%Y-%m-%d') as sdate,DATE_FORMAT(`edate`,'%Y-%m-%d') as edate from vacation_tbl where vidx='".$idx."' ";
$process->sql = $sql;
$result = $process->query();
$row = mysql_fetch_assoc($result);
?>



<script type="text/javascript">
var reqDate = '';
var reqarr = [];
var cnt = 0;
function cAlert(title,oData,cData){
  var alertConfig = {
    body:title,
    top:100,
    type:'Caution',
    buttons:[
      {buttonValue:'확인', buttonClass:'Red ', onClick:oData.func, data:oData.param},
      {buttonValue:'취소', buttonClass:'Blue', onClick:cData.func, data:cData.param}
    ]
  }
  dialog.push(alertConfig);
}
  function addWork(){
    cAlert("휴가신청서를 수정 하시겠습니까?",{func:function(){
      document.workForm.submit();
    },param:""},{func:"",param:""});
  }

  $(function(){
	//201222 박성아 날짜 함수 추가
	checkBox();
	dateChk();
	dateIn();
	$("#datepicker").datepicker({
		dateFormat: 'yy-mm-dd'
        ,showOn:"button"
        ,buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif"
        ,buttonImageOnly: true
		,buttonText:"선택"
		,onSelect:function(d){
			writeDate(d);
			reqarr.push(d);
			reqarr.sort();
			$('#sdate').val(reqarr[0]);
			$('#edate').val(reqarr[reqarr.length-1]);
		}
	});
	$('img.ui-datepicker-trigger').css({'cursor':'pointer', 'margin-left':'5px', 'vertical-align':'middle'});  //아이콘(icon) 위치
    $("#SelectDateED").bindTwinDate({
      startTargetID:"SelectDate",

      align:"center",
      valign:"bottom",
      separator:"-",
      buttonText:"선택",
      onChange:function(){

      },
      onBeforeShowDay:function(date){
        /*
        if (data.getDay() == 6 || data.getDay() == 7) {
          return {isEnable:false,title:"주말은 쉬세요",className:"",style:""};
        }
        */
      }
    });
    $(".AXInputSwitch").bindSwitch({off:"사용안함", on:"사용함", onChange:function(){
      if (this.value == "사용함") {
        if($(":input[name=des]").val()!="" && $(":input[name=end]").val()==""){
          $(":input[name=end]").val($(":input[name=des]").val());
        }
        $(".useCarClass").show();
      }else{
        $(".useCarClass").hide();
      }
    }});

  });
	//201222 박성아 일자 & 휴가종류 추가
	function checkBox(){
		for(var i=1; i<5; i++){
			if($('#date'+i).val() != 0){
				$('#dateChk'+i).prop('checked', true);
				$('#date'+i).attr("disabled", false);
			}
		}	
	}

	function dateChk(){
		for(var i=1; i<5; i++){
			if($('#dateChk'+i).is(":checked")){
				$('#date'+i).attr("disabled", false);
			}else{
				$('#date'+i).attr("disabled", true);
			}
		}
		dateIn();
	}
	function dateIn(){
		var res = 0;
		var sub = 0;
		for(var i=1; i<5; i++){
			if($('#dateChk'+i).is(":checked")){
				if( i == 1 || i == 2 ) sub += Number($("#date"+i).val());
				res += Number($("#date"+i).val());
			}
		}
		$('#sumDateOut').text(res);
		$('#sumDate').val(res);
		$('#subTotalDate').val(sub);
	}

	function clearDate(){
		reqDate = '';
		cnt = 0;
		reqarr.length = 0;
		$('#reqDate').val('');
		$('#reqSumDateOut').text(cnt);
		$('#reqSumDate').val(cnt);
	}

	function writeDate(d){
		if(reqDate == ''){
			reqDate += d;
			$('#reqDate').val(reqDate);
		}
		else{
			reqDate += ', ';
			reqDate += d;
			$('#reqDate').val(reqDate);
		}
		cnt++;
		$('#reqSumDateOut').text(cnt);
		$('#reqSumDate').val(cnt);
	}
</script>
<style>
  .conBody {margin:20px;}
  .conBody .workTypeBox {margin-bottom: 1em;}
  .workBox {border:1px solid #cccccc;padding:1em;}
  .workBox li.work {line-height: 1.6em;border-bottom: 1px dashed #cccccc;margin-bottom: 1em;}
  .workBox li.work span.issue {line-height: 1.6em;margin-left:20px;display: block;}
  .workTitle {font-size:1.3em;font-weight:bold;margin-bottom:10px; display: inline-block;}
  /*.workTxt { display: inline-block;margin-left: 1em;}*/

</style>
<div class="board_box conBody">

    <div style="width:98%;">

      <div class="workTypeBox">
        <div class="workBox"  id="workInput" >
            <form name="workForm" action="../web_control/control_vacation.php" method="post" >
            <input type="hidden" value="modi" name="process">
            <input type="hidden" value="<?=$idx?>" name="vidx">
            <input type="hidden" value="vacList&page=<?=$page?>" name="params">
            <table width="100%" cellpadding="0" cellspacing="0" >
                <colgroup>
                  <col width="80" >
                  <col width="*">
                </colgroup>
                <?
                  $teamArray = Array(
                    "PG1"=>"개발1팀",
                    "PG2"=>"개발2팀",
                    "PG3"=>"개발3팀",
                    "PG4"=>"개발4팀",
                    "PL1"=>"기획팀",
                    "DG1"=>"디자인팀",
                  );
                ?>
                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >부서</td>
                    <td >
                      <input type="text" class="AXInput " name="class" value="<?=$row["class"]?>" placeholder="예) 개발팀 " style="width:20em;height:23px;margin:5px;">
                    </td>
                </tr>
                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >직책</td>
                    <td >
                      <input type="text" class="AXInput " name="grade" value="<?=$row["grade"]?>" placeholder="예) 팀장 " style="width:20em;height:23px;margin:5px;">
                    </td>
                </tr>
                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >신청자</td>
                    <td >
                      <input type="text" class="AXInput " name="name" value="<?=$row["name"]?>" placeholder="예) 심재성 " style="width:20em;height:23px;margin:5px;">
                    </td>
                </tr>
				<!--
                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >일자</td>
                    <td style="padding:5px;">
                      <input type="text" class="AXInput " id="SelectDate" value="<?=$row["sdate"]?>" name="sdate" style="width:100px;" >
                      ~
                      <input type="text" class="AXInput " id="SelectDateED" value="<?=$row["edate"]?>" name="edate" style="width:100px;" >
                    </td>
                </tr>
                <?
                  $typeSelected[$row["type"]] = "selected";
                ?>
                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >휴가종류</td>
                    <td style="padding:5px;">
                      <select name="type" style="width:80px;height:21px;border:0px none;margin:5px;">
                        <option value="연차휴가" <?=$typeSelected["연차휴가"]?> >연차휴가</option>
                        <option value="월차휴가" <?=$typeSelected["월차휴가"]?> >월차휴가</option>
                        <option value="병가" <?=$typeSelected["병가"]?> >병가</option>
                        <option value="보건휴가" <?=$typeSelected["보건휴가"]?> >보건휴가</option>
                        <option value="반차휴가" <?=$typeSelected["반차휴가"]?> >반차휴가</option>
                        <option value="경조사휴가" <?=$typeSelected["경조사휴가"]?> >경조사휴가</option>
                        <option value="교육/세미나" <?=$typeSelected["교육/세미나"]?> >교육/세미나</option>
                        <option value="출산휴가" <?=$typeSelected["출산휴가"]?> >출산휴가</option>
                        <option value="조퇴" <?=$typeSelected["조퇴"]?> >조퇴</option>
                        <option value="공무상휴가" <?=$typeSelected["공무상휴가"]?> >공무상휴가</option>
                        <option value="대체휴가" <?=$typeSelected["대체휴가"]?> >대체휴가</option>
                        <option value="기타" <?=$typeSelected["기타"]?> >기타</option>
                      </select>
                    </td>
                </tr>
				-->
				<!-- 201223 박성아 휴가신청 수정 -->
                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >일자<br>(신청합계)<br>테스트</td>
                    <td style="padding:5px;">
					  <span id="reqSumDateOut"><?=$row["reqSumDate"]?></span>일 | &nbsp;
					  <input type="hidden" id="reqSumDate" name="reqSumDate" value="<?=$row["reqSumDate"]?>">
					  <input type="hidden" id="sdate" name="sdate" value="<?=$row["sdate"]?>">
					  <input type="hidden" id="edate" name="edate" value="<?=$row["edate"]?>">
					  <input type="text" id="datepicker" style="display: none;"> &nbsp;
                      <input type="text" class="AXInput " id="reqDate" name="reqDate" style="width:600px;" value="<?=$row["reqDate"]?>" 
					  placeholder="왼쪽 달력버튼을 선택해 날짜를 선택해주세요" readonly="readonly">
					  <input type="button" value="초기화" onClick="clearDate()">
                    </td>
                </tr>
                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >휴가종류<br>(사용합계)<br>테스트</td>
                    <td style="padding:5px;">
					<span id="sumDateOut">0</span>일 | &nbsp;
					<input type="hidden" id="sumDate" name="sumDate" value="<?=$row["sumDate"]?>">
					<input type="hidden" id="subTotalDate" name="subTotalDate" value="<?=$row["subTotalDatae"]?>">
					<input type="checkbox" id="dateChk1" name="dateChk1" value="dateChk1" onClick="dateChk()"> 연차휴가 &nbsp;
					<input type="text" id="date1" name="date1" value="<?=$row["date1"]?>" style="width:40px;" onChange="dateIn()"> &nbsp;
					<input type="checkbox" id="dateChk2" name="dateChk2" value="dateChk2" onClick="dateChk()"> 월차휴가 &nbsp;
					<input type="text" id="date2" name="date2" value="<?=$row["date2"]?>" style="width:40px;" onChange="dateIn()"> &nbsp;
					<input type="checkbox" id="dateChk3" name="dateChk3" value="dateChk3" onClick="dateChk()"> 대체휴가 &nbsp;
					<input type="text" id="date3" name="date3" value="<?=$row["date3"]?>" style="width:40px;" onChange="dateIn()"> &nbsp;
					<input type="checkbox" id="dateChk4" name="dateChk4" value="dateChk4" onClick="dateChk()"> 경조사/보건/공무 등 &nbsp;
					<input type="text" id="date4" name="date4" value="<?=$row["date4"]?>" style="width:40px;" onChange="dateIn()"> &nbsp;
                    </td>
                </tr>
                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >업무대행자</td>
                    <td >
                      <input type="text" class="AXInput " name="agent" value="<?=$row["agent"]?>" placeholder="예) 심재성 팀당 " style="width:20em;height:23px;margin:5px;">
                    </td>
                </tr>
                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >비상연락망</td>
                    <td >
                      <input type="text" class="AXInput " name="phone" value="<?=$row["phone"]?>" placeholder="예) 010-333-3333 " style="width:20em;height:23px;margin:5px;">
                    </td>
                </tr>

                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >사유</td>
                    <td >
                      <textarea class="AXInput " name="reason" style="width:60em;height:10em;margin:5px;"><?=$row["reason"]?></textarea>
                    </td>
                </tr>
                <?if($_SESSION["login_auth"]==9):?>
                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >승인</td>
                    <td >
                      <label style="font-weight:bold;color:blue;">
                        담당 :
                        <select name="confirm" style="width:80px;height:21px;border:0px none;margin:5px;">
                          <?
                            $confirmSelected[$row["confirm"]] = "selected";
                            $confirm2Selected[$row["confirm2"]] = "selected";
                            $confirm3Selected[$row["confirm3"]] = "selected";
                          ?>
                          <option value="N" <?=$confirmSelected["N"]?> >미승인</option>
                          <option value="Y" <?=$confirmSelected["Y"]?> >승인</option>
                        </select>
                      </label>
                      <label style="font-weight:bold;color:blue;">
                        부서장 :
                        <select name="confirm2" style="width:80px;height:21px;border:0px none;margin:5px;">
                          <option value="N" <?=$confirm2Selected["N"]?> >미승인</option>
                          <option value="Y" <?=$confirm2Selected["Y"]?> >승인</option>
                        </select>
                      </label>
                      <label style="font-weight:bold;color:blue;">
                        대표 :
                        <select name="confirm3" style="width:80px;height:21px;border:0px none;margin:5px;">
                          <option value="N" <?=$confirm3Selected["N"]?> >미승인</option>
                          <option value="Y" <?=$confirm3Selected["Y"]?> >승인</option>
                        </select>
                      </label>
                    </td>
                </tr>
                <tr height="30" style="border-bottom: 1px dashed #cccccc;">
                    <td align="center" >승인일자</td>
                    <td >
                      <label style="margin-right:4em;">
                        담당 : <?=($row["confirm"]=="Y")?$row["checkName"]."(".$row["checkDate"].")":"승인 전"?>
                      </label>,
                      <label style="margin-right:4em;">
                        부서장 : <?=($row["confirm2"]=="Y")?$row["checkName2"]."(".$row["checkDate2"].")":"승인 전"?>
                      </label>,
                      <label style="margin-right:4em;">
                        대표 : <?=($row["confirm3"]=="Y")?$row["checkName3"]."(".$row["checkDate3"].")":"승인 전"?>
                      </label>
                    </td>
                </tr>
                <?endif;?>
                <tr height="30">
                  <td colspan="2">
                    <span style="float:right;margin-top:1em;">
                      <button type="button" class="AXButton Red btnClass" id="addBtn" onclick="addWork();"><i class="axi axi-add-circle-outline "></i>신청서 수정</button>

                      <button type="button" class="AXButton " id="closeBtn" onclick="location.href='./applyVacation_test.php?view=vacList&page=<?=$page?>';" ><i class="axi axi-delete2"></i>취소(목록으로)</button>
                    </span>
                  </td>
                </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
