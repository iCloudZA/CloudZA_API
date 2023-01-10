<?php
if ( !isset($islogin)) header("Location: /");//非法访问
// 添加
if ($act === 'add') {
    $data[ 'name' ] = isset($_POST[ 'name' ]) && !empty($_POST[ 'name' ]) ? purge($_POST[ 'name' ]) : '';                                       // 接口名字
    $data[ 'api_url' ] = isset($_POST[ 'api_url' ]) && !empty($_POST[ 'api_url' ]) ? purge($_POST[ 'api_url' ]) : '';                           // 接口地址
    $data[ 'des' ] = isset($_POST[ 'des' ]) && !empty($_POST[ 'des' ]) ? purge($_POST[ 'des' ]) : '';                                           // 接口介绍
    $data[ 'api_key' ] = isset($_POST[ 'api_key' ]) && !empty($_POST[ 'api_key' ]) ? purge($_POST[ 'api_key' ]) : '';                                           // 接口关键词
    $data[ 'http_mode' ] = isset($_POST[ 'http_mode' ]) && !empty($_POST[ 'http_mode' ]) ? purge($_POST[ 'http_mode' ]) : '';                   // 接口请求方法
    $data[ 'return_format' ] = isset($_POST[ 'return_format' ]) && !empty($_POST[ 'return_format' ]) ? purge($_POST[ 'return_format' ]) : '';   // 接口返回格式
    $data[ 'http_case' ] = isset($_POST[ 'http_case' ]) && !empty($_POST[ 'http_case' ]) ? purge($_POST[ 'http_case' ]) : '';                   // 接口请求示例
    $data[ 'return_case' ] = isset($_POST[ 'return_case' ]) && !empty($_POST[ 'return_case' ]) ? purge($_POST[ 'return_case' ]) : '';
    $data[ 'add_time' ] = date("Y-m-d H:i:s"); // 添加时间
    ( !f($data) ) ? exit(ReturnError('数据不完整')) : true;
    if (Db::table('api_list')->add($data)) {
        exit(return_msg('200' , '添加成功' , $data));
    } else {
        exit(ReturnError('添加失败'));
    }


//    exit(ReturnSuccess('添加成功'));
}
if ($act === 'edit') {
    $id = isset($_POST[ 'id' ]) && !empty($_POST[ 'id' ]) ? purge($_POST[ 'id' ]) : '';                                                         //id
    $data[ 'name' ] = isset($_POST[ 'name' ]) && !empty($_POST[ 'name' ]) ? purge($_POST[ 'name' ]) : '';                                       // 接口名字
    $data[ 'api_url' ] = isset($_POST[ 'api_url' ]) && !empty($_POST[ 'api_url' ]) ? purge($_POST[ 'api_url' ]) : '';                           // 接口地址
    $data[ 'des' ] = isset($_POST[ 'des' ]) && !empty($_POST[ 'des' ]) ? purge($_POST[ 'des' ]) : '';                                           // 接口介绍
    $data[ 'api_key' ] = isset($_POST[ 'api_key' ]) && !empty($_POST[ 'api_key' ]) ? purge($_POST[ 'api_key' ]) : '';                                           // 接口关键词
    $data[ 'http_mode' ] = isset($_POST[ 'http_mode' ]) && !empty($_POST[ 'http_mode' ]) ? purge($_POST[ 'http_mode' ]) : '';                   // 接口请求方法
    $data[ 'return_format' ] = isset($_POST[ 'return_format' ]) && !empty($_POST[ 'return_format' ]) ? purge($_POST[ 'return_format' ]) : '';   // 接口返回格式
    $data[ 'http_case' ] = isset($_POST[ 'http_case' ]) && !empty($_POST[ 'http_case' ]) ? purge($_POST[ 'http_case' ]) : '';                   // 接口请求示例
    $data[ 'return_case' ] = isset($_POST[ 'return_case' ]) && !empty($_POST[ 'return_case' ]) ? purge($_POST[ 'return_case' ]) : '';
    ( !f($data) ) ? exit(ReturnError('数据不完整')) : true;
    if (Db::table('api_list')->where('id',$id)->update($data)) {
        exit(return_msg('200' , '更新成功' , $data));
    } else {
        exit(ReturnError('更新失败'));
    }
}
// 删除选中
if ($act === 'delSelect') {
    exit(ReturnSuccess('删除成功，但并没有执行SQL'));
}
// 删除按钮
if ($act === 'delapi') {
    $id = isset($_POST[ 'id' ]) && !empty($_POST[ 'id' ]) ? purge($_POST[ 'id' ]) : '';
    if(Db::table('api_list')->where('id',$id)->del()){
        exit(ReturnSuccess('删除成功'));
    } else {
        exit(ReturnError('删除失败'));
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