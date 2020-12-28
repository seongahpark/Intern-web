<script language="javascript">
<!--
	function Del_Chk(){
		var form=document.list_form;
		//201207 박성아
		//if(!All_Check_Num(form,'idx[]',1,'게시물')) return; // 게시글 VIEW에서 삭제를 위해 주석처리
		var msg = confirm('정말 삭제하실래요?');
		if(msg==true){
			form.submit();
		}
	}
//-->
</script>
<?php
	$_chkOVal=array("Y"=>"O","N"=>"X");
	IF($_GET['idx']){
		$viewRow  = Result_Query("multiboard","*","mysql_fetch_array","where idx='".$_GET['idx']."'");#게시판
		IF(!$viewRow) History_Back(-1,"데이터가 없습니다.");
		$NCheck   = NoticeChk($viewRow['notice']);													  #공지사항체크
		$SCheck   = NoticeChk($viewRow['secret']);													  #비밀글체크
		$FileList = BoardFileList($viewRow['idx'],$saveDir);										      #파일
		Update_Query("multiboard","visited=visited+1 where idx=".$_GET['idx']);

		$bid = $_GET['bid'];
		$fileSQL="select * from fileboard where bid='".$bid."' and idx=".$_GET['idx']." and type like 'image%' order by fileidx asc limit 1";
		$fileRs=mysql_query($fileSQL,$conn);
		$fileRow=mysql_fetch_array($fileRs);
		$fileType=$fileRow['type'];

		//이전 다음글
		$preImg   = "";
		$nxtImg   = "";
		$preNxt   = ListPN("multiboard","idx",$viewRow['idx'],"idx,title,name,regdate,re_level",$sv,$sw,$page,$preImg,$nxtImg,$getView);
		
		$ReplyIcon  = ReplyIcon($viewRow["re_level"],"../board/btn/icon_reply.gif");				  #답글아이콘
		$SecretIcon = BoardIcon($viewRow["secret"],"../board/btn/icon_secret.gif");					  #비밀아이콘
		
	}else{
		History_Back(-1,"글번호가 없습니다.");
	}

	//201130 박성아, BSC내용 추가
	//video URL 가공
	$getVideo = $viewRow['video'];
	$getVideo = substr($getVideo, 17); 
	//url을 https://www.youtube.com/embed/+해당링크 형식으로 만들어주기위해 url 가공 
	$uploadVideo = 'https://www.youtube.com/embed/'.$getVideo;
	$video = '<iframe width="560" height="315" src="'.$uploadVideo.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

	$thumbnail = 'https://img.youtube.com/vi/'.$getVideo.'/mqdefault.jpg'; //썸네일 이미지
	
	//파일 확장자 체크, IMAGE 파일인지
	if(strpos($fileType, "image") !== false) $fileChk = true;
	else $fileChk = false;

	//if($getVideo){	//유튜브 영상을 썸네일로 사용할 시 사용
	//	$imgURL="<img src='$thumbnail' width='284px' height='163px'>";
	//}else if($fileChk){
	if($fileChk){
		$imgURL="<img src='".$saveDir.$fileRow['sname']."' alt='".$fileRow['rname']."' style='width:284px;height:120.04px;'>";
	}else{
		$imgURL="<img src='/cmmImg/Board/no-img01.jpg' alt='NO images' style='width:284px;height:120.04px;'/>";
	}

?>
<form name="list_form" method="POST"  action="./deleteOk.php?<?=$get?>&page=<?=$page?>">
<input type="hidden" name="idx[]" value="<?=$idx?>">
<table class="board_view">
  <colgroup>
        <col width="12%" />
        <col width="18%" />
        <col width="12%" />
        <col width="18%" />
        <col width="12%" />
        <col width="18%" />
  </colgroup>
  <thead>
	<tr>
        <th colspan="6">
			<?if($bid=="fobst_const"){?>[<?=$viewRow['years'];?>년] <?}?>
			<?if($bid=="posit_photo3" || $bid=="posit_photo5"){?>[<?=$viewRow['years'];?>년 제<?=$viewRow['times'];?>회] <?}?>
			<?if($bid=="posit_photo4"){?><?=$viewRow['years'];?>년<?}?>
			<?=$ReplyIcon?> <?=$viewRow['title'];?> <?=$SecretIcon?> 
		</th>
    </tr>
  </thead>
  <tbody>
	<?if($bid!="lecture_lec"){?>

	<tr>
      <td class="tdl"><?if($bid=="posit_photo3" || $bid=="posit_photo5"){?>수상자<?}else{?>작성자<?}?></td>
      <td><?=$viewRow['name']?></td>
      <td class="tdl"><?if($bid=="posit_photo3"  || $bid=="posit_photo5"){?>수상일<?}else{?>작성일<?}?></td>
      <td><?if($bid=="BSC"){?><?=$viewRow['regdate']?><?}else{?><?=Date('Y-m-d',$viewRow['writedate']);?><?}?></td>
      <td class="tdl"><?if($bid=="posit_photo3" || $bid=="posit_photo5"){?><?}else{?>조회수<?}?></td>
      <td class="tdr"><?if($bid=="posit_photo3" || $bid=="posit_photo5"){?><?}else{?><?=$viewRow['visited']?><?}?></td>
    </tr>
	<?if($bid=="BSC"){?>
	<tr>
		<td class="tdl">분류</td>
		<td class="tdr"><?=$viewRow['subject']?></td>
		<td class="tdl">부서명</td>
		<td class="tdr"><?=$viewRow['depart']?></td>
	</tr>
	<?}?>	
     <tr>
      <td colspan="6" class="tdc">
		<?if($boardInfo["utbe"]=="Y"){?>
			<div style="padding-bottom:20px;">
			<?=$viewRow['utbe'];?>
			</div>
		<?}else{?>	
			<?if($bid != "sec_photo5"){?>
				<div><?=$FileList['viewFile'];?></div>
			<?}?>
		<?}?>
		<div style="padding-bottom:20px;"><?=$viewRow['contents'];?></div>
     </td>
    </tr>

	<?}else{?>
	<tr>
      <td class="tdl">분류</td>
      <td><?=$viewRow['classValue']?></td>
      <td class="tdl">강연자</td>
      <td><?=$viewRow['name']?></td>
      <td class="tdl">기관</td>
      <td class="tdr"><?=$viewRow['organ']?></td>
    </tr>
	<tr>
      <td class="tdl">학과(소속)</td>
      <td><?=$viewRow['depart']?></td>
      <td class="tdl">강연일</td>
      <td><?=$viewRow['lecDate'];?></td>
      <td class="tdl">강연지역</td>
      <td class="tdr"><?=$viewRow['region']?></td>
    </tr>
	<tr>
      <td class="tdl">링크</td>
      <td><?if(trim($viewRow['siteUrl'])){?><a href="<?=$viewRow['siteUrl'];?>" target="_blank">[링크]</a><?}?></td>
      <td class="tdl"></td>
      <td></td>
      <td class="tdl"></td>
      <td class="tdr"></td>
    </tr>
	<?}?>
	<?if($bid=="BSC"){?>
	<tr>
		<td class="tdl">동영상</td>
		<td colspan="5" class="tdr"><?if($getVideo) echo $video; else echo "업로드한 동영상이 없습니다.";?></td>
	</tr>
	<tr>
		<td class="tdl">동영상링크</td>
		<td colspan="5" class="tdr"><a href='<?=$viewRow['video']?>'><?=$viewRow['video']?></a></td>
	</tr>
     <tr>
      <td class="tdl">썸네일</td>
      <td colspan="5" class="tdr"><?=$imgURL?></td>
    </tr>
	<?}?>
     <tr>
      <td class="tdl">파일</td>
      <td colspan="5" class="tdr"><?=$FileList['linkFile'];?></td>
    </tr>
	<tr>
      <td class="tdl">이전글</td>
      <td colspan="5" class="tdr"><?=$preNxt[2];?></td>
    </tr>

	<tr>
      <td class="tdl">다음글</td>
      <td colspan="5" class="tdr"><?=$preNxt[3];?></td>
    </tr>
  </tbody>
</table>
</form>
<div class="btn_tr pt20">

<div style="float:left">
	<button class="btn_type01" style="width:70px;"  onclick="javascript:Del_Chk();"><p><img src="../board/btn/del.png" /><strong>삭제</strong></p></button>
</div>
<div style="float:right">
	<button class="btn_type01" style="width:70px;" onclick="javascript:location.href='./board.php?idx=<?=$idx?>&page=<?=$page?>&bid=<?=$bid?>';return false;"><p><img src="../board/btn/write.png" /><strong>목록</strong></p></button>
	<?if($boardInfo["reply"]=="Y"){?>
	<button class="btn_type01" style="width:70px;"  onclick="javascript:location.href='./board.php?idx=<?=$idx?>&page=<?=$page?>&bid=<?=$bid?>&pgMode=Write&type=QN';return false;"><p><img src="../board/btn/answer.png" /><strong>답변</strong></p></button>
	<?}?>
	<button class="btn_type01" style="width:70px;"  onclick="javascript:location.href='./board.php?idx=<?=$idx?>&<?=$getModi?>';return false;"><p><img src="../board/btn/pro_modi.png" /><strong>수정</strong></p></button>
</div>
</div>
<div class="btn_tr pt20">
	<?if($boardInfo['memo']=="Y"){?>
		<?include('./memo.php');?>
	<?}?>
</div>
