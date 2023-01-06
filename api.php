<?php
//php防注入和XSS攻击通用过滤.
$_GET     && SafeFilter($_GET);
$_POST    && SafeFilter($_POST);
$_COOKIE  && SafeFilter($_COOKIE);

function SafeFilter (&$arr){
  $ra=Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/','/script/','/javascript/','/vbscript/','/expression/','/applet/','/meta/','/xml/','/blink/','/link/','/style/','/embed/','/object/','/frame/','/layer/','/title/','/bgsound/','/base/','/onload/','/onunload/','/onchange/','/onsubmit/','/onreset/','/onselect/','/onblur/','/onfocus/','/onabort/','/onkeydown/','/onkeypress/','/onkeyup/','/onclick/','/ondblclick/','/onmousedown/','/onmousemove/','/onmouseout/','/onmouseover/','/onmouseup/','/onunload/');
  if (is_array($arr)){
    foreach ($arr as $key => $value){
      if(!is_array($value)){
        if (!ini_get('magic_quotes_gpc')){             //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
          $value=addslashes($value);           //给单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）加上反斜线转义
        }
        $value=preg_replace($ra,'',$value);     //删除非打印字符，粗暴式过滤xss可疑字符串
        $arr[$key]     = htmlentities(strip_tags($value)); //去除 HTML 和 PHP 标记并转换为 HTML 实体
      }else{
        SafeFilter($arr[$key]);
      }
    }
  }
}

require 'include/common.php';
$act = isset($_GET['act']) ? purge($_GET['act'],true,false) : null;
// $appid = isset($_GET['app']) ? intval($_GET['app']) : 0;//appid
// $sign = isset($_POST['sign']) ? (purge($_POST['sign'])) : (isset($_GET['sign']) ? purge($_GET['sign']) : '');//数据签名
// $data = isset($_POST['data']) ? (purge($_POST['data'])) : (isset($_GET['data']) ? purge($_GET['data']) : '');//加密数据

if($act){
	if(file_exists(FCPATH.API_EXTEND_MULU.$act.'.php')){
		require FCPATH.API_EXTEND_MULU.$act.'.php';
	}else{
		echo ReturnError('错误的参数');
	}
}

?>