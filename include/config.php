<?php

//数据参数参数
$param = array(
    'host' => 'localhost',            //数据库连接地址，默认：localhost或127.0.0.1
    'port' => '3306',                 //端口号
    'user' => 'public_api',             //用户名
    'pwd' => 'dong2002',      //密码
    'dbname' => 'public_api',           //数据库名称
    'charset' => 'utf8'               //设置字符集

);
$db = Db::getInstance($param);
