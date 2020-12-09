<?	//include_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/07_Session/inc/subHead.php');
	include "../conn/conn.php";
	header( "Content-type: application/vnd.ms-excel; charset=utf-8");
	header( "Content-Disposition: attachment; filename = excel_test.xls" );     //filename = 저장되는 파일명을 설정합니다.
	header( "Content-Description: PHP4 Generated Data" );


	
	$EXCEL_FILE = "
	<table border='1'>
		<tr>
		   <td>세션 종류</td>
		   <td>언어</td>
		   <td>소속</td>
		   <td>연락처</td>
		   <td>이메일</td>
		   <td>성명</td>
		</tr>
	";
	$selectSQL		= "SELECT session_type, language, belong, number, email, name from statistics order by stat_date , time ,session_type, LANGUAGE asc ";
	$res			= mysql_query($selectSQL);
	// DB 에 저장된 데이터를 테이블 형태로 저장합니다.
	while ($row = mysql_fetch_array($res)) {
		switch($row["language"]){
				case 1:
					$lang_convert = "국문";
					break;
				case 2:
					$lang_convert = "영문";
					break;
				case 3:
					$lang_convert = "일문";
					break;
				case 4:
					$lang_convert = "중문";
					break;
		}	
	$EXCEL_FILE .= "
		<tr>
		   <td>".$row["session_type"]."</td>
		   <td>".$lang_convert."</td>
		   <td>".$row["belong"]."</td>
		   <td>".$row["number"]."</td>
		   <td>".$row["email"]."</td>
		   <td>".$row["name"]."</td>
		</tr>
	";
	}
	$EXCEL_FILE .= "</table>";
	// 만든 테이블을 출력해줘야 만들어진 엑셀파일에 데이터가 나타납니다.
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	echo $EXCEL_FILE;
?>
