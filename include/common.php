<?php
require_once 'db.class.php';

const ADM_EXTEND_MULU = 'extend/adm/';
//adm扩展目录
const API_EXTEND_MULU = 'extend/api/';

define('FCPATH' , str_replace("\\" , '/' , dirname(dirname(__FILE__)) . '/'));
// 网站根目录
define('WEB_URL' , ( ( $_SERVER[ 'SERVER_PORT' ] == 443 ) ? 'https' : 'http' ) . '://' . $_SERVER[ 'HTTP_HOST' ] . str_replace($_SERVER[ 'DOCUMENT_ROOT' ] , ( substr($_SERVER[ 'DOCUMENT_ROOT' ] , -1) == '/' ) ? '/' : '' , dirname($_SERVER[ 'SCRIPT_FILENAME' ])));
// 网站根目录

/**
 * ADMIN导航配置方法
 */
function getPluginDataAd ($FilePath)
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
function myScanDir ($dir , $type = 0)
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
function pagination ($count , $perlogs , $page , $url)
{
    $pnums = @ceil($count / $perlogs);
    $re = '';
    $urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|" , "" , $url);
    for ($i = $page - 2; $i <= $page + 2 && $i <= $pnums; $i++) {
        if ($i > 0) {
            if ($i == $page) {
                $re .= "<li class=\"page-item active\"><a class=\"page-link\">$i</a></li>";
                //$re ."<li class=\"page-item active\"><a class=\"page-link\" >$i</a></li>";
                //$re .= "<li><span>$i</span></li>";

            } elseif ($i == 1) {
                $re .= "<li class=\"page-item\"><a class=\"page-link\" href=\"$urlHome\">$i</a></li>";
            } else {
                $re .= "<li class=\"page-item\"><a class=\"page-link\" href=\"$url$i\">$i</a></li>";
                //$re .= "<li><a href=\"$url$i\">$i</a></li>";

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
    $re = "<li class=\"page-item\">	<a class=\"page-link\" href=\"$url$after\" aria-label=\"Previous\">		<span aria-hidden=\"true\">&laquo;</span>		<span class=\"sr-only\">Previous</span>	</a> </li>$re";
    $re .= "<li class=\"page-item\"><a class=\"page-link\" href=\"$url$go\" aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span><span class=\"sr-only\">Next</span></a></li>";
    if ($pnums <= 1) $re = '';
    return "<ul class=\"pagination justify-content-end\">" . $re . "</ul>";
}


/**
 * 取QQ号
 */
function get_qqNum ($emil)
{
    $qq = str_replace('@qq.com' , '' , $emil);
    return $qq;
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


function check_email ($email)
{
    //匹配邮箱
    return preg_match('/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i' , $email) ? true : false;
}

function foreachArray ($array = [] , $count = 0)
{
    //数组维度判断
    if ( !is_array($array)) {
        return $count;
    }
    foreach ($array as $value) {
        $count++;
        if ( !is_array($value)) {
            return $count;
        }
        return foreachArray($value , $count);
    }
}


function txt_Arr ($txt)
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


//获取当个ip所在的省份
function get_ip_address ($ip)
{
    //访问api接口获取ip地址http://ip-api.com/json/ip地址?lang=zh-CN
    //获取当前ip所在的省份
    $url = "http://whois.pconline.com.cn/jsAlert.jsp?callback=testJson&ip=" . $ip;
    try {
        $ipaddres = file_get_contents($url);
        $iphtml = iconv("gb2312" , "utf-8//IGNORE" , $ipaddres);
        $addres = mb_substr($iphtml , 9 , -4);
        return $addres;
    } catch (Exception $e) {
        return '未知ip';
    }
}

/**
 * 获取用户真实IP
 * @param int  $type
 * @param bool $adv
 * @return mixed
 */
function get_user_ip ($type = 0 , $adv = true): mixed
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

// url参数转数组
function toarr ($para)
{
    $str = mb_substr($para , stripos($para , "?") + 1);
    parse_str($str , $arr);
    return $arr;
}

function sign ($arr , $key , $sha1 = true)
{ //数组签名
    unset($arr[ 'sign' ]);
    unset($arr[ 'act' ]);
    unset($arr[ 'clientid' ]);
    $sign = '';
    foreach ($arr as $k => $v) {
        $sign = $sign . $k . '=' . $v . '&';
    }
    $sign = $sign . $key;
    if ($sha1) {
        return sha1($sign);
    } else {
        return $sign;
    }
}

/**
 * 发送HTTP请求方法
 * @param string $url 请求URL
 * @param array  $params 请求参数
 * @param string $method 请求方法GET/POST
 * @param array  $header 请求头
 * @return bool|string  $data   响应数据
 * @throws Exception
 */
function http ($url , array $params , string $method = 'GET' , array $header = array()): bool|string
{
    $opts = array(CURLOPT_TIMEOUT => 30 , CURLOPT_RETURNTRANSFER => 1 , CURLOPT_SSL_VERIFYPEER => false , CURLOPT_SSL_VERIFYHOST => false , CURLOPT_HTTPHEADER => $header);
    /* 根据请求类型设置特定参数 */
    switch (strtoupper($method)) {
        case 'GET':
            // $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            $opts[ CURLOPT_URL ] = $url;
            break;
        case 'POST':
            $opts[ CURLOPT_URL ] = $url;
            $opts[ CURLOPT_POST ] = 1;
            $opts[ CURLOPT_POSTFIELDS ] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt($ch , CURLOPT_ENCODING , '');
    //set gzip, deflate or keep empty for server to detect and set supported encoding.
    curl_setopt($ch , CURLOPT_IPRESOLVE , CURL_IPRESOLVE_V4);
    curl_setopt($ch , CURLOPT_HTTPHEADER , array('Expect:'));
    curl_setopt_array($ch , $opts);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) throw new Exception('请求发生错误：' . $error);
    return $data;
}

/**
 * @param $code int 响应代码
 * @param $msg  string 描述字符串
 * @param $data array 返回的数据
 * @return false|string json
 */
function return_msg ($code , $msg , array $data = []): bool|string
{
    $return_data[ 'code' ] = $code;
    $return_data[ 'msg' ] = $msg;
    $return_data[ 'data' ] = $data;
    return json_encode($return_data);
}

//成功返回不带数据

/**
 * @param $msg string 描述
 */
function ReturnSuccess (string $msg)
{
    $result = ['code' => 200 , 'msg' => $msg ,];
    return json_encode($result);
}

/**
 * @param $msg string 描述
 */
function ReturnError ($msg)
{
    $result = ['code' => 201 , 'msg' => $msg ,];
    return json_encode($result);
}

// 耗时
function microtime_float ()
{
    list($usec , $sec) = explode(" " , microtime());
    return ( (float)$usec + (float)$sec );
}