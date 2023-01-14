<?php
/*
Sort:1
icons:si si-energy
Hidden:false
Name:接口列表
Url:control_list
*/

if ( !isset($islogin)) header("Location: /");//非法访问
$nums = $db::table('api_list')->count();
$page = isset($_GET[ 'page' ]) ? intval($_GET[ 'page' ]) : 1;
$url = "./?control_list&page=";
$ENUMS = PAGES; // 每页条数
$bnums = ( $page - 1 ) * $ENUMS;
?>
<style>
    td {
        white-space: nowrap;
    }
</style>
<div class="col-12">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title"><?php echo $val[ 'name' ]; ?></h3>
        </div>
    </div>
</div>
<div class="col-xl-12">
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">已经添加的API <small>每页展示<?php
                    echo PAGES; ?>条数据</small>
            </h3>
        </div>
        <div class="block-content block-content-full">
            <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="row mb-4">
                    <div class="col-12">
                        <button type="button" class="btn btn-sm btn-alt-primary me-1" onclick="edit_modal(null)">添加API
                        </button>
                        <button type="button" class="btn btn-sm btn-alt-secondary btn-alt-info" data-toggle="layout"
                                data-action="header_search_on">
                            <i class="fa fa-fw fa-search"></i>
                        </button>
                    </div>
                </div>


                <?php
                $data = Db::table('api_list');
                if ($so != '') {
                    $list = $data->where('name' , 'like' , "%{$so}%")->whereOr('des' , 'like' , "%{$so}%");
                } else {
                    $list = $data->order('id ASC')->limit($bnums , $ENUMS);
                }
                $res = $list->select();
                ?>

                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive  no-footer dtr-inline"
                               id="task-logs-list" data-type="sport"
                               aria-describedby="task-logs-list_info">
                            <thead>
                            <tr>
                                <th style="width: 10px;text-align: center;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="all"
                                               onclick="checkAll();" />
                                    </div>
                                </th>
                                <th style="text-align: center;" class="sorting_disabled" rowspan="1" colspan="1">
                                    API名称
                                </th>
                                <th style="text-align: center;" class="sorting_disabled" rowspan="1" colspan="1">
                                    API介绍
                                </th>
                                <th style="text-align: center;" class="sorting_disabled" rowspan="1" colspan="1">
                                    添加时间
                                </th>
                                <th style="text-align: center;" class="sorting_disabled" rowspan="1" colspan="1">pv</th>
                                <th style="width: 40px;text-align: center;" class="sorting_disabled" rowspan="1"
                                    colspan="1">操作
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            if (json_encode($res) == '[]') {
                                if ( !empty($_GET[ 'page' ])) {
                                    $url = ( ( $_SERVER[ 'SERVER_PORT' ] == 443 ) ? 'https' : 'http' ) . '://' . $_SERVER[ 'HTTP_HOST' ] . str_replace($_SERVER[ 'DOCUMENT_ROOT' ] , ( substr($_SERVER[ 'DOCUMENT_ROOT' ] , -1) == '/' ) ? '/' : '' , dirname($_SERVER[ 'SCRIPT_FILENAME' ]));
                                    $js = '<script>window.location="' . $url . '/?user_edit&id=' . $user_info[ 'id' ] . '"</script>';
                                    echo $js;
                                }
                                echo '<td style="text-align: center;" colspan="6" class="dataTables_empty"><i class="si si-drawer fa-2x"></i><p class="text-muted fs-sm">暂无数据</p></td>';
                            }
                            foreach ($res as $k => $v) {
                                $row = $res[ $k ];

                                ?>
                                <tr class="odd">
                                    <td style="text-align: center;" class="fs-sm">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ids[]"
                                                   value="<?php
                                                   echo $row[ 'id' ]; ?>" id="<?php
                                            echo 'check_' . $row[ 'id' ]; ?>">
                                            <label class="custom-control-label" for="<?php
                                            echo 'check_' . $row[ 'id' ]; ?>"></label>
                                        </div>
                                    </td>

                                    <td style="text-align: center;" class="fs-sm">
                                        <?php
                                        echo $row[ 'name' ]; ?>
                                    </td>

                                    <td style="text-align: center;" class="fs-sm">
                                        <?php
                                        echo ( strlen($row[ 'des' ]) > 33) ? mb_substr($row[ 'des' ] , 0 , 11).'...' : $row[ 'des' ] ?>
                                    </td>
                                    <td style="text-align: center;" class="fs-sm">
                                        <?php
                                        echo $row[ 'add_time' ]; ?>
                                    </td>
                                    <td style="text-align: center;" class="fs-sm">
                                        <?php
                                        echo $row[ 'pv' ];
                                        ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-sm btn-alt-primary me-1"
                                                onclick="edit_modal('%7B%22api_id%22:%22<?php
                                                echo $row[ 'id' ] ?>%22,%22api_name%22:%22<?php
                                                echo $row[ 'name' ] ?>%22,%22api_url%22:%22<?php
                                                echo $row[ 'api_url' ] ?>%22,%22api_des%22:%22<?php
                                                echo $row[ 'des' ] ?>%22,%22api_key%22:%22<?php
                                                echo $row[ 'api_key' ] ?>%22,%22http_mode%22:%22<?php
                                                echo $row[ 'http_mode' ] ?>%22,%22return_format%22:%22<?php
                                                echo $row[ 'return_format' ] ?>%22,%22http_case%22:%22<?php
                                                echo $row[ 'http_case' ] ?>%22,%22return_case%22:%22<?php
                                                echo base64_encode($row[ 'return_case' ]) ?>%22%7D');">
                                            修改
                                        </button>
                                        <button type="button" class="btn btn-sm btn-alt-primary me-1">
                                            代码示例
                                        </button>
                                        <button type="button" class="btn btn-sm btn-alt-primary me-1">
                                            错误代码
                                        </button>
                                        <button type="button" class="btn btn-sm btn-alt-primary me-1"
                                                onclick="del('<?php
                                                echo $row[ 'name' ] ?>',<?php
                                                echo $row[ 'id' ] ?>)">
                                            删除
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!--分页-->
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="task-logs-list_info" role="status" aria-live="polite">
                            选中项：<a href="javascript:void(0);" onclick="delSelect()">删除</a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_full_numbers" id="task-logs-list_paginate">
                            <?php if(!$so){echo pagination($nums,$ENUMS,$page,$url);}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<!--模态框-->
<div class="modal fade" id="modal-top" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-rounded shadow-none mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="title">新增API</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="block-content fs-sm">
                        <div class="row">
                            <input type="hidden" name="fun" id="fun" value="add">
                            <input type="hidden" name="api_id" id="api_id" value="">
                            <div class="col-sm-5 mb-4">
                                <label class="form-label">API名称</label>
                                <input type="text" class="form-control fs-sm" name="api_name" id="api_name"
                                       placeholder="例如：短网址生成" value="">
                            </div>
                            <div class="col-sm-7 mb-4">
                                <label class="form-label">API地址</label>
                                <input type="text" class="form-control fs-sm" name="api_url" id="api_url"
                                       placeholder="https://abc.com/api/dome" value="">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="example-textarea-input">API介绍</label>
                            <textarea class="form-control fs-sm " name="api_des" id="api_des" rows="2"
                                      placeholder="例如：将长网址进行缩短，支持百度、新浪、腾讯短网址等等..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">关键词</label>
                            <input type="text" class="form-control fs-sm" name="api_key" id="api_key"
                                   placeholder="用英文逗号分开例如：短网址,短链接" value="">
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <label class="form-label">请求方法</label>
                                <input type="text" class="form-control fs-sm" name="http_mode" id="http_mode"
                                       placeholder="例如：GET/POST" value="">
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label class="form-label">返回格式</label>
                                <input type="text" class="form-control fs-sm" name="return_format" id="return_format"
                                       placeholder="例如：JSON" value="">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">请求示例</label>
                            <input type="text" class="form-control fs-sm" name="http_case" id="http_case"
                                   placeholder="https://abc.com/api/dome?url=http://baidu.com" value="">
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="example-textarea-input">返回示例</label>
                            <textarea class="form-control fs-sm " name="return_case" id="return_case" rows="5"
                                      placeholder='{
    "code": 1,
    "msg": "生成成功",
    "url": "http://baidu.com",
    "data": {
        "tcn": "http://t.cn/xxxxxx",
        "url": "https://url.cn/xxxxxx"
    }
}'></textarea>
                        </div>

                    </div>

                    <div class="block-content block-content-full block-content-sm text-end border-top">
                        <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">
                            取消
                        </button>
                        <button type="button" class="btn btn-alt-primary" onclick="add_api()">
                            提交
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function add_api ()
        {
            x.ajax('ajax.php?act=control_' + x.getval('#fun'), {
                id: x.getval('#api_id'),                            // 接口ID
                name: x.getval('#api_name'),                        // 接口名字
                api_url: x.getval('#api_url'),                      // 接口地址
                des: x.getval('#api_des'),                          // 接口介绍
                api_key: x.getval('#api_key'),                      // 接口关键词
                http_mode: x.getval('#http_mode'),                  // 接口请求方法
                return_format: x.getval('#return_format'),          // 接口返回格式
                http_case: x.getval('#http_case'),                  // 接口请求示例
                return_case: x.getval('#return_case')               // 接口返回示例
            }, (data) => {
                if (data.code === 200) {
                    console.log('return =>', data)
                    $('#modal-top').modal('hide');
                    setTimeout(() => {
                        x.notify(data.msg, 'success')
                        setTimeout(() => {
                            x.pjax('?control_list');
                        }, 1200)
                    }, 300)
                } else {
                    x.btn(data.msg)
                }
            });
        }

        function edit_modal (list = null)
        {
            if (list != null) {
                let udata = decodeURI(list);
                let data = JSON.parse(udata.replace(/\n/g, "\\n").replace(/\r/g, "\\r"));
                $("input[name='api_id']").val(data.api_id); // 接口ID
                $("input[name='api_name']").val(data.api_name); // 接口名字
                $("input[name='api_url']").val(data.api_url); // 接口地址
                $("textarea[name='api_des']").val(data.api_des); // 接口介绍
                $("input[name='api_key']").val(data.api_key); // 接口关键词
                $("input[name='http_mode']").val(data.http_mode); // 接口请求方法
                $("input[name='return_format']").val(data.return_format); // 接口返回格式
                $("input[name='http_case']").val(data.http_case); // 接口请求示例
                $("textarea[name='return_case']").val(Base64.decode(data.return_case)); // 接口返回示例
                $("input[name='fun']").val('edit') // 编辑
                $("#title").html('编辑API');
                $('#modal-top').modal('show');
            } else {
                $("inpit[name='api_id']").val(null); // 接口ID
                $("input[name='api_name']").val(null); // 接口名字
                $("input[name='api_url']").val(null); // 接口地址
                $("textarea[name='api_des']").val(null); // 接口介绍
                $("input[name='api_key']").val(null); // 接口关键词
                $("input[name='http_mode']").val(null); // 接口请求方法
                $("input[name='return_format']").val(null); // 接口返回格式
                $("input[name='http_case']").val(null); // 接口请求示例
                $("textarea[name='return_case']").val(null); // 接口返回示例
                $("input[name='fun']").val('add') // 新增
                $("#title").html('新增API');
                $('#modal-top').modal('show');
            }

        }

        function checkAll ()
        {
            let code_Values = document.getElementsByTagName("input");
            let all = document.getElementById("all");
            if (code_Values.length) {
                for (let i = 0; i < code_Values.length; i++) {
                    if (code_Values[i].type === "checkbox") {
                        code_Values[i].checked = all.checked;
                    }
                }
            } else {
                if (code_Values.type === "checkbox") {
                    code_Values.checked = all.checked;
                }
            }
        }

        function delSelect ()
        {
            let id_array = [];
            //获取界面复选框的所有值
            $("input[name='ids[]']:checked").each(function () {
                //向数组中添加元素
                id_array.push($(this).val());
            });
            x.del('ajax.php?act=control_delSelect', {
                id: id_array
            }, ((data) => {
                if (200 === data.code) {
                    x.notify(data.msg, 'success')
                    setTimeout(() => {
                        x.pjax('?control_list');
                    }, 1200)
                } else {
                    x.notify(data.msg, 'warning')
                }
            }), '你确定要删除选中的内容吗?')
        }

        function del (name, id)
        {
            x.del('ajax.php?act=control_delapi', {
                id: id
            }, ((data) => {
                if (200 === data.code) {
                    x.notify(data.msg, 'success')
                    setTimeout(() => {
                        x.pjax('?control_list');
                    }, 1200)
                } else {
                    x.notify(data.msg, 'warning')
                }
            }), (name.length <= 5) ? '你确定要删除【' + name + '】吗?' : '你确定要删除【' + name.substring(0, 5) + "..." + '】吗?')
        }
    </script>