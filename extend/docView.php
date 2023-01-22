<?php
/**
 * 渲染API接口详情
 */
$row = DB::table('api_list')->where('sign',DOC_SIGN)->find();
if(!$row){
    header('Location:../');
}
?>

<!doctype html>
<html lang="zn-cn" class="">
<head>
    <meta charset="utf-8">
    <title><?php
        echo TITLE ?> - <?php
        echo TITLE_DESC ?></title>
    <meta name="description" content="<?php echo DESC ?>" />
    <meta name="keywords" content="<?php echo KEY ?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="../assets/img/favicons/favicon.png">
    <link rel="stylesheet" id="css-main" href="../assets/css/codebase.min-5.4.css">
    <!-- 表格样式 -->
    <link rel="stylesheet"
          href="../assets/css/dataTables.bootstrap5.min.css">
    <link href="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-0-M/nprogress/0.2.0/nprogress.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    td {
        white-space: nowrap;
        text-align: center;
    }
    th {
        text-align: center;
    }
</style>
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
                <div class="fs-lg p-3 bg-primary-op rounded text-white text-center push">
                    <div class="mb-2">
                        <i class="fa fa-2x fa-gift opacity-50"></i>
                    </div>
                    <h4 class="mb-1">
                        <?php echo $row['name'] ?>
                    </h4>
                    <p class="fs-sm fw-medium text-white mb-0">
                        <?php echo $row['des'] ?>
                    </p>
                </div>
                <div class="block block-rounded animated fadeIn">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">接口详情 <small><?php echo $row['name'] ?></small></h3>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="mb-4 col-sm-6">
                                <label class="form-label">接口地址</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-alt fs-sm" value="<?php echo ($row['type'] === 'local') ? WEB_URL.APIURI.$row['api_url'] : $row['api_url'] ?>" readonly>
                                    <a class="btn btn-sm btn-alt-info copy-btn" style="padding-top: 6px;" href="javascript:;" data-clipboard-text="<?php echo WEB_URL.APIURI.$row['api_url'] ?>" title="点击复制">
                                        <i class="far fa-copy"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="mb-4 col-sm-3">
                                <label class="form-label">请求方法</label>
                                    <input type="text" class="form-control form-control-alt fs-sm" value="<?php echo $row['http_mode'] ?>" readonly>
                            </div>
                            <div class="mb-4 col-sm-3">
                                <label class="form-label">返回格式</label>
                                    <input type="text" class="form-control form-control-alt fs-sm" value="<?php echo $row['return_format'] ?>" readonly>
                            </div>
                        </div>

                        <!-- 表格 -->
                        <?php if($row['http_param']): ?>
                        <span class="form-label">请求参数说明</span>
                        <div class="col-sm-12 table-responsive mb-4">
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive  ">
                                <?php echo $row['http_param'] ?>
                            </table>
                        </div>
                        <?php endif; ?>
                        <?php if($row['return_case']): ?>
                        <span class="form-label">返回示例</span>
                        <div class="block-content bg-gray-light rounded mb-4">
                            <pre><?php echo $row['return_case'] ?></pre>
                        </div>
                        <?php endif; ?>
                        <?php if($row['return_param']): ?>
                        <span class="form-label">返回参数说明</span>
                        <div class="col-sm-12 table-responsive mb-4">
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive  ">
                                <?php echo $row['return_param'] ?>
                            </table>
                        </div>
                        <?php endif; ?>
                        <?php if($row['code_case']): ?>
                        <span class="form-label">代码示例</span>
                        <div class="block-content bg-gray-light rounded mb-4">
                            <pre><?php echo $row['code_case'] ?></pre>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
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

<script>
    $(document).ready(()=>{
        var clipboard = new Clipboard('.copy-btn');
        clipboard.on('success', (e) => {
            layer.msg('复制成功！', {icon: 1});
        });
        clipboard.on('error', (e) => {
            layer.msg('复制失败，请长按链接后手动复制', {icon: 2});
        });
    })
</script>
<script src="../assets/js/codebase.app.min-5.4.js"></script>
<script src="../assets/js/plugins/jquery-pjax/jquery.pjax.js"></script>
<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-0-M/nprogress/0.2.0/nprogress.min.js"></script>
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/js/bootstrap-notify.min.js"></script>
<script src="../assets/js/layer.js"></script>
<script src="../assets/js/app.min.js"></script>
<script src="//cdn.staticfile.org/clipboard.js/1.7.1/clipboard.min.js"></script>
</body>
</html>