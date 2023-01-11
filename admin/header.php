<?php

require_once 'globals.php';
$so = isset($_POST[ 'so' ]) ? purge($_POST[ 'so' ]) : '';
?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <title>CloudZA API系统</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="../assets/img/favicons/favicon.png">
    <link rel="stylesheet" id="css-main" href="../assets/css/codebase.min-5.4.css">
    <!-- 表格样式 -->
    <link rel="stylesheet"
          href="http://tool.qqshabi.cn/static/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
    <link href="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-0-M/nprogress/0.2.0/nprogress.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/lib/base64.js"></script>

</head>
<body>
<div id="page-container"
     class="sidebar-o enable-page-overlay side-scroll page-header-fixed main-content-boxed remember-theme side-trans-enabled">
    <nav id="sidebar">
        <div class="sidebar-content">
            <div class="content-header justify-content-lg-center">
                <div>
							<span class="smini-visible fw-bold tracking-wide fs-lg">
								c<span class="text-primary">c</span>
							</span>
                    <a class="link-fx fw-bold tracking-wide mx-auto" data-pjax href="./?index">
								<span class="smini-hidden">
									<i class="fa fa-fire text-primary"></i>
									<span class="fs-4 text-dual">cloudza</span>
									<span class="fs-4 text-primary">api</span>
								</span>
                    </a>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-alt-danger d-lg-none" data-toggle="layout"
                            data-action="sidebar_close">
                        <i class="fa fa-fw fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="js-sidebar-scroll">
                <div class="content-side content-side-user px-0 py-0">
                    <div class="smini-visible-block animated fadeIn px-2">
                        <img class="img-avatar img-avatar32"
                             src="https://api.test.zhian.pro/assets/images/users/avatar-1.jpg" alt="">
                    </div>
                    <div class="smini-hidden text-center mx-auto">
                        <a class="img-link" data-pjax href="./?index">
                            <img class="img-avatar" src="https://api.test.zhian.pro/assets/images/users/avatar-1.jpg"
                                 alt="">
                        </a>
                        <ul class="list-inline mt-3 mb-0">
                            <li class="list-inline-item">
                                <a class="text-dual fs-sm fw-semibold text-uppercase">云之安</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="link-fx text-dual" href="./?action=logout">
                                    <i class="fa fa-sign-out-alt"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="content-side content-side-full" id="nav-main">
                    <ul class="nav-main">
                        <li class="nav-main-item">
                            <a class="nav-main-link" data-pjax href="./?index">
                                <i class="nav-main-link-icon fa fa-fire-flame-simple"></i>
                                <span class="nav-main-link-name">首页</span>
                            </a>
                        </li>
                        <li class="nav-main-heading">导航</li>
                        <?php
                        foreach ($menu as $val) { ?>
                            <li class="nav-main-item">
                                <a aria-expanded="false" aria-haspopup="true"
                                   class="nav-main-link nav-main-link-submenu" data-toggle="submenu" href="#">
                                    <i class="nav-main-link-icon <?php
                                    echo $val[ 'icons' ]; ?>"></i>
                                    <span class="nav-main-link-name">
											<?php
                                            echo $val[ 'name' ]; ?>
										</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <?php
                                    foreach ($val[ 'side-nav-second-level' ] as $v) {
                                        if ($v[ 'hidden' ] == 'true') continue; ?>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" data-pjax href="./?<?php
                                            echo $v[ 'file' ]; ?>">
												<span class="nav-main-link-name">
													<?php
                                                    echo $v[ 'name' ]; ?>
												</span>
                                            </a>
                                        </li>
                                    <?php
                                    } ?>
                                </ul>
                            </li>
                        <?php
                        } ?>

                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <header id="page-header">
        <div class="content-header ">
            <div class="space-x-1">
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout"
                        data-action="sidebar_toggle">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </div>
            <div class="space-x-1">
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user d-sm-none"></i>
                        <span class="d-none d-sm-inline-block fw-semibold">云之安</span>
                        <i class="fa fa-angle-down opacity-50 ms-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0"
                         aria-labelledby="page-header-user-dropdown">
                        <div class="px-2 py-3 bg-body-light rounded-top">
                            <h5 class="h6 text-center mb-0">
                                云之安
                            </h5>
                        </div>
                        <div class="p-2">
                            <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1"
                               data-pjax href="./?web_edit">
                                <span>修改密码</span>
                                <i class="fa fa-fw fa-wrench opacity-25"></i>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1"
                               data-pjax href="./?action=logout">
                                <span>退出登录</span>
                                <i class="fa fa-fw fa-sign-out-alt opacity-25"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page api_list search -->
            <div id="page-header-search" class="overlay-header bg-body-extra-light">
                <div class="content-header">
                    <form class="w-100" action="" method="post">
                        <div class="input-group">
                            <button type="button" class="btn btn-secondary btn-alt-info" data-toggle="layout"
                                    data-action="header_search_off">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                            <input type="search" class="form-control form-control-alt"
                                   placeholder="输入关键词进行搜索"
                                   name="so"
                                   value='<?php
                                   echo $so; ?>'
                                   aria-controls="task-logs-list">
                            <button type="submit" class="btn btn-alt-info">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
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