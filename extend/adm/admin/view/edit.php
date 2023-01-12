<?php
    /*
    Sort:2
    Hidden:false
    icons:mdi mdi-account-edit
    Name:修改密码
    Url:admin_edit
    */
    if ( !isset($islogin)) header("Location: /");//非法访问拦截
?>

<div class="content">


    <h2 class="content-heading">修改密码</h2>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="block-content">
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" id="username" name="username" placeholder="用户账号"
                                   value="<?php echo $user; ?>" required />
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

        $.ajax({
            cache: false,
            type: "POST",//请求的方式
            url: "ajax.php?act=admin_pwd",//请求的文件名
            data: {user: user, pwd: pwd, okpwd: okpwd},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.code == 200) {
                    x.notify(data.msg, 'success')
                    window.setTimeout("window.location='" + window.location.href + "'", 1000);
                } else {
                    x.notify(data.msg, 'danger')
                }
            }
        });
        return false;//重要语句：如果是像a链接那种有href属性注册的点击事件，可以阻止它跳转。
    });

</script>