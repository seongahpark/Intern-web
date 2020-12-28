<?php
require_once "../boss/common/config_www.php";
require_once ROOT."/web_process/process_common_filedown.php";

if(!LOGIN_ID) die('error auth');

$proc  = $_POST['process'];		
$ftype = $_POST['ftype'];
$fidx  = $_POST['fidx'];

//첨부파일경올 ftype
$_saveDir['company']	= "../data/company/";
$_saveDir['consult']	= "../data/consult/";
$_saveDir['modify']		= "../data/modify/";
$_saveDir['sian']		= "../data/sian/";
$_saveDir['contract']	= "../data/contract/";

$down = new DownloadFile($process);
$down ->saveDir = $_saveDir[$ftype];
$down ->ftype   = $ftype;
$down ->fidx    = $fidx;

$down -> fileDownLoadCommon();
?>