<?php
if(!isset($islogin))header("Location: /");//非法访问
// 添加
if($act === 'add'){

    exit(ReturnSuccess('添加成功'));
}
if($act === 'edit'){
    exit(ReturnSuccess('更新成功'));
}
// 删除选中
if ($act === 'delSelect') {
    exit(ReturnSuccess('删除成功，但并没有执行SQL'));
}
// 删除按钮
if ($act === 'delapi') {
    exit(ReturnSuccess('执行成功,但并没有删除'));
}
