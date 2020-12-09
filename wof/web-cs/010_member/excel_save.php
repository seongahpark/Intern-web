<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/web-cs/config_init.php';

$filename='일반회원_'.date('YmdHis');
$excel_title=$filename;
$filename=$filename.'.xls';
header( "Content-type: application/vnd.ms-excel" );   
header( "Content-type: application/vnd.ms-excel; charset=utf-8");  
header( "Content-Disposition: attachment; filename = $filename.xls" );   
header( "Content-Description: PHP4 Generated Data" );   

$_jobkind=array("","공무원/공공기관","기업","교직원/연구기관","기타");

$DB_TABLE	= 'member';

//삭제한 게시물
//$append=" IsDel='0'";
$append=" 1";

//게시판 기본
$sql="select ";
$sql=$sql." * ";
$sql=$sql."from `".$DB_TABLE."` ";
//20190821 신상원 세션재등록일만 체크하도록 수정함
$sql=$sql." where ".$append." and (LEFT(reg_date, 4) = ".date("Y")." || LEFT(reApply, 4) = ".date("Y").")";
$sql=$sql." order by `idx` desc ";

$result = mysql_query($sql);

echo '
<meta http-equiv="Content-Type" content="application/vnd.ms-excel;charset=utf-8">

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#d3d3d3" frame="hsides" rules="rows" style="border-top-color:#666666; border-collapse:collapse;">
	<tr>
		<td colspan="26" align="center"><span style="font-size:16pt;"><strong>'.$excel_title.'</strong></span></td>
	</tr>
	<tr>
		<th rowspan="2" bgcolor="ededed">회원번호</th>
		<th rowspan="2" bgcolor="ededed">회원분류</th>
		<th rowspan="2" bgcolor="ededed">담당</th>
		<th rowspan="2" bgcolor="ededed">이메일(아이디)</th>
		<th rowspan="2" bgcolor="ededed">호칭</th>
		<th rowspan="2" bgcolor="ededed">이름 - 성</th>
		<th rowspan="2" bgcolor="ededed">이름 - 이름</th>
		<th rowspan="2" bgcolor="ededed">영문이름 - 성</th>
		<th rowspan="2" bgcolor="ededed">영문이름 - 이름</th>
		<th rowspan="2" bgcolor="ededed">소속</th>
		<th rowspan="2" bgcolor="ededed">영문소속</th>
		<th rowspan="2" bgcolor="ededed">직책</th>
		<th rowspan="2" bgcolor="ededed">영문직책</th>
		<th rowspan="2" bgcolor="ededed">국적</th>
		<th rowspan="2" bgcolor="ededed">거주국가</th>
		<th rowspan="2" bgcolor="ededed">휴대전화</th>
		<th rowspan="2" bgcolor="ededed">일반전화</th>
		<th rowspan="2" bgcolor="ededed">세션재등록일</th>
		<th rowspan="2" bgcolor="ededed">가입일</th>
		<th rowspan="2" bgcolor="ededed">최종방문일</th>
		<th rowspan="2" bgcolor="ededed">가입언어</th>

		<th rowspan="2" bgcolor="ededed">직업분류</th>
		<th rowspan="2" bgcolor="ededed">직업분류2(해양관련여부)</th>
		<th rowspan="2" bgcolor="ededed">거주지역</th>

		<th rowspan="2" bgcolor="ededed">개막식&기조세션</th>
		<th rowspan="2" bgcolor="ededed">정규세션1</th>
		<th rowspan="2" bgcolor="ededed">특별세션1</th>
		<th rowspan="2" bgcolor="ededed">정규세션2</th>
		<th rowspan="2" bgcolor="ededed">특별세션2</th>
		<th rowspan="2" bgcolor="ededed">정규세션3</th>
		<th rowspan="2" bgcolor="ededed">특별세션3</th>
		<th rowspan="2" bgcolor="ededed">정규세션4</th>
		<th rowspan="2" bgcolor="ededed">특별세션4</th>
		<th rowspan="2" bgcolor="ededed">에필로그세션</th>

		<th rowspan="2" bgcolor="ededed">참가경로</th>
		<th rowspan="2" bgcolor="ededed">참가목적</th>
	</tr>
	<tr>
	';
echo '</tr>';

if(!$result)
{
	error_msg('DB 질의가 실패했습니다.\\n에러코드[050_member:001]');
	exit;
}

while($row = mysql_fetch_array($result))
{
	switch($row['user_type'])
	{
		case '10':
			$user_type='일반참가자';
			$user_detail_type	= '-';
			break;
		case '20':
			$user_type='연사';

			switch($row['user_detail_type'])
			{
				case '10':
					$user_detail_type='좌장';
					break;
				case '20':
					$user_detail_type='발표자';
					break;
				case '30':
					$user_detail_type='토론자';
					break;
				default:
					$user_detail_type='오류[정보없음]';
					break;
			}
			break;
		default:
			$user_type			= '오류[정보없음]';
			$user_detail_type	= '오류[정보없음]';
			break;
	}

	switch($row['appellation'])
	{
		case '10':
			$appellation='Mr.';
			break;
		case '20':
			$appellation='Ms.';
			break;
		case '30':
			$appellation='Dr.';
			break;
		case '40':
			$appellation='Prof.';
			break;
		case '50':
			$appellation='Ph. D.';
			break;
		case '60':
			$appellation='student';
			break;
		case '70':
			$appellation='기타';
			break;
		default:
			$appellation='오류[정보없음]';
			break;
	}

	$cont_apply='';

	for($i=0;$i<count($session_code);$i++)
	{
		$sql=" select ";
		$sql=$sql." count(`idx`) as `cnt` ";
		$sql=$sql." from ";
		$sql=$sql." `program_apply` a";
		$sql=$sql." where ";
		$sql=$sql." `isdel`=0 ";
		$sql=$sql." and `session_code_idx`='".$session_code[$i]['idx']."' ";
		$sql=$sql." and `user_idx`='".$rs_board->fields['idx']."' ";

		$rs_apply=$conn->Execute($sql);

		if($rs_apply->fields['cnt'])
		{
			$cont_apply=$cont_apply.'<td align="center" style="white-space:nowrap;color:red;">O</td>';
		}
		else
		{
			$cont_apply=$cont_apply.'<td align="center" style="white-space:nowrap"></td>';
		}
	}
	for($i=0;$i<count($session_code_eng);$i++)
	{
		$sql=" select ";
		$sql=$sql." count(`idx`) as `cnt` ";
		$sql=$sql." from ";
		$sql=$sql." `program_apply_eng` a";
		$sql=$sql." where ";
		$sql=$sql." `isdel`=0 ";
		$sql=$sql." and `session_code_idx`='".$session_code_eng[$i]['idx']."' ";
		$sql=$sql." and `user_idx`='".$rs_board->fields['idx']."' ";

		$rs_apply=$conn->Execute($sql);

		if($rs_apply->fields['cnt'])
		{
			$cont_apply=$cont_apply.'<td align="center" style="white-space:nowrap;color:red;">O</td>';
		}
		else
		{
			$cont_apply=$cont_apply.'<td align="center" style="white-space:nowrap"></td>';
		}
	}
	
	$interest1='';
	$interest2='';
	$interest3='';
	$interest4='';
	$interest5='';
	$interest6='';
	$interest7='';
	$interest8='';
	$interest9='';
	$interest10='';
	$interest11='';
	$interest12='';
	$interest13='';

	$roots='';
	$object='';
	$etcVal1='';
	$etcVal2='';
	$etcVal3='';

	if(($row['interest1'])=="Y"){
		$interest1 = "O";
	}
	if(($row['interest2'])=="Y"){
		$interest2 = "O";
	}
	if(($row['interest3'])=="Y"){
		$interest3 = "O";
	}
	if(($row['interest4'])=="Y"){
		$interest4 = "O";
	}
	if(($row['interest5'])=="Y"){
		$interest5 = "O";
	}
	if(($row['interest6'])=="Y"){
		$interest6 = "O";
	}
	if(($row['interest7'])=="Y"){
		$interest7 = "O";
	}
	if(($row['interest8'])=="Y"){
		$interest8 = "O";
	}
	if(($row['interest9'])=="Y"){
		$interest9 = "O";
	}
	if(($row['interest10'])=="Y"){
		$interest10 = "O";
	}
	/*
	if(($rs_board->fields['interest11'])=="Y"){
		$interest11 = "O";
	}
	if(($rs_board->fields['interest12'])=="Y"){
		$interest12 = "O";
	}
	if(($rs_board->fields['interest13'])=="Y"){
		$interest13 = "O";
	}
	*/
	/*
	if(($rs_board->fields['interest12'])=="Y"){
		
		if(($rs_board->fields['etcVal1'])!=""){
			$etcVal1=" [".$rs_board->fields['etcVal1']."]";
		}
		$interest12 = '기타 : '.$etcVal1;
	}*/

	//20201106 박성아 메뉴명이 일치하지않아 수정
	if(($row['roots1'])=="Y"){
		$roots.='초청장 및 리플릿</br>';
	}
	if(($row['roots2'])=="Y"){
		$roots.='일간지 및 해양 전문지</br>';
	}
	if(($row['roots3'])=="Y"){
		$roots.='TV 및 라디오 광고</br>';
	}
	if(($row['roots4'])=="Y"){
		$roots.='인터넷 보도자료</br>';
	}
	if(($row['roots5'])=="Y"){
		$roots.='이메일 뉴스레터</br>';
	}
	if(($row['roots6'])=="Y"){
		$roots.='SNS(유튜브, 페이스북, 인스타그램 등)</br>';
	}
	if(($row['roots7'])=="Y"){
		$roots.='현수막 및 가로등 배너</br>';
	}
	if(($row['roots8'])=="Y"){

		if(($row['etcVal2'])!=""){
			$etcVal2=" [".$row['etcVal2']."]";
		}
		$roots.='기타'.$etcVal2.'</br>';
	}

	if(($row['object1'])=="Y"){
		$object.='관련분야의 정보수집 및 지식습득</br>';
	}
	if(($row['object2'])=="Y"){
		$object.='선호연사의 강연청강</br>';
	}
	if(($row['object3'])=="Y"){
		$object.='흥미로운 주제와 컨텐츠</br>';
	}
	if(($row['object4'])=="Y"){
		$object.='관련 업계와의 네트워킹</br>';
	}
	if(($row['object5'])=="Y"){
		$object.='지인의 권유</br>';
	}
	if(($row['object6'])=="Y"){
		
		if(($row['etcVal3'])!=""){
			$etcVal3=" [".$row['etcVal3']."]";
		}
		$object.='기타'.$etcVal3.'</br>';
	}

	echo '
		<tr>
			<td align="center" style="white-space:nowrap">'.$row['idx'].'</td>
			<td align="center" style="white-space:nowrap">'.$user_type.'</td>
			<td align="center" style="white-space:nowrap">'.$user_detail_type.'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['user_id']).'</td>
			<td align="center" style="white-space:nowrap">'.$appellation.'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['user_name1']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['user_name2']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['eng_user_name1']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['eng_user_name2']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['belong']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['eng_belong']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['position']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['eng_position']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['nationality']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['residence']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['mobile']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['tel']).'</td>
			<td align="center" style="white-space:nowrap">'.stripslashes($row['reApply']).'</td>
			<td align="center" style="white-space:nowrap">'.$row['reg_date'].'</td>
			<td align="center" style="white-space:nowrap"></td>
			<td align="center" style="white-space:nowrap">'.$row['lan'].'</td>

			<td align="center" style="white-space:nowrap">'.$_jobkind[$row['jobkind']].'</td>
			<td align="center" style="white-space:nowrap">'.$row['jobkind2'].'</td>
			<td align="center" style="white-space:nowrap">'.$row['region'].'</td>

			<td align="center" style="white-space:nowrap">'.$interest1.'</td>
			<td align="center" style="white-space:nowrap">'.$interest2.'</td>
			<td align="center" style="white-space:nowrap">'.$interest3.'</td>
			<td align="center" style="white-space:nowrap">'.$interest4.'</td>
			<td align="center" style="white-space:nowrap">'.$interest5.'</td>
			<td align="center" style="white-space:nowrap">'.$interest6.'</td>
			<td align="center" style="white-space:nowrap">'.$interest7.'</td>
			<td align="center" style="white-space:nowrap">'.$interest8.'</td>
			<td align="center" style="white-space:nowrap">'.$interest9.'</td>
			<td align="center" style="white-space:nowrap">'.$interest10.'</td>		
			<td align="center" style="white-space:nowrap">'.$roots.'</td>
			<td align="center" style="white-space:nowrap">'.$object.'</td>
		</tr>
		';
}

echo '</table>';
?>
<!-- 
106번줄에 		<th bgcolor="ededed" colspan="'.count($session_code).'">등록세션</th>
107번줄에			<th bgcolor="ededed" colspan="'.count($session_code_eng).'">영문등록세션</th>
426번줄에 '.$cont_apply.' 가 있었음 (작은 따옴표 포함) 세션을 표시하는 부분인데 삭제해달라고 해서 삭제함--> 