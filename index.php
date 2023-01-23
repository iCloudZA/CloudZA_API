<?php
/*
 * @LastEditors: CloudZA(云之安) <admin@osuu.cc>
 * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
 * Copyright (c) 2022 by CloudZA, All Rights Reserved.
 */
if (!file_exists('./install/install.lock')) {
    header("Location: ../install");
    return true;
}
require_once( 'include/common.php' );
require_once( 'include/Route.class.php' );
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
                if ( !ini_get('magic_quotes_gpc')) {
                    $value = addslashes($value);
                }
                $value = preg_replace($ra , '' , $value);
                $arr[ $key ] = htmlentities(strip_tags($value));
            } else {
                SafeFilter($arr[ $key ]);
            }
        }
    }
}

$route = new Route();
?>

<!doctype html>
<html lang="zn-cn" class="">
<head>
    <meta charset="utf-8">
    <title><?php
        echo TITLE ?> - <?php
        echo TITLE_DESC ?></title>
    <meta name="description" content="<?php
    echo DESC ?>" />
    <meta name="keywords" content="<?php
    echo KEY ?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="/assets/img/favicons/favicon.png">
    <link rel="stylesheet" id="css-main" href="/assets/css/codebase.min-5.4.css">
    <!-- 表格样式 -->
    <link rel="stylesheet"
          href="/assets/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.staticfile.org/nprogress/0.2.0/nprogress.css" rel="stylesheet">
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
                        <a class="link-fx fw-bold tracking-wide mx-auto" data-pjax href="../">
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
            <div class="row block block-rounded">
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
                        <p class="fs-sm fw-medium text-muted mb-4">共收录了<?php
                            echo $count_api ?>个接口</p>
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-8 col-xl-6">
                                <div class="input-group input-group-lg">
                                    <input type="text" class="form-control" name="search" id="search" placeholder="搜索API">
                                    <button type="submit" onclick="search()" class="btn btn-alt-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
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
                    Powered by <?php echo FOOTER_BAN ?> <i class="fa fa-heart text-danger"></i> Developer is <a href="https://github.com/iCloudZA/CloudZA_API" target="_blank">CloudZA</a>
                </div>
                <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                    <a class="fw-semibold text-muted" href="javascript:void (0);"><?php echo BEIAN ?> </a>
                </div>
            </div>
        </div>
    </footer>
</div>
<script>
    $(() => {
        x.ajax("extend/ajaxApi.php?act=list",{}, (data) => {
            if (data.code && data.data.length > 0) {
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
                    $("#list").append(itemHtml);
                }
            } else {
                let itemHtml = '<div class="block block-rounded"><div class="block-content block-content-full  text-center"><h2 class="h3 fw-bold mb-2">暂无接口</h2><h3 class="h4 fw-medium text-muted mb-2">您可以联系管理员添加接口</h3></div></div> '
                $("#list").append(itemHtml);
            }
        })
    })

    function search(){
        let name = x.getval('#search');
        x.ajax("extend/ajaxApi.php?act=search",{
            name:name
        },(data)=>{
            $("#list").empty();  // or $("#list").remove();
            if (data.code && data.data.length > 0) {
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
                    $("#list").append(itemHtml);
                }
            } else {
                let itemHtml = '<div class="block block-rounded"><div class="block-content block-content-full  text-center"><h2 class="h3 fw-bold mb-2">暂无接口</h2><h3 class="h4 fw-medium text-muted mb-2">您可以联系管理员添加接口</h3></div></div> '
                $("#list").append(itemHtml);
            }
        })
    }


    function goToApiDoc (state, uri)
    {
        if (state === 'on') {
            try {
                x.pjax(uri)
            }
            catch {
                x.notify('出现异常，请看控制台', 'warning')
            }
        } else {
            x.notify('此接口维护中', 'warning');
        }
    }

</script>
<script src="/assets/js/codebase.app.min-5.4.js"></script>
<script src="https://cdn.staticfile.org/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
<script src="https://cdn.staticfile.org/nprogress/0.2.0/nprogress.js"></script>
<script src="/assets/js/bootstrap-notify.min.js"></script>
<script src="/assets/js/layer.js"></script>
<script src="https://cdn.staticfile.org/clipboard.js/2.0.11/clipboard.min.js"></script>
<script src="/assets/js/app.min.js"></script>
</body>
</html>