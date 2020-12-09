<?require_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/deFine.php')?>
<? include  topInc."/headProc.php";?>

<? require_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/sessionTop.php') ?>

<?php
	$menu_skin_result = SelectAndNum("boardinfo","distinct(btype)","where 1 ORDER BY idx ASC");
	$admin_recent = SelectAndNum("nt_login","*","where admin_id='".$_SESSION['sess_id']."' order by elog_time desc limit 0,1");
?>
<script  type="text/javascript" src="<?=defineUrlPath(topJs)?>/layoutSub.js"></script> 
<script  type="text/javascript" src="<?=defineUrlPath(siteJs)?>/sub.js"></script>
<!-- s: #doc //-->
<div id="doc" class="isPage">		
<div id="skipNavi">
	<h1 class="blind"><!--사이트이릅 ---> 스킵네비게이션</h1>
	<ul>
		<li><a href="#contents" class="skipLink">본문바로가기</a></li>
		<li><a href="#topmenu" class="skipLink">주메뉴바로가기</a></li>
	</ul>
</div>
<!-- s: .doc-pg //-->
<div id="pg-code" class="doc-pg">
	<? include topInc."/headerInc.php";?>
	<!-- s: #container-wrap //-->
	<div id="container-wrap">
			<div id="subNavi-wrap">
				<div id="subNavi">
					<!-- s : 프로젝트 (추후 프로그램연동 필요) -->
					<div id="project-name">
						<span class="name"><?=$_SESSION['sess_name']?></span>
						<button id="view-btn"><span class="blind">상세보기</span></button>
					</div>
					<!-- e : 프로젝트 (추후 프로그램연동 필요) -->
					<!-- s : 사용자정보 (추후 프로그램연동 필요) -->
					<div id="user-wrap">
						<div class="user-cont">
							<ul>
								<?
									$admin_recent_row = mysql_fetch_Array($admin_recent["result"]);
								?>
							   <!--li><span class="btxt">최근접속시간</span><span class="stxt"><?=date("Y.m.d / A g시 i분",$admin_recent_row["slog_time"])?></span></li-->
							   
							   <li>
									<li><span class="btxt">관리자 등급</span><span class="stxt nbl">:  <?
									IF($_SESSION['sess_auth']==1){
										echo "최고관리자";
									}ELSE{
										echo "부관리자";
									}?></span></li>
									<!-- 200918 관리자 등급에 따라 출력되는 내용 수정 -->
							   </li>
							</ul>
							<button class="logout-btn" onclick="location.href='/Mngt/admin_logout.php'"><span>로그아웃</span></button>
						</div>
					</div>
					<!-- e : 사용자정보 (추후 프로그램연동 필요) -->
					<div class="lm-wrap">
						<div class="lm-tit">
							<div class="tit">
								<span class="btxt">제목(데스크탑용)</span>
								<span class="stxt">소제목(모바일 용)<!-- (추후 프로그램연동 필요) --></span>
								<button  class="" type="button" onclick="$('#leftmenu').toggle();"><span>▼</span></button>
							</div>
						</div>
						<!-- s : 좌측메뉴 -->
						
						<div class="leftmenu" id="leftmenu">
								<ul class='depth2'>

								<?while($menu_skin_row = mysql_fetch_Array($menu_skin_result["result"])){
									if($menu_skin_row["btype"]=='Board'){
										$type_name="일반게시판";
									}else if($menu_skin_row["btype"]=='Gallery'){
										$type_name="포토게시판";
									}

									if($menu_skin_row["btype"]==$_GET['btype']){
										$skin_class_option = " over";
									}else{
										$skin_class_option = "";
									}
								?>
									<li id="Setting" class='lm_l2<?=$skin_class_option?>'>
										<a href='#none'  class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$type_name?></span></a>
										<ul class='depth3'>
										  <?
											$menu_result_num = SelectAndNum("boardinfo","*","where btype='".$menu_skin_row["btype"]."' order by seq asc");
											while($menu_row = mysql_fetch_Array($menu_result_num["result"])){
												//특정 게시판을 숨김처리하기위한 if문
												if($menu_row['bid']!="juji_monk" and $menu_row['bid']!="ceremony" and $menu_row['bid']!="pray_gallery" and $menu_row['bid']!="sh"){
													if($_GET["bid"]==$menu_row['bid']){
														$class_option = "over";
													}else{
														$class_option = "";
													}
											?>
												<li class='lm_l3 <?=$class_option?>'>
													<a href='/Mngt/02_Board/BoardList.php?btype=<?=$menu_row["btype"]?>&bid=<?=$menu_row["bid"]?>'  class='lm_a3'><span class='isMask'></span><span class='isTxt'><?=$menu_row["bnm"]?></span></a>
												</li>
											<?	}?>
											<?}?>
										</ul>
									</li>
								<?}?>
								
							</ul>			
						</div>
						<!-- e : 좌측메뉴 -->
					</div>
					<!-- e : 프로젝트 (추후 프로그램연동 필요) -->
					<script src="<?=defineUrlPath(topJs)?>/leftMenu.js"></script>
					<script type="text/javascript" >
						$(document).ready(function(){ 
							subNavi._init();	
							if($("#leftmenu li").length<1) $(".lm-tit button").hide();
						});
					</script>
				</div>
			</div>
			<div id="container"  class="div-cont">
			<?
				$recent_subject_result = Select_Query("boardinfo","*","where bid='".$_GET['bid']."'");
				$recent_subject_row = mysql_fetch_Array($recent_subject_result);
			?>	
				<div id="contents-wrap">
					<div id="contents">
						<div class="cont-top">
							<div class="cont-tit">
								<h2><?=$recent_subject_row["bnm"]?></h2>
							    <!--<p>사이트관리화면입니다.</p>-->
							</div>
							<a href="/" class="homepage-btn" target="_blank" title="새창으로열림"><span>홈페이지 바로가기</span></a>
						</div>