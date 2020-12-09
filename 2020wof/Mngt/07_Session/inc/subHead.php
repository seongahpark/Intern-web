<?require_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/deFine.php')?>
<? include  topInc."/headProc.php";?>

<? require_once ($_SERVER["DOCUMENT_ROOT"].'/Mngt/cmmInc/sessionTop.php') ?>

<script  type="text/javascript" src="<?=defineUrlPath(topJs)?>/layoutSub.js"></script> 
<script  type="text/javascript" src="<?=defineUrlPath(siteJs)?>/sub.js"></script>

<?
	//$admin_recent = SelectAndNum("member_admin_log","*","where admin_id='".$_SESSION['sess_id']."' order by idx desc limit 0,1");
	if($_SERVER['REMOTE_ADDR'] == "106.242.167.93"){
		//106.242.167.93
		$adminList_url = array("/Mngt/07_Session/sessionYear.php","/Mngt/07_Session/SessionList.php", "/Mngt/07_Session/Stats.php");
		$adminList_sub = array("세션년도관리", "세션관리", "통계");
		$admin_type = array("sessionYear","SessionList","Stats");
	}else{
		$adminList_url = array("/Mngt/07_Session/SessionList.php","/Mngt/07_Session/Stats.php");
		$adminList_sub = array("세션관리","통계");
		$admin_type = array("SessionList","Stats");
	}
	/*
		$adminList_url = array("/Mngt/07_Session/sessionYear.php","/Mngt/07_Session/SessionList.php","/Mngt/07_Session/SessionWrite.php","/Mngt/07_Session/Stats.php");
		$adminList_sub = array("세션년도관리", "세션관리","세션등록/수정", "통계");
		$admin_type = array("sessionYear","SessionList","SessionWrite","Stats");
	*/
?>
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
						<span class="name"><?=$_SESSION['sess_name'] ?></span>
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
								<li id="Setting" class='lm_l2 over'>
									<a href='/Mngt/07_Session/sessionYear.php'  class='lm_a2'><span class='isMask'></span><span class='isTxt'>세션관리</span></a>
									<ul class='depth3'>
										<?	
											for($i=0;$i<count($adminList_url);$i++){
											

											if($_GET["admin_type"]==$admin_type[$i]){
												$class_option = "over";
												$recent_adminList_sub = $adminList_sub[$i];
											}else{
												$class_option = "";
											}
										?>

										<li class='lm_l3 <?=$class_option?>'><a href='<?=$adminList_url[$i]?>?admin_type=<?=$admin_type[$i]?>' class='lm_a3'><span class='isMask'></span><span class='isTxt'><?=$adminList_sub[$i]?></span></a></li>
										<?
											}
										?>
									</ul>
								</li>			
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
				
				<div id="contents-wrap">
					<div id="contents">
						<div class="cont-top">

							<div class="cont-tit">
								<h2><?=$recent_adminList_sub?> <!-- (추후 프로그램연동 필요) --></h2>
							    <!--<p>사이트관리화면입니다.</p>-->
							</div>
							<!-- <a href="/kor/" class="homepage-btn" target="_blank" title="새창으로열림"><span>홈페이지 바로가기</span></a> -->
						</div>