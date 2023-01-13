<?php
/*
Sort:1
icons:fa fa-gear
Hidden:false
Name:网站设置
Url:set_web
*/
$row = Db::table('webset')->find();
?>
<div class="col-12">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">网站设置</h3>
        </div>
    </div>
</div>
<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">
            <i class="fa fa-gear me-1 text-muted"></i> 网站设置
        </h3>
    </div>
    <div class="block-content">
            <div class="row items-push">
                <div class="col-12 ">
                    <div class="mb-4">
                        <label class="form-label" for="title">网站标题</label>
                        <input class="form-control form-control-lg" id="title" name="title" placeholder="输入网站描述"
                               type="text" value="<?php echo $row['web_title'] ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="des">网站描述</label>
                        <input class="form-control form-control-lg" id="des" name="des" placeholder="输入网站描述"
                               type="text" value="<?php echo $row['web_des'] ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="key">网站关键词</label>
                        <input class="form-control form-control-lg" id="key" name="key"
                               placeholder="输入网站关键词，用英文逗号隔开" type="text" value="<?php echo $row['web_key'] ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="qq">站长QQ</label>
                        <input class="form-control form-control-lg" id="qq" name="qq"
                               placeholder="输入你的QQ号" type="text" value="<?php echo $row['web_qq'] ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="beian">网站备案号</label>
                        <input class="form-control form-control-lg" id="beian" name="beian"
                               placeholder="如果没有备案可以不用输入" type="text" value="<?php echo $row['web_beian'] ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="ban">底部版权</label>
                        <input class="form-control form-control-lg" id="ban" name="ban"
                               placeholder="例如CloudZA" type="text" value="<?php echo $row['web_ban']?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="page_num">后台每页条数</label>
                        <input class="form-control form-control-lg" id="page_num" name="page_num"
                               placeholder="最少填10条" type="number" value="<?php echo $row['web_page_nums'] ?>">
                    </div>
                    <div class="mb-4">
                        <button class="btn btn-alt-primary" onclick="submit()" type="submit">
                            提交
                        </button>
                    </div>
                </div>
            </div>
    </div>
</div>

<script>
    function submit ()
    {
        x.ajax('ajax.php?act=set_web', {
            web_title: x.getval('#title'),
            web_des: x.getval('#des'),
            web_key: x.getval('#key'),
            web_qq: x.getval('#qq'),
            web_beian: x.getval('#beian'),
            web_ban: x.getval('#ban'),
            web_page_nums: x.getval('#page_num')
        }, (data) => {
            if (data.code === 200) {
                x.notify(data.msg, 'success')
                setTimeout(() => {
                    x.pjax('?set_web')
                }, 1200)
            } else {
                x.notify(data.msg, 'warning')
            }
        })
    }
</script>