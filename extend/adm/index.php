<?php
if (!isset($islogin)) header("Location: /"); //非法访问拦截
$WEB = Db::table('webset')->select();
/** 服务器信息 **/
$php_ver = PHP_VERSION;
$res = $db->getMysqlVersion();
$uploadfile_maxsize = ini_get('upload_max_filesize');
if (function_exists("imagecreate")) {
	if (function_exists('gd_info')) {
		$ver_info = gd_info();
		$gd_ver = $ver_info['GD Version'];
	} else {
		$gd_ver = '支持';
	}
} else {
	$gd_ver = '不支持';
}



?>

<div class="block block-rounded bg-gd-dusk mb-4">
    <div class="block-content bg-white-5">
        <div class="py-4 text-center">
            <h1 class="h2 fw-bold text-white mb-2"><?php echo $WEB[0]['title']?></h1>
            <h2 class="h5 fw-medium text-white-75">一款开源的API系统</h2>
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
                    <div class="fs-3 fw-semibold text-primary">435</div>
                    <div class="fs-sm fw-semibold text-uppercase text-muted">用户数量</div>
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
                    <div class="fs-3 fw-semibold text-earth">177</div>
                    <div class="fs-sm fw-semibold text-uppercase text-muted">API接口</div>
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
                    <div class="fs-3 fw-semibold text-elegance">10930</div>
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
                    <div class="fs-3 fw-semibold text-pulse">423</div>
                    <div class="fs-sm fw-semibold text-uppercase text-muted">日均IP</div>
                </div>
            </div>
        </a>
    </div>
</div>
	<div class="block block-rounded">
		<div class="block-header block-header-default">
			<h3 class="block-title">这里 <small>暂时还没想好</small>
			</h3>
			<div class="block-options">
				<button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
				<button type="button" class="btn-block-option" data-toggle="block-option" data-action="pinned_toggle">
					<i class="si si-pin"></i>
				</button>
				<button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
					<i class="si si-refresh"></i>
				</button>
				<button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
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
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="header-title mb-3">服务器信息</h4>
					<div class="chart inline-legend grid">
						<p>PHP版本:
							<?php echo $php_ver; ?>
						</p>
						<p>MySQL版本:
							<?php echo $res ?>
						</p>
						<p>GD图形处理库:
							<?php echo $gd_ver; ?>
						</p>
						<p>服务器空间允许上传最大文件：
							<?php echo $uploadfile_maxsize; ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>


