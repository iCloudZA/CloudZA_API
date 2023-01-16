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
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?php
        echo TITLE ?> - <?php
        echo TITLE_DESC ?></title>
    <link rel="icon" href="/assets/img/favicons/favicon.png">
    <link rel="stylesheet" id="css-main" href="/assets/css/codebase.min-5.4.css">
</head>
<body>

<script src="/assets/js/codebase.app.min-5.4.js"></script>
</body>
</html>