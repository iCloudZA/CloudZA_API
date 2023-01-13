<?php

/*
Name:系统配置API
*/
if (!isset($islogin)) header("Location: /"); //非法访问

if($act == 'web') {
    $data[ 'web_title' ] = isset($_POST[ 'web_title' ]) && !empty($_POST[ 'web_title' ]) ? purge($_POST[ 'web_title' ]) : '';
    $data['web_titleDesc'] = isset($_POST[ 'web_titleDesc' ]) && !empty($_POST[ 'web_titleDesc' ]) ? purge($_POST[ 'web_titleDesc' ]) : '';
    $data[ 'web_des' ] = isset($_POST[ 'web_des' ]) && !empty($_POST[ 'web_des' ]) ? purge($_POST[ 'web_des' ]) : '';
    $data[ 'web_key' ] = isset($_POST[ 'web_key' ]) && !empty($_POST[ 'web_key' ]) ? purge($_POST[ 'web_key' ]) : '';
    $data[ 'web_qq' ] = isset($_POST[ 'web_qq' ]) && !empty($_POST[ 'web_qq' ]) ? purge($_POST[ 'web_qq' ]) : '';
    $data[ 'web_beian' ] = isset($_POST[ 'web_beian' ]) && !empty($_POST[ 'web_beian' ]) ? purge($_POST[ 'web_beian' ]) : '';
    $data[ 'web_ban' ] = isset($_POST[ 'web_ban' ]) && !empty($_POST[ 'web_ban' ]) ? purge($_POST[ 'web_ban' ]) : '';
    $data[ 'web_page_nums' ] = isset($_POST[ 'web_page_nums' ]) && !empty($_POST[ 'web_page_nums' ]) ? purge($_POST[ 'web_page_nums' ]) : '';
    if ( !f($data)) exit(ReturnError('数据不完整'));
    $table = Db::table('webset');
    $origData = $table->find();
    // 对比原始数据
    if (array_diff($origData , (array)$data) && array_diff((array)$data , $origData)) {
        if ($table->update($data)) {
            exit(ReturnSuccess('更新成功'));
        } else {
            exit(ReturnError('更新失败'));
        }
    } else {
        exit(ReturnError('你没有修改任何内容！'));
    }
}
function f ($arr): bool
{
    $len1 = count($arr);
    $newarr = array_filter($arr);
    $len2 = count($newarr);
    if ($len1 === $len2) {
        return true;
    } else {
        return false;
    }
}