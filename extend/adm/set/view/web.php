<?php
/*
Sort:1
Hidden:false
Name:网站设置
Url:set_web
*/
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
            <i class="fa fa-gear me-1 text-muted"></i> SEO设置
        </h3>
    </div>
    <div class="block-content">
        <form id="edit-profile" onsubmit="return false;">
            <div class="row items-push">
                <div class="col-lg-3">
                    <p class="text-muted">
                        你可以在这里修改网站的SEO信息
                    </p>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <div class="mb-4">
                        <label class="form-label">网站标题</label>
                        <input class="form-control form-control-lg" id="title" name="title" placeholder="输入网站标题" type="number" value="">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">网站描述</label>
                        <input class="form-control form-control-lg" id="des" name="des" placeholder="输入网站描述" type="email" value="">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">网站关键词</label>
                        <input class="form-control form-control-lg" id="key" name="key" placeholder="输入网站关键词，用英文逗号隔开" type="email" value="">
                    </div>
                    <div class="mb-4">
                        <button class="btn btn-alt-primary" onclick="" type="submit">
                            提交
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
