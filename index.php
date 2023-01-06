<?php
/*
 * @Date: 2022-05-19 19:40:56
 * @LastEditors: CloudZA(云之安) <i@zhian.cc>
 * @LastEditTime: 2022-06-13 12:37:54
 * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
 * Copyright (c) 2022 by CloudZA, All Rights Reserved. 
 */

include 'include/CheckRedis.php';
require_once('include/common.php');
CheckRedis::Run();
// URL
// $scriptpath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
// $sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
// $siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $sitepath . '/';
// header('Location:./admin/login.php');
// exit;
?>

<!doctype html>
<html lang="zn-cn">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>CloudZA API - 即将推出</title>
  <link rel="icon" href="../assets/img/favicons/favicon.png">
  <link rel="stylesheet" id="css-main" href="../assets/css/codebase.min-5.4.css">
</head>
<body>
<div id="page-container" class="main-content-boxed">
          <main id="main-container">
<div class="bg-image" style="background-image: url('../assets/img/photo23@2x.jpg');">
  <div class="hero bg-black-50">
    <div class="hero-inner">
      <div class="content content-full">
        <div class="row justify-content-center">
          <div class="col-md-6 py-4 text-center">
            <h1 class="display-4 fw-bold text-white mb-2">API系统</h1>
            <h2 class="h4 fw-normal text-white-75 pb-4 mb-3 border-white-op-b">即将推出</h2>
            <div class="js-countdown mb-3"></div>
            <a class="btn rounded-pill btn-outline-warning" href="https://github.com/iCloudZA">
              <i class="fa fa-arrow-right opacity-50 me-1"></i> Go to my Github
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</main>
</div>
<script src="../assets/js/codebase.app.min-5.4.js"></script>
</body>
</html>