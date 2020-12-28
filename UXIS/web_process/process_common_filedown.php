<?php
class DownloadFile{


	//function process(){
		//$this->DeverProcess();
	//}
	var $saveDir;
	var $fidx;
	var $ftype;
	
	function __construct($process){
		$this->process = $process;
	}
 
	function __destruct(){
	}

	private function fileDownLoadStream($filePath,$sname,$rname){
		
		$rname = urlencode($rname);
		if(file_exists($filePath) && $sname!=""):
			header("Content-Type: application/octet-stream;");
			header("Content-Disposition: attachment; filename=$rname");
			header("Content-Transfer-Encoding: binary"); 
			header("Content-Length:".(string)(filesize($filePath))); 
			header("Cache-Control: cache, must-revalidate"); 
			header("Pragma: no-cache"); 
			header("Expires: 0");
			$fp = fopen($filePath, "rb");     ##rb 읽기전용 바이러니 타입
			   while(!feof($fp)) :
				   echo fread($fp, 100*1024); ##전송
				   flush();					  ##버퍼비우기
			   endwhile;
			fclose ($fp);
		else:
			die('등록된 파일이없습니다[FILE].');
		endif;

	}

	//다운로드
	public function fileDownLoadCommon(){
		echo $sql		 = "select sname,rname from common_file where fidx='".$this->fidx."'";
		$this ->process-> sql = $sql;
		$ret = $this -> process-> query();
		if($ret):

		   $row      = mysql_fetch_assoc($ret);
		   $sdir	 = $this->saveDir;
		   $sname    = $row['sname'];
		   $rname	 = $row['rname'];
		   $filePath = $sdir.$sname;
		   $this->fileDownLoadStream($filePath,$sname,$rname);

		else:
				die('등록된 파일이없습니다[DB].');
		endif;
		
	}

}
?>