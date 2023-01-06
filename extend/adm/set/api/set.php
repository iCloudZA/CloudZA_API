<?php

/*
Name:系统配置API
*/
if (!isset($islogin)) header("Location: /"); //非法访问

if ($act == 'web') {
    $data = array(
        'web_title' => $_POST['web_title'],
        'web_des' => $_POST['web_des'],
        'web_key' => $_POST['web_key'],
        'web_beian' => $_POST['web_beian'],
        'web_ban' => $_POST['web_ban'],
        'page_enums' => $_POST['page_enums'],
    );
    $perform_sql = $db->table('web_set')->update(['web_title' => $data['web_title'], 'web_des' => $data['web_des'], 'web_key' => $data['web_key'], 'web_beian' => $data['web_beian'], 'web_ban' => $data['web_ban'], 'page_enums' => $data['page_enums']]);
    if ($perform_sql) {
        echo json(200, '修改成功');
    } else {
        echo json(201, '修改失败');
    }
}
