<?php
require '../include/common.php';

$res = Db::table('api_list')->select();

$arr = array();
foreach ($res as $k => $v){
    $row = $res[$k];
        $data['name'] = $row['name'];
        $data['desc'] = $row['des'];
        $data['pv'] = $row['pv'];
        $data['state'] = $row['state'];
        $data['uri'] = ($row['state'] === 'on') ? DESCURI.$row['sign'].'.html' : '';
        $data['stateInfo'] = ($row['state'] === 'on') ? '正常' : '维护';
        $arr[] = $data;

}

echo return_msg('1','success',$arr);