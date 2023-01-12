<?php
    /*
    Name:系统配置API
    */
    if ( !isset($islogin)) header("Location: /");//非法访问

    if ($act === 'pwd'){
        $data['user'] = isset($_POST[ 'user' ]) ? purge($_POST[ 'user' ]) : '';
        $data['password'] = isset($_POST[ 'pwd' ]) ? purge($_POST[ 'pwd' ]) : '';
        $okpwd = isset($_POST[ 'okpwd' ]) ? purge($_POST[ 'okpwd' ]) : '';
        if ($data['user'] == '') exit(ReturnError('账号不能为空'));
        if ($data['password'] == '') exit(ReturnError('密码不能为空'));
        if ($okpwd == '') exit(ReturnError('请确认密码'));
        if ($okpwd != $data['password']) exit(ReturnError('确认密码有误'));
        $data['password'] = md5($data['password']);
        $data['cookie'] = md5($data['user'] . $data['password'] . time());
        if(Db::table('admin')->update($data)){
            echo ReturnSuccess('修改成功，即将重新登录');
        } else {
            echo ReturnError('修改失败');
        }


    }
