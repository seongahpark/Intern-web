<script language="javascript">
<!--
	function Del_Chk(){
		var form=document.list_form;
		if(!All_Check_Num(form,'idx[]',1,'게시물')) return;
		var msg = confirm('정말 삭제하실래요?');
		if(msg==true){
			form.submit();
		}
	}
//-->
</script>
<?
	$_arrRepair=array("s"=>"접수","i"=>"진행중","e"=>"완료");
?>
<form name="searchForm" method="get" action="./board.php">
<div class="board_search">
    <input type="hidden" name="pgMode" value="<?=$pgMode?>">
    <input type="hidden" name="bid" value="<?=$bid?>">
	<input type="text" class="input_text fl mr5"  style="width:200px;" name="sw"/>
    <button class="search_btn" onclick="submit();"><span>검색</span></button>
</div>
</form>
<form name="list_form" method="POST"  action="./deleteOk.php?<?=$get?>">
<table class="board_list">
      <colgroup>
            <col width="3%" />
            <col width="7%" />
			<?if($boardInfo['orgChk']=="Y"){?>
				<col width="15%" />
			<?}?>
			<col width="*" />
            <col width="13%" />
            <col width="10%" />
			<col width="10%" />
      </colgroup>
      <thead>
        <tr>
            <th><input type='checkbox' name='check_all' onclick="javascript:All_Check('list_form','idx[]',this)"></th>
            <th>번호</th>
			<?if($boardInfo['orgChk']=="Y"){?>
				<th>학교명</th>
			<?}?>
			<th>제목</th>
            <th>글쓴이</th>
			<th>조회수</th>
            <th class="thr">작성일</th>
        </tr>
      </thead>
      <tbody>
		<?
		#..공지사항
		$list_img = array("../board/btn/arrow01.jpg","../board/btn/arrow02.jpg","../board/btn/arrow03.jpg","../board/btn/arrow04.jpg");
		$noticeResult = Select_Query("multiboard","*",$noticeWhere." ".$orderby);
		while($noticeRow=mysql_Fetch_array($noticeResult)){
			  if($bid == "BSC") $regdate = $noticeRow['regdate'];										//bsc일 때만 regdate로 설정
			  else $regdate  = date('Y-m-d',$noticeRow['writedate']);
			  $FileIcon = FileIcon($noticeRow['idx'],"../board/btn/save.png");							#파일아이콘
			  $NewIcon  = NewIcon($boardInfo["newicon"],$noticeRow["writedate"],"../board/btn/icon_new.gif");  #뉴  아이콘
			  $title    = strcut_utf8($noticeRow["title"],100,true,'...');
				
				$memoNSQL="select idx from memoboard where bid='".$bid."' and idx=".$noticeRow['idx'];
				$memoNRs=mysql_query($memoNSQL,$conn);
				$memoNCnt=mysql_num_rows($memoNRs);
		?>		
		<tr>
          <td class="tdl"><input type='checkbox' name='idx[]' value="<?=$noticeRow['idx']?>"></td>
          <td><img src="../board/btn/icon_notice.gif" style="vertical-align:middle;"></td>
		<?if($boardInfo['orgChk']=="Y"){?>
			<td>[<?=$noticeRow["schGubun"]?>]<?=$noticeRow["school"]?></td>
		<?}?>
		  <td class="title">
		  
		  <a href="./board.php?idx=<?=$noticeRow["idx"]?>&<?=$getView?>"><?=$title?></a><?=$NewIcon;?> <?=$FileIcon?>
		  <?if($boardInfo['memo']=="Y"){?>
				(<span class="torange"><?=$memoNCnt?></span>)
		  <?}?>
		  
		  </td>
          <td><?=$noticeRow['name']?><!-- [<?=$noticeRow['id']?>] --></td>
          <td><?=$noticeRow['visited']?></td>
		  <td class="tdr"><?=$regdate?></td>
        </tr>
		<?}?>
		<?php
		#..일반글
		$style_class="on";
		$result = Page_Result("multiboard","idx","*",$vrecord,$vpage,$page,$sv,$sw,$where,$list_img,$get,$orderby,$style_class,$linkClass,$pageLine);
		IF(!$result[1]){?>
         <tr>
          <td class="tdl tdr" colspan="<?if($boardInfo['orgChk']=="Y"){?>7<?}else{?>6<?}?>">작성된 글이 없습니다.</td>
        </tr>
		<?}else{
		$num = ($result[5]-($page*$vrecord));     										  #글번호
		while($row=Mysql_Fetch_array($result[0])){
			if($bid == "BSC") $regdate = $row['regdate'];
			else $regdate  = date('Y-m-d',$row['writedate']);
			$ReplyIcon  = ReplyIcon($row["re_level"],"../board/btn/icon_reply.gif");					  #답글아이콘
			$FileIcon   = FileIcon($row["idx"],"../board/btn/save.png");						      #파일아이콘
			$NewIcon    = NewIcon($boardInfo["newicon"],$row["writedate"],"../board/btn/icon_new.gif");  #뉴  아이콘
			$SecretIcon = BoardIcon($row["secret"],"../board/btn/icon_secret.gif");					  #비밀아이콘
			$title      = strcut_utf8($row["title"],100,true,'...');
			$deep       = ($row["re_level"]*10)+10;												  #답변뎁스	

			$memoSQL="select idx from memoboard where bid='".$bid."' and idx=".$row['idx'];
			$memoRs=mysql_query($memoSQL,$conn);
			$memoCnt=mysql_num_rows($memoRs);
		?>
         <tr>
          <td class="tdl"><input type="checkbox"  class="input_check" name='idx[]' value="<?=$row['idx']?>"/> </td>
          <td><?=$num?></td>

		  <td  class="title"  style="padding-left:<?=$deep?>px;"><?=$ReplyIcon?>
			<a href="./board.php?idx=<?=$row["idx"]?>&<?=$getView?>">
			<?if($bid=="posit_photo4"){?><?=$row['years'];?>년<?}?> <?=$title?> 
			</a>
			<?=$NewIcon;?> <?=$SecretIcon?> <?=$FileIcon?>
			<?if($boardInfo['memo']=="Y"){?>
				(<span class="torange"><?=$memoCnt?></span>)
			<?}?>
		  </td>
          <td><?=$row['name']?><br>[<?=$row['id']?>]</td>
          <td ><?=$row['visited']?></td>
		  <td class="tdr"><?=$regdate?></td>
        </tr>
		<?php $num--;}?>
		<!--LOOP END-->
		<?}?>
      </tbody>
</table>
</form>
<div class="btn_tr pt20">
   <div style="float:right">
       <button class="btn_type01" style="width:70px;" onclick="javascript:location.href='./board.php?page=<?=$page?>&bid=<?=$bid?>&pgMode=Write'"><p><img src="../board/btn/write.png" /><strong>등록</strong></p></button>
   </div>
    <div style="float:left">
        <button class="btn_type01" style="width:70px;"  onclick="javascript:Del_Chk();"><p><img src="../board/btn/del.png" /><strong>삭제</strong></p></button>
   </div>
</div>
<div class="board_page">
	<?=$result[6]?>
	<?=$result[2]?>
	 <div class="pageNum"><?=$result[3]?></div>
	<?=$result[4]?>
	<?=$result[7]?>
</div>