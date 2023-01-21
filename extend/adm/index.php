<?php
if ( !isset($islogin)) header("Location: /"); //非法访问拦截
$apiCount = Db::table('api_list')->count();
$apiCallCount = Db::table('api_count')->count();
$today = Db::table('api_count')->where('datetime' , 'like' , '%' . date('Y-m-d') . '%')->count();
?>
<div class="animated fadeIn">
    <div class="block block-rounded bg-primary-light mb-4">
        <div class="bl  ock-content bg-white-5">
            <div class="py-4 text-center">
                <h1 class="h2 fw-bold text-white mb-2"><?php
                    echo TITLE ?></h1>
                <h2 class="h5 fw-medium text-white-75"><?php
                    echo TITLE_DESC ?></h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6 col-xl-3">
            <a class="block block-rounded block-link-pop text-end" href="javascript:void(0)">
                <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center border-black-op-b border-3">
                    <div class="d-none d-sm-block">
                        <i class="si si-bar-chart fa-2x text-primary-light"></i>
                    </div>
                    <div class="text-end">
                        <div class="fs-3 fw-semibold text-primary"><?php
                            echo $apiCount ?><span class="fs-sm">个</span></div>
                        <div class="fs-sm fw-semibold text-uppercase text-muted">接口数量</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a class="block block-rounded block-link-pop text-end" href="javascript:void(0)">
                <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center border-black-op-b border-3">
                    <div class="d-none d-sm-block">
                        <i class="si si-trophy fa-2x text-earth-light"></i>
                    </div>
                    <div class="text-end">
                        <div class="fs-3 fw-semibold text-earth"><span class="fs-lg"><?php
                                echo 'sign' ?></span></div>
                        <div class="fs-sm fw-semibold text-uppercase text-muted">今日冠军</div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-xl-3">
            <a class="block block-rounded block-link-pop text-end" href="javascript:void(0)">
                <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center border-black-op-b border-3">
                    <div class="d-none d-sm-block">
                        <i class="si si-bar-chart fa-2x text-elegance-light"></i>
                    </div>
                    <div class="text-end">
                        <div class="fs-3 fw-semibold text-elegance"><?php
                            echo $apiCallCount; ?><span class="fs-sm">次</span></div>
                        <div class="fs-sm fw-semibold text-uppercase text-muted">调用次数</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a class="block block-rounded block-link-pop text-end" href="javascript:void(0)">
                <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center border-black-op-b border-3">
                    <div class="d-none d-sm-block">
                        <i class="si si-fire fa-2x text-corporate-light"></i>
                    </div>
                    <div class="text-end">
                        <div class="fs-3 fw-semibold text-pulse"><?php
                            echo $today; ?><span class="fs-sm">次</span></div>
                        <div class="fs-sm fw-semibold text-uppercase text-muted">今日调用</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="block block-rounded block-mode-hidden">
        <div class="block-header block-header-default">
            <h3 class="block-title">公告 <small>作者寄语</small>
            </h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle"
                        data-action-mode="demo">
                    <i class="si si-refresh"></i>
                </button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle">
                    <i
                            class="si si-arrow-down"></i></button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="close">
                    <i class="si si-close"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            <p>这个估计会删掉，可能没什么用！</p>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-7">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        <i class="si si-bar-chart me-1 text-muted"></i>API统计
                    </h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle"
                                data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full text-center">
                    <canvas id="js-chartjs-bars" width="1120" height="560"
                            style="display: block; box-sizing: border-box; height: 140px; width: 280px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <i class="si si-clock me-1 text-muted"></i>
                    <h3 class="block-title">操作日志</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle"
                                data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <ul class="list list-activity mb-0" id="eventList"></ul>
                </div>
            </div>
        </div>

    </div>
</div>