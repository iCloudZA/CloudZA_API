<?php
if ( !isset($islogin)) header("Location: /");//非法访问
// 添加API
if ($act === 'add') {
    $data[ 'name' ] = isset($_POST[ 'name' ]) && !empty($_POST[ 'name' ]) ? purge($_POST[ 'name' ]) : '';                                       // 接口名字
    $data[ 'api_url' ] = isset($_POST[ 'api_url' ]) && !empty($_POST[ 'api_url' ]) ? purge($_POST[ 'api_url' ]) : '';                           // 接口地址
    $data[ 'des' ] = isset($_POST[ 'des' ]) && !empty($_POST[ 'des' ]) ? purge($_POST[ 'des' ]) : '';                                           // 接口介绍
    $data[ 'api_key' ] = isset($_POST[ 'api_key' ]) && !empty($_POST[ 'api_key' ]) ? purge($_POST[ 'api_key' ]) : '';                           // 接口关键词
    $data[ 'http_mode' ] = isset($_POST[ 'http_mode' ]) && !empty($_POST[ 'http_mode' ]) ? purge($_POST[ 'http_mode' ]) : '';                   // 接口请求方法
    $data[ 'return_format' ] = isset($_POST[ 'return_format' ]) && !empty($_POST[ 'return_format' ]) ? purge($_POST[ 'return_format' ]) : '';   // 接口返回格式
    $data[ 'http_case' ] = isset($_POST[ 'http_case' ]) && !empty($_POST[ 'http_case' ]) ? purge($_POST[ 'http_case' ]) : '';                   // 接口请求示例
    $data[ 'return_case' ] = isset($_POST[ 'return_case' ]) && !empty($_POST[ 'return_case' ]) ? $_POST[ 'return_case' ] : '';
    $data[ 'add_time' ] = date("Y-m-d H:i:s"); // 添加时间
    if ( !f($data)) exit(ReturnError('数据不完整'));
    if (Db::table('api_list')->add($data)) {
        exit(ReturnSuccess('添加成功'));
    } else {
        exit(ReturnError('添加失败'));
    }


//    exit(ReturnSuccess('添加成功'));
}
//修改API
if ($act === 'edit') {
    $id = isset($_POST[ 'id' ]) && !empty($_POST[ 'id' ]) ? purge($_POST[ 'id' ]) : '';                                                         //id
    $data[ 'name' ] = isset($_POST[ 'name' ]) && !empty($_POST[ 'name' ]) ? purge($_POST[ 'name' ]) : '';                                       // 接口名字
    $data[ 'api_url' ] = isset($_POST[ 'api_url' ]) && !empty($_POST[ 'api_url' ]) ? purge($_POST[ 'api_url' ]) : '';                           // 接口地址
    $data[ 'des' ] = isset($_POST[ 'des' ]) && !empty($_POST[ 'des' ]) ? purge($_POST[ 'des' ]) : '';                                           // 接口介绍
    $data[ 'api_key' ] = isset($_POST[ 'api_key' ]) && !empty($_POST[ 'api_key' ]) ? purge($_POST[ 'api_key' ]) : '';                           // 接口关键词
    $data[ 'http_mode' ] = isset($_POST[ 'http_mode' ]) && !empty($_POST[ 'http_mode' ]) ? purge($_POST[ 'http_mode' ]) : '';                   // 接口请求方法
    $data[ 'return_format' ] = isset($_POST[ 'return_format' ]) && !empty($_POST[ 'return_format' ]) ? purge($_POST[ 'return_format' ]) : '';   // 接口返回格式
    $data[ 'http_case' ] = isset($_POST[ 'http_case' ]) && !empty($_POST[ 'http_case' ]) ? purge($_POST[ 'http_case' ]) : '';                   // 接口请求示例
    $data[ 'return_case' ] = isset($_POST[ 'return_case' ]) && !empty($_POST[ 'return_case' ]) ? $_POST[ 'return_case' ] : '';
    if ( !f($data)) exit(ReturnError('数据不完整'));
    $table = Db::table('api_list');
    $origData = $table->where('id' , $id)->select();
    // 对比原始数据
    if (array_diff($origData[ 0 ] , (array)$data) && array_diff((array)$data , $origData[ 0 ])) {
        if ($table->where('id' , $id)->update($data)) {
            exit(ReturnSuccess('更新成功'));
        } else {
            exit(ReturnError('更新失败'));
        }
    } else {
        exit(ReturnError('你没有修改任何内容！'));
    }
}

// 删除选中
if ($act === 'delSelect') {
    $id = $_POST[ 'id' ] ?? '';
    if ($id) {
        $ids = '';
        foreach ($id as $value) {
            $ids .= intval($value) . ",";
        }
        $ids = rtrim($ids , ",");
        $res = Db::table('api_list')->where('id' , 'in' , '(' . $ids . ')')->del();
        if ($res) {
            exit(ReturnSuccess('删除成功'));
        } else {
            exit(ReturnError('删除失败'));
        }
    } else {
        exit(ReturnError('没有需要删除的数据'));
    }
}
// 删除按钮
if ($act === 'delapi') {
    $id = isset($_POST[ 'id' ]) && !empty($_POST[ 'id' ]) ? purge($_POST[ 'id' ]) : '';
    if (Db::table('api_list')->where('id' , $id)->del()) {
        exit(ReturnSuccess('删除成功'));
    } else {
        exit(ReturnError('删除失败'));
    }

}
/**
 * 判断数组是否完整
 * @param $arr
 * @return bool
 */
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