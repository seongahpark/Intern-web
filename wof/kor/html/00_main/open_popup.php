<?
	$now_date		= date("Y-m-d");
	$db_table		= "h_popup";
	$sql_popup		= "select * from ".$db_table." where isdel = '0'";
	$sql_popup=$sql_popup." and start<='".$now_date."' and end>='".$now_date."' and puse='1'";

	//201021 박성아 팝업창 다수가 뜰 수 있도록 수정, 
	//이전 버전은 open_popup_201021.php, layer_popup_201021.php 에서 확인
	$result = Mysql_query($sql_popup);
	$comment = Mysql_num_rows($result);

	if(!$result)
	{
		error_msg('DB 질의가 실패했습니다.\\n에러코드[popup0001]');
		exit;
	}

	while($rs_popup = Mysql_fetch_array($result)){
		$i = $rs_popup["idx"];

		$tmpCname	= "jj_layer" . $i;
		$POPUP_CHK	= $_COOKIE[$tmpCname];
	
		$wich = explode("|$|",$rs_popup["pxy"]);
		$size = explode("|$|",$rs_popup["sxy"]);
		$scroll = $rs_popup["scroll"];
		if($scroll=="1")
		{
			$scroll="1";
			$overflow="overflow:auto;";
		}
		else
		{
			$scroll="0";
			$overflow="overflow:visible;";
		}
		if($_COOKIE["showimage"]=="")
		{	
			include 'layer_popup.php';
		}
		else
		{
			include 'o_popups.php';
			popup( "/kor/html/00_main/basic_popup.php", $rs_popup['idx'], $size[0], $size[1], $wich[0], $wich[1],$scroll);
		}
	}	
?>