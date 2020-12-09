<script type="text/javascript" src="/kor/share/js/utils_lib.js"></script>

<script language="JavaScript1.2">
<!--
var gobj	= 0;
function drag_dropie( ) {
	if (dragapproved==true) {
		getobj("showimage" + gobj ).style.pixelLeft=tempx+event.clientX-iex
		getobj("showimage" + gobj ).style.pixelTop=tempy+event.clientY-iey
		return false
	}
}
function setCookie(name, value, expiredays){
 var today = new Date();
  today.setDate( today.getDate() + expiredays );
  document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";"
}

function initializedragie( obj ) {
	gobj	= obj;
	iex=event.clientX
	iey=event.clientY
	tempx	= getobj("showimage" + obj ).style.pixelLeft
	tempy	= getobj("showimage" + obj ).style.pixelTop
	dragapproved=true
	document.onmousemove=drag_dropie
}

if (document.all) {
	document.onmouseup=new Function("dragapproved=false")
}

function hidebox0( obj ) {
	doTrans(eval("document.all.showimage" + obj), 9);
	setTimeout("layerPopupClose(" + obj + ")", 1000);
}

function layerPopupClose(obj) {
	getobj("showimage" + obj).style.display="none";
}

function CloseOver(obj) {
	getobj("img_close" + obj).src = "/popup/images/close_over.gif";
}

function CloseOut(obj) {
	getobj("img_close" + obj).src = "/popup/images/close.gif";
}
function closeWin(obj) {

    if (document.all['chkbox'+obj].checked==true){

        setCookie( "showimage"+obj, "done" , 1 );
    }
    document.all['showimage'+obj].style.visibility = "hidden";
}
-->
</script>

<div id="showimage<?=$i?>" style="display:<?if($POPUP_CHK){?>none<?}else{?>block<?}?>; position:absolute; left:<?php echo $wich[0]?>px; top:<?php echo $wich[1]?>px; z-index:999;word-break:break-all;max-width:<?php echo $size[0]?>px;height:<?php echo $size[1]?>px;<?php echo $overflow;?>border:none; padding:0 15px;">
	<table border="0" cellspacing="0" cellpadding="0" id="tbl_layer_popyp" width="100%" style="table-layout:fixed;">
		<!-- tr>
			<td height="28" onMousedown="initializedragie('<?=$i?>')" style="cursor:move;border:none;"></td>
		</tr -->
		<tr>
			<td id="td_l_cont">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;">
			<tr>
			<td width="100%" id="pop_content"><?= $rs_popup["contents"];?></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td>
				<form name="notice_form" style="margin:0px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="height:25px;text-align:right; background-color:#222;">
						<input type="checkbox" name="chkbox<?=$i?>" id="chkbox<?=$i?>" />
						<label for="chkbox<?=$i?>" style="color:#fff;">오늘하루 더 이상 열지않습니다.</label> <a href="javascript:closeWin('<?=$i?>');" style="color:#fff;">[닫기]</a>
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
</div>


<?
 if($_SERVER['REMOTE_ADDR'] == "106.242.167.93"){
	//print_r($rs_popup);
	//여기서 셀렉트문
 }
?>
