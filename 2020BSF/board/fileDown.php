<?PHP
	include "../conn/conn.php";
	header("Content-Type: text/html; charset=UTF-8");

	$idx	  = $_GET['idx'];
	$Query	  = "select bid,sname,rname from fileboard where fileidx =".$idx;
	$Row	  = mysql_fetch_array(mysql_query($Query,$conn));
	$saveDir  = "../../data/".$Row['bid']."/";

	$sname	  = $Row['sname'];
	$rname	  = iconv('utf-8','euc-kr',trim($Row['rname']));
	$FilePath = $saveDir.$sname;
	
	Header("Content-Type: application/octet-stream");
	Header("Content-Disposition: attachment; filename=".$rname.";");
	Header("Content-Transfer-Encoding: binary"); 
	Header("Content-Length: ".filesize($FilePath)); 
	Header("Cache-Control: cache, must-revalidate"); 
	Header("Pragma: no-cache"); 
	Header("Expires: 0");
	$fp = fopen($FilePath, "rb");     ##rb 읽기전용 바이러니 타입
	   while(!feof($fp)) { 
		   echo fread($fp, 100*1024); ##전송
		   flush();					  ##버퍼비우기
	   } 
	fclose ($fp);

	Mysql_Query("update fileboard set down=down+1 where fileidx=".$idx,$conn);
?>