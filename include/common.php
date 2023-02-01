<?php
/*
 * @LastEditors: CloudZA(云之安) <admin@osuu.cc>
 * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
 * Copyright (c) 2022 by CloudZA, All Rights Reserved.
 */
require_once 'db.class.php';
const ADM_EXTEND_MULU = 'extend/adm/';
//API存放路径
const API_EXTEND_MULU = 'extend/api/';
// API展示路径
const APIURI = 'api/';

// API详情规则
const  DESCURI = 'doc-';


$web_info = Db::table('webset' , 'as A')->find();
define("TITLE" , ( $web_info[ 'web_title' ] ) ?: 'CloudZA-API');
define("TITLE_DESC" , ( $web_info[ 'web_titleDesc' ] ) ?: '一款开源的API系统');
define("DESC" , ( $web_info[ 'web_des' ] ) ?: '一款开源的API系统');
define("KEY" , ( $web_info[ 'web_key' ] ) ?: 'API,CloudZA-API,免费API,API内容管理系统');
define("BEIAN" , ( $web_info[ 'web_beian' ] ) ?: '京ICP备8888888号-8');
define("QQ" , ( $web_info[ 'web_qq' ] ) ?: '2922619853');
define("FOOTER_BAN" , ( $web_info[ 'web_ban' ] ) ?: '云之安');
define("PAGES" , ( $web_info[ 'web_page_nums' ] ) ?: '10');
define('FCPATH' , str_replace("\\" , '/' , dirname(dirname(__FILE__)) . '/'));
define('WEB_URL' , ( ( $_SERVER[ 'SERVER_PORT' ] == 443 ) ? 'https' : 'http' ) . '://' . $_SERVER[ 'HTTP_HOST' ] . '/');
define('WEB_URL_FILE' , ( ( $_SERVER[ 'SERVER_PORT' ] == 443 ) ? 'https' : 'http' ) . '://' . $_SERVER[ 'HTTP_HOST' ] . str_replace($_SERVER[ 'DOCUMENT_ROOT' ] , ( substr($_SERVER[ 'DOCUMENT_ROOT' ] , -1) == '/' ) ? '/' : '' , dirname($_SERVER[ 'SCRIPT_FILENAME' ])));
//管理日志
$lang_adm = ['logon' => '后台登录' , 'add_api' => '新增API' , 'edit_api' => '修改API' , 'del_api' => '删除API' , 'dels_api' => '删除多个API' , 'edit_web' => '修改网站设置' , 'edit_admin' => '修改管理员信息' ,];


// API调用记录
function callApiLog ($name , $sign , $pv): bool
{
    $pv += 1;
    if (Db::table('api_list')->where('sign' , $sign)->update(['pv' => $pv]) && Db::table('api_count')->add(['sign' => $sign , 'name' => $name , 'ip' => get_ip() , 'address' => getIPAddress(get_ip()) , 'datetime' => date('Y-m-d H:i:s')])) {
        return true;
    } else {
        return false;
    }
}

/**
 * 导航配置方法
 */
function getPluginDataAd ($FilePath): array
{
    $file_arr = myScanDir(FCPATH . ADM_EXTEND_MULU . $FilePath . '/view' , 2);
    $nav_arr = [];
    foreach ($file_arr as $val) {
        $Data = implode('' , file(FCPATH . ADM_EXTEND_MULU . $FilePath . '/view/' . $val));
        preg_match("/Sort:(.*)/i" , $Data , $sort);
        preg_match("/Hidden:(.*)/i" , $Data , $hidden);
        preg_match("/icons:(.*)/i" , $Data , $icons);
        preg_match("/Name:(.*)/i" , $Data , $name);
        preg_match("/Url:(.*)/i" , $Data , $url);
        preg_match("/Right:(.*)/i" , $Data , $right);
        $sort = isset($sort[ 1 ]) ? strip_tags(trim($sort[ 1 ])) : '';
        $hidden = isset($hidden[ 1 ]) ? strip_tags(trim($hidden[ 1 ])) : '';
        $icons = isset($icons[ 1 ]) ? strip_tags(trim($icons[ 1 ])) : '';
        $name = isset($name[ 1 ]) ? strip_tags(trim($name[ 1 ])) : '';
        $url = isset($url[ 1 ]) ? strip_tags(trim($url[ 1 ])) : '';
        $right = isset($right[ 1 ]) ? strip_tags(trim($right[ 1 ])) : '';
        //if($hidden == 'true')continue;
        $nav_arr[] = ['name' => $name , 'file' => $url , 'icons' => $icons , 'right' => $right , 'sort' => $sort , 'hidden' => $hidden];
    }
    $sortKey = array_column($nav_arr , 'sort');
    array_multisort($sortKey , SORT_ASC , $nav_arr);
    return $nav_arr;
}

/**
 * 实现遍历出目录及其子文件
 */
function myScanDir ($dir , $type = 0): array
{
    $file_arr = scandir($dir);
    $new_arr = [];
    foreach ($file_arr as $item) {
        //echo $item.'<br>';
        if ($type == 0 && $item != ".." && $item != ".") {
            //目录和文件
            $new_arr[] = $item;
        } elseif ($type == 1 && is_dir($dir . '/' . $item) && $item != ".." && $item != ".") {
            //只要目录
            $new_arr[] = $item;
        } elseif ($type == 2 && is_file($dir . '/' . $item) && $item != ".." && $item != ".") {
            //只要文件
            $new_arr[] = $item;
        }
    }
    return $new_arr;
}

/**
 * 分页
 */
function pagination ($count , $perlogs , $page , $url): string
{
    $pnums = @ceil($count / $perlogs);
    $re = '';
    $urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|" , "" , $url);
    for ($i = $page - 2; $i <= $page + 2 && $i <= $pnums; $i++) {
        if ($i > 0) {
            if ($i == $page) {
                $re .= "<li class=\"page-item active\"><a class=\"page-link\">$i</a></li>";
            } elseif ($i == 1) {
                $re .= "<li class=\"page-item\"><a class=\"page-link\" data-pjax href=\"$urlHome\">$i</a></li>";
            } else {
                $re .= "<li class=\"page-item\"><a class=\"page-link\" data-pjax href=\"$url$i\">$i</a></li>";
            }
        }
    }
    if ($page > 0) if ($pnums > $page) {
        //前进
        $go = $page + 1;
    } else {
        $go = $page;
    }
    if ($page > 1) {
        $after = $page - 1;
    } else {
        $after = $page;
    }
    $re = "<li class=\"page-item\"><a class=\"page-link\" data-pjax href=\"$url$after\" aria-label=\"Previous\"><span aria-hidden=\"true\"><i class=\"fa fa-angle-left\"></i></span> <span class=\"sr-only\"><span style=\"vertical-align: inherit;\"><span style=\"vertical-align: inherit;\">Previous</span></span></span></a></li>$re";
    $re .= "<li class=\"page-item\"><a class=\"page-link\" data-pjax href=\"$url$go\" aria-label=\"Next\"><span aria-hidden=\"true\"><i class=\"fa fa-angle-right\"></i></span> <span class=\"sr-only\"><sapn style=\"vertical-align: inherit;\"><sapn style=\"vertical-align: inherit;\">Next</sapn></sapn></span></a></li>";
    if ($pnums <= 1) $re = '';
    return "<ul class=\"pagination pagination-sm\">" . $re . "</ul>";
}

function purge ($string , $trim = true , $filter = true , $force = 0 , $strip = false)
{
    //递归addslashes  对参数进行净化
    $encode = mb_detect_encoding($string , array("ASCII" , "UTF-8" , "GB2312" , "GBK" , "BIG5"));
    if ($encode != 'UTF-8') {
        $string = iconv($encode , 'UTF-8' , $string);
    }
    if ($trim) {
        $string = preg_replace('/\s+/' , '' , $string);
    }
    if ($filter) {
        $farr = array("/<(\\/?)(script|i?frame|style|html|body|title|link|meta|object|\\?|\\%)([^>]*?)>/isU" , "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU" , "/select |insert |and |or |create |update |delete |alter |count |\'|\/\*|\*|\.\.\/|\.\/|\^|union |into |load_file|outfile |dump/is");
        $string = preg_replace($farr , '' , $string);
    }
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC' , !ini_get('magic_quotes_gpc'));
    if ( !MAGIC_QUOTES_GPC || $force) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[ $key ] = purge($val , $force , $strip);
            }
        } else {
            $string = addslashes($strip ? stripslashes($string) : $string);
        }
    }
    return $string;
}


function txt_Arr ($txt): array
{
    //文本转数组
    $arr = explode('&' , $txt);
    $array = [];
    foreach ($arr as $value) {
        $tmp_arr = explode('=' , $value);
        if (is_array($tmp_arr) && count($tmp_arr) == 2) {
            $array = array_merge($array , [$tmp_arr[ 0 ] => $tmp_arr[ 1 ]]);
        }
    }
    return $array;
}

function txt_zhong ($str , $leftStr , $rightStr)
{
    //取文本中间
    $left = strpos($str , $leftStr);
    //echo '左边:'.$left;
    $right = strpos($str , $rightStr , $left);
    //echo '<br>右边:'.$right;
    if ($left < 0 or $right < $left) return '';
    return substr($str , $left + strlen($leftStr) , $right - $left - strlen($leftStr));
}

function txt_you ($str , $leftStr)
{
    //取文本右边
    $left = strpos($str , $leftStr);
    return substr($str , $left + strlen($leftStr));
}

function txt_zuo ($str , $rightStr)
{
    //取文本左边
    $right = strpos($str , $rightStr);
    return substr($str , 0 , $right);
}

function ip_city_str ($str)
{
    return str_replace(array('省' , '市') , '' , $str);
}

//获取当个ip所在的省份
function getIpAddress ($ip)
{
    $url = 'https://whois.pconline.com.cn/ipJson.jsp?json=true&ip=';
    $city = curl_get($url . $ip);
    $city = mb_convert_encoding($city , "UTF-8" , "GB2312");
    $city = json_decode($city , true);
    if ($city[ 'city' ]) {
        $location = ip_city_str($city[ 'pro' ]) . ip_city_str($city[ 'city' ]);
    } else {
        $location = ip_city_str($city[ 'pro' ]);
    }
    if ($location) {
        return $location;
    } else {
        return $city[ 'addr' ];
    }
}


/**
 * 获取用户真实IP
 * @param int  $type
 * @param bool $adv
 * @return mixed
 */
function get_ip (int $type = 0 , bool $adv = true)
{
    $type = $type ? 1 : 0;
    $ip = NULL;
    if (NULL !== $ip) {
        return $ip[ $type ];
    }
    if ($adv) {
        if (isset($_SERVER[ 'HTTP_X_FORWARDED_FOR' ])) {
            $arr = explode(',' , $_SERVER[ 'HTTP_X_FORWARDED_FOR' ]);
            $pos = array_search('unknown' , $arr);
            if (false !== $pos) {
                unset($arr[ $pos ]);
            }
            $ip = trim(current($arr));
        } elseif (isset($_SERVER[ 'HTTP_CLIENT_IP' ])) {
            $ip = $_SERVER[ 'HTTP_CLIENT_IP' ];
        } elseif (isset($_SERVER[ 'REMOTE_ADDR' ])) {
            $ip = $_SERVER[ 'REMOTE_ADDR' ];
        }
    } elseif (isset($_SERVER[ 'HTTP_X_FORWARDED_FOR' ])) {
        $arr = explode(',' , $_SERVER[ 'HTTP_X_FORWARDED_FOR' ]);
        $pos = array_search('unknown' , $arr);
        if (false !== $pos) {
            unset($arr[ $pos ]);
        }
        $ip = trim(current($arr));
    } elseif (isset($_SERVER[ 'REMOTE_ADDR' ])) {
        $ip = $_SERVER[ 'REMOTE_ADDR' ];
    }
    // IP地址合法验证
    $long = sprintf("%u" , ip2long($ip));
    $ip = $long ? array($ip , $long) : array('0.0.0.0' , 0);
    return $ip[ $type ];
}

/**
 * 生成随机字符串
 * @param $length int 长度
 * @return string|null
 */
function getRand (int $length): ?string
{
    $str = NULL;
    $strPol = "abcdefhijkmnprstwxyz";
    $max = strlen($strPol) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[ rand(0 , $max) ];
    }
    return $str;
}

// url参数转数组
function toarr ($para)
{
    $str = mb_substr($para , stripos($para , "?") + 1);
    parse_str($str , $arr);
    return $arr;
}


function curl_get ($url)
{
    $ch = curl_init($url);
    curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , false);
    curl_setopt($ch , CURLOPT_SSL_VERIFYHOST , false);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
    curl_setopt($ch , CURLOPT_USERAGENT , 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
    curl_setopt($ch , CURLOPT_TIMEOUT , 30);
    $content = curl_exec($ch);
    curl_close($ch);
    return ( $content );
}

/**
 * 返回带数据
 * @param $code int 响应代码
 * @param $msg  string 描述字符串
 * @param $data array 返回的数据
 * @return false|string json
 */
function return_msg (int $code , string $msg , array $data = [])
{
    $return_data[ 'code' ] = $code;
    $return_data[ 'msg' ] = $msg;
    $return_data[ 'data' ] = $data;
    return json_encode($return_data);
}

/**
 * 成功返回不带数据
 * @param $msg string 描述
 */
function ReturnSuccess (string $msg)
{
    $result = ['code' => 200 , 'msg' => $msg ,];
    return json_encode($result);
}

/**
 * 失败返回
 * @param $msg string 描述
 */
function ReturnError (string $msg)
{
    $result = ['code' => 201 , 'msg' => $msg ,];
    return json_encode($result);
}

/**
 * 记录日志
 * @param $msg
 * @return bool
 */
function writeLog ($msg): bool
{
    if (empty($msg)) {
        return false;
    }
    $ip = get_ip();
    $implement = Db::table('web_log')->add(['ip' => $ip , 'time' => date('Y-m-d H:i:s') , 'event' => $msg , 'detailed' => getIPAddress($ip)]);
    if ($implement) {
        return true;
    } else {
        return false;
    }
}