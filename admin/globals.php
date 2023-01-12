<?php
    /*
     * @LastEditors: CloudZA(云之安) <admin@osuu.cc>
     * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
     * Copyright (c) 2022 by CloudZA, All Rights Reserved.
     */

    require_once 'userdata.php';//管理员配置
    require_once '../include/common.php';
    $res = Db::table('admin')->select();
    $action = isset($_GET[ 'action' ]) ? purge($_GET[ 'action' ]) : '';
    substr($_SERVER[ 'PHP_SELF' ] , strrpos($_SERVER[ 'PHP_SELF' ] , '/') + 1);
    //登录验证
    if ($action == 'login') {
        $username = isset($_POST[ 'user' ]) ? purge($_POST[ 'user' ]) : '';
        $password = isset($_POST[ 'pwd' ]) ? purge($_POST[ 'pwd' ]) : '';
        if ($username == '' || $password == '') {
            exit(ReturnError('账号密码不能为空'));
        }
        if ($username == $res[0]['user'] && md5($password) == $res[0]['password']) {
            setcookie('ADMIN_COOKIE' , $res[0]['cookie'] , time() + 36000 , '/');
            exit(return_msg('200','登录成功',array('url' => '/admin?index')));
        } else {
            exit(ReturnError('账号密码错误'));
        }
    }
    //退出
    if ($action == 'logout') {
        setcookie('ADMIN_COOKIE' , ' ' , time() - 36000 , '/');
        header('Location:./login.php');
        exit;
    }
    $ADMIN_COOKIE = isset($_COOKIE[ 'ADMIN_COOKIE' ]) ? purge($_COOKIE[ 'ADMIN_COOKIE' ]) : '';
    if ($ADMIN_COOKIE == $res[0]['cookie']) {
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
