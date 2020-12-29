<?
class Write extends WriteCommon {

	private $my_tbl = "staff";

	private function executeQuery($sql){
		$this -> process -> sql = $sql;
		$ret	= $this -> process -> query();
		return $ret;
	}


  /*
  @method addVacation
  @description  휴가신청 정보 저장
  @param  $data : 저장할 데이터 배열
  @return boolean
  2020-12-23 박성아 수정
  */
  public function addVacation($data){
    $sql = "insert into vacation_tbl (
    vidx,class,grade,`name`,sdate,edate,
    `type`,agent,phone,reason,confirm,id,confirm2,confirm3, reqDate, reqSumDate, sumDate, date1, date2, date3, date4, subTotalDate) values(
    '','".$data["class"]."','".$data["grade"]."','".$data["name"]."','".$data["sdate"]."','".$data["edate"]."',
    '".$data["type"]."','".$data["agent"]."','".$data["phone"]."','".$data["reason"]."','N','".$_SESSION["login_id"]."','N','N'
	,'".$data["reqDate"]."','".$data["reqSumDate"]."','".$data["sumDate"]."','".$data["date1"]."','".$data["date2"]."','".$data["date3"]."'
	,'".$data["date4"]."','".$data["subTotalDate"]."')";
    $this->process->sql = $sql;

    return $this->process->query();
  }

	/*
  @method deleteVacation
  @description  휴가신청을 삭제한다.
  @param  $idxstr : 삭제할 대상의 식별자(복수의 식별자를 ',' 를 이용해 문자열로 넘긴다.)
  @return boolean
  */
  public function deleteVacation($idxstr){
    $this->process->sql = "delete from vacation_tbl where vidx in (".$idxstr.")";
    return $this->process->query();
  }
	/*
  @method sendMailForVacationInfo
  @description  휴가신청 정보를 메일로 발송한다.
  @param  $title,$toMail,$toName,$fromMail,$fromName,$contents
  @return boolean
  */
  public function sendMailForVacationInfo($title,$toMail,$toName,$fromMail,$fromName,$contents){
		$e = new sendEmailClass;
		$e -> STR01			= "{contents}";				#치환01
		$e -> STR02			= $contents; 	#치환02
		$e -> sendFile	    = "../03_modify/commonMailForm.html";					#파일원본
		$e -> sendEmail		= $fromMail;						#보내는이메일
		$e -> receiveEmail  = $toMail;								#받는이메일
		$e -> sendName		= $fromName;						#보내는사람
		$e -> receiveName	= trim($toName);					#받는사람이름
		$e -> emailTitle    = $title;	#제목
		$result = $e -> SingleEmail();

		if($result):
			//alert('메일발송되었습니다.');
			return true;
		else:
			//alert('메일발송이 실패되었습니다.');
			return false;
		endif;
  }

	/*
  @method modiVacation
  @description  휴가신청을 수정한다.
  @param  $data : 저장할 데이터 배열
  @return boolean
  201223 박성아 update 쿼리문 수정
  */
	public function modiVacation($data){
    if($_SESSION["login_auth"]==9){
			$sql = "select * from vacation_tbl where vidx='".$data["vidx"]."' ";
			$this->process->sql = $sql;
			$confirmResult = $this->process->query();
			if($confirmResult){
				$conformRow = mysql_fetch_assoc($confirmResult);
			}
      //관리권한이 있는 계정이면 승인절차 진행
      $addStr = ",confirm='".$data["confirm"]."' ";
      $addStr .= ",confirm2='".$data["confirm2"]."'";
      $addStr .= ",confirm3='".$data["confirm3"]."'";
      if($data["confirm"]=="Y" && $conformRow["confirm"]=="N"){//이전 값이 N이고 변경되는 값이 Y이면
        $addStr .= ",checkDate='".date("Y-m-d H:i:s")."'";
        $addStr .= ",checkName='".$_SESSION["login_name"]."'";
      }
      if($data["confirm2"]=="Y" && $conformRow["confirm2"]=="N"){
        $addStr .= ",checkDate2='".date("Y-m-d H:i:s")."'";
        $addStr .= ",checkName2='".$_SESSION["login_name"]."'";
      }
      if($data["confirm3"]=="Y" && $conformRow["confirm3"]=="N"){
        $addStr .= ",checkDate3='".date("Y-m-d H:i:s")."'";
        $addStr .= ",checkName3='".$_SESSION["login_name"]."'";
      }
    }
    $sql = "update vacation_tbl set
    class='".$data["class"]."',grade='".$data["grade"]."',`name`='".$data["name"]."',sdate='".$data["sdate"]."',edate='".$data["edate"]."',
    `type`='".$data["type"]."',agent='".$data["agent"]."',phone='".$data["phone"]."',reason='".$data["reason"]."' ".$addStr."
	,reqDate='".$data["reqDate"]."',reqSumDate='".$data["reqSumDate"]."',sumDate='".$data["sumDate"]."',date1='".$data["date1"]."',date2='".$data["date2"]."'
	,date3='".$data["date3"]."',date4='".$data["date4"]."',subTotalDate='".$data["subTotalDate"]."' 
    where vidx=".$data["vidx"];
    $this->process->sql = $sql;

    return $this->process->query();
	}

/*
	2017-06-05
  @method confirmVacation
  @description  대표님 메일에서 승인을 클릭할경우 대표 승인부분만 변경되도록함
  @param  $data : 저장할 데이터 배열
  @return boolean
  */
	public function confirmVacation($data){
		//메일에 대응하는 글이 있는지 확인 (없으면 글이 없다는 메세지를 띄움)
		$sql = "select * from vacation_tbl where vidx='".$data["vidx"]."' ";
		$this->process->sql = $sql;
		$Result = $this->process->query();
		$getRow = mysql_num_rows($Result);
		if($getRow){
			$getInfo = mysql_fetch_assoc($Result);	//승인했었는지 아닌지 확인
			if($getInfo['confirm3']=='Y'){ //이미 승인된 신청서
				return '2';
			}else{
				$sql = "update vacation_tbl set confirm3='Y', checkDate3='".date('Y-m-d H:i:s')."', checkName3='박종덕' where vidx=".$data["vidx"];
				$this->process->sql = $sql;
				$this->process->query();
				return '1';
			}
		}else{
			return false;
		}
	}
}
