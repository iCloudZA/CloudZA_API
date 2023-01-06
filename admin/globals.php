<?php 
/*
 * @Date: 2022-05-20 20:53:10
 * @LastEditors: CloudZA(云之安) <i@zhian.cc>
 * @LastEditTime: 2022-06-06 18:25:04
 * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
 * Copyright (c) 2022 by CloudZA, All Rights Reserved. 
 */
/*
* File：后台全局加载项
* Author：之安
*/
require_once 'userdata.php';//管理员配置
require_once '../include/common.php';


$action = isset($_GET['action']) ? purge($_GET['action']) : '';
substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
//登录验证
if ($action == 'login') {
	$username = isset($_POST['user']) ? purge($_POST['user']) : '';
	$password = isset($_POST['pwd']) ? purge($_POST['pwd']) : '';
	
    if($username == '' || $password == ''){
		header('Location:./login.php?err=1');
		exit;
	}

    if($username == $user && $password == $pass){
// 		if(defined('ADM_LOG') && ADM_LOG == 1){Db::table('log')->add(['group'=>'adm','type'=>'logon','status'=>200,'time'=>time(),'ip'=>getip(),'data'=>json_encode($_POST)]);}//记录日志
		setcookie('ADMIN_COOKIE', $cookie, time() + 36000, '/');
		header('Location:./');
		exit;
	}else{
		header('Location:./login.php?err=2');
		exit;
	}
}
//退出
if ($action == 'logout') {
	setcookie('ADMIN_COOKIE', ' ', time() - 36000, '/');
	header('Location:./login.php');
	exit;
}

$ADMIN_COOKIE = isset($_COOKIE['ADMIN_COOKIE']) ? purge($_COOKIE['ADMIN_COOKIE']) : '';
if($ADMIN_COOKIE == $cookie){
	$islogin = true;
}else{
	$islogin = false;
}

if (!$islogin) {
	header('Location:./login.php?err=3');
	exit;
}


/*导航配置*/
$menu_arr = myScanDir(FCPATH.ADM_EXTEND_MULU,1); 
$titlename = [];
foreach($menu_arr as $value){
	$nav_arr = getPluginDataAd($value);
	foreach($nav_arr as $val){
		$titlename = array_merge($titlename,[$val['file']=>$val['name']]);
	}
	if($value == 'web'){//continue;
		$web = $nav_arr;
	}else{
		if(!file_exists(FCPATH.ADM_EXTEND_MULU.$value."/menu.php")){//continue;
			foreach($nav_arr as $value){
				$menu[] = $value;
			}
		}else{
			$nav = include FCPATH.ADM_EXTEND_MULU.$value."/menu.php";
			$menu[] = array_merge($nav,['side-nav-second-level'=>$nav_arr]);
		}
	}
}
$sortKey =  array_column($menu,'sort');
array_multisort($sortKey,SORT_ASC,$menu);

$Filename = strpos($_SERVER["QUERY_STRING"],'&') ? txt_zuo($_SERVER["QUERY_STRING"],"&") : $_SERVER["QUERY_STRING"];
$title = !empty($titlename[$Filename])?$titlename[$Filename]:'首页';
