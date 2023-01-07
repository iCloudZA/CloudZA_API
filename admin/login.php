<?php
    /*
     * @LastEditors: CloudZA(云之安) <admin@osuu.cc>
     * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
     * Copyright (c) 2022 by CloudZA, All Rights Reserved.
     */

    require_once '../include/common.php';
    $WEB = Db::table('webset')->select();
?>
<html lang="zh-cn">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title><?php echo $WEB[ 0 ][ 'title' ]; ?> - 后台登录</title>
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
                        <div
                        ="js-validation-signin">
                        <div class="block block-themed block-rounded block-fx-shadow">
                            <div class="block-header bg-gd-dusk">
                                <h3 class="block-title">请登录</h3>
                            </div>
                            <div class="block-content">
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control" name="user" placeholder="输入你的账号"
                                           required />
                                    <label class="form-label" for="login-username">账号</label>
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="password" class="form-control" name="password"
                                           placeholder="输入你的密码" required />
                                    <label class="form-label" for="login-password">密码</label>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 d-sm-flex align-items-center push">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" checked="" value="y"
                                                   required />
                                            <label class="form-check-label" for="ok">记住我</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-sm-end push">
                                        <button type="submit" id="submit" class="btn btn-lg btn-alt-primary fw-medium">
                                            登录
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</main>
</div>
<script src="../assets/js/codebase.app.min-5.4.js"></script>
<script src="../assets/js/lib/jquery.min.js"></script>
<script src="../assets/js/bootstrap-notify.min.js"></script>
<script src="../assets/js/plugins/jquery-pjax/jquery.pjax.js"></script>
<script src="../assets/js/app.min.js"></script>
<script>
    $('#submit').click(function () {
        let user = $("input[name='user']").val();
        let pwd = $("input[name='password']").val();
        $.ajax({
            cache: false,
            type: "POST",//请求的方式
            url: "index.php?action=login",//请求的文件名
            data: {user: user, pwd: pwd},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.code == 200) {
                    x.notify(data.msg, 'success')
                    window.setTimeout("window.location='" + data.data.url + "'", 1000);
                } else {
                    x.notify(data.msg, 'danger')
                }
            }
        });
    });
</script>
</body>
</html>