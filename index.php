<?php
/*
 * @LastEditors: CloudZA(云之安) <admin@osuu.cc>
 * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
 * Copyright (c) 2022 by CloudZA, All Rights Reserved.
 */

include 'include/CheckRedis.php';
require_once( 'include/common.php' );
CheckRedis::Run();
//details-test.html
$_GET && SafeFilter($_GET);
$_POST && SafeFilter($_POST);
$_COOKIE && SafeFilter($_COOKIE);
function SafeFilter (&$arr): void
{
    $ra = array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/' , '/script/' , '/javascript/' , '/vbscript/' , '/expression/' , '/applet/' , '/meta/' , '/xml/' , '/blink/' , '/link/' , '/style/' , '/embed/' , '/object/' , '/frame/' , '/layer/' , '/title/' , '/bgsound/' , '/base/' , '/onload/' , '/onunload/' , '/onchange/' , '/onsubmit/' , '/onreset/' , '/onselect/' , '/onblur/' , '/onfocus/' , '/onabort/' , '/onkeydown/' , '/onkeypress/' , '/onkeyup/' , '/onclick/' , '/ondblclick/' , '/onmousedown/' , '/onmousemove/' , '/onmouseout/' , '/onmouseover/' , '/onmouseup/' , '/onunload/');
    if (is_array($arr)) {
        foreach ($arr as $key => $value) {
            if ( !is_array($value)) {
                if ( !ini_get('magic_quotes_gpc')) {             //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
                    $value = addslashes($value);           //给单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）加上反斜线转义
                }
                $value = preg_replace($ra , '' , $value);     //删除非打印字符，粗暴式过滤xss可疑字符串
                $arr[ $key ] = htmlentities(strip_tags($value)); //去除 HTML 和 PHP 标记并转换为 HTML 实体
            } else {
                SafeFilter($arr[ $key ]);
            }
        }
    }
}

//const API_EXTEND_MULU = 'extend/api/';
//define('FCPATH' , str_replace("\\" , '/' , dirname(dirname(__FILE__)) . '/'));

$uri = $_SERVER[ 'REQUEST_URI' ];
if (str_contains($uri , '/api/')) {
    $uri_parts = explode('/' , $uri);
    $uri_parts = explode('?' , $uri_parts[ 2 ]);
    if ($uri_parts[ 0 ]) {
        $table = Db::table('api_list');
        $sign = $table->where('sign' , $uri_parts[ 0 ])->find();
        if ($sign && file_exists(FCPATH . API_EXTEND_MULU . $uri_parts[ 0 ] . '/index.php')) {
            require FCPATH . API_EXTEND_MULU . $uri_parts[ 0 ] . '/index.php';
            $pv = $sign[ 'pv' ] + 1;
            $table->where('sign' , $uri_parts[ 0 ])->update(['pv' => $pv]);
            exit;
        } else {
            exit(ReturnError('暂无此接口'));
        }
    }
}

?>

<!doctype html>
<html lang="zn-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?php
        echo TITLE ?> - <?php
        echo TITLE_DESC ?></title>
    <link rel="icon" href="/assets/img/favicons/favicon.png">
    <link rel="stylesheet" id="css-main" href="../assets/css/codebase.min-5.4.css">
</head>
<body>
<div id="page-container" class="main-content-boxed">
    <main id="main-container">
        <div class="bg-image" style="background-image: url('../assets/img/photo23@2x.jpg');">
            <div class="hero bg-black-50">
                <div class="hero-inner">
                    <div class="content content-full">
                        <div class="row justify-content-center">
                            <div class="col-md-6 py-4 text-center">
                                <h1 class="display-4 fw-bold text-white mb-2">免费的API系统</h1>
                                <h2 class="h4 fw-normal text-white-75 pb-4 mb-3 border-white-op-b">即将推出</h2>
                                <div class="js-countdown mb-3"></div>
                                <a class="btn rounded-pill btn-outline-warning" href="https://github.com/iCloudZA">
                                    <i class="fa fa-arrow-right opacity-50 me-1"></i> Go to my Github
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="../assets/js/codebase.app.min-5.4.js"></script>
</body>
</html>