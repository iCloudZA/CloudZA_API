<?php
if ( !isset($islogin)) header("Location: /");//非法访问
// 添加API
if ($act === 'add') {
    $data[ 'name' ] = isset($_POST[ 'name' ]) && !empty($_POST[ 'name' ]) ? purge($_POST[ 'name' ]) : '';                                       // 接口名字
    $data[ 'type' ] = isset($_POST[ 'type' ]) && !empty($_POST[ 'type' ]) ? purge($_POST[ 'type' ]) : '';                                       // 接口类型
    $data[ 'api_url' ] = isset($_POST[ 'api_url' ]) && !empty($_POST[ 'api_url' ]) ? purge($_POST[ 'api_url' ]) : '';                           // 接口地址
    $data[ 'des' ] = isset($_POST[ 'des' ]) && !empty($_POST[ 'des' ]) ? purge($_POST[ 'des' ]) : '';                                           // 接口介绍
    $data[ 'http_mode' ] = isset($_POST[ 'http_mode' ]) && !empty($_POST[ 'http_mode' ]) ? purge($_POST[ 'http_mode' ]) : '';                   // 接口请求方法
    $data[ 'return_format' ] = isset($_POST[ 'return_format' ]) && !empty($_POST[ 'return_format' ]) ? purge($_POST[ 'return_format' ]) : '';   // 接口返回格式
    $data[ 'http_case' ] = isset($_POST[ 'http_case' ]) && !empty($_POST[ 'http_case' ]) ? purge($_POST[ 'http_case' ]) : '';                   // 接口请求示例
    $data[ 'return_case' ] = isset($_POST[ 'return_case' ]) && !empty($_POST[ 'return_case' ]) ? $_POST[ 'return_case' ] : '';                  // 接口返回示例
    $data[ 'code_case' ] = isset($_POST[ 'code_case' ]) && !empty($_POST[ 'code_case' ]) ? $_POST[ 'code_case' ] : '';                          // 接口代码示例
    $data[ 'state' ] = isset($_POST['state']) && !empty($_POST['state']) ? purge($_POST['state']) : '';                                         // 接口状态
    $data[ 'add_time' ] = date("Y-m-d H:i:s"); // 添加时间
    if($data['type'] == 'local'){
        $data['sign'] = $data[ 'api_url' ];
//        $data['api_url'] = WEB_URL.APIURI.$data['api_url'];
//        $data[ 'http_case' ] = WEB_URL.APIURI.$data[ 'http_case' ];
    } else if($data['type'] == 'external') {
        $data['sign'] = 'api-' . getRand(4);
    } else {
        exit(ReturnError('Form error!'));
    }
    if ( !f($data)) exit(ReturnError('数据不完整'));
    if(Db::table('api_list')->where('sign',$data['sign'])->find()) exit(ReturnError('【'.$data['sign'].'】'.'已存在，请更换'));
    if (Db::table('api_list')->add($data)) {
        writeLog('添加API：['.$data['name'].']');
        exit(ReturnSuccess('添加成功'));
    } else {
        exit(ReturnError('添加失败'));
    }
}
//修改API
if ($act === 'edit') {
    $id = isset($_POST[ 'id' ]) && !empty($_POST[ 'id' ]) ? purge($_POST[ 'id' ]) : '';                                                         // id
    $data[ 'name' ] = isset($_POST[ 'name' ]) && !empty($_POST[ 'name' ]) ? purge($_POST[ 'name' ]) : '';                                       // 接口名字
    $data[ 'type' ] = isset($_POST[ 'type' ]) && !empty($_POST[ 'type' ]) ? purge($_POST[ 'type' ]) : '';                                       // 接口类型
    $data[ 'api_url' ] = isset($_POST[ 'api_url' ]) && !empty($_POST[ 'api_url' ]) ? purge($_POST[ 'api_url' ]) : '';                           // 接口地址
    $data[ 'des' ] = isset($_POST[ 'des' ]) && !empty($_POST[ 'des' ]) ? purge($_POST[ 'des' ]) : '';                                           // 接口介绍
    $data[ 'http_mode' ] = isset($_POST[ 'http_mode' ]) && !empty($_POST[ 'http_mode' ]) ? purge($_POST[ 'http_mode' ]) : '';                   // 接口请求方法
    $data[ 'return_format' ] = isset($_POST[ 'return_format' ]) && !empty($_POST[ 'return_format' ]) ? purge($_POST[ 'return_format' ]) : '';   // 接口返回格式
    $data[ 'http_case' ] = isset($_POST[ 'http_case' ]) && !empty($_POST[ 'http_case' ]) ? purge($_POST[ 'http_case' ]) : '';                   // 接口请求示例
    $data[ 'return_case' ] = isset($_POST[ 'return_case' ]) && !empty($_POST[ 'return_case' ]) ? $_POST[ 'return_case' ] : '';                  // 接口返回示例
    $data[ 'code_case' ] = isset($_POST[ 'code_case' ]) && !empty($_POST[ 'code_case' ]) ? $_POST[ 'code_case' ] : '';                          // 接口代码示例
    $data[ 'state' ] = isset($_POST[ 'state' ]) && !empty($_POST[ 'state' ]) ? $_POST[ 'state' ] : '';                                          // 接口状态
    if($data['type'] == 'local'){
        $data['sign'] = $data[ 'api_url' ];
//        $data['api_url'] = WEB_URL.APIURI.$data['api_url'];
//        $data[ 'http_case' ] = WEB_URL.APIURI.$data[ 'http_case' ];
    } else if($data['type'] == 'external') {
//        $data['sign'] = 'api-' . getRand(4);
    } else {
        exit(ReturnError('Form error!'));
    }
    if ( !f($data)) exit(ReturnError('数据不完整'));
    $table = Db::table('api_list');
    $origData = $table->where('id' , $id)->find();
    // 对比原始数据
    if (array_diff($origData, (array)$data) && array_diff((array)$data , $origData)) {
        if ($table->where('id' , $id)->update($data)) {
            writeLog('修改API：['.$data['name'].']');
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
            writeLog('删除了'.count($_POST[ 'id' ]).'个API');
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
        writeLog('删除了一个API');
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