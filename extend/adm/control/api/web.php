<?php
if (!isset($islogin)) header("Location: /"); //非法访问

if($act == 'set') {
    $data[ 'web_title' ] = isset($_POST[ 'web_title' ]) && !empty($_POST[ 'web_title' ]) ? purge($_POST[ 'web_title' ]) : '';
    $data['web_titleDesc'] = isset($_POST[ 'web_titleDesc' ]) && !empty($_POST[ 'web_titleDesc' ]) ? purge($_POST[ 'web_titleDesc' ]) : '';
    $data[ 'web_des' ] = isset($_POST[ 'web_des' ]) && !empty($_POST[ 'web_des' ]) ? purge($_POST[ 'web_des' ]) : '';
    $data[ 'web_key' ] = isset($_POST[ 'web_key' ]) && !empty($_POST[ 'web_key' ]) ? purge($_POST[ 'web_key' ]) : '';
    $data[ 'web_qq' ] = isset($_POST[ 'web_qq' ]) && !empty($_POST[ 'web_qq' ]) ? purge($_POST[ 'web_qq' ]) : '';
    $data[ 'web_beian' ] = isset($_POST[ 'web_beian' ]) && !empty($_POST[ 'web_beian' ]) ? purge($_POST[ 'web_beian' ]) : '';
    $data[ 'web_ban' ] = isset($_POST[ 'web_ban' ]) && !empty($_POST[ 'web_ban' ]) ? purge($_POST[ 'web_ban' ]) : '';
    $data[ 'web_page_nums' ] = isset($_POST[ 'web_page_nums' ]) && !empty($_POST[ 'web_page_nums' ]) ? purge($_POST[ 'web_page_nums' ]) : '';
    if($data['web_page_nums']<10) exit(ReturnError('分页最低设置10条'));
    if ( !f($data)) exit(ReturnError('数据不完整'));
    $table = Db::table('webset');
    $origData = $table->find();
    // 对比原始数据
    if (array_diff($origData , (array)$data) && array_diff((array)$data , $origData)) {
        if ($table->update($data)) {
            writeLog('修改了网站信息');
            exit(ReturnSuccess('更新成功'));
        } else {
            exit(ReturnError('更新失败'));
        }
    } else {
        exit(ReturnError('你没有修改任何内容！'));
    }
}

// 删除日志
if ($act === 'delCheck') {
    $id = $_POST[ 'id' ] ?? '';
    if ($id) {
        $ids = '';
        foreach ($id as $value) {
            $ids .= intval($value) . ",";
        }
        $ids = rtrim($ids , ",");
        $res = Db::table('web_log')->where('id' , 'in' , '(' . $ids . ')')->del();
        if ($res) {
            exit(ReturnSuccess('删除成功'));
        } else {
            exit(ReturnError('删除失败'));
        }
    } else {
        exit(ReturnError('没有需要删除的数据'));
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