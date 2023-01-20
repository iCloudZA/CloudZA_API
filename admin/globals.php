<?php
/*
 * @LastEditors: CloudZA(云之安) <admin@osuu.cc>
 * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
 * Copyright (c) 2022 by CloudZA, All Rights Reserved.
 */

require_once '../include/common.php';
$res = Db::table('admin')->find();
$action = isset($_GET[ 'action' ]) ? purge($_GET[ 'action' ]) : '';
$api = isset($_GET[ 'api' ]) ? purge($_GET[ 'api' ]) : '';
substr($_SERVER[ 'PHP_SELF' ] , strrpos($_SERVER[ 'PHP_SELF' ] , '/') + 1);
//登录验证
if ($action === 'login') {
    $username = isset($_POST[ 'user' ]) ? purge($_POST[ 'user' ]) : '';
    $password = isset($_POST[ 'pwd' ]) ? purge($_POST[ 'pwd' ]) : '';
    if ($username == '' || $password == '') {
        exit(ReturnError('账号密码不能为空'));
    }
    if ($username == $res[ 'user' ] && md5($password) == $res[ 'password' ]) {
        $COOKIE = md5($res[ 'user' ] . $res[ 'password' ] . time());
        // 更新数据库中的Cookie
        if ( !Db::table('admin')->update(['cookie' => $COOKIE])) {
            exit(ReturnError('Sever Error!'));
        }
        writeLog('登录后台');
        setcookie('ADMIN_COOKIE' , $COOKIE , time() + 36000 , '/');
        exit(return_msg('200' , '登录成功' , array('url' => '/admin?index')));
    } else {
        exit(ReturnError('账号密码错误'));
    }
}
//退出
if ($action === 'logout') {
    setcookie('ADMIN_COOKIE' , ' ' , time() - 36000 , '/');
    header('Location:./login.php');
    exit;
}
$ADMIN_COOKIE = isset($_COOKIE[ 'ADMIN_COOKIE' ]) ? purge($_COOKIE[ 'ADMIN_COOKIE' ]) : '';
if ($ADMIN_COOKIE == $res[ 'cookie' ]) {
    $islogin = true;
} else {
    $islogin = false;
}
if ( !$islogin) {
    header('Location:./login.php?err=3');
    exit;
}

/*导航配置*/
$menu_arr = myScanDir(FCPATH . ADM_EXTEND_MULU , 1);
$titlename = [];
foreach ($menu_arr as $value) {
    $nav_arr = getPluginDataAd($value);
    foreach ($nav_arr as $val) {
        $titlename = array_merge($titlename , [$val[ 'file' ] => $val[ 'name' ]]);
    }
    if ($value == 'admin') {//continue;
        $web = $nav_arr;
    } else {
        if ( !file_exists(FCPATH . ADM_EXTEND_MULU . $value . "/menu.php")) {//continue;
            foreach ($nav_arr as $value) {
                $menu[] = $value;
            }
        } else {
            $nav = include FCPATH . ADM_EXTEND_MULU . $value . "/menu.php";
            $menu[] = array_merge($nav , ['side-nav-second-level' => $nav_arr]);
        }
    }
}
$sortKey = array_column($menu , 'sort');
array_multisort($sortKey , SORT_ASC , $menu);

$Filename = strpos($_SERVER[ "QUERY_STRING" ] , '&') ? txt_zuo($_SERVER[ "QUERY_STRING" ] , "&") : $_SERVER[ "QUERY_STRING" ];
$title = !empty($titlename[ $Filename ]) ? $titlename[ $Filename ] : '首页';


// Chart Data

if($api === 'chart'){
    $week_array = ["星期日" , "星期一" , "星期二" , "星期三" , "星期四" , "星期五" , "星期六"];
    $data = Db::query('SELECT DATE(datetime) as date, COUNT(DISTINCT ip) as ips, COUNT(*) as pv FROM api_count WHERE datetime >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY DATE(datetime)');
    $result = ["date" => [] ,"ip"=>[] , "pv" => []];
    foreach ($data as $item) {
        $result["date"][] = $item["date"];
        $result['ip'][] = $item['ips'];
        $result['pv'][] = $item['pv'];
    }
    exit(return_msg('200','success',$result));
}