<?php
if (file_exists('install.lock')) {//已经安装过了
    header("Location: ../");
    return;
}
$web_mulu = dirname($_SERVER[ 'SCRIPT_FILENAME' ] , 2);//当前目录
date_default_timezone_set("PRC");
$php_bb = phpversion();
$mysql_bb = function_exists('mysqli_connect') ? "支持" : "不支持";

$web_url = dirname((($_SERVER['SERVER_PORT']==443) ? 'https':'http').'://'.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'],(substr($_SERVER['DOCUMENT_ROOT'],-1) == '/') ? '/':'',dirname($_SERVER['SCRIPT_FILENAME'])));//当前域名
$error_msg = '';
$a = isset($_GET[ 'a' ]) ? intval($_GET[ 'a' ]) : 0;
$submit = isset($_POST[ 'install' ]) ? addslashes($_POST[ 'install' ]) : '';

if ($a == 1 && $submit) {

    $error = ['cloudDbServer' => '请输入数据库地址' , 'cloudDbPort' => '请输入数据库端口号' , 'cloudDbUser' => '请输入数据库用户名' , 'cloudDbPwd' => '请输入数据库密码' , 'cloudDbName' => '请输入数据库名' , 'cloudAdmUser' => '请输入管理员账号' , 'cloudAdmPwd' => '请输入管理员密码'];
    foreach ($error as $key => $val) {
        if ( !array_isset($_POST , $key)) {
            $error_msg = $val;
            break;
        }
    }
    if ( !$error_msg) {
        $user = $_POST['cloudAdmUser'];
        $pass = md5($_POST['cloudAdmPwd']);
        $cookie = md5($user.$pass.time());
        $conn = @mysqli_connect($_POST[ 'cloudDbServer' ] , $_POST[ 'cloudDbUser' ] , $_POST[ 'cloudDbPwd' ]);
        mysqli_query($conn , "set names utf8");

        if ($conn) {
            if (@mysqli_select_db($conn , $_POST[ 'cloudDbName' ])) {
                require_once 'cloudza_api.php';//引入数据表
                foreach ($sql as $value) {
                    mysqli_query($conn , $value);
                }
                $param = array(
                    'host' => $_POST['cloudDbServer'],            //数据库连接地址，默认：localhost或127.0.0.1
                    'port' => $_POST['cloudDbPort'],                 //端口号
                    'user' => $_POST['cloudDbUser'],             //用户名
                    'pwd' => $_POST['cloudDbPwd'],      //密码
                    'dbname' => $_POST['cloudDbName'],           //数据库名称
                    'charset' => 'utf8'               //设置字符集
                );
                $config = "<?php\n";
                $config .= "\$param = ".var_export($param, true).";\n";
                $config .= '$db = Db::getInstance($param);';
                file_put_contents('../include/config.php' , $config);
                //-------生成唯一随机串防CSRF攻击
                $state = md5(uniqid(rand() , true));
                setcookie('install_state' , $state , time() + 3600 , '/');
                header("Location: ./?a=2&s={$state}");
            } else {
                $error_msg = '未找到数据库';
            }
        } else {
            $error_msg = '错误的数据库信息,连接失败';
        }
    }
}

if ($a == 2) {
    if ( !isset($_GET[ 's' ]) or !isset($_COOKIE[ 'install_state' ]) or $_GET[ 's' ] != $_COOKIE[ 'install_state' ]) {
        header("Location: ../");
    }
}

function array_isset ($arr , $key): bool
{
    return isset($arr[ $key ]) && !empty($arr[ $key ]);
}

?>


<!doctype html>
<html lang="zn-cn" class="">
<head>
    <meta charset="utf-8">
    <title>CloudZA API系统 - Install</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="/assets/img/favicons/favicon.png">
    <link rel="stylesheet" id="css-main" href="/assets/css/codebase.min-5.4.css">
    <link rel="stylesheet"
          href="/assets/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div id="page-container" class="main-content-boxed">
    <main id="main-container">
        <div class="bg-body-light hero-bubbles">
            <span class="hero-bubble hero-bubble-lg bg-primary" style="top: 20%; left: 10%;"></span>
            <span class="hero-bubble bg-success" style="top: 20%; left: 80%;"></span>
            <span class="hero-bubble hero-bubble-sm bg-corporate" style="top: 40%; left: 25%;"></span>
            <span class="hero-bubble hero-bubble-lg bg-pulse" style="top: 30%; left: 90%;"></span>
            <span class="hero-bubble bg-danger" style="top: 40%; left: 20%;"></span>
            <span class="hero-bubble bg-warning" style="top: 60%; left: 25%;"></span>
            <span class="hero-bubble bg-info" style="top: 60%; left: 80%;"></span>
            <span class="hero-bubble hero-bubble-lg bg-flat" style="top: 75%; left: 70%;"></span>
            <span class="hero-bubble hero-bubble-lg bg-earth" style="top: 75%; left: 10%;"></span>
            <span class="hero-bubble bg-elegance" style="top: 90%; left: 90%;"></span>
            <div class="row g-0 justify-content-center position-relative">
                <div class="hero-static col-lg-7">
                    <div class="content content-full overflow-hidden">
                        <div class="py-5 text-center">
                            <a class="link-fx fw-bold" href="javascript:void(0);">
                                <i class="fa fa-fire"></i>
                                <span class="fs-4 text-body-color">Cloud</span><span class="fs-4">ZA</span>
                            </a>
                            <h1 class="h3 fw-bold mt-5 mb-2">欢迎使用CloudZA API系统</h1>
                            <h2 class="fs-base fw-medium text-muted mb-0" style="text-transform: uppercase;">
                                <?php
                                if ($a == 0): ?>环境监测<?php
                                elseif ($a == 1): ?>数据库配置<?php
                                elseif ($a == 2): ?>安装完成<?php
                                endif; ?> - 系统安装
                            </h2>

                        </div>
                        <?php if($error_msg):?>
                        <div class="alert alert-warning" role="alert">
                            <p class="mb-0"><?php echo $error_msg; ?></p>
                        </div>
                        <?php endif; ?>
                        <?php
                        if ( $a == 0 ): ?>
                        <div class="block block-rounded block-fx-shadow">
                            <div class="block-content">
                                <div class="table-responsive-sm">
                                    <table class="table table-bordered table-centered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">参数</th>
                                            <th class="text-center">当前值</th>
                                            <th class="text-center">需求值</th>
                                            <th class="text-center">状态</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-center">当前域名</td>
                                            <td class="text-center"><?php
                                                echo $web_url; ?></td>
                                            <td class="text-center">*</td>
                                            <td class="text-center"><?php
                                                if ( $web_url ): ?><span class="text-success">正常<?php
                                                    else: ?><span class="text-danger">异常<?php
                                                        endif; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">PHP版本</td>
                                            <td class="text-center"><?php
                                                echo $php_bb; ?></td>
                                            <td class="text-center">>=8.0</td>
                                            <td class="text-center"><?php
                                                if ( $php_bb >= 8.0 ): ?><span class="text-success">正常<?php
                                                    else: ?><span class="text-danger">异常<?php
                                                        endif; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">MYSQL</td>
                                            <td class="text-center"><?php
                                                echo $mysql_bb; ?></td>
                                            <td class="text-center">支持</td>
                                            <td class="text-center"><?php
                                                if ( $mysql_bb == '支持' ): ?><span class="text-success">正常<?php
                                                    else: ?><span class="text-danger">异常<?php
                                                        endif; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">服务器系统</td>
                                            <td class="text-center"><?php
                                                echo PHP_OS; ?></td>
                                            <td class="text-center">WINNT/LINUX</td>
                                            <td class="text-center"><?php
                                                if ( strtoupper(PHP_OS) == 'WINNT' or strtoupper(PHP_OS) == 'LINUX' ): ?>
                                                <span class="text-success">正常<?php
                                                    else: ?><span class="text-danger">异常<?php
                                                        endif; ?></span></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="block-content">
                                    <div class="row mb-4">
                                        <div class="col-lg-6 offset-lg-5">
                                            <a href="./?a=1" class="btn btn-alt-primary mb-2">
                                                <i class="fa fa-arrow-right opacity-75 me-1"></i> 下一步
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            elseif ($a == 1): ?>
                                <form action="./?a=1" method="post" id="addimg" name="addimg">
                                    <div class="block block-rounded block-fx-shadow">
                                        <div class="block-content">
                                            <h2 class="content-heading pt-3">数据库安装</h2>
                                            <div class="row items-push">
                                                <div class="col-lg-4">
                                                    <p class="text-muted">
                                                        请确保数据库表单填写正确，否则会造成安装失败
                                                    </p>
                                                </div>
                                                <div class="col-lg-6 offset-lg-1">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="cloudDbServer">数据库地址</label>
                                                        <input type="text" class="form-control form-control-lg" id="cloudDbServer" name="cloudDbServer" value="localhost" placeholder="数据库连接地址">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="cloudDbPort">数据库端口</label>
                                                        <input type="text" class="form-control form-control-lg" id="cloudDbPort" name="cloudDbPort" value="3306" placeholder="数据库端口号">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="cloudDbUser">数据库用户</label>
                                                        <input type="text" class="form-control form-control-lg" id="cloudDbUser" name="cloudDbUser" value="root " placeholder="数据库账号">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="cloudDbPwd">数据库密码</label>
                                                        <input type="text" class="form-control form-control-lg" id="cloudDbPwd" name="cloudDbPwd" placeholder="填写数据库密码">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="cloudDbName">数据库名</label>
                                                        <input type="text" class="form-control form-control-lg" id="cloudDbName" name="cloudDbName" placeholder="数据库名称">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content">
                                            <h2 class="content-heading pt-3">管理员信息</h2>
                                            <div class="row items-push">
                                                <div class="col-lg-4">
                                                    <p class="text-muted">
                                                        请设置管理员账号信息，请牢记设置好的账号和密码
                                                    </p>
                                                </div>
                                                <div class="col-lg-6 offset-lg-1">
                                                    <div class="mb-4">
                                                        <label class="form-label" for="cloudAdmUser">账号</label>
                                                        <input type="text" class="form-control form-control-lg" id="cloudAdmUser" name="cloudAdmUser" value="admin" placeholder="管理员账号">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="cloudAdmPwd">密码</label>
                                                        <input type="text" class="form-control form-control-lg" id="cloudAdmPwd" name="cloudAdmPwd" value="123456" placeholder="管理员密码">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content">
                                            <div class="row mb-4">
                                                <div class="col-lg-6 offset-lg-5">
                                                    <button  type="submit" name="install" id="install" value="确定" class="btn btn-primary mb-2">
                                                        <i class="fa fa-arrow-right opacity-50 me-1"></i> 安装
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php
                            elseif ($a == 2 && isset($_GET[ 's' ]) && isset($_COOKIE[ 'install_state' ]) && $_GET[ 's' ] == $_COOKIE[ 'install_state' ]): @file_put_contents("install.lock" , '欢迎使用CloudZA API系统');
                                setcookie('install_state' , '' , 0 , '/'); ?>
                                <div class="block block-rounded block-fx-shadow">
                                    <div class="block-content">
                                        <div class="row items-push">
                                            <div class="text-center text-muted">
                                                <h2 class="mt-0"><i class="mdi mdi-check-all"></i></h2>
                                                <h3 class="mt-0">Good for you !</h3>
                                                <p class="w-75 mb-2 mt-2 mx-auto">CloudZA API 安装完成，您可以开始使用本系统了。若访问首页任然继续跳转至安装跳转，请自行在install/目录下创建一个 install.lock 空文档即可</p>
                                                <div class="mb-3 mt-2">
                                                    <a href="../" class="btn btn-sm btn-alt-primary">返回首页</a>
                                                    <a href="../admin" class="btn btn-sm btn-alt-success">前往后台</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            else:header("Location: /");
                            endif; ?>
                        </div>
                    </div>
                </div>
            </div>
    </main>
</div>
<script src="/assets/js/codebase.app.min-5.4.js"></script>
</body>
</html>
