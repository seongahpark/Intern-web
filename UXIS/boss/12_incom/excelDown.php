<?
ob_start();	
?>
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?
$year = substr($_GET['year'],0,4);
$filename = "휴가신청_".$year; //GET값으로 연도 불러와 휴가신청_연도 형식으로 파일명 생성
require_once "../common/config_www.php";
header("Content-type:application/vnd.ms-excel");
header("Content-type:application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition:attachment; filename = $filename.xls");
header("Content-Description:PHP4 Generated Data");

$arr = array( //사원 이름
	array( //월
		array() //reqSumDate 등 7가지 데이터
	)
);

$tmp = array();
//class, NAME,
$sql = "select * from vacation_tbl where sdate LIKE '$year%' group by name order by name asc";
$result = mysql_query($sql);
$num = mysql_num_rows($result); //사원 수
$cnt = 0;
$total = 13;
while($nameRow = mysql_fetch_array($result)){
	$tmp = array();
	$name = $nameRow['name'];
	for($j=1; $j<=12; $j++){ // 월
		if($j < 10) $mon = "0".strval($j);
		else $mon = $j;
		$sqll = "select SUM(reqSumDate) AS 'reqSumDate', SUM(sumDate) AS 'sumDate', SUM(date1) AS 'date1',SUM(DATE2) AS 'date2', SUM(subTotalDate) AS 'subTotalDate', SUM(DATE3) AS 'date3',SUM(DATE4) AS 'date4' from vacation_tbl  WHERE name='".$name."' and sdate LIKE '$year-$mon%' group by name order by name ASC";
		$res = mysql_query($sqll);
		$tmpcnt = @mysql_num_rows($res);
		if($tmpcnt != 0) {
			while($row = @mysql_fetch_array($res)){
				$arr[$cnt][$j][0] = $row['reqSumDate'];
				$arr[$cnt][$j][1] = $row['sumDate'];
				$arr[$cnt][$j][2] = $row['date1'];
				$arr[$cnt][$j][3] = $row['date2'];
				$arr[$cnt][$j][4] = $row['subTotalDate'];
				$arr[$cnt][$j][5] = $row['date3'];
				$arr[$cnt][$j][6] = $row['date4'];

				$tmp[0] += $arr[$cnt][$j][0];
				$tmp[1] += $arr[$cnt][$j][1];
				$tmp[2] += $arr[$cnt][$j][2];
				$tmp[3] += $arr[$cnt][$j][3];
				$tmp[4] += $arr[$cnt][$j][4];
				$tmp[5] += $arr[$cnt][$j][5];
				$tmp[6] += $arr[$cnt][$j][6];
			}
		}else{
			$arr[$cnt][$j][0] = 0;
			$arr[$cnt][$j][1] = 0;
			$arr[$cnt][$j][2] = 0;
			$arr[$cnt][$j][3] = 0;
			$arr[$cnt][$j][4] = 0;
			$arr[$cnt][$j][5] = 0;
			$arr[$cnt][$j][6] = 0;
		}

		$arr[$cnt][$total][0] = $tmp[0];
		$arr[$cnt][$total][1] = $tmp[1];
		$arr[$cnt][$total][2] = $tmp[2];
		$arr[$cnt][$total][3] = $tmp[3];
		$arr[$cnt][$total][4] = $tmp[4];
		$arr[$cnt][$total][5] = $tmp[5];
		$arr[$cnt][$total][6] = $tmp[6];
	}
	$cnt++;
}

// 테이블 상단 만들기
$sql = "select * from vacation_tbl where sdate LIKE '$year%' group by name order by name asc";
$result = mysql_query($sql);
$member = 0;
$EXCEL_STR = "
<table border='1'>
<tr>
	<td bgcolor='ededed'></td>
	<td bgcolor='ededed'></td>
	<td align='center' colspan='7' bgcolor='ededed'>1월</td>
	<td align='center' colspan='7' bgcolor='ededed'>2월</td>
	<td align='center' colspan='7' bgcolor='ededed'>3월</td>
	<td align='center' colspan='7' bgcolor='ededed'>4월</td>
	<td align='center' colspan='7' bgcolor='ededed'>5월</td>
	<td align='center' colspan='7' bgcolor='ededed'>6월</td>
	<td align='center' colspan='7' bgcolor='ededed'>7월</td>
	<td align='center' colspan='7' bgcolor='ededed'>8월</td>
	<td align='center' colspan='7' bgcolor='ededed'>9월</td>
	<td align='center' colspan='7' bgcolor='ededed'>10월</td>
	<td align='center' colspan='7' bgcolor='ededed'>11월</td>
	<td align='center' colspan='7' bgcolor='ededed'>12월</td>
	<td align='center' colspan='7' bgcolor='ededed'>합계</td>
</tr>
<tr>
   <td align='center' bgcolor='ededed'>부서</td>
   <td align='center' bgcolor='ededed'>이름</td>";
for($i=0; $i<13; $i++){
$EXCEL_STR .= "
   <td align='center' bgcolor='F3E2A9'>신청합계</td>
   <td align='center' bgcolor='F3E2A9'>사용합계</td>
   <td align='center' bgcolor='ededed'>연차</td>
   <td align='center' bgcolor='ededed'>월차</td>
   <td align='center' bgcolor='CEF6CE'>소계</td>
   <td align='center' bgcolor='ededed'>대체</td>
   <td align='center' bgcolor='ededed'>경조사등</td>
   ";
}
$EXCEL_STR .= "</tr>";

while($row = mysql_fetch_array($result)) {

   $EXCEL_STR .= "
   <tr>
       <td>".$row['class']."</td>
       <td align='center'>".$row['name']."</td>";
	   for($i=1;$i<=13;$i++){
		for($j=0;$j<7;$j++){
			 $EXCEL_STR .= "<td align='center'>".$arr[$member][$i][$j]."</td>";
		}
	   }
   $EXCEL_STR .= "</tr>";
   $member++;
}

$EXCEL_STR .= "</table>";

echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> ";
echo $EXCEL_STR;
?>