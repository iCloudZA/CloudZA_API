<?php
if (!isset($islogin)) header("Location: /"); //非法访问拦截

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

	<h2 class="content-heading">首页</h2>
	<div class="row">
		<div class="col-md-6 col-xl-3">
			<a class="block block-rounded block-link-shadow" href="javascript:void(0)">
				<div class="block-content block-content-full block-sticky-options">
					<div class="block-options">
						<div class="block-options-item">
							<i class="far fa-circle fa-2x text-info-light"></i>
						</div>
					</div>
					<div class="py-3 text-center">
						<div class="fs-2 fw-bold mb-0 text-info">3580</div>
						<div class="fs-sm fw-semibold text-uppercase text-muted">All Products</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-md-6 col-xl-3">
			<a class="block block-rounded block-link-shadow" href="javascript:void(0)">
				<div class="block-content block-content-full block-sticky-options">
					<div class="block-options">
						<div class="block-options-item">
							<i class="fa fa-star fa-2x text-warning-light"></i>
						</div>
					</div>
					<div class="py-3 text-center">
						<div class="fs-2 fw-bold mb-0 text-warning">95</div>
						<div class="fs-sm fw-semibold text-uppercase text-muted">Top Sellers</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-md-6 col-xl-3">
			<a class="block block-rounded block-link-shadow" href="javascript:void(0)">
				<div class="block-content block-content-full block-sticky-options">
					<div class="block-options">
						<div class="block-options-item">
							<i class="fa fa-exclamation-triangle fa-2x text-danger-light"></i>
						</div>
					</div>
					<div class="py-3 text-center">
						<div class="fs-2 fw-bold mb-0 text-danger">30</div>
						<div class="fs-sm fw-semibold text-uppercase text-muted">Out of Stock</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-md-6 col-xl-3">
			<a class="block block-rounded block-link-shadow" href="be_pages_ecom_product_edit.html">
				<div class="block-content block-content-full block-sticky-options">
					<div class="block-options">
						<div class="block-options-item">
							<i class="fa fa-archive fa-2x text-success-light"></i>
						</div>
					</div>
					<div class="py-3 text-center">
						<div class="fs-2 fw-bold mb-0 text-success">
							<i class="fa fa-plus"></i>
						</div>
						<div class="fs-sm fw-semibold text-uppercase text-muted">New Product</div>
					</div>
				</div>
			</a>
		</div>
	</div>
	<div class="block block-rounded">
		<div class="block-header block-header-default">
			<h3 class="block-title">Blank <small>Get Started</small>
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
			<p>Create your own awesome project!</p>
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


