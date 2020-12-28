<?
$viewRow    = Result_Query("multiboard","*","mysql_fetch_array","where idx='".$_GET['idx']."'");
IF(!$viewRow){ History_Back(-1,"Empty Board"); }										 #게시판유무
//조회수 업데이트
Update_Query("multiboard","visited=visited+1 where idx=".$_GET['idx']);

$GetIDX     = "idx=".$viewRow['idx']."&".$getPage;									 #변수
$ReplyIcon  = ReplyIcon($viewRow["re_level"],$BoardIcon["Reply"]);				     #답글아이콘
$FileList   = BoardFileList1($viewRow['idx'],$saveDir);								 #파일
$regdate    = $viewRow['regdate'];

//이전 다음글
$preImg   = "";
$nxtImg   = "";
$preNxt   = ListPN("multiboard","idx",$viewRow['idx'],"idx,title,name,regdate,re_level",$sv,$sw,$page,$preImg,$nxtImg,$getView);

//답글아이콘
$PreReplyIcon  = ReplyIcon($preNxt[4][4],$BoardIcon["Reply"]);
$NxtReplyIcon  = ReplyIcon($preNxt[5][4],$BoardIcon["Reply"]);

$boardInfo['tag'] == 'Y' ? $viewContents = $viewRow['contents'] : $viewContents = tag_no($viewRow['contents']);
$_arrRepair=array("s"=>"접수","i"=>"진행중","e"=>"완료");

//video 가공
$getVideo = $viewRow['video'];
$getVideo = substr($getVideo, 17); 
//url을 https://www.youtube.com/embed/+해당링크 형식으로 만들어주기위해 url 가공
$uploadVideo = 'https://www.youtube.com/embed/'.$getVideo;
$video = '<iframe width="640" height="360" src="'.$uploadVideo.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

?>
<div class="board-view-wrap">
	<span class="u-line-dpoint1"></span>
	<table>
		  <caption><span class="blind">'<?=$viewRow['title'];?>' 글 입니다.</span></caption>
		  <thead>
			  <tr>
				  <th>
					<p class="btxt"><?=$viewRow['title'];?></p>
					<span><strong>분류</strong> : <?=$viewRow['subject']?></span>
					<span><strong>부서명</strong> : <?=$viewRow['depart']?></span><br>
					<span><strong>작성자</strong> : <?=$viewRow['name']?></span>
					<span><strong>작성일자</strong> : <?=$regdate?></span>
					<!--모바일사이즈시 조회수는 사라집니다-->
					<p class="hit">
						<span>조회수</span>
						<span><?=$viewRow['visited']?></span>
					</p>
				  </th>
			  </tr>
		  </thead>
		  <tbody>
			  <tr>
				  <td>
				     <div class="file-set">
					 <strong class="file-btxt">첨부파일 :</strong>
					 <?=$FileList['linkFile'];?>
					 </div>
				  </td>
			  </tr>
			  <tr>
				  <td colspan="2" class="editor-data-box">
					<div id="view-cont">
						<div><?if($getVideo) echo $video;?></div>
						<div id ="imgSize"><?=$FileList['viewFile'];?></div>
						<div class="sgap"></div>
						<div class="editor-text"><?=$viewContents?></div>
					</div> 
				  </td>
			  </tr>

		  </tbody>
	</table>
	<div class="ssgap"></div>
	<div class="r">
		<!-- 
		<button class="bp-btn">삭제</button>
		<button class="bdp-btn">수정</button>
		<button class="bg-btn">목록</button>
		<button class="bw-btn">닫기</button>
		-->
		<?=OwnerBtn($viewRow["writer"],$viewRow["id"],"삭제",$_SERVER['PHP_SELF']."?".$GetIDX."&pg_mode=Del","bp-btn");?>
		<?//=AuthBtn($boardInfo["writer"],"답변글",$_SERVER['PHP_SELF']."?".$GetIDX."&pg_mode=Write",$boardInfo["reply"],"bw-btn")?>
		<?=OwnerBtn($viewRow["writer"],$viewRow["id"],"수정",$_SERVER['PHP_SELF']."?".$GetIDX."&pg_mode=Modi","bdp-btn");?>
		<?=LinkBtn("목록",$_SERVER['PHP_SELF']."?{$getPage}","bg-btn")?>
	</div>
	<div class="ssgap"></div>
	<ul class="np-page">
		<li>
			<a href="#" class="first">이전글&nbsp;<span class="f9">▲</span></a>
			<?=$preNxt[2];?>
		</li>
		<li>
			<a href="#" class="first">다음글&nbsp;<span class="f9">▼</span></a>
			<?=$preNxt[3];?>
		</li>
	<ul>
</div>