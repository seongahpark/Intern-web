<?
class Write extends WriteCommon {
 
	private $my_tbl = "consult";

	private function executeQuery($sql){
		$this -> process -> sql = $sql;
		$ret	= $this -> process -> query();
		return $ret;
	}
	
	 
	public function deleteFile(){
		$_params  = $this->process->rejectPostParams();
		$fidx	  = $_params['fidx'];
		//파일정보
		$file_sql	= "select fidx,sname from common_file where fidx in('".$fidx."') and bid='".$this->my_tbl."'";
		
		$this ->process -> sql = $file_sql;
		$ret  = $this -> process -> query();
		$fnum = mysql_num_rows($ret);
		 
		for($f=0;$f<$fnum;$f++):
			$row	  = mysql_fetch_assoc($ret);
			$_sname[] = $row['sname'];
			$_fidx[]  = $row['fidx'];
		endfor;
		 
		//첨부파일 테이블삭제
		if(is_array($_fidx)):
			$file_sql_ret	= $this->deleteCommonFile(@implode("','",$_fidx));
			$del_cnt		= mysql_affected_rows(); 
			if($file_sql_ret && $del_cnt==1):
				$this->deleteCommonFileData($_sname,$this->saveDir);
				alert('삭제되었습니다');
				return true;
			else:
				alert('실패되었습니다');
				return false;
			endif;
		endif;

		return false;

	}
	
	//삭제
	public function deleteConsult(){

		$_params  = $this->process->rejectPostParams();
		$idx	  = $_params['idx'];
	 
		if(is_array($idx)):
			$idx = implode("','",$idx);
		endif;
		
		$this->process->start_tran();
		
		//파일정보
		$file_sql	= "select fidx,sname from common_file where idx in('".$idx."') and bid='".$this->my_tbl."'";
		
		$this ->process -> sql = $file_sql;
		$ret  = $this -> process -> query();
		$fnum = mysql_num_rows($ret);
		 
		for($f=0;$f<$fnum;$f++):
			$row   = mysql_fetch_assoc($ret);
			$_sname[] = $row['sname'];
			$_fidx[]  = $row['fidx'];
		endfor;
		
		//첨부파일 테이블삭제
		if(is_array($_fidx)):
			$file_sql_ret	= $this->deleteCommonFile(@implode("','",$_fidx));
		else:
			$file_sql_ret	= true;
		endif;
		
		//테이블삭제
		$tbl_ret = $this->executeQuery("delete from ".$this->my_tbl." where idx in('".$idx."')");
		 
		if($file_sql_ret && $tbl_ret):
			//데이터 파일삭제
			if(is_array($_sname)):
				$this->deleteCommonFileData($_sname,$this->saveDir);
			endif;
			$this->process->commit();
			alert('삭제되었습니다.');
			return true;
		else:
			$this->process->rollback();
			return false;
		endif;
	}
	
	//등록
	public function insertConsult(){
		$_params = $this->process->rejectPostParams();
		

		//$dam_tel	= @implode("-",$_params['dam_tel']);	//2020 01 23 신상원 리뉴얼전 전화번호 입력형태는 inputBox 3개로 입력받는 형태였는데 리뉴얼 후에는 한칸으로 변경되어서 implode할 필요가 없어짐
		$dam_phone  = @implode("-",$_params['dam_phone']);
		$benchmark_url = @implode(",",$_params['benchmark_url']);

		$sql = "insert into ".$this->my_tbl." set ";
		$sql.= " staff_name			='".$_params['staff_name']."'";
		$sql.= ",staff_id			='".LOGIN_ID."'";
		$sql.= ",state				='".$_params['state']."'";
		$sql.= ",cp_name			='".$_params['cp_name']."'";
		$sql.= ",dam_name			='".$_params['dam_name']."'";
		//$sql.= ",dam_tel			='".$dam_tel."'";		//2020 01 23 전화번호 바로 입력되도록 수정
		$sql.= ",dam_tel			='".$_params['dam_tel']."'";
		$sql.= ",dam_phone			='".$dam_phone."'";
		$sql.= ",dam_email			='".$_params['dam_email']."'";
		$sql.= ",web_url			='".$_params['web_url']."'";
		$sql.= ",benchmark_url		='".$benchmark_url."'";
		$sql.= ",make_type			='".$_params['make_type']."'";
		$sql.= ",make_product		='".$_params['make_product']."'";
		$sql.= ",c_money			='".$_params['c_money']."'";
		$sql.= ",e_money			='".$_params['e_money']."'";
		$sql.= ",c_moneyMax			='".$_params['c_moneyMax']."'";
		$sql.= ",consult_method		='".$_params['consult_method']."'";
		$sql.= ",contents			='".$_params['contents']."'";
		$sql.= ",yns				='미정'";
		$sql.= ",consult_date		='".$_params['consult_date']."'";
		$sql.= ",regdate			='".date('Y-m-d H:i:s')."'";
		$sql.= ",modidate			='".date('Y-m-d H:i:s')."'";
		$sql.= ",user_ip			='".ADDR."'";
		 
		 
		//트랜젝션시작
		$this->process->start_tran();

		$this->process->sql = $sql;
		$idx =  $this->process->getLastInsertId();
		 
		if($idx):
			$this->procFileWrite($idx,$this->my_tbl);
			$this->process->commit();
			
			//상담내용 이메일 발송


			alert('등록되었습니다.');
		else:
			$this->process->rollback();
			alert('실패되었습니다.');
		endif;

		return $idx;

	} 
	

	
	 //수정
	public function updateConsult(){
		$_params = $this->process->rejectPostParams();
		
		$idx		= $_params['idx'];
		$dam_tel	= @implode("-",$_params['dam_tel']);
		$dam_phone  = @implode("-",$_params['dam_phone']);

		$benchmark_url = @implode(",",$_params['benchmark_url']);

		$sql = "update ".$this->my_tbl." set ";
		$sql.= " state				='".$_params['state']."'";
		$sql.= ",cp_name			='".$_params['cp_name']."'";
		$sql.= ",dam_name			='".$_params['dam_name']."'";
		$sql.= ",dam_tel			='".$dam_tel."'";
		$sql.= ",dam_phone			='".$dam_phone."'";
		$sql.= ",dam_email			='".$_params['dam_email']."'";
		$sql.= ",web_url			='".$_params['web_url']."'";
		$sql.= ",benchmark_url		='".$benchmark_url."'";
		$sql.= ",make_type			='".$_params['make_type']."'";
		$sql.= ",make_product		='".$_params['make_product']."'";
		$sql.= ",c_money			='".$_params['c_money']."'";
		$sql.= ",e_money			='".$_params['e_money']."'";
		$sql.= ",c_moneyMax			='".$_params['c_moneyMax']."'";
		$sql.= ",consult_method		='".$_params['consult_method']."'";
		$sql.= ",contents			='".$_params['contents']."'";
		$sql.= ",yns				='".$_params['yns']."'";
		$sql.= ",consult_date		='".$_params['consult_date']."'";
		$sql.= ",modidate			='".date('Y-m-d H:i:s')."'";
		$sql.= ",user_ip			='".ADDR."'";
		$sql.= " where idx ='".$idx."'";
		
		//트랜젝션시작
		$this->process->start_tran();

		$this->process->sql = $sql;
		$ret = $this->process->query();
		$up_cnt = mysql_affected_rows(); 
		if($ret && $up_cnt==1):
			$this->procFileWrite($idx,$this->my_tbl);
			$this->process->commit();
			
			alert('수정되었습니다.');
		else:
			$this->process->rollback();
			alert('실패되었습니다.');
		endif;

		return $idx;

	} 

 
}