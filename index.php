<?php
/*
 * @LastEditors: CloudZA(云之安) <admin@osuu.cc>
 * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
 * Copyright (c) 2022 by CloudZA, All Rights Reserved.
 */

include 'include/CheckRedis.php';
require_once( 'include/common.php' );
CheckRedis::Run();
$count_api = Db::table('api_list')->count();

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
        // 判断数据库中&&本地接口是否存在
        if ($sign && file_exists(FCPATH . API_EXTEND_MULU . $uri_parts[ 0 ] . '/index.php')) {
            // 判断接口是否正常
            if ($sign[ 'state' ] === 'on') {
                require FCPATH . API_EXTEND_MULU . $uri_parts[ 0 ] . '/index.php';
                $pv = $sign[ 'pv' ] + 1;
                $table->where('sign' , $uri_parts[ 0 ])->update(['pv' => $pv]);
            } else {
                exit(ReturnError('接口维护中'));
            }
            exit;
        } else {
            exit(ReturnError('暂无此接口'));
        }
    }
}

if(str_contains($uri , DESCURI)){
    $uri_parts = explode('-' , $uri);
    $uri_parts = explode('.',$uri_parts[1]);
    define("DOC_SIGN" , $uri_parts[ 0 ]);
    require 'extend/docView.php';
    exit;
}
?>

<!doctype html>
<html lang="zn-cn">
<head>
    <meta charset="utf-8">
    <title><?php
        echo TITLE ?> - <?php
        echo TITLE_DESC ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="/assets/img/favicons/favicon.png">
    <link rel="stylesheet" id="css-main" href="/assets/css/codebase.min-5.4.css">
    <!-- 表格样式 -->
    <link rel="stylesheet"
          href="/assets/css/dataTables.bootstrap5.min.css">
    <link href="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-0-M/nprogress/0.2.0/nprogress.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div id="page-container" class="enable-page-overlay side-scroll page-header-fixed main-content-boxed remember-theme side-trans-enabled">
    <header id="page-header">
        <div class="content-header ">
            <div class="space-x-1">
                <div class="content-header justify-content-lg-center">
                    <div>
                    <span class="smini-visible fw-bold tracking-wide fs-lg">
								c<span class="text-primary">c</span>
							</span>
                        <a class="link-fx fw-bold tracking-wide mx-auto" data-pjax="" href="./">
                            <span class="smini-hidden">
                                <i class="fa fa-fire text-primary"></i>
                                <span class="fs-4 text-dual">cloudza</span>
                                <span class="fs-4 text-primary">api</span>
                            </span>
                        </a>
                    </div>

                </div>
            </div>
            <div class="space-x-1">
                <a class="btn btn-sm btn-alt-secondary" href="https://github.com/iCloudZA" target="_blank">
                    <i class="fab fa-github-alt m-1"></i>Github</a>
            </div>
        </div>
        <div id="page-header-loader" class="overlay-header bg-primary">
            <div class="content-header">
                <div class="w-100 text-center">
                    <i class="far fa-sun fa-spin text-white"></i>
                </div>
            </div>
        </div>
    </header>

    <main id="main-container">
        <div class="content" id="pjax-container">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="py-3 text-center">
                        <h2 class="fw-bold mb-3"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">
                                    <?php
                                    echo TITLE ?>
                                </span></span></h2>
                        <h3 class="fs-base fw-medium text-muted mb-3">
                            <span style="vertical-align: inherit;"><span style="vertical-align: inherit;">
                                    <?php
                                    echo DESC ?>
                                </span></span></h3>
                        <p class="fs-sm fw-medium text-muted mb-4">共收录了<?php echo $count_api ?>个接口</p>
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-8 col-xl-6">
                                <form action="" method="POST">
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" name="search" id="search" placeholder="搜索API">
                                        <button type="submit" class="btn btn-alt-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row animated fadeIn" id="list"></div>
    </main>

    <footer id="page-footer">
        <div class="content py-3">
            <div class="row fs-sm">
                <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                    Crafted with <i class="fa fa-heart text-danger"></i> by
                    <a class="fw-semibold" href="https://github.com/iCloudZA" target="_blank">CloudZA</a>
                </div>
                <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                    <a class="fw-semibold" href="javascript:void (0);">云之安 </a> ©
                    <span data-toggle="year-copy" class="js-year-copy-enabled">2023</span>
                </div>
            </div>
        </div>
    </footer>
</div>
<script>
    $.ajax({
        url: "extend/ajaxApi.php",
        dataType: "json",
        success: function (data) {
            console.log(data)
            if(data.code){
                let listContainer = $("#list");
                for (let i = 0; i < data.data.length; i++) {
                    let title = data.data[i].name;
                    let desc = data.data[i].desc;
                    let pv = data.data[i].pv;
                    let state = data.data[i].state;
                    let stateInfo = data.data[i].stateInfo;
                    let uri = data.data[i].uri;
                    let itemHtml = '<div class="col-sm-6"><a class="block block-rounded d-flex align-items-stretch" href="javascript:void(0)" onclick="goToApiDoc(\'' + state + '\',\'' + uri + '\')">' +
                        '<div class="block-content block-sticky-options pt-5 bg-white">' +
                        '<div class="block-options block-options-left">' +
                        '<h2 class="fs-sm text-muted">' + title + '</h2>' +
                        '</div>' +
                        '<div class="block-options">' +
                        '<div class="block-options-item text-muted fs-sm">' +
                        '<i class="far fa-bookmark m-1"></i>' + stateInfo +
                        '<i class="si si-eye m-1"></i>' + pv +
                        '</div>' +
                        '</div>' +
                        '<h3 class="fs-sm fw-medium text-muted">' + desc + '</h3>' +
                        '</div>' +
                        '</a></div>';
                    listContainer.append(itemHtml);
                }
            } else {
                x.notify('Sever Error');
            }
        }
    });

    function goToApiDoc (state, uri)
    {
        if (state === 'on') {
            x.pjax(uri)
        } else {
            x.notify('此接口维护中', 'warning');
        }
    }

</script>
<script src="/assets/js/codebase.app.min-5.4.js"></script>
<script src="/assets/js/plugins/jquery-pjax/jquery.pjax.js"></script>
<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-0-M/nprogress/0.2.0/nprogress.min.js"></script>
<script src="/assets/js/dashboard.js"></script>
<script src="/assets/js/bootstrap-notify.min.js"></script>
<script src="/assets/js/layer.js"></script>
<script src="/assets/js/app.min.js"></script>
</body>
</html>