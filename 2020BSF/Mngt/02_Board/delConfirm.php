<?
	$disView   = Array("OLD"=>"[OLD IMAGE]","NEW"=>"[NEW IMAGE]");
	$FileWhere = "where idx=".$idx." and dis=''";
	$FileNum   = SelectAndNum("fileboard","fileidx,idx,rname,sname,type,bid,dis",$FileWhere);

	
	IF($FileNum[num]>0){
		for($i=0;$i<$FileNum[num];$i++){
			$fileRow  = mysql_fetch_array($FileNum[result]);
			$imgName  = $saveDir.$fileRow['bid']."/".urlencode($fileRow['sname']);	#파일경로
?>

<script>
	function del_Chk(form){
		var form = document.del_form;
		var msg = confirm('정말 삭제하시겠습니까?');
		if(msg==true){
			location.href="./delConfirm.php?fidx=".$fileRow['fileidx']."&idx=".$fileRow['idx']."&bid=".$fileRow['bid']."";
		}
	}
</script>

<?
	}else{
		$linkFile  = "등록된 파일이 없습니다.!";
	}
?>