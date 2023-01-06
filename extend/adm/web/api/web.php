<?php
/*
Name:系统配置API
*/
	if(!isset($islogin))header("Location: /");//非法访问
	
	if($act == 'set'){
	    

		if($adm_res){
			ReturnSuccess(200,'修改成功');
		}else{
			ReturnSuccess(201,'修改失败');
		}
	}
	
	if($act == 'pswd'){
		$user = isset($_POST['user']) ? purge($_POST['user']) : '';
		$pwd = isset($_POST['pwd']) ? purge($_POST['pwd']) : '';
		$okpwd = isset($_POST['okpwd']) ? purge($_POST['okpwd']) : '';
		if($user == '') exit(ReturnError(201,'账号不能为空'));
		if($pwd == '') exit(ReturnError(201,'密码不能为空'));
		if($okpwd == '') exit(ReturnError(201,'请确认密码'));
		if($okpwd != $pwd) exit(ReturnError(201,'确认密码有误'));
		$userdata = file_get_contents('userdata.php');
		//json(201,$userdata);
		$userdata = preg_replace('/\$user = \'.*?\'/', '$user = \'' . $user . '\'', $userdata);
		$userdata = preg_replace('/\$pass = \'.*?\'/', '$pass = \'' . $pwd . '\'', $userdata);
		$userdata = preg_replace('/\$cookie = \'.*?\'/', '$cookie = \'' . md5($user.$pwd.time()) . '\'', $userdata);
		$adm_res = file_put_contents('userdata.php', $userdata);
		if($adm_res){
			echo ReturnSuccess(200,'修改成功，即将重新登录...');
		}else{
			echo ReturnError(201,'修改失败');
		}
	}
	

?>