<?php
if(!isset($islogin))header("Location: /");//非法访问
if ($act === 'delSelect') {
    exit(ReturnSuccess('删除成功，但并没有执行SQL'));
}

if ($act === 'delapi') {
    exit(ReturnSuccess('执行成功,但并没有删除'));
}
