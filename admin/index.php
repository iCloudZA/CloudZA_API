<?php 
/** 
 * File: App Store 后台管理系统 CloudZA
 */

require_once "header.php";
if($Filename == '' or $Filename == 'index'){
	include(FCPATH.ADM_EXTEND_MULU."/index.php");
}else if(file_exists(FCPATH.ADM_EXTEND_MULU.str_replace("_",'/view/',$Filename).".php")){
	include(FCPATH.ADM_EXTEND_MULU.str_replace("_",'/view/',$Filename).".php");
}else{
	if(!strpos($Filename,"_") && file_exists(FCPATH.ADM_EXTEND_MULU.$Filename.'/view/'.$Filename.".php")){
		include(FCPATH.ADM_EXTEND_MULU.$Filename.'/view/'.$Filename.".php");
	}else{
		include("404.php");
	}
}
require_once "footer.php";

