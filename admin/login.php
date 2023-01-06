<?php
/*
 * @Date: 2022-05-20 20:53:10
 * @LastEditors: CloudZA(云之安)
 * @LastEditTime: 2022-12-30 16:09:01 
 * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
 * File：后台登陆
*/
require_once '../include/common.php';
$WEB = Db::table('webset')->select();
$err = isset($_GET['err']) ?
intval($_GET['err']) : 0; $errmsg = array(null,'账号密码不能为空','账号密码有误','您还没有登陆，请先登录！');
$error_msg = $errmsg[$err]; ?>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<title><?php echo $WEB[0]['title']; ?> - 后台登录</title>
		<link rel="icon" href="../assets/img/favicons/favicon.png" />
		<link rel="stylesheet" id="css-main" href="../assets/css/codebase.min-5.4.css" />
	</head>
	<body>
		<div id="page-container" class="main-content-boxed">
			<main id="main-container">
				<div class="bg-body-dark">
					<div class="row mx-0 justify-content-center">
						<div class="hero-static col-lg-6 col-xl-4">
							<div class="content content-full overflow-hidden">
								<div class="py-4 text-center">
									<a class="link-fx fw-bold" href="./">
										<i class="fa fa-fire"></i>
										<span class="fs-4 text-body-color">cloudza</span>
										<span class="fs-4">api</span>
									</a>
									<h1 class="h3 fw-bold mt-4 mb-2">
										Welcome to Your Dashboard
									</h1>
									<h2 class="h5 fw-medium text-muted mb-0">
										It’s a great day today!
									</h2>
								</div>
								<form class="js-validation-signin" name="f" method="post" action="./index.php?action=login">
									<div class="block block-themed block-rounded block-fx-shadow">
										<div class="block-header bg-gd-dusk">
											<h3 class="block-title">请登录</h3>
										</div>
										<div class="block-content">
											<div class="form-floating mb-4">
												<input type="text" class="form-control" name="user" placeholder="输入你的账号" required />
												<label class="form-label" for="login-username">账号</label>
											</div>
											<div class="form-floating mb-4">
												<input type="password" class="form-control" name="pwd" placeholder="输入你的密码" required />
												<label class="form-label" for="login-password">密码</label>
											</div>
											<div class="row">
												<div class="col-sm-6 d-sm-flex align-items-center push">
													<div class="form-check">
														<input type="checkbox" class="form-check-input" checked="" value="y" required />
														<label class="form-check-label" for="ok">记住我</label>
													</div>
												</div>
												<div class="col-sm-6 text-sm-end push">
													<button type="submit" class="btn btn-lg btn-alt-primary fw-medium">
														登录
													</button>
												</div>
											</div>
										</div>
									</div>
								</form>
								<?php if($error_msg):?>
								<div class="alert alert-warning" role="alert">
									<p class="mb-0">
										<font style="vertical-align: inherit">
											<font style="vertical-align: inherit">
												<strong>提示：</strong>
												<?php echo $error_msg; ?>
											</font>
										</font>
									</p>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
		<script src="../assets/js/codebase.app.min-5.4.js"></script>
		<script src="../assets/js/lib/jquery.min.js"></script>
		<script src="../assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
	</body>
</html>