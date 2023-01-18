<?php
/**
 * 渲染API接口详情
 */

/**
 * 获取Sign -- $uro_page[0]
 * 向数据库查询Sign字段，返回data
 *
 * $data = Db::table('api_list')->where('sign',Sign)->find();
 *
 * echo $dat[*]
 *
 *
 */
include '../../include/common.php';
?>


<!doctype html>
<html lang="zn-cn">
<head>
    <meta charset="utf-8">
    <title><?php
        echo TITLE ?> - <?php
        echo TITLE_DESC ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="../../assets/img/favicons/favicon.png">
    <link rel="stylesheet" id="css-main" href="../../assets/css/codebase.min-5.4.css">
    <!-- 表格样式 -->
    <link rel="stylesheet"
          href="../../assets/css/dataTables.bootstrap5.min.css">
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
                        <a class="link-fx fw-bold tracking-wide mx-auto" data-pjax="" href="./?index">
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
                <a class="btn btn-sm btn-alt-secondary" href="https://github.com/iCloudZA">
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
        <div class="content">
<!--            -->
            <div class="col-xl-12">
                <div class="fs-lg p-4 bg-primary-op rounded text-white text-center push">
                    <div class="mb-2">
                        <i class="fa fa-2x fa-gift opacity-50"></i>
                    </div>
                    <h4 class="mb-1">
                        某某API
                    </h4>
                    <p class="fs-sm fw-medium text-white mb-0">
                        xxxxxxxxxxxxxxxxxxx
                    </p>
                </div>
                <div class="block block-rounded">
                    <div class="block-content">
                        xxx
                    </div>
                </div>
            </div>

<!--            -->
            </div>
    </main>

    <footer id="page-footer">
        <div class="content py-3">
            <div class="row fs-sm">
                <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                    Crafted with <i class="fa fa-heart text-danger"></i> by
                    <a class="fw-semibold" href="https://osuu.cc/" target="_blank">CloudZA</a>
                </div>
                <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                    <a class="fw-semibold" href="https://1.envato.market/95j" target="_blank">云之安 </a> ©
                    <span data-toggle="year-copy" class="js-year-copy-enabled">2023</span>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="../../assets/js/codebase.app.min-5.4.js"></script>
<!--<script src="../assets/js/lib/jquery.min.js"></script>-->
<script src="../../assets/js/plugins/jquery-pjax/jquery.pjax.js"></script>
<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-0-M/nprogress/0.2.0/nprogress.min.js"></script>
<script src="../../assets/js/dashboard.js"></script>
<script src="../../assets/js/bootstrap-notify.min.js"></script>
<script src="../../assets/js/layer.js"></script>
<script src="../../assets/js/app.min.js"></script>
</body>
</html>