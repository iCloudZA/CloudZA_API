<?php
/*
Sort:2
Hidden:false
icons:mdi mdi-account-edit
Name:修改密码
Url:admin_edit
*/

if ( !isset($islogin)) header("Location: /");//非法访问拦截
$data = Db::table('admin')->find();
?>

<div class="animated fadeIn">
    <div class="col-12">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">修改密码</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="block-content">
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" id="username" name="username" placeholder="用户账号"
                                   value="<?php
                                   echo $data['user']; ?>" required />
                            <label class="form-label" for="login-username">账号</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="空则不修改密码" value="" required />
                            <label class="form-label" for="login-password">密码</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="okpassword" name="okpassword"
                                   placeholder="空则不修改密码" value="" required />
                            <label class="form-label" for="login-password">确认密码</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 d-sm-flex align-items-center push">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="ok" name="ok" required />
                                    <label class="form-check-label" for="ok">确认是我操作</label>
                                </div>
                            </div>
                            <div class="col-sm-6 text-sm-end push">
                                <button id="submit" type="submit" class="btn btn-block btn-primary">
                                    确认修改
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $('#submit').click(function () {
        var user = $("input[name='username']").val();
        var pwd = $("input[name='password']").val();
        var okpwd = $("input[name='okpassword']").val();
        var ok = document.getElementById("ok").checked;
        //console.log(okpwd);
        if (!ok) {
            x.notify('请确认是我操作', 'warning')
            return false;
        }
        x.ajax('ajax.php?act=admin_pwd', {
            user: user,
            pwd: pwd,
            okpwd: okpwd
        }, (data) => {
            if (data.code === 200) {
                x.notify(data.msg, 'success')
                window.setTimeout("window.location='" + window.location.href + "'", 1000);
            } else {
                x.notify(data.msg, 'danger')
            }
        })
    });

</script>